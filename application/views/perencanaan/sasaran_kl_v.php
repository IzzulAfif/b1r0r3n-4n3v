            
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
                         	<?=form_dropdown('tahun',$renstra,'0','id="sasaran-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="sasaran-kodekl"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="sasaran-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
	
    <div id="sasaran_kl_konten" class="hide">
    	
        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#sasaranModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="sasaran_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />

        <div class="adv-table">
        <table  class="display table table-bordered table-striped" id="sasaran-tbl">
        <thead>
        <tr>
        
        
            <th width="13%">Kode Sasaran</th>
            <th>Sasaran</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        </div>

	</div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="sasaranModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="sasaran_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="sasaran_title"></h5>
                </div>
                <div class="modal-body" id="sasaran_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btnsasaran-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btnsasaran-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#sasaran-btn").click(function(){
			tahun = $('#sasaran-tahun').val();
			kode = $('#sasaran-kodekl').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#sasaran-tahun').select2('open');
			}
			else {
				$.ajax({
                    url:"<?php echo site_url(); ?>perencanaan/rencana_kl/get_body_sasaran/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#sasaran-tbl tbody');
                            table_body.empty().html(result);        
                            $('#sasaran_kl_konten').removeClass("hide");
                        }
                });  
			}
		});
		sasaran_add =function(){
			$("#sasaran_title").html('<i class="fa fa-plus-square"></i> Tambah Sasaran Kementerian');
			$("#sasaran_form").attr("action",'<?=base_url()?>perencanaan/rencana_kl/save/sasaran');
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_kl/add/sasaran',
					success:function(result) {
						$('#sasaran_konten').html(result);
					}
			});
		}
		sasaran_edit =function(tahun,kode){
			$("#sasaran_title").html('<i class="fa fa-pencil"></i> Edit Sasaran Kementerian');
			$("#sasaran_form").attr("action",'<?=base_url()?>perencanaan/rencana_kl/update');
			$('#sasaran_konten').html("");
			$.ajax({
				url:'<?=base_url()?>perencanaan/rencana_kl/edit/sasaran/'+tahun+'/'+kode,
					success:function(result) {
						$('#sasaran_konten').html(result);
					}
			});
		}
		sasaran_delete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
			
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>perencanaan/rencana_kl/hapus/sasaran/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#sasaran-btn").click();
						}
				});
			}
		}
		$("#sasaran_form").submit(function( event ) {
			
			var tahun 	= $('#form-tahun-sasaran').val();
			var kl		= $('#form-kl-sasaran').val();
			var kds		= $('#form-kode-sasaran').val();
			var sasaran	= $('#form-sasaran').val();
			
			if(tahun==""){
				alert("Periode Renstra belum ditentukan");
				return false;
			}else if(kl==""){
				alert("Nama Kementerian belum ditentukan");
				return false;
			}else if(kds==""){
				alert("Kode sasaran belum ditentukan");
				return false;
			}else if(sasaran==""){
				alert("Sasaran belum ditentukan");
				return false;
			}else{
				
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
							$('#btnsasaran-close').click();
							$("#sasaran-btn").click();
						},
						error: function(jqXHR, textStatus, errorThrown) 
						{
							//if fails
							$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
							$('#btnsasaran-close').click();
						}
					});
				  event.preventDefault();
			
			}
		});
	})
</script>	
               