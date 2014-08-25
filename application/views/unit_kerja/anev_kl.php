<!--main content start-->
<div class="panel-body">
 <header class="panel-heading">
	Identitas dan Tugas Pokok Kementerian
	<span class="pull-right">
		 <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
	 </span>
</header>
<div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Singkatan</th>
                        <th>Tugas Pokok</th>
                        <th width="10%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    
						<?php foreach($data as $d): ?>
                        <tr class="gradeX">
                            <td><?=$d->kode_kl?></td>
                            <td><?=$d->nama_kl?></td>
                            <td><?=$d->singkatan?></td>
                            <td><?=$d->tugas_kl?></td>
                            <td>
                            	<a href="<?=base_url()?>unit_kerja/anev_kl/edit/<?=$d->kode_kl?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?=base_url()?>unit_kerja/anev_kl/hapus/<?=$d->kode_kl?>" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    
                    </tbody>
                    </table>
</div>



    
    <!--main content end-->
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" action="<?=base_url()?>unit_kerja/anev_kl/save" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h4 class="modal-title">Form Kementerian</h4>
                </div>
                <div class="modal-body">
					<div class="form-group">
                        <label class="col-sm-4 control-label">Kode</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="kode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Kementerian</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Singkatan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="singkatan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>