<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-3">
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="kl-tahun" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Kelompok Indikator</label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kelompok_indikator',$kelompok_indikator,'0','id="kl-kelompok_indikator" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Rentang Tahun</label>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_awal',array("0"=>"Pilih Tahun"),'','id="kl-tahun_awal"')?>
                        </div>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_akhir',array("0"=>"Pilih Tahun"),'','id="kl-tahun_akhir"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-5">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="kl-kodekl" class="populate"')?>
                        </div>
                    </div>
                  	
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="profilekl-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    
     <div class="feed-box hide" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                
                <p class="text-primary">Daftar IKU Kementerian</p><br />
                 
				    <div class="adv-table" id="kl-data" style="width:100%; overflow: auto; padding:10px 5px 10px 5px;">
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
			kl_renstra = $('#kl-tahun');
			kl_tahun_awal = $('#kl-tahun_awal');
			kl_tahun_akhir = $('#kl-tahun_akhir');
			kl_renstra.change(function(){
				kl_tahun_awal.empty(); kl_tahun_akhir.empty();
				kl_tahun_awal.append(new Option("Pilih Tahun","0"));
				kl_tahun_akhir.append(new Option("Pilih Tahun","0"));
				$("#kl-tahun_awal").select2("val", "0");
				$("#kl-tahun_akhir").select2("val", "0");
				if (kl_renstra.val()!=0) {
					//alert('here');
					kl_year = kl_renstra.val().split('-');
					
					for (i=parseInt(kl_year[0]);i<=parseInt(kl_year[1]);i++)  {
						kl_tahun_awal.append(new Option(i,i));
						kl_tahun_akhir.append(new Option(i,i));
					}
					kl_tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); 
					kl_tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
					
				}
			});
			kl_load_data = function(){
				var kl_tahun_awal = $('#kl-tahun_awal').val();
				var kl_tahun_akhir = $('#kl-tahun_akhir').val();
				var kl_kodekl = $('#kl-kodekl').val();
				var kl_indikator = $('#kl-kelompok_indikator').val();
				$("#kl-data").load("<?=base_url()?>laporan/kelompok_indikator_kl/getindikator/"+kl_indikator+"/"+kl_tahun_awal+"/"+kl_tahun_akhir+"/"+kl_kodekl);
				$("#kl-data").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
			}
			
			 $("#profilekl-btn").click(function(){
				kl_load_data();
				$('#box-result').removeClass("hide");
			}); 
			
			
		});
	</script>