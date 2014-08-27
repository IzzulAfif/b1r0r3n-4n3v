<!--main content start-->
<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
   <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-3">
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="id-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="id-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="id-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
	
    <div id="bodytable" class="hide">
    
        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="id-tbl">
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
            
                <?php if (isset($data)){foreach($data as $d): ?>
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
               <?php endforeach; } else {?>
                <tr class="gradeX">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                   
                </tr>
                <?php }?>
            
            </tbody>
            </table>
        </div>
	
    </div>
    <!--main content end-->
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" action="<?=base_url()?>unit_kerja/anev_kl/save" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title"><i class="fa fa-plus-square"></i> Form Kementerian</h5>
                </div>
                <div class="modal-body">
					<div class="form-group">
                        <label class="col-sm-4 control-label">Tahun Renstra</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="tahun">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kode</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="kode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Kementerian</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="nama">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Singkatan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="singkatan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tugas Pokok</label>
                        <div class="col-sm-8">
                            <textarea name="tugas" class="form-control"></textarea>
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
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateModal" class="modal fade">
        <div class="modal-dialog"> 
        <form method="post" action="<?=base_url()?>unit_kerja/anev_kl/update" class="form-horizontal bucket-form" role="form">  
            <div class="modal-content">
            	<div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title"><i class="fa fa-pencil"></i> Update Kementerian</h5>
                </div>
                <div class="modal-body" id="edit_konten">
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
    
<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#id-btn").click(function(){
			tahun = $('#id-tahun').val();
			kl = $('#id-kodekl').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/anev_kl/get_body_identitas/"+tahun+"/"+kl,
                        success:function(result) {
                            table_identitas = $('#id-tbl tbody');
                            table_identitas.empty().html(result);        
                            $('#bodytable').removeClass("hide");
                        }
                });  
		});
	});
	
	function edit(id)
	{
		$.ajax({
			url:'<?=base_url()?>unit_kerja/anev_kl/edit/'+id,
				success:function(result) {
					$('#edit_konten').html(result);
				}
		});
	}
</script>	