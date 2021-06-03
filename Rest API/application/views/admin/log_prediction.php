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
							<h2>Catatan Prediksi</h2>
							<p>Ini adalah halaman yang mencatat riwayat prediksi kerusakan bangunan oleh Machine Learning.</p>
						</div>
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th style="width: 10px;">P-ID</th>
									<td>Email</td>
									<td style="width: 250px;">Scan Type</td>
									<td>Damage Level</td>
									<td>Date</td>
								</tr>
							</thead>
							<tbody>

							<?php
								$data = Curl(HomeUrl()."/service_log_process?page=1&limit=200&token=".$_SESSION["token"]);
								$data = json_decode($data);
								foreach($data->data as $key => $value)
								{ 
							?>

								<tr>
									<td><?php echo $value->id?></td>
									<td>
										<a href="mailto:<?php echo $value->email?>"><?php echo $value->email?></a>
									</td>
									<td><?php echo $value->scan_type?> [<a href="<?php echo $value->image?>" style="text-decoration: none;" target="_blank">Lihat gambar</a>]</td>
									<td><?php echo $value->damage_lvl?></td>
									<td><?php echo $value->date_time?></td>
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
		$('#example').DataTable();
	</script>
</body>
</html>