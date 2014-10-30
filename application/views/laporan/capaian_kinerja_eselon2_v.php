	
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
                         		<?=form_dropdown('tahun',$renstra,'0','id="e2-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Pilih Unit Kerja Eselon I"),'0','id="e2-kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e2',array("0"=>"Pilih Unit Kerja Eselon II"),'0','id="e2-kode_e2" class="populate"')?>
                        </div>
                    </div>
                    
                  
					<div class="form-group">
						 <div class="col-sm-offset-2 col-sm-3">
							<button type="button" id="e2-btnLoad"  class="btn btn-info">
								<i class="fa fa-play"></i> Tampilkan Data
							</button>
						</div>
					</div>		
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box hide" id="box-result-e2">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">                	
                   
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Realisasi Capaian Kinerja Eselon II</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e2-capaian"  ></div>
                        </div>
                    </div>
					
                </form>
				
                  <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_capaiane2"><i class="fa fa-print"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_capaiane2"><i class="fa fa-download"></i> Ekspor Excel</button>
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
			 $("#e2-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>laporan/profil_eselon2/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#e2-kode_e1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#e2-kode_e1').append(new Option(result[k],k));
						}
						$("#e2-kode_e1").select2("val", "0");
						 $("#e2-kode_e1").change();
					}
				});
			});
			
			 $("#e2-kode_e1").change(function(){
				$.ajax({
					url:"<?php echo site_url(); ?>laporan/profil_eselon2/get_list_eselon2/"+ $('#e2-tahun').val()+"/"+this.value,
					success:function(result) {
						$("#e2-kode_e2").empty();
						result = JSON.parse(result);
						for (k in result) {
							$("#e2-kode_e2").append(new Option(result[k],k));
						}
						$("#e2-kode_e2").select2("val", "0");
					}
				});
			});
			
			load_capaian_e2 = function(tahun,kodee1){
				
				 
				$("#e2-capaian").load("<?=base_url()?>laporan/capaian_kinerja_eselon2/get_capaian/"+tahun+"/"+$('#e2-kode_e2').val());
				$("#e2-capaian").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
			}
			
			$("#e2-btnLoad").click(function(){
				var tahun = $('#e2-tahun').val();
				var kode_e1 = $('#e2-kode_e1').val();
				var kode_e2 = $('#e2-kode_e2').val();
				if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#e2-tahun').select2('open');
				}
				else if (kode_e1=="0") {
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#e2-kode_e1').select2('open');
				}
				else if (kode_e2=="0") {
					alert("Unit Kerja Eselon II belum ditentukan");
					$('#e2-kode_e2').select2('open');
				}
				else {
					load_capaian_e2(tahun,kode_e2);
					$('#box-result-e2').removeClass("hide");
				}
			});
			
		
		$('#cetakpdf_capaiane2').click(function(){
			var tahun = $('#e2-tahun').val();
			var kodee2 = $('#e2-kode_e2').val();
			window.open('<?=base_url()?>laporan/capaian_kinerja_eselon2/print_pdf/'+tahun+"/"+kodee2,'_blank');			
		});
		
      
    });
    </script>
    <!--js-->