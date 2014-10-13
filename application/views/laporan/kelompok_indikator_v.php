<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<!-- page start-->
			 <form class="form-horizontal" role="form">  
		
			<!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Kelompok Indikator</b></p>
                   
                </header>
				<div class="panel-body">
					<div class="feed-box">
					<section class="panel tab-bg-form">
					<div class="panel-body">
				   
						<div class="corner-ribon blue-ribon">
						   <i class="fa fa-cog"></i>
						</div>
							<div class="row" id="boxcartscrool">
								
								<div class="col-sm-5">
									<p class="text-primary"><b>Periode dan Indikator</b></p>
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
									<div class="form-group">
										<label class="col-md-5 control-label">Kelompok Indikator<span class="text-danger">*</span></label>
										<div class="col-sm-7">
											<?=form_dropdown('kelompok_indikator',$kelompok_indikator,'0','id="kelompok_indikator" class="populate"')?>
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
								</div>
							</div>
							
							
					</div>
					</section>
					</div>
				</div>
			</section>	
 
			<div class="feed-box hide" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                             	
                    
					<div class="form-group hide" id="divKL">
                    	<p class="text-primary col-md-12" ><b>IKU Kementerian</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="kl-indikator"  ></div>
                        </div>
                    </div>
					<div class="form-group hide" id="divE1">
                    	<p class="text-primary col-md-12" id="e1-title"><b>IKU Eselon I</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e1-indikator"  ></div>
                        </div>
                    </div>
					<div class="form-group hide" id="divE2">
                    	<p class="text-primary col-md-12" id="e2-title"><b>IKU Eselon II</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e2-indikator"  ></div>
                        </div>
                    </div>
					<div class="pull-right">
						<button type="button" class="btn btn-primary btn-sm" id="cetakpdf_indikator"><i class="fa fa-print"></i> Cetak PDF</button>          
						<button type="button" class="btn btn-primary btn-sm" id="cetakexcel_indikator"><i class="fa fa-download"></i> Ekspor Excel</button>
					</div>
               
                
            </div>
        </section>
    </div>
			  
            <!--tab nav end-->
        </form>
        </section>
    </section>
    <!--main content end-->
	<style type="text/css">
        select {width:100%;}        
    </style>
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
			renstra = $('#periode_renstra');
			tahun_awal = $('#rentang_awal');
			//tahun_akhir = $('#rentang_akhir');
			indikator = $('#kelompok_indikator');
			
			renstra.change(function(){
				tahun_awal.empty(); 
				//tahun_akhir.empty();
				tahun_awal.append(new Option("Pilih Tahun","0"));
				//tahun_akhir.append(new Option("Pilih Tahun","0"));
				$("#rentang_awal").select2("val", "0");
				//$("#rentang_akhir").select2("val", "0");
				if (renstra.val()!=0) {
					//alert('here');
					year = renstra.val().split('-');
					
					for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
						tahun_awal.append(new Option(i,i));
					//	tahun_akhir.append(new Option(i,i));
					}
					tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); 
					//tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
					
				}
				
				$.ajax({
					url:"<?php echo site_url(); ?>laporan/kelompok_indikator/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#kode_e1').append(new Option(result[k],k));
						}
						$("#kode_e1").select2("val", "0");
					}
				});
			});
			
			
			 $("#kode_e1").change(function(){
				$.ajax({
					url:"<?php echo site_url(); ?>laporan/kelompok_indikator/get_list_eselon2/"+ $('#periode_renstra').val()+"/"+this.value,
					success:function(result) {
						$('#kode_e2').empty();
						result = JSON.parse(result);
						for (k in result) {
							$('#kode_e2').append(new Option(result[k],k));
						}
						$("#kode_e2").select2("val", "0");
					}
				});
			});
			
			
			load_data = function(){
			//	alert($("#chkKl").is(':checked'));
				if ($("#chkKl").is(':checked')){
					$("#kl-indikator").load("<?=base_url()?>laporan/kelompok_indikator/getindikator_kl/"+indikator.val()+"/"+tahun_awal.val()+"/-1/-1");
					$("#kl-indikator").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
					$('#divKL').removeClass("hide");
				}else{
					$('#divKL').addClass("hide");
				}
						
				if ($("#chkE1").is(':checked')){			
					if ($("#chkE2").is(':checked'))
						$("#e1-title").html("<b>IKU Eselon I dan IKK Eselon II</b>");
					else
						$("#e1-title").html("<b>IKU Eselon I</b>");
					
					$("#e1-indikator").load("<?=base_url()?>laporan/kelompok_indikator/getindikator_e1/"+indikator.val()+"/"+tahun_awal.val()+"/-1/"+$("#kode_e1").val()+($("#chkE2").is(':checked')?"/"+$("#kode_e2").val():""));
					$("#e1-indikator").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
					$('#divE1').removeClass("hide");
				}else{
					$('#divE1').addClass("hide");
				}			
				
				if (($("#chkE2").is(':checked'))&&(!$("#chkE1").is(':checked'))){	
					
					$("#e2-indikator").load("<?=base_url()?>laporan/kelompok_indikator/getindikator_e2/"+indikator.val()+"/"+tahun_awal.val()+"/-1/"+$("#kode_e1").val()+"/"+$("#kode_e2").val());
					$("#e2-indikator").mCustomScrollbar({
									axis:"x",
									theme:"dark-2"
								});
					$('#divE2').removeClass("hide");
				}else{
					$('#divE2').addClass("hide");
				}			
				
				
							
			}
			
			 $("#btnLoad").click(function(){
				if (renstra.val()=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#periode_renstra').select2('open');
				}
				
				else if ((tahun_awal.val()=="0")) {
					alert("Tahun belum ditentukan");
					$('#rentang_awal').select2('open');
				}
				/*else if ((tahun_akhir.val()=="0")) {
					alert("Rentang Tahun Akhir belum ditentukan");
					$('#rentang_akhir').select2('open');
				}*/
				else if ((indikator.val()=="0")) {
					alert("Indikator belum ditentukan");
					$('#kelompok_indikator').select2('open');
				}
				else if (!$("#chkE1").is(':checked')&&$("#chkE2").is(':checked')&& $("#kode_e1").val()=="0"){
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#kode_e1').select2('open');
				}
				else {
					load_data();
					$('#box-result').removeClass("hide");
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