<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?=$box?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORM DATA DOA</h3>
                </div>
                <div class="box-body">
                <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                     

                      <div class="form-group has-feedback">
                            <label for="judul"> Nama Doa <?php echo form_error('judul') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="Nama  harus diisi" name="judul" id="judul" placeholder="Nama Doa" value="<?php echo $judul; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>


                        <div class="form-group has-feedback">
                            <label for="arab"> Arab<?php echo form_error('arab') ?></label>
                            <div class="input-group">
                            <input type="text" class="form-control" data-error="harus diisi" name="arab" id="arab" placeholder="arab" value="<?php echo $arab; ?>" required/>
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>


                        <div class="form-group has-feedback">
                            <label for="latin"> Latin<?php echo form_error('latin') ?></label>
                            <div class="input-group">
                            <input type="text" class="form-control" data-error="harus diisi" name="latin" id="latin" placeholder="latin" value="<?php echo $latin; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="keteranganayat"> Arti <?php echo form_error('arti') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="harus diisi" name="arti" id="arti" placeholder="Arti" value="<?php echo $arti; ?>" required/>
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="keteranganayat"> Informasi <?php echo form_error('informasi') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="harus diisi" name="informasi" id="informasi" placeholder="Informasi" value="<?php echo $informasi; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                          


                        <input type="hidden" name="id_doa" value="<?php echo $id_doa; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('basedoa') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
