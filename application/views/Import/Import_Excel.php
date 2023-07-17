<!DOCTYPE html>
<html>
<head>
	<title>Data</title>
</head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<body>

<div class="container">
	<div class="row" style="margin-top: 30px;">
		<div class="col-md-4 col-md-offset-3">
			<h3>Import Data</h3>
			<?php if(!empty($this->session->flashdata('status'))){ ?>
			<div class="alert alert-info" role="alert"><?= $this->session->flashdata('status'); ?></div>
			<?php } ?>
			<form action="<?= base_url('ImportController/import_excel'); ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Pilih File Excel</label>
					<input type="file" name="fileExcel" required>
				</div>
				<div>
					<button class='btn btn-success' type="submit">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			    		Import		
					</button>
					<?php echo anchor(site_url('bankhafal'), ' <i class="fa fa-plus"></i> &nbsp;&nbsp;Kembali', ' class="btn btn-unique btn-lg btn-create-data btn1d" hidden="true"'); ?>
                    
				</div>
			</form>
		</div>
		
	</div>
</div>
</body>
</html>