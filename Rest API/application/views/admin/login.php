<!DOCTYPE html>
<html>
<head>
	<title>Selamat Datang di BangunanKu</title>
	<link rel="stylesheet" href="{sourceURL}/bootstrap/css/bootstrap.css">
	<link rel="icon" type="image/png" href="{sourceURL}/assets/images/favicon/favicon.png"/>

	<script src="{sourceURL}/assets/js/jquery-3.5.1.min.js"></script>
	<script src="{sourceURL}/bootstrap/js/bootstrap.js"></script>
</head>
<body style="background: #f5f5f5">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default" style="margin-top: 100px;">
					<div class="panel panel-body">
						<div style="text-align: center;border-bottom: 2px #ddd dashed; margin-bottom: 10px;padding-bottom: 10px;">
							<img src="{sourceURL}/assets/images/logo/logo.png" style="width: 180px">
							<p style="margin-top: 10px;"s>Adalah halaman khusus untuk admin memverifikasi data laporan kerusakan.</p>
						</div>
						<form method="POST" action="{homeURL}/service_login">
							<label>Email</label>
							<input type="email" name="email" class="form-control">
							<p></p>
							<label>Password</label>
							<input type="password" name="password" class="form-control">
							<p id="message" style="color: #ff0000;margin-top: 20px;border-top: 2px #ddd dashed;padding-top:5px;"></p>
							<button class="btn btn-primary" style="width: 100%">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>



	<script>
		$(document).ready(function(){
			$("form").submit(function(){
				var obejct = $(this);
				$.ajax({
					type: $(this).attr("method"),
					url: $(this).attr("action"),
					data: $(this).serialize(),
					beforeSend: function()
					{
						$("button").html("Please Wait ...");
					},
					success: function(event)
					{
						var json = event;

						if (json.response == true)
						{
							$("button").html("Success, redirecting ...");
							$.get("{homeURL}/admin/token?access_token="+json.access_token, function(){
								setTimeout(function(){ window.location.reload() }, 2000);
							});
						}
						else
						{
							$("#message").html("*"+json.message);
							$("button").html("Login");
						}
					}
				});

				return false;
			});
		});
	</script>

</body>
</html>