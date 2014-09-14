            
<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
   <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                   <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-4">
                         	<?=form_dropdown('tahun',$renstra,'0','id="program-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja</label>
                        <div class="col-md-8">
                         <?=form_dropdown('kode_e1',$eselon1,'0','id="program-kode_e1"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="program-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
                   
	<div id="program_kl_konten" class="hide">

        <!--<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#programModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="program_add();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />-->
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="program-tbl">
                <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Kode Program</th>
                    <th>Nama Program</th>
                    <th>Pagu</th>
                    <th>Realisasi</th>
                    <th>Persen</th>
                    <!--<th width="10%">Aksi</th>-->
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
	
    </div>
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="programModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="program_form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="program_title"></h5>
                </div>
                <div class="modal-body" id="program_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btnprogram-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btnprogram-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#program-btn").click(function(){
			tahun = $('#program-tahun').val();
			kode = $('#program-kode_e1').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_body_program/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#program-tbl tbody');
                            table_body.empty().html(result);        
                            $('#program_kl_konten').removeClass("hide");
                        }
                });  
		});
		program_add =function(){
			$("#program_title").html('<i class="fa fa-plus-square"></i> Tambah Program');
			$("#program_form").attr("action",'<?=base_url()?>pemrograman/pemrograman_kl/save/program');
			$.ajax({
				url:'<?=base_url()?>pemrograman/pemrograman_kl/add/program',
					success:function(result) {
						$('#program_konten').html(result);
					}
			});
		}
		program_edit =function(tahun,kode){
			$("#program_title").html('<i class="fa fa-pencil"></i> Update Program');
			$("#program_form").attr("action",'<?=base_url()?>pemrograman/pemrograman_kl/update');
			$('#program_konten').html("");
			$.ajax({
				url:'<?=base_url()?>pemrograman/pemrograman_kl/edit/program/'+tahun+'/'+kode,
					success:function(result) {
						$('#program_konten').html(result);
					}
			});
		}
		program_delete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
			
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>pemrograman/pemrograman_kl/hapus/program/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#program-btn").click();
						}
				});
			}
		}
		$("#program_form").submit(function( event ) {
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
						$('#btnprogram-close').click();
						$("#program-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btnprogram-close').click();
					}
				});
			  event.preventDefault();
		});
	})
	</script>	        