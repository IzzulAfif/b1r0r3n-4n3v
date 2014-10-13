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
                        <label class="col-md-2 control-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Pilih Unit Kerja Eselon I"),'0','id="e1-kode_e1" class="populate"')?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="profilee1-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                  
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box hide" id="box-resulte1">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">
                	
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Tugas Pokok</label>
                    	<div class="col-md-10" id="e1-tugas"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Fungsi</label>
                    	<div class="col-md-10" id="e1-fungsi"></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Unit Kerja</label>
                    	<div class="col-md-10" id="e1-unitkerja"></div>
                    </div>
                </form>
				
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_profilee1"><i class="fa fa-print"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_profilee1"><i class="fa fa-download"></i> Ekspor Excel</button>
                </div>
                
            </div>
        </section>
    </div>
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
	
	
                 
	<script type="text/javascript">
		$(document).ready(function() {
			$('select').select2({minimumResultsForSearch: -1, width:'resolve'});

			load_profile_e1 = function(tahun,kodee1){
				
				$("#e1-unitkerja").load("<?=base_url()?>laporan/profil_eselon1/get_unit_kerja/"+tahun+"/"+kodee1);
				$("#e1-fungsi").load("<?=base_url()?>laporan/profil_eselon1/get_fungsi/"+tahun+"/"+kodee1);
				$("#e1-tugas").load("<?=base_url()?>laporan/profil_eselon1/get_tugas/"+tahun+"/"+kodee1);
			}
			
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
			
			 $("#profilee1-btn").click(function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kode_e1').val();
				if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#e1-tahun').select2('open');
				}
				else if (kodee1=="0") {
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#e1-kode_e1').select2('open');
				}else {
					load_profile_e1(tahun,kodee1);
					$('#box-resulte1').removeClass("hide");
				}
			}); 
			
			$('#cetakpdf_profilee1').click(function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kode_e1').val();
				window.open('<?=base_url()?>laporan/profil_eselon1/print_pdf/'+tahun+'/'+kodee1,'_blank');			
			});
		});
	</script>