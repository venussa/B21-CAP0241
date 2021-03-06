<!DOCTYPE html>
<html>
<head>
	<title>BangunanKu - List Laporan</title>
	<link rel="icon" type="image/png" href="{sourceURL}/assets/images/favicon/favicon.png"/>
	<link rel="stylesheet" href="{sourceURL}/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="{sourceURL}/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{sourceURL}/bootstrap/css/dataTables.bootstrap.min.css" />

	<script src="{sourceURL}/assets/js/jquery-3.5.1.min.js"></script>
	<script src="{sourceURL}/bootstrap/js/bootstrap.js"></script>
	<script src="{sourceURL}/bootstrap/js/jquery.dataTables.min.js"></script>
    <script src="{sourceURL}/bootstrap/js/dataTables.bootstrap.min.js"></script>

    <style>
    	.navmenu{
    		right:0px;
    		top: 15px;
    		position: absolute;
    	}
    	.navmenu a{
    		padding: 10px;
    		color:#666;
    		font-size: 17px;
    		text-decoration: none;
    	}
    	.navmenu a:hover{
    		font-weight: 600;
    		color: #434343;
    	}
    </style>
</head>
<body style="background: #f5f5f5">
	<?php $this->view("admin/navbar")?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default" style="margin-top: 100px;">
					<div class="panel-body">
						<div style="border-bottom: 2px #ddd dashed;padding-bottom: 20px;margin-bottom: 20px;">
							<h2>Laporan Kerusakan</h2>
							<p>Ini adalah halaman yang menampilkan daftar laporan kerusakan yang mana setiap laporan kerusakan akan di verifikasi untuk di tindak lanjuti kebenarannya.</p>
						</div>
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th style="width: 25px;">R-ID</th>
									<th>Name</th>
									<th style="width: 250px;">Location Info</th>
									<th style="width: 250px;">Prediction Report</th>
									<th style="width: 200px;">Status 
										<small style="font-weight: 400; font-size: 12px; color: #666">(Switch to Verif)</small>
									</th>
								</tr>
							</thead>
							<tbody>

							<?php
								$data = Curl(HomeUrl()."/service_log_report?page=1&limit=200&token=".$_SESSION["token"]);
								$data = json_decode($data);
								foreach($data->data as $key => $value)
								{ 

								$geocord = explode(",", $value->geocordinate);
								$maps_url = "https://www.google.com/maps/search/".$geocord[0].",".$geocord[1];
							?>

								<tr>
									<td><?php echo $value->id?></td>
									<td>
										<p>
											<strong><?php echo $value->fullname?></strong> <br>
											<a href="mailto:<?php echo $value->email?>"><?php echo $value->email?></a>
										</p>
									</td>
									<td>
										<div>
											<p><?php echo $value->address?></p>
											<p>
											<a href="<?php echo $value->image?>" style="text-decoration: none;" target="_blank">Lihat gambar</a> | 
											<a href="<?php echo $maps_url?>" style="text-decoration: none;" target="_blank">Buka pada Peta</a></p>
										</div>
									</td>
									<td>
										<p><strong>Jenis Prediksi :</strong> <?php echo $value->scan_type?></p>
										<p><strong>Jenis Bangunan :</strong> <?php echo $value->buildtype?></p>
										<p><strong>Tingkat Kerusakan :</strong>
											<?php 
												if ($value->damage_lvl === "Tidak Rusak")
												{ ?>
													<span class="label label-success"><?php echo $value->damage_lvl?></span>
												<?php }
												else if ($value->damage_lvl === "Rusak Sedang")
												{ ?>
													<span class="label label-warning"><?php echo $value->damage_lvl?></span>
												<?php }
												else
												{ ?>
													<span class="label label-danger"><?php echo $value->damage_lvl?></span>
												<?php }
											?>
										</p>
										<p><strong>Tanggal Lapor :</strong> <?php echo $value->datetime?></p>
									</td>
									<td>
										<p>
										   <?php 
											   	if ($value->status == 1)
											   	{ ?>
											   		<img src="{sourceURL}/assets/images/background/on.png"style="width: 80px; cursor: not-allowed;">
											   	<?php }
											   	else 
											   	{ ?>
											   		<img data-id="<?php echo $value->id?>" src="{sourceURL}/assets/images/background/off.png" onclick="return verif_now(this)" process_token="<?php echo $value->process_token?>" style="cursor: pointer;width: 80px">
											   	<?php }
										   	?>
										</p>
										<p style="font-size: 12px;"><i class="date-<?php echo $value->id?>">
											<?php if($value->verified_timestamp !== "-") echo $value->verified_timestamp ?>
											</i></p>
									</td>
								</tr>

								<?php }
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function verif_now(object)
		{
			if(confirm("Apakah anda sudah memastikan data yang di laporkan adalah benar ?"))
			{
				$.ajax({
					type: "POST",
					url: "{homeURL}/service_report_verification?token=<[token]>&process_token="+$(object).attr("process_token"),
					data: {
						status: 1,
					},
					success: function(event)
					{
						var json = event;
						var id = $(object).attr("data-id");
						$(object).removeAttr("onclick");
						$(object).css({
							"cursor" : "not-allowed"
						});
						$(".date-"+id).html(json.datetime);
						$(object).attr("src", "{sourceURL}/assets/images/background/on.png");
					}
				});
			}
		}
		$('#example').DataTable();
	</script>
</body>
</html>