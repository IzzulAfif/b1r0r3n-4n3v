<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
						<label class="col-sm-2 control-label">Periode Renstra<span class="text-danger">*</span></label>
						<div class="col-sm-3">									
							<?=form_dropdown('periode_renstra',$renstra,'0','id="e1-periode_renstra" class="populate"')?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Rentang Tahun<span class="text-danger">*</span></label>
						<div class="col-sm-2">									
							<?=form_dropdown('rentang_awal',array("0"=>"Pilih Tahun"),'0','id="e1-rentang_awal"  class="populate"')?>
							
						</div>
						<label class="col-sm-1 control-label" style="text-align:center;width:10px;margin-left:-20px">s.d.</label>
					
						<div class="col-sm-2">																			
							<?=form_dropdown('rentang_akhir',array("0"=>"Pilih Tahun"),'0','id="e1-rentang_akhir"  class="populate"')?>
						</div>
					</div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I<span class="text-danger">*</span></label>
                        <div class="col-md-4">
                           <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="e1-kodee1" class="populate"')?>
                        </div>
                    </div>
					
					<div class="form-group">
						 <div class="col-sm-offset-2 col-sm-3">
						 
							<button type="button" id="e1-btnLoad"  class="btn btn-info">
								<i class="fa fa-play"></i> Tampilkan Data
							</button>
						</div>
					</div>
								
                   
                </form>
            </div>
        </section>
    </div>
	
	
	<div class="feed-box hide" id="box-result-e1">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
				 <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">  
				<div id="e1-reportKonten">
					</div>
				</form>	
				<div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_e1"><i class="fa fa-print"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_e1"><i class="fa fa-download"></i> Ekspor Excel</button>
                </div>
			</div>
		</section>
	</div>
	
	
	<style type="text/css">
	select {width:100%;}
</style>

<script  type="text/javascript" language="javascript">
$(document).ready(function() {
	$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
	load_profile_e1 = function(){
		var tahun = $('#e1-periode_renstra').val();
		var kodee1 = $('#e1-kodee1').val();
		var range_awal = $("#e1-rentang_awal").val();
		var range_akhir = $("#e1-rentang_akhir").val();
		
		$("#e1-reportKonten").load("<?=base_url()?>laporan/matriks_pembangunan_e1/get_output/"+tahun+"/"+range_awal+"/"+range_akhir+"/"+kodee1);
		
		
	}
	
	 $("#e1-periode_renstra").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>laporan/renstra_eselon1/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#e1-kodee1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#e1-kodee1').append(new Option(result[k],k));
						}
						$("#e1-kodee1").select2("val", "0");
					}
				});
			});
			
	set_rentang = function(){
		var periode_renstra = $("#e1-periode_renstra");
		var range_awal = $("#e1-rentang_awal");
		var range_akhir = $("#e1-rentang_akhir");
		range_awal.empty();range_akhir.empty();
		range_awal.append(new Option("Pilih Tahun","0"));
		range_akhir.append(new Option("Pilih Tahun","0"));
		 if (periode_renstra.val()!=0) {
			year = periode_renstra.val().split('-');
			//alert(year[0]);
			for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
				range_awal.append(new Option(i,i));
				range_akhir.append(new Option(i,i));
			}
			
		 }
		 $('#e1-rentang_awal').select2({minimumResultsForSearch: -1, width:'resolve'});
			$('#e1-rentang_akhir').select2({minimumResultsForSearch: -1, width:'resolve'});
	}
	
	
	clickIku = function(id){
		chk = $("#chk"+id);
		keterangan = $("#keterangan"+id);		
		keterangan.prop("readonly",!chk.is(':checked'));
		
	}
	
	 $("#e1-btnLoad").click(function(){
		var periode_renstra = $("#e1-periode_renstra");
		var range_awal = $("#e1-rentang_awal");
		var range_akhir = $("#e1-rentang_akhir");
		var kodee1 = $('#e1-kodee1').val();
		
		if (periode_renstra.val()=="0") {
			alert("Periode Renstra belum ditentukan");
			$('#e1-periode_renstra').select2('open');
		}		
		else if ((range_awal.val()=="0")) {
			alert("Rentang Tahun Awal belum ditentukan");
			$('#e1-rentang_awal').select2('open');
		}
		else if ((range_akhir.val()=="0")) {
			alert("Rentang Tahun Akhir belum ditentukan");
			$('#e1-rentang_akhir').select2('open');
		}
		else if (kodee1=="0") {
			alert("Unit Kerja belum ditentukan");
			$('#e1-kodee1').select2('open');
		}
		else {
			load_profile_e1();
			$('#box-result-e1').removeClass("hide");
		}
	}); 
	
	$("#e1-periode_renstra").change(function(){
		set_rentang();
	}); 
	
	$("#matriks_form").submit(function( event ) {
		
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
					//renstra_update();
					//$('#btn-close').click();
					//$("#id-btn").click();
					//alert('kadieu sukses');
					print_matriks();
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					//if fails
				//	$.gritter.add({text: '<h5><i class="fa fa-exclamation-triangle"></i> <b>Eror !!</b></h5> <p>'+errorThrown+'</p>'});
				//	$('#btn-close').click();
				}
			});
			event.preventDefault();
	});
	
	print_matriks = function(){
		var tahun = $('#e1-periode_renstra').val();
		var rentang_awal = $('#e1-rentang_awal').val();
		var rentang_akhir = $('#e1-rentang_akhir').val();
		var kodee1 = $('#e1-kodee1').val();
		window.open("<?=base_url()?>laporan/matriks_pembangunan_e1/print_pdf/"+tahun+"/"+rentang_awal+"/"+rentang_akhir+"/"+kodee1);
	}
	
	$('#cetakpdf_e1').click(function(){
		print_matriks();
	});
	
	$('#cetakexcel_e1').click(function(){
		var tahun = $('#e1-periode_renstra').val();
		var rentang_awal = $('#e1-rentang_awal').val();
		var rentang_akhir = $('#e1-rentang_akhir').val();
		var kodee1 = $('#e1-kodee1').val();
		window.open("<?=base_url()?>laporan/matriks_pembangunan_e1/excel/"+tahun+"/"+rentang_awal+"/"+rentang_akhir+"/"+kodee1);
	});
});
</script>