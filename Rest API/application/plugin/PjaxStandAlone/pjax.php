<?php

function pjax($class = "data-pjax", $container = "container",$content = "content",$action){

	$pjax = "<script>

		var delay = (function(){
		  var timer = 0;
		  return function(callback, ms){
		    clearTimeout (timer);
		    timer = setTimeout(callback, ms);
		  };
		})();

		pjax.connect({

		'".$container."': '".$content."',";


	if(!empty($class)) $pjax .= "'useClass'  : '".$class."',";

	$pjax .= "
		'beforeSend' : function(){

			".$action["before"]."

			document.title = 'Please Wait ...';
		},
		'success': function(event){
			var url = (typeof event.data !== 'undefined') ? event.data.url : '';
			console.log(\"Successfully loaded \"+ url);
			
			".$action["success"]."

			var title = document.title;

			setTimeout(function(){

				var encodedStr = title;
				var parser = new DOMParser;
				var dom = parser.parseFromString(encodedStr,
				    'text/html');
				var decodedString = dom.body.textContent;

				document.title = decodedString;
			},1);
		},
		'error': function(event){
			var url = (typeof event.data !== 'undefined') ? event.data.url : '';
			console.log(\"Could not load \"+ url);
	
			".$action["error"]."
		},
		'ready': function(){
			console.log(\"loaded!\");
		}
	});



	function search_form(object){

		var parm = $(object).serialize();

		if($(object).attr('method').toLowerCase() == 'get'){
			var url = $(object).attr('action')+'/?'+parm;
		}else{
			var url = $(object).attr('action')+'/?post='+btoa(parm);
		}

		pjax.invoke(url,'".$content."');

		return false;
	}


	function move_page(url = null){

		pjax.invoke(url,'".$content."');
		
	}

	</script>
	";

	return $pjax;

}