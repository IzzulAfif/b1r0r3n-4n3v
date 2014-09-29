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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e1-tahun" class="populate"')?>
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
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_profilee1"><i class="fa fa-download"></i> Download PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_profilee1"><i class="fa fa-download"></i> Download Excel</button>
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

			load_profile_e1 = function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kode_e1').val();
				$("#e1-unitkerja").load("<?=base_url()?>laporan/profil_eselon1/get_unit_kerja/"+kodee1);
				$("#e1-fungsi").load("<?=base_url()?>laporan/profil_eselon1/get_fungsi/"+tahun+"/"+kodee1);
				$("#e1-tugas").load("<?=base_url()?>laporan/profil_eselon1/get_tugas/"+tahun+"/"+kodee1);
			}
			
			 $("#profilee1-btn").click(function(){
				load_profile_e1();
				$('#box-resulte1').removeClass("hide");
			}); 
			
			$('#cetakpdf_profilee1').click(function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kode_e1').val();
				window.open('<?=base_url()?>laporan/profil_eselon1/print_pdf/'+tahun+'/'+kodee1,'_blank');			
			});
		});
	</script>