<style media="screen">
    table,
    th,
    tr {
        text-align: center;
    }

    .dataTables_wrapper .dt-buttons {
        float: none;
        text-align: center;
    }

    .sfwal2-popup {
        font-family: inherit;
        font-size: 1.2rem;
    }

    div.dataTables_wrapper div.dataTables_length label {
        padding-top: 5px;
        font-weight: normal;
        text-align: left;
        white-space: nowrap;
    }

    .swal2-popup {
        font-family: inherit;
        font-size: 1.2rem;
    }
</style>

<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-success'>
                <div class='box-header with-border'>
                    
                <?php $Karyawan = $this->Karyawan_model->get_by_id($segment = $this->uri->segment(3)); ?>
                   <h4 class='box-title'> TABEL DATA BAYARAN <span style="text-transform:uppercase ;color:green;"><b><?php echo $Karyawan->nama_karyawan ?></b></span></h3>
                </div><!-- /.box-header -->
                <div class='box-body'>
                <div class="actionSelect">
                        <div class="col-md-3">
                            <select id="exportLink" class="form-control">
                                <option>Export Data</option>
                                <option id="csv">Export as CSV</option>
                                <option id="excel">Export as XLS</option>
                                <option id="copy">Copy to clipboard</option>
                                <option id="pdf">Export as PDF</option>
                            </select>
                        </div>
                    </div>
                    
                    <table id="mytable" class="table table-bordered table-hover display" style="width:100%;">
                        <thead>
                            <tr>
                                <th width="30px">No</th>
                                <th>Tanggal </th>
                        
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Act</th>
                            </tr>
                        </thead>
                    
                            <?php
                            $start = 0;
                            foreach($bayar_data as $by){
                            ?>
                           
                        <tbody>
                            

                            <tr><td><?php echo ++$start ?></td>
                                <td><?php echo $by->tglbayar ?></td>
                                <td><?php echo $by->jmlbyr?></td>
                                <td><?php echo $by->statusbayar?></td>
                           
                                <td>  <?php
                                        echo anchor(site_url('bayaran/update/'. $by->id_bayar), '<i class="fa fa-pencil-square-o fa-lg"></i>&nbsp;&nbsp;Edit', array('title' => 'edit', 'class' => 'btn btn-md btn-warning btn-edit-data btn3d'));
                                        ?></td>

                            </tr> 
                        <?php } ?>
                        </tbody>
                        <tr>
                            <td colspan="6" style="text-align:center;"><?php echo anchor('karyawan', 'Kembali', array('class' => 'btn btn-indigo btn-lg btn3d')); ?></td>
                        </tr>
                    </table>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $("#mytable")
                                .addClass('nowrap')
                                .dataTable({
                                    responsive: true,
                                    colReorder: true,
                                    fixedHeader: true,
                                    columnDefs: [{
                                        targets: [-1, -4],
                                        className: 'dt-responsive'
                                    }],
                                    dom: 'Blfrtip',
                                    buttons: [
                                        'colvis',
                                        {
                                            extend: 'csv',
                                            exportOptions: {
                                                columns: [0, 1, 2, 3],
                                            },
                                        },
                                        {
                                            extend: 'excel',
                                            title: 'Data <?php echo $Karyawan->nama_karyawan ?>',
                                            exportOptions: {
                                                columns: [0, 1, 2, 3],
                                            },
                                        },
                                        {
                                            extend: 'copy',
                                            title: 'Data <?php echo $Karyawan->nama_karyawan ?>',
                                            exportOptions: {
                                                columns: [0, 1, 2, 3],
                                            },
                                        },
                                        {
                                            extend: 'pdf',
                                            oriented: 'portrait',
                                            pageSize: 'legal',
                                            title: 'Data <?php echo $Karyawan->nama_karyawan ?>',
                                            download: 'open',
                                            exportOptions: {
                                                columns: [0, 1, 2, 3],
                                            },
                                            customize: function(doc) {
                                                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                                doc.styles.tableBodyEven.alignment = 'center';
                                                doc.styles.tableBodyOdd.alignment = 'center';
                                            },
                                        },
                                        {
                                            extend: 'print',
                                            oriented: 'portrait',
                                            pageSize: 'A4',
                                            title: 'Data <?php echo $Karyawan->nama_karyawan ?>',
                                            exportOptions: {
                                                columns: [0, 1, 2, 3],
                                            },
                                        },
                                    ],
                                    initComplete: function() {
                                        var $buttons = $('.dt-buttons').hide();
                                        $('#exportLink').on('change', function() {
                                            var btnClass = $(this).find(":selected")[0].id ?
                                                '.buttons-' + $(this).find(":selected")[0].id :
                                                null;
                                            if (btnClass) $buttons.find(btnClass).click();
                                        })
                                    }
                                });
                        });
                    </script>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->