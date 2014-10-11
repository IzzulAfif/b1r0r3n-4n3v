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
                         	<?=form_dropdown('tahun',$renstra,'0','id="kl-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-3">
                           <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="kl-kodekl" class="populate"')?>
                        </div>
                    </div>
                  	<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="renstrakl-btn" style="margin-left:15px;">
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
                    	<label class="col-md-2 text-primary">Visi</label>
                    	<div class="col-md-10" id="kl-visi"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Misi</label>
                    	<div class="col-md-10" id="kl-misi"></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Tujuan</label>
                    	<div class="col-md-10" id="kl-tujuan"></div>
                    </div>
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Sasaran Strategis dan IKU</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="kl-sasaran"  ></div>
                        </div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Target Capaian Kinerja</label>
                    	<div class="col-md-10" ><a href="#" id="kl-klikdisini">Klik Disini</a></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Program</label>
                    	<div class="col-md-10" id="kl-program"></div>
                    </div>
						<div class="form-group">
                    	<label class="col-md-2 text-primary">Kebutuhan Pendanaan</label>
                    	<div class="col-md-10" ><a href="#" id="kl-dana_klik">Klik Disini</a></div>
                    </div>
                </form>
				
                  <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_renstrakl"><i class="fa fa-download"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_renstrakl"><i class="fa fa-download"></i> Ekspor Excel</button>
                </div>
                
            </div>
        </section>
    </div>
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
	
	
                
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
			load_profile = function(tahun,kodekl){
				
				$("#kl-visi").load("<?=base_url()?>laporan/renstra_kl/get_visi/"+tahun+"/"+kodekl);
				$("#kl-misi").load("<?=base_url()?>laporan/renstra_kl/get_misi/"+tahun+"/"+kodekl);
				$("#kl-tujuan").load("<?=base_url()?>laporan/renstra_kl/get_tujuan/"+tahun+"/"+kodekl);
				$("#kl-sasaran").load("<?=base_url()?>laporan/renstra_kl/get_sasaran/"+tahun+"/"+kodekl);
				$("#kl-program").load("<?=base_url()?>laporan/renstra_kl/get_program/"+tahun+"/"+kodekl);
			}
			
			$("#renstrakl-btn").click(function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#kl-tahun').select2('open');
				}
				else {
					load_profile(tahun,kodekl);
					$('#box-result').removeClass("hide");
				}
			});
			
			$("#kl-klikdisini").click(function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				window.open("<?=base_url()?>laporan/renstra_kl/get_detail/"+tahun+"/"+kodekl);
			}); 
			
			$("#kl-dana_klik").click(function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				window.open("<?=base_url()?>laporan/renstra_eselon1/get_pendanaan/"+tahun+"/0/kl");
			}); 
			
			$('#cetakpdf_renstrakl').click(function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				window.open('<?=base_url()?>laporan/renstra_kl/print_pdf/'+tahun,'_blank');			
			});
		});
	</script>