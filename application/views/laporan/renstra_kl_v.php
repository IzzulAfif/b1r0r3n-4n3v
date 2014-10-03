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
                    	<p class="text-primary col-md-12" ><b>Sasaran</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="kl-sasaran"  ></div>
                        </div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Detail Perencanaan</label>
                    	<div class="col-md-10" ><a href="#" id="kl-klikdisini">Klik Disini</a></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Program</label>
                    	<div class="col-md-10" id="kl-program"></div>
                    </div>
                </form>
				
               
                
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
			load_profile = function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				
				$("#kl-visi").load("<?=base_url()?>laporan/renstra_kl/get_visi/"+tahun+"/"+kodekl);
				$("#kl-misi").load("<?=base_url()?>laporan/renstra_kl/get_misi/"+tahun+"/"+kodekl);
				$("#kl-tujuan").load("<?=base_url()?>laporan/renstra_kl/get_tujuan/"+tahun+"/"+kodekl);
				$("#kl-sasaran").load("<?=base_url()?>laporan/renstra_kl/get_sasaran/"+tahun+"/"+kodekl);
				$("#kl-program").load("<?=base_url()?>laporan/renstra_kl/get_program/"+tahun+"/"+kodekl);
			}
			
			$("#renstrakl-btn").click(function(){
				load_profile();
				$('#box-result').removeClass("hide");
			});
			
			$("#kl-klikdisini").click(function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				window.open("<?=base_url()?>laporan/renstra_kl/get_detail/"+tahun+"/"+kodekl);
			}); 
		});
	</script>