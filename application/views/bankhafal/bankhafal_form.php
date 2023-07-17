<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?=$box?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORM HAFALAN</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                     

                      <div class="form-group has-feedback">
                            <label for="bankhafalan"> Nama Hafalan <?php echo form_error('bankhafalan') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="Nama Hafalan harus diisi" name="bankhafalan" id="bankhafalan" placeholder="Nama Hafalan" value="<?php echo $bankhafalan; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="jumkahayat"> Jumlah Ayat <?php echo form_error('jumlahayat') ?></label>
                            <div class="input-group">
                                <input type="number" class="form-control" data-error="harus diisi" name="jumlahayat" id="jumlahayat" placeholder="Jumlah ayat" value="<?php echo $jumlahayat; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="tentangayat"> Tentang Ayat/Arti <?php echo form_error('tentangayat') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="harus diisi" name="tentangayat" id="tentangayat" placeholder="Arti" value="<?php echo $tentangayat; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="keteranganayat"> Keterangan Ayat <?php echo form_error('keteranganayat') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="harus diisi" name="keteranganayat" id="keteranganayat" placeholder="Keterangan" value="<?php echo $keteranganayat; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                          
                      <div class="form-group has-feedback">
                            <label for="id_kategori"> Kategori <?php echo form_error('id_kategori') ?></label>
                            <div class="input-group">
                            <select class="js-example-basic-single form-control" id="kat" style="width:100%" name="id_kategori">
                            <option selected disabled> Pilih  </option>
                                <option value="Doa">Doa</option>
                                <option value="Quran">Quran</option>
                                <option value="Ayat">Ayat Pilihan</option>
                                <option value="Hadist">Hadist</option>
                            </select>
                            <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <input type="hidden" name="id_hafal" value="<?php echo $id_hafal; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('bankhafal') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
