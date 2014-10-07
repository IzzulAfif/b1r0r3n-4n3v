<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<!-- page start-->
		
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

								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-2 control-label">Periode Renstra<span class="text-danger">*</span></label>
										<div class="col-sm-3">									
											<?=form_dropdown('periode_renstra',$renstra,'0','id="periode_renstra" class="populate"')?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Rentang Tahun<span class="text-danger">*</span></label>
										<div class="col-sm-2">									
											<?=form_dropdown('rentang_awal',array("0"=>"Pilih Tahun"),'','id="rentang_awal"  class="populate"')?>
											
										</div>
										<label class="col-sm-1 control-label" style="text-align:center;width:10px;margin-left:-20px">s.d.</label>
									
										<div class="col-sm-2">																			
											<?=form_dropdown('rentang_akhir',array("0"=>"Pilih Tahun"),'','id="rentang_akhir"  class="populate"')?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Kelompok Indikator<span class="text-danger">*</span></label>
										<div class="col-md-9">
											<?=form_dropdown('kelompok_indikator',$kelompok_indikator,'0','id="kelompok_indikator" class="populate"')?>
										</div>
									</div>
									<div class="form-group">
										 <div class="col-sm-offset-2 col-sm-3">
										 
											<button type="button" id="btnLoad"  class="btn btn-info">
												<i class="fa fa-play"></i> Tampilkan Data
											</button>
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
                <form class="form-horizontal grid-form" role="form">                	
                    
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>IKU Kementerian</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="kl-indikator"  ></div>
                        </div>
                    </div>
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>IKU Eselon I</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e1-indikator"  ></div>
                        </div>
                    </div>
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>IKU Eselon II</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e2-indikator"  ></div>
                        </div>
                    </div>
					
                </form>
                
            </div>
        </section>
    </div>
			  
            <!--tab nav end-->
       
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
			tahun_akhir = $('#rentang_akhir');
			indikator = $('#kelompok_indikator');
			
			renstra.change(function(){
				tahun_awal.empty(); tahun_akhir.empty();
				tahun_awal.append(new Option("Pilih Tahun","0"));
				tahun_akhir.append(new Option("Pilih Tahun","0"));
				$("#rentang_awal").select2("val", "0");
				$("#rentang_akhir").select2("val", "0");
				if (renstra.val()!=0) {
					//alert('here');
					year = renstra.val().split('-');
					
					for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
						tahun_awal.append(new Option(i,i));
						tahun_akhir.append(new Option(i,i));
					}
					tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
					
				}
			});
			
			
			
			load_data = function(){
				
				$("#kl-indikator").load("<?=base_url()?>laporan/kelompok_indikator_kl/getindikator/"+indikator.val()+"/"+tahun_awal.val()+"/"+tahun_akhir.val()+"/-1");
				$("#kl-indikator").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
							
				$("#e1-indikator").load("<?=base_url()?>laporan/kelompok_indikator_eselon1/getindikator/"+indikator.val()+"/"+tahun_awal.val()+"/"+tahun_akhir.val()+"/0");
				$("#kl-indikator").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
							
				$("#e2-indikator").load("<?=base_url()?>laporan/kelompok_indikator_eselon2/getindikator/"+indikator.val()+"/"+tahun_awal.val()+"/"+tahun_akhir.val()+"/-1/-1");
				$("#kl-indikator").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
							
			}
			
			 $("#btnLoad").click(function(){
				if (renstra.val()=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#periode_renstra').select2('open');
				}
				
				else if ((tahun_awal.val()=="0")) {
					alert("Rentang Tahun Awal belum ditentukan");
					$('#rentang_awal').select2('open');
				}
				else if ((tahun_akhir.val()=="0")) {
					alert("Rentang Tahun Akhir belum ditentukan");
					$('#rentang_akhir').select2('open');
				}
				else if ((indikator=="0")) {
					alert("Indikator belum ditentukan");
					$('#kelompok_indikator').select2('open');
				}
				else {
					load_data();
					$('#box-result').removeClass("hide");
				}
			}); 
			//$("#kl-content").load("<?=base_url()?>laporan/kelompok_indikator_kl/loadindikator");
			//$("#e1-content").load("<?=base_url()?>laporan/kelompok_indikator_eselon1/loadindikator");
			//$("#e2-content").load("<?=base_url()?>laporan/kelompok_indikator_eselon2/loadindikator");
			
		});
	</script>