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
                         		<?=form_dropdown('tahun',$tahun_renstra,'0','id="fungsi-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="fungsi-kode_e1" class="populate" style="width:100%"')?>
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
        <div class="adv-table" id="div-e1-fungsi">
        
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
			if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#fungsi-tahun').select2('open');
					return;
			}
			$("#div-e1-fungsi").load("<?php echo site_url(); ?>unit_kerja/eselon1/get_body_fungsi/"+tahun+"/"+kode);
			 $('#fungsi_es1').removeClass("hide");
		});
		
		 $("#fungsi-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>unit_kerja/eselon1/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#fungsi-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#fungsi-kode_e1').append(new Option(result[k],k));
						}
						$("#fungsi-kode_e1").select2("val", "0");
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
    
    