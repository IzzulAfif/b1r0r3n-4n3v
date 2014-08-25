
             
<div class="feed-box">

                <form class="form-horizontal" role="form">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
  			 <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                       
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Periode Renstra</label>
                        <div class="col-sm-3">
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="kl-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nama Kementerian</label>
                        <div class="col-sm-5">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="kl-kodekl" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-8">
                        <button type="button" class="btn btn-info btn-sm" id="proses-c1">
                            <i class="fa fa-play"></i> Tampilkan Data
                        </button>
                        </div>
                    </div>			 
                
                
            </div>
        </section>
        </form>
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

<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
	});
</script>