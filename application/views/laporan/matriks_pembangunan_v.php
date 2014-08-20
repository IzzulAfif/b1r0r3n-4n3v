<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Matriks Pembangunan Bidang Transportasi
                        <span class="pull-right">
                            <!--<a href="<?=base_url()?>unit_kerja/eselon1/add" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>-->
                         </span>
                    </header>
                    <div class="panel-body">
						<div class="row">
							<div class="well wellform">
							<form class="form-horizontal">
												
								<p class="text-primary"><b>Kriteria</b></p>
								<div class="form-group">
									<label class="col-sm-2 control-label">Periode Renstra</label>
									<div class="col-sm-2">									
										<?=form_dropdown('periode_renstra',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="periode_renstra" class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Rentang Tahun</label>
									<div class="col-sm-2">									
										<?=form_dropdown('rentang_awal',array(),'','id="rentang_awal"  class="form-control input-sm"')?>
										
									</div>
									<label class="col-sm-1 control-label" style="text-align:center;width:10px;margin-left:-20px">s.d.</label>
								
									<div class="col-sm-2">																			
										<?=form_dropdown('rentang_akhir',array(),'','id="rentang_akhir"  class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Kementerian</label>
									<div class="col-sm-2">									
										<?=form_dropdown('kl',array("0"=>"Pilih Kementrian","022"=>"Kementerian Perhubungan"),'0','id="kodekl" class="form-control input-sm"')?>
									</div>
								</div>
								<br />
								<div class="form-group">
									 <div class="col-sm-offset-2 col-sm-3">
										<button type="button" id="btnLoad"  class="btn btn-warning btn-block">
											<i class="fa fa-play"></i> Tampilkan Data
										</button>
									</div>
								</div>
							</form>	
							</div>	
						</div>	&nbsp;
						<div class ="row">
							 <div class="col-sm-13">
                                    	
                                        <div class="well wellform">
                                        	
                                            <div id="reportKonten">
                                            </div>
                                            
                                        </div>
                                        
							</div>
						</div>
                    </div>
                </section>
            </div>
        </div>
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			load_profile = function(){
				var tahun = $('#periode_renstra').val();
				var kodekl = $('#kodekl').val();
				var range_awal = $("#rentang_awal").val();
				var range_akhir = $("#rentang_akhir").val();
				
				$("#reportKonten").load("<?=base_url()?>laporan/matriks_pembangunan/get_sasaran/"+tahun+"/"+kodekl+"/"+range_awal+"/"+range_akhir);
				
			}
			
			set_rentang = function(){
				var periode_renstra = $("#periode_renstra");
				var range_awal = $("#rentang_awal");
				var range_akhir = $("#rentang_akhir");
				range_awal.empty();range_akhir.empty();
				
				 if (periode_renstra.val()!=0) {
					year = periode_renstra.val().split('-');
					//alert(year[0]);
					for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
						range_awal.append(new Option(i,i));
						range_akhir.append(new Option(i,i));
					}
				 }
			}
			
			 $("#btnLoad").click(function(){
				load_profile();
			}); 
			
			$("#periode_renstra").change(function(){
				set_rentang();
			}); 
			
			
			$("#klikdisini").click(function(){
				alert('underconstruction');
				return;
				var tahun = $('#tahun').val();
				var kodekl = $('#kodekl').val();
				window.open("<?=base_url()?>laporan/renstra_kl/get_detail/"+tahun+"/"+kodekl);
			}); 
		});
	</script>