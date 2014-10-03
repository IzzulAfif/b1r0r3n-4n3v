            
<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
   <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                     <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         	<?=form_dropdown('tahun',$renstra,'0','id="tujuan-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="tujuan-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="tujuan-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
    
    <div id="tujuan_kl_konten" class="hide">
    
        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#tujuanModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="tujuan_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />

        <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="tujuan-tbl">
        <thead>
        <tr>
          
            <th width="10%">Kode Tujuan</th>
            <th>Tujuan</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        </div>

	</div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="tujuanModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="tujuan_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="tujuan_title"></h5>
                </div>
                <div class="modal-body" id="tujuan_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btntujuan-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btntujuan-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#tujuan-btn").click(function(){
			tahun = $('#tujuan-tahun').val();
			kode = $('#tujuan-kodekl').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>perencanaan/rencana_kl/get_body_tujuan/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#tujuan-tbl tbody');
                            table_body.empty().html(result);        
                            $('#tujuan_kl_konten').removeClass("hide");
                        }
                });  
		});
		tujuan_add =function(){
			$("#tujuan_title").html('<i class="fa fa-plus-square"></i> Tambah Tujuan Kementerian');
			$("#tujuan_form").attr("action",'<?=base_url()?>perencanaan/rencana_kl/save/tujuan');
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_kl/add/tujuan',
					success:function(result) {
						$('#tujuan_konten').html(result);
					}
			});
		}
		tujuan_edit =function(tahun,kode){
			$("#tujuan_title").html('<i class="fa fa-pencil"></i> Update Tujuan Kementerian');
			$("#tujuan_form").attr("action",'<?=base_url()?>perencanaan/rencana_kl/update');
			$('#tujuan_konten').html("");
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_kl/edit/tujuan/'+tahun+'/'+kode,
					success:function(result) {
						$('#tujuan_konten').html(result);
					}
			});
		}
		tujuan_delete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
			
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>perencanaan/rencana_kl/hapus/tujuan/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#tujuan-btn").click();
						}
				});
			}
		}
		$("#tujuan_form").submit(function( event ) {
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
						$('#btntujuan-close').click();
						$("#tujuan-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btntujuan-close').click();
					}
				});
			  event.preventDefault();
		});
	})
</script>	               
               