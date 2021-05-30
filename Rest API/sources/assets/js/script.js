const api_url = "http://103.212.239.10:8000/api/";
const api_key = "2d6b123d09";
const baseurl = $('[name="domain"]').attr('content');
const sensors = 'Sensor Arus';

/* ================================================================================= */
/*                                     User Nodelist                                 */
/* ================================================================================= */
function node_list()
{
    $.ajax({
        type: 'GET',
        url: api_url+'app/node?api_key='+api_key,
        success: function(event)
        {
            var object = event;
            var html = '';
            var list = object.data;
            
            for (var i = 0; i < list.length; i++)
            {
                list[i].description = list[i].description == '' ? '-' : list[i].description;
                
                html += '<tr>';
                html += '<td>'+list[i].id+'</td>';
                html += '<td>'+list[i].name+'</td>';
                html += '<td>'+list[i].description+'</td>';
                html += '<td>'+list[i].api_key+'</td>';
                html += '<td><a href="'+baseurl+'/user/node_detail/'+list[i].id+'" class="btn btn-info btn-sm" style="color:#fff !important">View Detail</a></td>';
                html += '</tr>';
            }

            $('tbody').html(html);
        },
        complete: function()
        {
            $('#example').DataTable();
        }
    });
}

/* ================================================================================= */
/*                         User NodeDetail Reatime Chart                             */
/* ================================================================================= */
var x_r_chart = []
var y_r_chart = []

function node_detail_realtime_chart(node_id = '')
{
    var sensor_id = sensor_switch(node_id);
    
    $.ajax({
        type: 'GET',
        url: api_url+'app/data/sensor/'+sensor_id+'?api_key='+api_key+'&realtime=true',
        success: function(event)
        {
            var object = event;
            var list = object.data.data;
            
            for (var i = 0; i < list.length; i++)
            {
               list[i].value = list[i].value == null ? 0.000 : list[i].value;
               list[i].created_at = formatAMPM(list[i].created_at);

               x_r_chart.push(list[i].created_at);
               y_r_chart.push(list[i].value);
            }
        },
        complete: function()
        {
            renderChart($("#myChart1")[0].getContext('2d'), x_r_chart, y_r_chart);
        }
    });
}

/* ================================================================================= */
/*                         User NodeDetail Range Charts                              */
/* ================================================================================= */
var x_n_chart = []
var y_n_chart = []

function node_detail_range_chart(node_id = '', SD, ST, ED, ET)
{
    var sensor_id = sensor_switch(node_id);
    var param  = "start_date="+SD+"&";
        param += "start_time="+ST+"&";
        param += "end_date="+ED+"&";
        param += "end_time="+ET+"&";
        param += "type=graph";

    $.ajax({
        type: 'GET',
        url: api_url+'app/data/sensor/'+sensor_id+'?api_key='+api_key+'&'+param,
        success: function(event)
        {
            var object = event;
            var created_at = object.data.data.created_at;
            var value = object.data.data.value;
            
            for (var i = 0; i < created_at.length; i++)
            {
               if (Date.parse(created_at[i]) <= Date.now())
               {
                value[i] = value[i] == null ? 0.000 : value[i];
                created_at[i] = formatAMPM(created_at[i]);

                x_n_chart.push(created_at[i]);
                y_n_chart.push(value[i]);
               }
            }
        },
        complete: function()
        {
            renderChart($("#myChart2")[0].getContext('2d'), x_n_chart, y_n_chart);
        }
    });
}

/* ================================================================================= */
/*                         User NodeDetail Table Data                                */
/* ================================================================================= */
function node_detail_table(node_id = '', SD, ST, ED, ET, PRICE = 14440)
{
    var sensor_id = sensor_switch(node_id);
    var param  = "start_date="+SD+"&";
        param += "start_time="+ST+"&";
        param += "end_date="+ED+"&";
        param += "end_time="+ET+"&";
        param += "type=table";

    $.ajax({
        type: 'GET',
        url: api_url+'app/data/sensor/'+sensor_id+'?api_key='+api_key+'&'+param,
        success: function(event)
        {
            var object = event;
            var list = object.data.data;
            var sensor_status = ['danger', 'success'];
            var sensor_status_name = ['Down', 'Up'];
            var html = '';
            var no = 1;

            var avg_watt = 0;
            var time_first = 0;
            var time_last = 0;
            
            for (var i = 0; i < list.length; i++)
            {
               if (Date.parse(list[i].created_at) <= Date.now())
               {
                    list[i].value = list[i].value == null ||  list[i].value == 0 ? '0.0000' : String(list[i].value);
                    var time_created = list[i].created_at;
                    list[i].created_at = formatAMPM(list[i].created_at);
                    var idx = list[i].sensor_status == 'up' ? 1 : 0;

                    html += '<tr>';
                    html += '<td>'+no+'</td>';
                    html += '<td>'+list[i].created_at+'</td>';
                    html += '<td>'+list[i].value+'</td>';
                    html += '<td><span class="label label-'+sensor_status[idx]+'">'+sensor_status_name[idx]+'</span></td>';
                    html += '</tr>';

                    avg_watt += parseFloat(list[i].value);
                    if (no == 1) time_first = (Date.parse(time_created))  /  1000;
                    no++;
               }
            }
            
            time_last = (Date.parse(time_created))  /  1000;

            var average = avg_watt * 220 * (time_last - time_first);
                average = average / 1000 / 3600;
                average = parseFloat(average).toFixed(4);
            
            var kwh_price = PRICE * average;
            
                $("#kwh-usage").html(average);
                $("#kwh-price").html(number_format(kwh_price.toFixed(2)));

            $('tbody').html(html);
        },
        complete: function()
        {
            $('#example').DataTable();
        }
    });
}

/* ================================================================================= */
/*                                     Sensor Switch                                 */
/* ================================================================================= */

function sensor_switch(node_id)
{

    $.ajax({
        type: 'GET',
        url: api_url+'app/node/'+node_id+'?api_key='+api_key+'&with_sensors=true',
        success: function(event)
        {
            var object = event;
            var sensor = object.data.sensors;
            
            for (var i = 0; i < sensor.length; i++)
            {
               if (sensors == sensor[i].name)
               {
                  sessionStorage.setItem('node_id', sensor[i].id);
               }
            }
        }
    });
    
    return sessionStorage.getItem('node_id');
}

/* ================================================================================= */
/*                                     Other FUnction                                */
/* ================================================================================= */
function number_format(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatAMPM(date) {
    var date = new Date(Date.parse(date));
    var day = String(date.getDate()).padStart(2, '0');
    var month = String(month_name_convert(date.getMonth())).padStart(2, '0');
    var years = date.getFullYear();
    var hours = String(date.getHours());
    var minutes = String(date.getMinutes());
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = month+' '+day+', '+years+'. '+String(hours).padStart(2, '0') + ':' + minutes + ' ' + ampm;
    return strTime;
  }

function month_name_convert(index){
    var name = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return name[index];
}

function timepicker(object)
{
    $(object).datetimepicker();
}

function filter_date(object, node_id)
{
    var SD = $(object).find("#date0").val();
    var ED = $(object).find("#date1").val();
    
    var parse_sd = Date.parse(SD);
        parse_sd = new Date(parse_sd);
        SD = parse_sd.getFullYear()+'-'+(String(parse_sd.getMonth()+1).padStart(2, '0'))+'-'+parse_sd.getDate();
    var ST = parse_sd.getHours()+':'+parse_sd.getMinutes()+':00';

    var parse_ed = Date.parse(ED);
        parse_ed = new Date(parse_ed);
        ED = parse_ed.getFullYear()+'-'+(String(parse_ed.getMonth()+1).padStart(2, '0'))+'-'+parse_ed.getDate();
    var ET = parse_ed.getHours()+':'+parse_ed.getMinutes()+':00';
    window.location = baseurl+'/user/node_detail/'+node_id+'?start_date='+SD+'&start_time='+ST+'&end_date='+ED+'&end_time='+ET;
    return false;
}

function renderChart(ctx, x, y)
{
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: x,
            datasets: [{
                label: 'Energy Usage',
                data: y,
                backgroundColor: 'rgba(215, 236, 251, 0.3308600444178428)',
                borderColor: '#73abcf',
                borderWidth: 2,
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                    }
                }],
                xAxes: [{
                    ticks: {
                        maxRotation: 20,
                        minRotation: 20,
                        fontSize: 10,
                    }
                }]
            }
        }
    });
}