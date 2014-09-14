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
                         		<?=form_dropdown('tahun',$tahun_renstra,'0','id="fungsi-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="fungsi-kode_e1" class="populate" style="width:100%"')?>
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
	<div id="fungsi_es1" class="hide">
    	<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#fungsiModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="fungsiAdd();"><i class="fa fa-plus-circle"></i> Tambah</a>
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
                <td><?=$d->kode_fungsi_e1?></td>
            
                <td><?=$d->fungsi_e1?></td>
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
    <!--main content end-->
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="fungsiModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="fungsi-form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="fungsi_title_form"></h5>
                </div>
                <div class="modal-body" id="fungsi_form_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btnf-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btnf-save" class="btn btn-info">Simpan</button>
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
		$("#fungsi-btn").click(function(){
			tahun = $('#fungsi-tahun').val();
			kode = $('#fungsi-kode_e1').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>unit_kerja/eselon1/get_body_fungsi/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#fungsi-tbl tbody');
                            table_body.empty().html(result);        
                            $('#fungsi_es1').removeClass("hide");
                        }
                });  
		});
		
		fungsiAdd =function(){
			$("#fungsi_title_form").html('<i class="fa fa-plus-square"></i>  Tambah Fungsi Eselon I');
			$("#fungsi-form").attr("action",'<?=base_url()?>unit_kerja/eselon1/save');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon1/add/fungsi',
					success:function(result) {
						$('#fungsi_form_konten').html(result);
					}
			});
		}
		
		fungsiEdit = function(tahun,kode){
			$("#fungsi_title_form").html('<i class="fa fa-pencil"></i>  Update Fungsi Eselon I');
			$("#fungsi-form").attr("action",'<?=base_url()?>unit_kerja/eselon1/update');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon1/edit/fungsi/'+tahun+'/'+kode,
					success:function(result) {
						$('#fungsi_form_konten').html(result);
					}
			});
		}
		
		 fungsiDelete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
		
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>unit_kerja/eselon1/hapus/fungsi/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#fungsi-btn").click();
						}
				});
			}
		}
		
		$( "#fungsi-form" ).submit(function( event ) {
			 var postData = $(this).serializeArray();
				var formURL = $(this).attr("action");
				$.ajax(
				{
					url : formURL,
					type: "POST",
					data : postData,
					success:function(data, textStatus, jqXHR) 
					{
						//data: return data from server
						$.gritter.add({text: data});
						$("#btnf-close").click();
						$("#fungsi-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails   
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btnf-close').click();   
					}
				});
			
			  event.preventDefault();
		});
		
	});
</script>	
    
    