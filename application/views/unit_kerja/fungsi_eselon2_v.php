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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="fungsi-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="fungsi-kode_e1" class="populate" style="width:100%"')?>
                        </div>
                    </div> 
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e2',array("0"=>"Pilih Unit Kerja Eselon II"),'0','id="fungsi-kode_e2" class="populate"  style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="fungsi-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>
<!--main content start-->

	<div class="hide" id="fungsi_es2">
    
 		<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table">
		<table  class="display table table-bordered table-striped" id="fungsi-tbl">
		<thead>
		<tr>
			<th>Kode</th>
			<th>Fungsi</th>
			
			<th width="10%">Aksi</th>
		</tr>
		</thead>
		<tbody>
		
			
			<?php if (isset($data)){foreach($data as $d): ?>
			<tr class="gradeX">
				<td><?=$d->kode_fungsi_e2?></td>
			
				<td><?=$d->fungsi_e2?></td>
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
   </div>
   
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#fungsi-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_list_eselon2/"+this.value,
				success:function(result) {
					kode_e2=$("#fungsi-kode_e2");
					kode_e2.empty();
					result = JSON.parse(result);
					for (k in result) {
						kode_e2.append(new Option(result[k],k));
					}
				}
			});
		});
		
		$("#fungsi-btn").click(function(){
			tahun = $('#fungsi-tahun').val();
			kode = $('#fungsi-kode_e1').val();
			kode2 = $('#fungsi-kode_e2').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_body_fungsi/"+tahun+"/"+kode+"/"+kode2,
                        success:function(result) {
                            table_body = $('#fungsi-tbl tbody');
                            table_body.empty().html(result);        
                            $('#fungsi_es2').removeClass("hide");
                        }
                });  
		});
	});
</script>	

    
    <!--main content end-->
    
    