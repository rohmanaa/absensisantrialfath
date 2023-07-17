<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-<?=$box;?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>INPUT CAPAIAN PRESTASI</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post" autocomplete="off">
                      
                    <div class="form-group">
                     <label for="id_karyawan" class="control-label">Nama Santri</label>
                            <div class="input-group">
                            <select class="js-example-basic-single form-control" style="width:100%" name="id_karyawan" required>
                            <option selected disabled>   </option>
                                <?php
                                $data = $this->db->get('karyawan')->result();
                                foreach($data as $k){
                                ?>
                                <option value="<?=$k->id_karyawan?>"><?=$k->nama_karyawan?></option>
                                <?php }?>
                            </select>
                                
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            
                            <label for="tgllomba" class="control-label">Tanggal <?php echo form_error('tgllomba') ?></label>
                            <div class="input-group">
                                <input type="date"  class="form-control" data-error="Tanggal harus diisi" name="tgllomba" required id="tgllomba" placeholder="Tanggal" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="jenislomba" class="control-label">jenislomba <?php echo form_error('jenislomba') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="jenislomba" id="jenislomba" placeholder="Jenis Lomba" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="juara" class="control-label">Juara <?php echo form_error('juara') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="juara" id="juaraa" placeholder="Juara" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="penyelenggara" class="control-label">Penyelenggara <?php echo form_error('penyelenggara') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="penyelenggara" id="penyelenggara" placeholder="Penyelenggara" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ketlomba" class="control-label">Ket <?php echo form_error('ketlomba') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="ketlomba" id="ketlomba" placeholder="Ket Lomba" required />
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