<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Upload</title>
</head>
<body>
	<div class="container">
		<div class="col-sm-4 col-md-offset-4">
		<h4>Upload Foto Santri</h4>

        <form action="<?php echo $action; ?>" id="myForm" method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<input type="text" name="ktr" class="form-control" placeholder="Keterangan">
				</div>
				<div class="form-group">
                <input type="file" name="nama_foto" id="nama_foto" required>
				</div>

				<div class="form-group">
                <button type="submit" class="button button-primary">Upload</button>
				</div>
			</form>	
		</div>
	</div>
</body>
</html>