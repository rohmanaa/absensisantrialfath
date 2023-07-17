<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-<?=$box;?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>INPUT CAPAIAN BACAAN</h3>
                </div>
          
                <div class="box-body">
                    
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post" autocomplete="off">
                    <input type="hidden" readonly class="form-control" name="id_karyawan" id="id_karyawan" placeholder="Id Karyawan" value="<?php echo $id_karyawan; ?>" />
                      
                    
                        <div class="form-group">
                            
                            <label for="tglbaca" class="control-label">Tanggal Baca <?php echo form_error('tglbaca') ?></label>
                            <div class="input-group">
                                <input type="date"  class="form-control" data-error="Tanggal harus diisi" name="tglbaca"  required id="tglbaca" placeholder="Tanggal Terakhir Baca" value="<?php echo $tglbaca; ?>"  required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ketbaca" class="control-label">Pencapaian Baca <?php echo form_error('jam_klr') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="ketbaca" id="ketbaca" placeholder="Keterangan Baca" value="<?php echo $ketbaca; ?>"  required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="id_capai" value="<?php echo $id_capai; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('Bacaan') ?>" class="btn btn-default">Cancel</a>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datepicker/datepicker3.css">
<script src="<?php echo base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        showAnim: "slideDown",

        autoclose: true,
    });
</script>
<script>
    $('.js-example-basic-single').select2({
  placeholder: 'Select an option'
});
</script>