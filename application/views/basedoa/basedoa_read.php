<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class="box box-success">
                <div class='box-header with-border'>
                    <h3 class='box-title'>Detail Doa</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">

                        <tr>
                            <td>Nama</td>
                            <td><?php echo $judul; ?></td>
                        </tr>
                        <tr>
                            <td>Arab</td>
                            <td><?php echo $arab; ?></td>
                        </tr>
                        <tr>
                            <td>LAtin</td>
                            <td><?php echo $latin; ?></td>
                        </tr>
                        <tr>
                            <td>Arti</td>
                            <td><?php echo $arti; ?></td>
                        </tr>
   
                        <tr>
                            <td>Info</td>
                            <td><?php echo $informasi; ?></td>
                        </tr>

           
                        <tr>
                            <td colspan="2" style="text-align:center;"><a href="<?php echo site_url('basedoa') ?>" class="btn-xs btn btn-primary">Kembali</a></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->