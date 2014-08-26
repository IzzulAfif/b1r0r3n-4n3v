           
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
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="iku-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="iku-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="iku-btn" style="margin-left:15px;">
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
<table  class="display table table-bordered table-striped" id="iku-tbl">
<thead>
<tr>
	
	<th>Sasaran Strategis</th>
	<th>Kode IKU</th>
	<th>Deskripsi</th>                        
	<th width="10%">Aksi</th>
</tr>
</thead>
<tbody>

	<?php if (isset($data)){foreach($data as $d): ?>
	<tr class="gradeX">
		
		<td><?=$d->sastra_deskripsi?></td>
		<td><?=$d->kode_iku_kl?></td>                            
		<td><?=$d->deskripsi?></td>
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
		<td>&nbsp;</td>
	 
	</tr>
	<?php }?>

</tbody>
</table>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#iku-btn").click(function(){
			tahun = $('#iku-tahun').val();
			kode = $('#iku-kodekl').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_body_iku/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#iku-tbl tbody');
                            table_body.empty().html(result);        
                            
                            
                        }
                });  
		});
	
	})
</script>	
                   