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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="id-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="id-kode_e1" class="populate" style="width:100%"')?>
                        </div>
                    </div> 
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="id-btn" style="margin-left:15px;">
                            <i class="fa fa-play"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

<!--main content start-->
 <header class="panel-heading">
	&nbsp;
	<span class="pull-right">
		 <a href="#" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>
	 </span>
</header>
<div class="adv-table">
<table class="display table table-bordered table-striped" id="id-tbl">
<thead>
	<tr>
		
		<th>Kode Unit Kerja</th>
		<th>Nama Unit Kerja</th>
		<th>Singkatan</th>
		<th>Tugas Pokok</th>
		<th width="10%">Aksi</th>
	</tr>
</thead>
<tbody>

	<?php if (isset($data)){foreach($data as $d): ?>
	<tr class="gradeX">
		
		<td><?=$d->kode_e2?></td>
		<td><?=$d->nama_e2?></td>
		<td><?=$d->singkatan?></td>
		<td><?=$d->tugas_e2?></td>
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
		<td>&nbsp;</td>
	   
	</tr>
	<?php }?>

</tbody>
</table>
</div>
                   
    <!--main content end-->
 <script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#id-btn").click(function(){
			tahun = $('#id-tahun').val();
			kode = $('#id-kode_e1').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_body_identitas/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#id-tbl tbody');
                            table_body.empty().html(result);        
                            
                            
                        }
                });  
		});
	});
</script>	   
    <script>
		$(document).ready(function(){
			//load_ajax_datatable('table_e2','<?=base_url()?>unit_kerja/eselon2/load_data_e2');
		});
	</script>