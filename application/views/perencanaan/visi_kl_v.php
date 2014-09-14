            
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
                         	<?=form_dropdown('tahun',$renstra,'0','id="visi-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="visi-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="visi-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>

            </div>
        </section>
    </div>
    
    
	<div id="visi_kl_konten" class="hide">

        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#visiModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="visi_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
    
        <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="visi-tbl">
        <thead>
        <tr>
            
            <th width="10%">Kode Visi</th>
            <th>Visi</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
            
        </tbody>
        </table>
        </div>

	</div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="visiModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="visi_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="visi_title"></h5>
                </div>
                <div class="modal-body" id="visi_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btnvisi-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btnvisi-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
<style type="text/css">
	select {width:100%;}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#visi-btn").click(function(){
			tahun = $('#visi-tahun').val();
			kode = $('#visi-kodekl').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>perencanaan/rencana_kl/get_body_visi/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#visi-tbl tbody');
                            table_body.empty().html(result);        
							$('#visi_kl_konten').removeClass("hide");
                        }
                });  
		});
		visi_add =function(){
			$("#visi_title").html('<i class="fa fa-plus-square"></i> Tambah Visi Kementerian');
			$("#visi_form").attr("action",'<?=base_url()?>perencanaan/rencana_kl/save/visi');
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_kl/add/visi',
					success:function(result) {
						$('#visi_konten').html(result);
					}
			});
		}
		visi_edit =function(tahun,kode){
			$("#visi_title").html('<i class="fa fa-pencil"></i> Update Visi Kementerian');
			$("#visi_form").attr("action",'<?=base_url()?>perencanaan/rencana_kl/update');
			$('#visi_konten').html("");
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_kl/edit/visi/'+tahun+'/'+kode,
					success:function(result) {
						$('#visi_konten').html(result);
					}
			});
		}
		visi_delete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
			
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>perencanaan/rencana_kl/hapus/visi/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#visi-btn").click();
						}
				});
			}
		}
		$("#visi_form").submit(function( event ) {
			var postData = $(this).serializeArray();
			var formURL = $(this).attr("action");
				$.ajax({
					url : formURL,
					type: "POST",
					data : postData,
					success:function(data, textStatus, jqXHR) 
					{
						//data: return data from server
						$.gritter.add({text: data});
						$('#btnvisi-close').click();
						$("#visi-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btnvisi-close').click();
					}
				});
			  event.preventDefault();
		});
	})
</script>               
