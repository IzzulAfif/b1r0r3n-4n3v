<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-2">
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e1-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-4">
                           <?=form_dropdown('kode_e1',$eselon1,'0','id="e1-kodee1" class="populate"')?>
                        </div>
                    </div>
                  
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">                	
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Visi</label>
                    	<div class="col-md-10" id="e1-visi"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Misi</label>
                    	<div class="col-md-10" id="e1-misi"></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Tujuan</label>
                    	<div class="col-md-10" id="e1-tujuan"></div>
                    </div>
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Sasaran</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e1-sasaran"  ></div>
                        </div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Detail Perencanaan</label>
                    	<div class="col-md-10" ><a href="#" id="e1-klikdisini">Klik Disini</a></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Program</label>
                    	<div class="col-md-10" id="e1-program"></div>
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
			load_profile_e1 = function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kodee1').val();
				
				$("#e1-visi").load("<?=base_url()?>laporan/renstra_eselon1/get_visi/"+tahun+"/"+kodee1);
				$("#e1-misi").load("<?=base_url()?>laporan/renstra_eselon1/get_misi/"+tahun+"/"+kodee1);
				$("#e1-tujuan").load("<?=base_url()?>laporan/renstra_eselon1/get_tujuan/"+tahun+"/"+kodee1);
			}
			
			 $("#e1-kodee1").change(function(){
				load_profile_e1();
			}); 
		});
	</script>