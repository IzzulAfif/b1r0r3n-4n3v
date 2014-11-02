<div class="feed-box">
	 <form id="form_ss" method="post" class="form-horizontal">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <div class="row" id="boxcartscrool">
								
								<div class="col-sm-5">
									<p class="text-primary"><b>Periode </b></p>
									<div class="form-group">
										<label class="col-sm-5 control-label">Periode Renstra<span class="text-danger">*</span></label>
										<div class="col-sm-7">									
											<?=form_dropdown('periode_renstra',$renstra,'0','id="periode_renstra" class="populate"')?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5 control-label">Tahun<span class="text-danger">*</span></label>
										<div class="col-sm-7">									
											<?=form_dropdown('rentang_awal',array("0"=>"Pilih Tahun"),'','id="rentang_awal"  class="populate"')?>
											
										</div>
										
									</div>
								<!--	<div class="form-group">
										<label class="col-md-5 control-label">Kelompok Indikator<span class="text-danger">*</span></label>
										<div class="col-sm-7">
											<=form_dropdown('kelompok_indikator',array(),'0','id="kelompok_indikator" class="populate"')?>
										</div>
									</div> -->
									
								</div>	
							
								<div class="col-sm-7" style="left:65px">
									<p class="text-primary"><b>Unit Kerja</b></p>
									 <div class="form-group">										
										<div class="checkbox">
											<label class="control-label">
												<input name="chkKl" id="chkKl" value="ok" type="checkbox" checked="checked"> Tampilkan IKU Kementerian
											</label>
										</div>
									</div>
									<div class="form-group">
										<div class="checkbox col-md-4">
											<label class="control-label">
												<input name="chkE1" id="chkE1" value="ok" type="checkbox" checked="checked"> Tampilkan IKU Eselon I
											</label>
										</div>
										
										
											<div class="col-sm-6">
										   <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="kode_e1" class="populate"')?>
											</div>
										
									</div>
									<div class="form-group">
										<div class="checkbox col-md-4">
											<label class="control-label">
												<input name="chkE2" id="chkE2" value="ok" type="checkbox" checked="checked"> Tampilkan IKK
											</label>
										</div>
										<div class="col-sm-6">
										   <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon II"),'0','id="kode_e2" class="populate"')?>
											</div>
									</div>
									<div class="form-group">
										 <div class="col-sm-offset-7 col-sm-7">										 
											<button type="button" id="btnLoad"  class="btn btn-info">
												<i class="fa fa-play"></i> Tampilkan Data
											</button>
										</div>
									</div>
								</div>
							</div>
            </div>
        </section>
		</form>
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
		
		$("#kl-reportKonten").load("<?=base_url()?>laporan/matriks_pembangunan_e1/get_sasaran/"+tahun+"/-1/"+range_awal+"/"+range_akhir);
		
		
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
		
		window.open("<?=base_url()?>laporan/matriks_pembangunan_kl/get_detail/"+tahun+"/"+rentang_awal+"/"+rentang_akhir+"/-1");
	}
});
</script>