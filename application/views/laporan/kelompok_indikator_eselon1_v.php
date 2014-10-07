<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra<span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tahun',$renstra,'0','id="e1-tahun" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Kelompok Indikator<span class="text-danger">*</span></label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kelompok_indikator',$kelompok_indikator,'0','id="e1-kelompok_indikator" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Rentang Tahun<span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_awal',array("0"=>"Pilih Tahun"),'','id="e1-tahun_awal"')?>
                        </div>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_akhir',array("0"=>"Pilih Tahun"),'','id="e1-tahun_akhir"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-5">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="e1-kode_e1" class="populate"')?>
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
    
    
     <div class="feed-box hide" id="e1-box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                
                <p class="text-primary">Daftar IKU Eselon I</p><br />
                 
				    <div class="adv-table" id="e1-data" style="width:100%; overflow: auto; padding:10px 5px 10px 5px;">
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
			
			
			e1_renstra = $('#e1-tahun');
			e1_tahun_awal = $('#e1-tahun_awal');
			e1_tahun_akhir = $('#e1-tahun_akhir');
			e1_renstra.change(function(){
				e1_tahun_awal.empty(); e1_tahun_akhir.empty();
				e1_tahun_awal.append(new Option("Pilih Tahun","0"));
				e1_tahun_akhir.append(new Option("Pilih Tahun","0"));
				$("#e1-tahun_awal").select2("val", "0");
				$("#e1-tahun_akhir").select2("val", "0");
				if (e1_renstra.val()!=0) {
					//alert('here');
					e1_year = e1_renstra.val().split('-');
					
					for (i=parseInt(e1_year[0]);i<=parseInt(e1_year[1]);i++)  {
						e1_tahun_awal.append(new Option(i,i));
						e1_tahun_akhir.append(new Option(i,i));
					}
					e1_tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); 
					e1_tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
					
				}
			});
			
			load_data_e1 = function(e1_kodee1,e1_indikator){
				
				$("#e1-data").load("<?=base_url()?>laporan/kelompok_indikator_eselon1/getindikator/"+e1_indikator+"/"+e1_tahun_awal.val()+"/"+e1_tahun_akhir.val()+"/"+e1_kodee1);
				$("#e1-data").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
				 
			}
			
			 $("#profilee1-btn").click(function(){
			
				var e1_kodee1 = $('#e1-kode_e1').val();
				var e1_indikator = $('#e1-kelompok_indikator').val();
				if (e1_renstra.val()=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#e1-tahun').select2('open');
				}
				else if ((e1_indikator =="0")) {
					alert("Indikator belum ditentukan");
					$('#e1-kelompok_indikator').select2('open');
				}
				else if ((e1_tahun_awal.val()=="0")) {
					alert("Rentang Tahun Awal belum ditentukan");
					$('#e1-tahun_awal').select2('open');
				}
				else if ((e1_tahun_akhir.val()=="0")) {
					alert("Rentang Tahun Akhir belum ditentukan");
					$('#e1-tahun_akhir').select2('open');
				}
				else {
					load_data_e1(e1_kodee1,e1_indikator);
					$('#e1-box-result').removeClass("hide");
				}
			}); 
			
			
		});
	</script>