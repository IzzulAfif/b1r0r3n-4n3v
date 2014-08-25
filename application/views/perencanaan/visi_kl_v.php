
             
<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
   <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-2">
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="kl-tahun" class="form-control input-sm"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-4">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="kl-kodekl" class="form-control input-sm"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="proses-c1" style="margin-left:15px;">
                            <i class="fa fa-play"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
    
	
 <header class="panel-heading">
	&nbsp;
	<span class="pull-right">
		<a href="#" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
	 </span>
</header>
<div class="adv-table">
<table  class="display table table-bordered table-striped" id="dynamic-table">
<thead>
<tr>
	
	<th width="10%">Kode Visi</th>
	<th>Visi</th>
	<th width="10%">Aksi</th>
</tr>
</thead>
<tbody>
                    
		<?php if (isset($data)){foreach($data as $d): ?>
		<tr class="gradeX">
			<td><?=$d->kode_visi_kl?></td>
			
			<td><?=$d->visi_kl?></td>
			<td>
				<a href="#" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
				<a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
			</td>
		</tr>
		<?php endforeach; } else {?>
		<tr class="gradeX">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
		   
		</tr>
		<?php }?>
	
	</tbody>
</table>
</div>


 <script>
		$(document).ready(function(){
			//load_ajax_datatable('dynamic-table','<?=base_url()?>perencanaan/rencana_kl/loadvisi_table');
		});
	</script>               