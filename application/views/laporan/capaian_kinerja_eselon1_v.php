	
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
                         		<?=form_dropdown('tahun',$renstra,'0','id="e1-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Pilih Unit Kerja Eselon I"),'0','id="e1-kode_e1" class="populate"')?>
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
                   
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Realisasi Capaian Kinerja Eselon I</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e1-capaian"  ></div>
                        </div>
                    </div>
					
                </form>
				
                  <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_capaiane1"><i class="fa fa-print"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_capaiane1"><i class="fa fa-download"></i> Ekspor Excel</button>
                </div>
                
            </div>
        </section>
    </div>
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
    <!--js-->
    <script type="text/javascript">
    $(document).ready(function () {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
			 $("#e1-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>laporan/profil_eselon1/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#e1-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#e1-kode_e1').append(new Option(result[k],k));
						}
						$("#e1-kode_e1").select2("val", "0");
					}
				});
			});
			
			
			load_capaian_e1 = function(tahun,kodee1){
				
				 
				$("#e1-capaian").load("<?=base_url()?>laporan/capaian_kinerja_eselon1/get_capaian/"+tahun+"/"+kodee1);
				$("#e1-capaian").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
			}
			
			$("#e1-btnLoad").click(function(){
				var tahun = $('#e1-tahun').val();
				var kode_e1 = $('#e1-kode_e1').val();
				if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#e1-tahun').select2('open');
				}
				else if (kode_e1=="0") {
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#e1-kode_e1').select2('open');
				}
				else {
					load_capaian_e1(tahun,kode_e1);
					$('#box-result-e1').removeClass("hide");
				}
			});
			
		
		$('#cetakpdf_capaiane1').click(function(){
			var tahun = $('#e1-tahun').val();
			var kodee1 = $('#e1-kode_e1').val();
			window.open('<?=base_url()?>laporan/capaian_kinerja_eselon1/print_pdf/'+tahun+"/"+kodee1,'_blank');			
		});
		
      
    });
    </script>
    <!--js-->