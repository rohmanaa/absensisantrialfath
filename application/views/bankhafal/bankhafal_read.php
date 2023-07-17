<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class="box box-success">
                <div class='box-header with-border'>
                    <h3 class='box-title'>Detail Hafalan</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Kode Hafalan</td>
                            <td><?php echo $id_hafal ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><?php echo $bankhafalan; ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td><?php echo $jumlahayat; ?></td>
                        </tr>
                        <tr>
                            <td>Tentang Ayat</td>
                            <td><?php echo $tentangayat; ?></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td><?php echo $keteranganayat; ?></td>
                        </tr>
   
                        <tr>
                            <td>Kategori</td>
                            <td><?php echo $id_kategori; ?></td>
                        </tr>

           
                        <tr>
                            <td colspan="2" style="text-align:center;"><a href="<?php echo site_url('bankhafal') ?>" class="btn-xs btn btn-primary">Kembali</a></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->