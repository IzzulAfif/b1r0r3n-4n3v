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
							<?=form_dropdown('periode_renstra',$renstra,'0','id="kl-periode_renstra" class="populate"')?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Rentang Tahun<span class="text-danger">*</span></label>
						<div class="col-sm-2">									
							<?=form_dropdown('rentang_awal',array("0"=>"Pilih Tahun"),'0','id="kl-rentang_awal"  class="populate"')?>
							
						</div>
						<label class="col-sm-1 control-label" style="text-align:center;width:10px;margin-left:-20px">s.d.</label>
					
						<div class="col-sm-2">																			
							<?=form_dropdown('rentang_akhir',array("0"=>"Pilih Tahun"),'0','id="kl-rentang_akhir"  class="populate"')?>
						</div>
					</div>
					
					<div class="form-group">
						 <div class="col-sm-offset-2 col-sm-3">
						 
							<button type="button" id="kl-btnLoad"  class="btn btn-info">
								<i class="fa fa-play"></i> Tampilkan Data
							</button>
						</div>
					</div>
								
                   
                </form>
            </div>
        </section>
    </div>
	
	
	<div class="feed-box hide" id="box-result-kl">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
				 <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">  
				<div id="kl-reportKonten">
					</div>
				</form>	
				<div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_kl"><i class="fa fa-print"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_kl"><i class="fa fa-download"></i> Ekspor Excel</button>
                </div>
			</div>
		</sectoion>
	</div>
	
	
	<style type="text/css">
	select {width:100%;}
</style>

<script  type="text/javascript" language="javascript">
$(document).ready(function() {
	$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
	load_profile_kl = function(){
		var tahun = $('#kl-periode_renstra').val();
		
		var range_awal = $("#kl-rentang_awal").val();
		var range_akhir = $("#kl-rentang_akhir").val();
		
		$("#kl-reportKonten").load("<?=base_url()?>laporan/matriks_pembangunan_kl/get_output/"+tahun+"/-1/"+range_awal+"/"+range_akhir);
		
		
	}

	set_rentang_kl = function(){
		var periode_renstra = $("#kl-periode_renstra");
		var range_awal = $("#kl-rentang_awal");
		var range_akhir = $("#kl-rentang_akhir");
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
		 $('#kl-rentang_awal').select2({minimumResultsForSearch: -1, width:'resolve'});
			$('#kl-rentang_akhir').select2({minimumResultsForSearch: -1, width:'resolve'});
	}
	
	
	clickIku = function(id){
		chk = $("#chk"+id);
		keterangan = $("#keterangan"+id);		
		keterangan.prop("readonly",!chk.is(':checked'));
		
	}
	
	 $("#kl-btnLoad").click(function(){
		var periode_renstra = $("#kl-periode_renstra");
		var range_awal = $("#kl-rentang_awal");
		var range_akhir = $("#kl-rentang_akhir");
		
		if (periode_renstra.val()=="0") {
			alert("Periode Renstra belum ditentukan");
			$('#kl-periode_renstra').select2('open');
		}		
		else if ((range_awal.val()=="0")) {
			alert("Rentang Tahun Awal belum ditentukan");
			$('#kl-rentang_awal').select2('open');
		}
		else if ((range_akhir.val()=="0")) {
			alert("Rentang Tahun Akhir belum ditentukan");
			$('#kl-rentang_akhir').select2('open');
		}
		else {
			load_profile_kl();
			$('#box-result-kl').removeClass("hide");
		}
	}); 
	
	$("#kl-periode_renstra").change(function(){
		set_rentang_kl();
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
	
	
	
	print_matriks_kl = function(){
		var tahun = $('#kl-periode_renstra').val();
		var rentang_awal = $('#kl-rentang_awal').val();
		var rentang_akhir = $('#kl-rentang_akhir').val();
		
		window.open("<?=base_url()?>laporan/matriks_pembangunan_kl/print_pdf/"+tahun+"/"+rentang_awal+"/"+rentang_akhir+"/-1");
	}
	
	$('#cetakpdf_kl').click(function(){
		print_matriks_kl();
	});
	
	$('#cetakexcel_kl').click(function(){
		var tahun = $('#kl-periode_renstra').val();
		var rentang_awal = $('#kl-rentang_awal').val();
		var rentang_akhir = $('#kl-rentang_akhir').val();
		
		window.open("<?=base_url()?>laporan/matriks_pembangunan_kl/excel/"+tahun+"/"+rentang_awal+"/"+rentang_akhir+"/-1");
	});
});
</script>