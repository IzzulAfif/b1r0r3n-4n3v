<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Data Eselon I
                        <span class="pull-right">
                            <a href="#" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
                         </span>
                    </header>
                    <div class="panel-body">
                    
                    <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Kode Unit Kerja</th>
                        <th>Nama Unit Kerja</th>
                        <th>Singkatan</th>
                        <th width="10%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    
						<?php foreach($data as $d): ?>
                        <tr class="gradeX">
                            <td><?=$d->kode_e1?></td>
                            <td><?=$d->nama_e1?></td>
                            <td><?=$d->singkatan?></td>
                            <td>
                            	<a href="#" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    
                    </tbody>
                    </table>
                    </div>
                    </div>
                </section>
            </div>
        </div>
        </section>
    </section>
    <!--main content end-->