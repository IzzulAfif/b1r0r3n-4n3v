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
                         		<?=form_dropdown('tahun',$renstra,'0','id="id-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e1',array("0"=>"Pilih Unit Kerja Eselon I"),'0','id="id-kode_e1" class="populate" style="width:100%"')?>
                        </div>
                    </div> 
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e2',array("0"=>"Semua Unit Kerja Eselon II"),'0','id="id-kode_e2" class="populate"  style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="id-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>

<!--main content start-->
	<div class="hide" id="konten_es2">
    
 		<div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                     <a href="#identitasModal" data-toggle="modal" onclick="identitasAdd()" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table" id="div-id-e2">
       
        </div>
	</div>                   
    <!--main content end-->
    
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="identitasModal" class="modal fade">
        <div class="modal-dialog">
        <form method="post" id="identitas-form" class="form-horizontal bucket-form" role="form">    
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                    <h5 class="modal-title" id="identitas_title_form"></h5>
                </div>
                <div class="modal-body" id="identitas_form_konten">
                </div>
                <div class="modal-footer">
                	<div class="pull-right">
                		<button type="button" id="btn-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>
                    	<button type="submit" id="btn-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
 <script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#id-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_list_eselon2/"+$("#id-tahun").val()+"/"+this.value,
				success:function(result) {
					
					$("#id-kode_e2").empty();
					result = JSON.parse(result);
					for (k in result) {
						$("#id-kode_e2").append(new Option(result[k],k));
					}
					$("#id-kode_e2").select2("val", "0");
				}
			});
		});
		
		 $("#id-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#id-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#id-kode_e1').append(new Option(result[k],k));
						}
						$("#id-kode_e1").select2("val", "0");
						$("#id-kode_e1").change();
					}
				});
			});
		
		$("#id-btn").click(function(){
			tahun = $('#id-tahun').val();
			kode = $('#id-kode_e1').val();
			kode2 = $('#id-kode_e2').val();
			if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#id-tahun').select2('open');
					return;
			}else if (kode=="0") {
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#id-kode_e1').select2('open');
					return;
			}else {
				$("#div-id-e2").load("<?php echo site_url(); ?>unit_kerja/eselon2/get_body_identitas/"+tahun+"/"+kode+"/"+kode2);
				$('#konten_es2').removeClass("hide");
				
			}
		});
		
		identitasAdd =function(){
			$("#identitas_title_form").html('<i class="fa fa-plus-square"></i>  Tambah Identitas dan Tugas Eselon II');
			$("#identitas-form").attr("action",'<?=base_url()?>unit_kerja/eselon2/save');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon2/add/id',
					success:function(result) {
						$('#identitas_form_konten').html(result);
					}
			});
		}
		
		 identitasEdit = function(tahun,kode){
			$("#identitas_title_form").html('<i class="fa fa-pencil"></i>  Update Identitas dan Tugas Eselon II');
			$("#identitas-form").attr("action",'<?=base_url()?>unit_kerja/eselon2/update');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon2/edit/id/'+tahun+'/'+kode,
					success:function(result) {
						$('#identitas_form_konten').html(result);
					}
			});
		}
		
		 identitasDelete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
		
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>unit_kerja/eselon2/hapus/id/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#id-btn").click();
						}
				});
			}
		}
		
		$( "#identitas-form" ).submit(function( event ) {
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
						$("#btn-close").click();
						$("#id-btn").click();
					},
					error: function(jqXHR, textStatus, errorThrown) 
					{
						//if fails   
						$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
						$('#btn-close').click();   
					}
				});
			
			  event.preventDefault();
		});
	});
</script>