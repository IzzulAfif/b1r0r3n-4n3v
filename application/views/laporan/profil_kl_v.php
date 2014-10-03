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
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="kl-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group hide">
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
				
				<form class="form-horizontal grid-form" role="form">                	
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Tugas Pokok</label>
                    	<div class="col-md-10" id="kl-tugas"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Fungsi</label>
                    	<div class="col-md-10" id="kl-fungsi"></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Unit Kerja</label>
                    	<div class="col-md-10" id="kl-unitkerja"></div>
                    </div>
                </form>
                
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_profilekl"><i class="fa fa-download"></i> Download PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_profilekl"><i class="fa fa-download"></i> Download Excel</button>
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
	
			load_profile = function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				$("#kl-unitkerja").load("<?=base_url()?>laporan/profil_kl/get_unit_kerja/"+kodekl);
				$("#kl-fungsi").load("<?=base_url()?>laporan/profil_kl/get_fungsi/"+tahun+"/"+kodekl);
				$("#kl-tugas").load("<?=base_url()?>laporan/profil_kl/get_tugas/"+tahun+"/"+kodekl);
			}
			
			 $("#profilekl-btn").click(function(){
				load_profile();
				$('#box-result').removeClass("hide");
			}); 
			
			
			$('#cetakpdf_profilekl').click(function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				window.open('<?=base_url()?>laporan/profil/print_pdf/'+tahun,'_blank');			
			});
		});
	</script>