<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-<?=$box;?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>EDIT PRESTASI</h3>
                </div>
          
                <div class="box-body">
                    
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post" autocomplete="off">
                    <input type="hidden" class="form-control" name="id_karyawan" id="id_karyawan" placeholder="Id Karyawan" value="<?php echo $id_karyawan; ?>" />
                      
                    
                        <div class="form-group">
                            
                            <label for="tgllomba" class="control-label">Tanggal <?php echo form_error('tgllomba') ?></label>
                            <div class="input-group">
                                <input type="date"  class="form-control" data-error="Tanggal" name="tgllomba"  required id="tgllomba" placeholder="Tanggal Terakhir Baca" value="<?php echo $tgllomba; ?>"  required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="jenislomba" class="control-label">Jenis Lomba<?php echo form_error('jenislomba') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="jenislomba" id="jenislomba" placeholder="Jenis Lomba" value="<?php echo $jenislomba; ?>"  required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="juara" class="control-label">Juara<?php echo form_error('juara') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="juara" id="juara" placeholder="Juara" value="<?php echo $juara; ?>"  required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="penyelenggara" class="control-label">Penyelenggara<?php echo form_error('penyelenggara') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="penyelenggara" id="penyelenggara" placeholder="" value="<?php echo $penyelenggara; ?>"  required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ketlomba" class="control-label">ket Lomba<?php echo form_error('ketlomba') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="ketlomba" id="ketlomba" placeholder="Lomba" value="<?php echo $ketlomba; ?>"  required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="id_prestasi" value="<?php echo $id_prestasi; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('Prestasi') ?>" class="btn btn-default">Cancel</a>
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