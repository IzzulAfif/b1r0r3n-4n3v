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
                         		<?=form_dropdown('tahun',$renstra,'0','id="fungsi-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I<span class="text-danger">*</span></label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="fungsi-kode_e1" class="populate" style="width:100%"')?>
                        </div>
                    </div> 
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e2',array("0"=>"Semua Unit Kerja Eselon II"),'0','id="fungsi-kode_e2" class="populate"  style="width:100%"')?>
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
                     <a href="#fungsiModal" data-toggle="modal" class="btn btn-primary btn-sm" style="margin-top:-5px;" onclick="fungsiAdd();"><i class="fa fa-plus-circle"></i> Tambah</a>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="adv-table" id="div-fungsi-e2">
		
		</div>
   </div>
   
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
    
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#fungsi-kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_list_eselon2/"+$("#fungsi-tahun").val()+"/"+this.value,
				success:function(result) {
					
					$("#fungsi-kode_e2").empty();
					result = JSON.parse(result);
					for (k in result) {
						$("#fungsi-kode_e2").append(new Option(result[k],k));
					}
					$("#fungsi-kode_e2").select2("val", "0");
				}
			});
		});
		
		$("#fungsi-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#fungsi-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#fungsi-kode_e1').append(new Option(result[k],k));
						}
						$("#fungsi-kode_e1").select2("val", "0");
						$("#fungsi-kode_e1").change();
					}
				});
			});
		
		$("#fungsi-btn").click(function(){
			tahun = $('#fungsi-tahun').val();
			kode = $('#fungsi-kode_e1').val();
			kode2 = $('#fungsi-kode_e2').val();
			if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#fungsi-tahun').select2('open');
					return;
			}
			else if (kode=="0") {
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#fungsi-kode_e1').select2('open');
					return;
			}
			$("#div-fungsi-e2").load("<?php echo site_url(); ?>unit_kerja/eselon2/get_body_fungsi/"+tahun+"/"+kode+"/"+kode2);
			$('#fungsi_es2').removeClass("hide");
			
		});
		
		fungsiAdd =function(){
			$("#fungsi_title_form").html('<i class="fa fa-plus-square"></i>  Tambah Fungsi Eselon II');
			$("#fungsi-form").attr("action",'<?=base_url()?>unit_kerja/eselon2/save');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon2/add/fungsi',
					success:function(result) {
						$('#fungsi_form_konten').html(result);
					}
			});
		}
		
		fungsiEdit = function(tahun,kode){
			$("#fungsi_title_form").html('<i class="fa fa-pencil"></i>  Edit Fungsi Eselon II');
			$("#fungsi-form").attr("action",'<?=base_url()?>unit_kerja/eselon2/update');
			$.ajax({
				url:'<?=base_url()?>unit_kerja/eselon2/edit/fungsi/'+tahun+'/'+kode,
					success:function(result) {
						$('#fungsi_form_konten').html(result);
					}
			});
		}
		
		 fungsiDelete = function(tahun,kode){
			var confir = confirm("Anda yakin akan menghapus data ini ?");
		
			if(confir==true){
				$.ajax({
					url:'<?=base_url()?>unit_kerja/eselon2/hapus/fungsi/'+tahun+'/'+kode,
						success:function(result) {
							$.gritter.add({text: result});
							$("#fungsi-btn").click();
						}
				});
			}
		}
		
		$( "#fungsi-form" ).submit(function( event ) {
			var tahun 	= $('#form-tahun').val();
			var es1		= $('#form-es1').val();
			var esl2	= $('#form-esl2').val();
			var kdf		= $('#form-kode').val();
			var fungsi	= $('#form-fungsi').val();
			
			if(tahun==""){
				alert("Periode Renstra belum ditentukan");
				return false;
			}else if(es1==""){
				alert("Nama Unit Kerja Eselon I belum ditentukan");
				return false;
			}else if(esl2=="" || esl2==0){
				alert("Nama Unit Kerja Eselon II belum ditentukan");
				return false;
			}else if(kdf==""){
				alert("Kode Fungsi belum ditentukan");
				return false;
			}else if(fungsi==""){
				alert("Fungsi belum ditentukan");
				return false;
			}else{
				
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
			
			}
		});
	});
</script>	

    
    <!--main content end-->
    
    