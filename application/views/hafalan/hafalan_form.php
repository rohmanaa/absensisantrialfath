<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jQueryUI/css/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?=$box;?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>INPUT HAFALAN</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">

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
                            <label for="Hafalan" class="control-label">Hafalan</label>
                            <div class="input-group">
                            <select class="js-example-basic-single form-control" style="width:100%" name="id_hafal" required>
                            <option selected disabled>   </option>
                                <?php
                                $data = $this->db->get('hafalan')->result();
                                foreach($data as $h){
                                ?>
                                <option value="<?=$h->id_hafal?>"><?=$h->bankhafalan?> (<?=$h->id_kategori?>)</option>
                                <?php }?>
                            </select>
                                <span class="input-group-addon">
                                    <span class="fas fa-retweet"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            
                            <label for="tglbaca" class="control-label">Tanggal Baca </label>
                            <div class="input-group">
                                <input type="date"  class="form-control" data-error="Tanggal harus diisi" name="tglhafal" required id="tglhafal" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                      

                        <div class="form-group has-feedback">
                            <label for="statussantri">Nilai Hafalan</label>
                            <div class="input-group">
                            <select class="js-example-basic-single form-control" id="nilaihafal" style="width:100%" name="nilaihafal">
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
                            <label for="ketbaca" class="control-label">Catatan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="kethafalan" id="kethafalan" placeholder="Keterangan" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                

                        <input type="hidden" name="id_lapor" value="<?php echo $id_lapor; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('hafalan') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script>
    $('.js-example-basic-single').select2({
  placeholder: 'Select an option'
});
</script>
