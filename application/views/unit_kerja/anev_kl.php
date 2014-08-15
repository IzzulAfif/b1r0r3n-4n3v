<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Kementerian
                        <span class="pull-right">
                            <a href="<?=base_url()?>unit_kerja/anev_kl/add" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
                         </span>
                    </header>
                    <div class="panel-body">
                    
                    <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Singkatan</th>
                        <th width="10%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    
						<?php foreach($data as $d): ?>
                        <tr class="gradeX">
                            <td><?=$d->kode_kl?></td>
                            <td><?=$d->nama_kl?></td>
                            <td><?=$d->singkatan?></td>
                            <td>
                            	<a href="<?=base_url()?>unit_kerja/anev_kl/edit/<?=$d->kode_kl?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?=base_url()?>unit_kerja/anev_kl/hapus/<?=$d->kode_kl?>" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
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