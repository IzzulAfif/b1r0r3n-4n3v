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
								<?=form_dropdown('periode_renstra',$renstra,'0','id="ss-periode_renstra" class="populate"')?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label">Tahun<span class="text-danger">*</span></label>
							<div class="col-sm-7">									
								<?=form_dropdown('rentang_awal',array("0"=>"Pilih Tahun"),'','id="ss-rentang_awal"  class="populate"')?>
								
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
									<input name="chkKl" id="ss-chkKL" value="ok" type="checkbox" checked="checked"> Tampilkan Sasaran Kementerian
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="checkbox col-md-4">
								<label class="control-label">
									<input name="chkE1" id="ss-chkE1" value="ok" type="checkbox" checked="checked"> Tampilkan Sasaran Program
								</label>
							</div>
							
							
								<div class="col-sm-6">
							   <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="ss-kode_e1" class="populate"')?>
								</div>
							
						</div>
						<div class="form-group">
							<div class="checkbox col-md-4">
								<label class="control-label">
									<input name="chkE2" id="ss-chkE2" value="ok" type="checkbox" checked="checked"> Tampilkan Sasaran Kegiatan
								</label>
							</div>
							<div class="col-sm-6">
							   <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon II"),'0','id="ss-kode_e2" class="populate"')?>
								</div>
						</div>
						<div class="form-group">
							 <div class="col-sm-offset-7 col-sm-7">										 
								<button type="button" id="ss-btnLoad"  class="btn btn-info">
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
	
	
	<div class="feed-box hide" id="box-result-ss">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
				 <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">  
				<div id="ss-reportKonten">
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
			ss_renstra = $('#ss-periode_renstra');
			ss_tahun_awal = $('#ss-rentang_awal');
			
			ss_renstra.change(function(){
				ss_tahun_awal.empty(); 				
				ss_tahun_awal.append(new Option("Pilih Tahun","0"));
				$("#ss-rentang_awal").select2("val", "0");
				if (ss_renstra.val()!=0) {
					year = ss_renstra.val().split('-');					
					for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
						ss_tahun_awal.append(new Option(i,i));
					}
					ss_tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); 					
				}
				
				$.ajax({
					url:"<?php echo site_url(); ?>laporan/kelompok_indikator/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#ss-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#ss-kode_e1').append(new Option(result[k],k));
						}
						$("#ss-kode_e1").select2("val", "0");
					}
				});
			});
			
			
			 $("#ss-kode_e1").change(function(){
				$.ajax({
					url:"<?php echo site_url(); ?>laporan/kelompok_indikator/get_list_eselon2/"+ $('#ss-periode_renstra').val()+"/"+this.value,
					success:function(result) {
						$('#ss-kode_e2').empty();
						result = JSON.parse(result);
						for (k in result) {
							$('#ss-kode_e2').append(new Option(result[k],k));
						}
						$("#ss-kode_e2").select2("val", "0");
					}
				});
			});
			
			
			ss_load_data = function(){
				var chkKL = $("#ss-chkKL").is(':checked');
				var chkE1 = $("#ss-chkE1").is(':checked');
				var chkE2 = $("#ss-chkE2").is(':checked');			
				
				$("#ss-reportKonten").load("<?=base_url()?>laporan/relevansi_sastra/get_sasaran/"+ss_renstra.val()+"/"+ss_tahun_awal.val()+"/"+chkKL+"/"+chkE1+"/"+chkE2+"/"+$("#ss-kode_e1").val()+"/"+$("#ss-kode_e2").val());
					$("#ss-reportKonten").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});			
			}
			
			 $("#ss-btnLoad").click(function(){
				if (ss_renstra.val()=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#ss-periode_renstra').select2('open');
				}
				
				else if ((ss_tahun_awal.val()=="0")) {
					alert("Tahun belum ditentukan");
					$('#ss-rentang_awal').select2('open');
				}
				/*else if ((tahun_akhir.val()=="0")) {
					alert("Rentang Tahun Akhir belum ditentukan");
					$('#rentang_akhir').select2('open');
				}
				else if ((indikator.val()=="0")) {
					alert("Indikator belum ditentukan");
					$('#kelompok_indikator').select2('open');
				}*/
				else if (!$("#ss-chkE1").is(':checked')&&$("#ss-chkE2").is(':checked')&& $("#ss-kode_e1").val()=="0"){
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#ss-kode_e1').select2('open');
				}
				else {
					ss_load_data();
					$('#box-result-ss').removeClass("hide");
				}
			}); 
			
			$('#cetakpdf_indikator').click(function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kodee1').val();
				window.open('<?=base_url()?>laporan/kelompok_indikator/print_pdf/'+renstra.val()+"/"+tahun_awal.val()+"/"+indikator.val()+"/"+ $("#kode_e1").val()+"/"+ $("#kode_e2").val()+"/"+$("#chkKl").is(':checked')+"/"+$("#chkE1").is(':checked')+"/"+$("#chkE2").is(':checked'),'_blank');			
			});
			//$("#kl-content").load("<?=base_url()?>laporan/kelompok_indikator_kl/loadindikator");
			//$("#e1-content").load("<?=base_url()?>laporan/kelompok_indikator_eselon1/loadindikator");
			//$("#e2-content").load("<?=base_url()?>laporan/kelompok_indikator_eselon2/loadindikator");
			
		
});
</script>