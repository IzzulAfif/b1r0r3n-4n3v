<div class="feed-box">
	 <form id="form_iku" method="post" class="form-horizontal">
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
											<?=form_dropdown('periode_renstra',$renstra,'0','id="iku-periode_renstra" class="populate"')?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5 control-label">Tahun<span class="text-danger">*</span></label>
										<div class="col-sm-7">									
											<?=form_dropdown('rentang_awal',array("0"=>"Pilih Tahun"),'','id="iku-rentang_awal"  class="populate"')?>
											
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
												<input name="chkKl" id="iku-chkKL" value="ok" type="checkbox" checked="checked"> Tampilkan IKU Kementerian
											</label>
										</div>
									</div>
									<div class="form-group">
										<div class="checkbox col-md-4">
											<label class="control-label">
												<input name="chkE1" id="iku-chkE1" value="ok" type="checkbox" checked="checked"> Tampilkan IKU Eselon I
											</label>
										</div>
										
										
											<div class="col-sm-6">
										   <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="iku-kode_e1" class="populate"')?>
											</div>
										
									</div>
									<div class="form-group">
										<div class="checkbox col-md-4">
											<label class="control-label">
												<input name="chkE2" id="iku-chkE2" value="ok" type="checkbox" checked="checked"> Tampilkan IKK
											</label>
										</div>
										<div class="col-sm-6">
										   <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon II"),'0','id="iku-kode_e2" class="populate"')?>
											</div>
									</div>
									<div class="form-group">
										 <div class="col-sm-offset-7 col-sm-7">										 
											<button type="button" id="iku-btnLoad"  class="btn btn-info">
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
	
	
	<div class="feed-box hide" id="box-result-iku">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
				 <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">  
				<div id="iku-reportKonten">
					</div>
				</form>	
				<div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_iku"><i class="fa fa-print"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_iku"><i class="fa fa-download"></i> Ekspor Excel</button>
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
	iku_renstra = $('#iku-periode_renstra');
	iku_tahun_awal = $('#iku-rentang_awal');
	
	iku_renstra.change(function(){
		iku_tahun_awal.empty(); 				
		iku_tahun_awal.append(new Option("Pilih Tahun","0"));
		$("#iku-rentang_awal").select2("val", "0");
		if (iku_renstra.val()!=0) {
			year = iku_renstra.val().split('-');					
			for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
				iku_tahun_awal.append(new Option(i,i));
			}
			iku_tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); 					
		}
		
		$.ajax({
			url:"<?php echo site_url(); ?>laporan/kelompok_indikator/get_list_eselon1/"+this.value,
			success:function(result) {
				$('#iku-kode_e1').empty();
				//alert('kadieu');
				result = JSON.parse(result);
				for (k in result) {
					$('#iku-kode_e1').append(new Option(result[k],k));
				}
				$("#iku-kode_e1").select2("val", "0");
			}
		});
	});
	
	
	 $("#iku-kode_e1").change(function(){
		$.ajax({
			url:"<?php echo site_url(); ?>laporan/kelompok_indikator/get_list_eselon2/"+ $('#iku-periode_renstra').val()+"/"+this.value,
			success:function(result) {
				$('#iku-kode_e2').empty();
				result = JSON.parse(result);
				for (k in result) {
					$('#iku-kode_e2').append(new Option(result[k],k));
				}
				$("#iku-kode_e2").select2("val", "0");
			}
		});
	});
	
	
	iku_load_data = function(){
		var chkKL = $("#iku-chkKL").is(':checked');
		var chkE1 = $("#iku-chkE1").is(':checked');
		var chkE2 = $("#iku-chkE2").is(':checked');			
		
		$("#iku-reportKonten").load("<?=base_url()?>laporan/relevansi_iku/get_iku/"+iku_renstra.val()+"/"+iku_tahun_awal.val()+"/"+chkKL+"/"+chkE1+"/"+chkE2+"/"+$("#iku-kode_e1").val()+"/"+$("#iku-kode_e2").val());
			$("#iku-reportKonten").mCustomScrollbar({
						axis:"x",
						theme:"dark-2"
					});			
	}
	
	 $("#iku-btnLoad").click(function(){
		if (iku_renstra.val()=="0") {
			alert("Periode Renstra belum ditentukan");
			$('#iku-periode_renstra').select2('open');
		}
		
		else if ((iku_tahun_awal.val()=="0")) {
			alert("Tahun belum ditentukan");
			$('#iku-rentang_awal').select2('open');
		}
		/*else if ((tahun_akhir.val()=="0")) {
			alert("Rentang Tahun Akhir belum ditentukan");
			$('#rentang_akhir').select2('open');
		}
		else if ((indikator.val()=="0")) {
			alert("Indikator belum ditentukan");
			$('#kelompok_indikator').select2('open');
		}*/
		else if (!$("#iku-chkE1").is(':checked')&&$("#iku-chkE2").is(':checked')&& $("#iku-kode_e1").val()=="0"){
			alert("Unit Kerja Eselon I belum ditentukan");
			$('#iku-kode_e1').select2('open');
		}
		else {
			iku_load_data();
			$('#box-result-iku').removeClass("hide");
		}
	}); 
	
	$('#cetakpdf_iku').click(function(){
		var chkKL = $("#iku-chkKL").is(':checked');
		var chkE1 = $("#iku-chkE1").is(':checked');
		var chkE2 = $("#iku-chkE2").is(':checked');	
		window.open('<?=base_url()?>laporan/relevansi_iku/print_pdf/'+iku_renstra.val()+"/"+iku_tahun_awal.val()+"/"+chkKL+"/"+chkE1+"/"+chkE2+"/"+$("#iku-kode_e1").val()+"/"+$("#iku-kode_e2").val(),'_blank');			
	});
	
});
</script>