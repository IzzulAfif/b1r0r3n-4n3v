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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="tujuan-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="tujuan-kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="tujuan-btn" style="margin-left:15px;">
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
<table  class="display table table-bordered table-striped" id="tujuan-tbl">
<thead>
<tr>
	<th>Kode Tujuan</th>
	<th>Tujuan</th>
	<th width="10%">Aksi</th>
</tr>
</thead>
<tbody>

	<?php 	if (isset($data)){ foreach($data as $d): ?>
	<tr class="gradeX">
		<td><?=$d->kode_tujuan_e1?></td>
		<td><?=$d->tujuan_e1?></td>
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

<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#tujuan-btn").click(function(){
			tahun = $('#tujuan-tahun').val();
			kode = $('#tujuan-kode_e1').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>perencanaan/rencana_eselon1/get_body_tujuan/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#tujuan-tbl tbody');
                            table_body.empty().html(result);        
                            
                            
                        }
                });  
		});
	})
</script>	
               