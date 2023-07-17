<style media="screen">
    table,
    th,
    tr {
        text-align: center;
    }

    .swal2-popup {
        font-family: inherit;
        font-size: 1.2rem;
    }
</style>
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-primary'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>DATA TIDAK ABSEN</h3>

                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                
                    <div class="pull-right">
                   
                     <button type="submit" name="submit" class="btn btn-success">Add Selected</button>        
                     </div>
                      
            <div class="box-body">
                <table id="mytable" class="table table-bordered table-hover table-responsive display" width="100%">
                        <thead>
                            <tr>
                                <th class="all">No.</th>
                                <th class="all">Nama</th>
                               
                            </tr>
                        </thead>
                     
                            <?php
                        $start = 0;
                        date_default_timezone_set("Asia/Jakarta");
                        $tgll=date('Y-m-d');
                        foreach ($Presensi_data as $Presensi) {?>
                            <tr>
                                <td><?php echo ++$start ?></td>
                                <input type="hidden" name="id_karyawan" value="<?= $Presensi->id_karyawan ?>" />
                                <td><?=$Presensi->nama_karyawan ?></td>
                                <input type='hidden' name='id_status' value='4'/>
                                <input type='hidden' name='id_khd' value='4'/>
                                <input type='hidden' name='tgl' value='<?=$tgll?>'/>
                                <td> <input type='hidden' name='ket' value='Tidak Absen dan Tanpa Keterangan'/></td>
                                                          </tr> <?php } ?>
                        </tbody>
                    </table>
                    <div class="pull-right">
                  
       
                         
                       </div>
                </form>
                <?php echo anchor(site_url('presensi'), ' <i class="fa fa-backward"></i> &nbsp;&nbsp; Kembali', ' class="btn btn-info btn-lg btn-create-data btn3d"'); ?>
       
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $("#mytable")
                                .addClass('nowrap')
                                .dataTable({
                                    responsive: true,
                                    columnDefs: [{
                                        targets: [-1, -3],
                                        className: 'dt-responsive'
                                    }],
                                });
                        });
                    </script>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script>
    $(document).ready(function() {
        let checkLogin = '<?= $result ?>';
        if (checkLogin == 0) {
            $('.btn-create-data').hide();
            $('.btn-edit-data').hide();
            $('.btn-remove-data').hide();
        }
    });
</script>