<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?=$box?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORM AKADMEIK</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                     

                      <div class="form-group has-feedback">
                            <label for="tahun"> Tahun Akademik <?php echo form_error('tahun') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-error="Tahun Isi" name="tahun" id="tahun" placeholder="Tahun" value="<?php echo $tahun; ?>" required />
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="status">Status</label>
                            <div class="input-group">
                            <select class="js-example-basic-single form-control" id="status" style="width:100%" name="status" required>
                            <option selected disabled> Pilih  </option>
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                            <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        

                        <input type="hidden" name="id_ajaran" value="<?php echo $id_ajaran; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('akademik') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
