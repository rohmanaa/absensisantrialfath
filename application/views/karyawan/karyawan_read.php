<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class="box box-success">
                <div class='box-header with-border'>
                    <h3 class='box-title'>Santri Read</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Kode NIS</td>
                            <td><?php echo $id_karyawan; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Santri</td>
                            <td><?php echo $nama_karyawan; ?></td>
                        </tr>
                        <tr>
                            <td>TTL</td>
                            <td><?php echo $tempat_lahir; ?>, <?php echo $tgl_lahir; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td><?php echo $jeniskelamin; ?></td>
                        </tr>
                        <tr>
                            <td>No HP</td>
                            <td><?php echo $nohp; ?></td>
                        </tr>
                        <tr>
                            <td>Orang Tua</td>
                            <td cols='2'>Ayah : <?php echo $ayah; ?><br>
                            Ibu : <?php echo $ibu; ?><br>
                            No. Wa : <?php echo $nowa; ?></td>
                          
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><?php echo $alamat; ?></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><?php echo $password; ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><?php echo $statussantri; ?></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td><?php echo $nama_shift; ?></td>
                        </tr>
           
                        <tr>
                            <td colspan="2" style="text-align:center;"><a href="<?php echo site_url('karyawan') ?>" class="btn-xs btn btn-primary">Kembali</a></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->