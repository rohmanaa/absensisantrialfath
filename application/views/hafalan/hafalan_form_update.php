<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-<?=$box;?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>EDIT HAFALAN</h3>
                </div>
          
                <div class="box-body">
                    
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post" autocomplete="off">
                    <input type="hidden" readonly class="form-control" name="id_karyawan" id="id_karyawan" placeholder="Id Karyawan" value="<?php echo $id_karyawan; ?>" />
                    <input type="hidden" readonly class="form-control" name="id_hafal" id="id_hafal" placeholder="Id Karyawan" value="<?php echo $id_hafal; ?>" />
                       
                    
                        <div class="form-group">
                            <label for="tglhafal" class="control-label">Tanggal Hafal <?php echo form_error('tglbaca') ?></label>
                            <div class="input-group">
                                <input type="date"  class="form-control" data-error="Tanggal harus diisi" name="tglhafal"  required id="tglhafal" placeholder="Tanggal Terakhir Baca" value="<?php echo $tglhafal; ?>"  required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group has-feedback">
                            <label for="nilaihafalan">Nilai Hafalan</label>
                            <div class="input-group">
                            <select class="js-example-basic-single form-control" id="nilaihafal" style="width:100%" name="nilaihafal" value="<?php echo $nilaihafal; ?>" >
                            <option selected disabled> Pilih  </option>
                                <option value="Sangat Baik">Sangat Baik</option>
                                <option value="Baik">Baik</option>
                                <option value="Cukup">Cukup</option>
                                <option value="Kurang">Kurang</option>
                                <option value="Sangat Kurang">Sangat Kurang</option>
                            </select>
                            <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label for="kethafalan" class="control-label">Catatan Hafal<?php echo form_error('kethafalan') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="kethafalan" id="kethafalan" placeholder="Ket Hafal" value="<?php echo $kethafalan; ?>"  required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="id_lapor" value="<?php echo $id_lapor; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('Hafalan') ?>" class="btn btn-default">Cancel</a>
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