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
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e2-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-4">
                           <?=form_dropdown('kode_e1',$eselon1,'0','id="e2-kode_e1" class="populate"')?>
                        </div>
                    </div> 
					<div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-4">
                           <?=form_dropdown('kode_e2',array(),'','id="e2-kode_e2" class="populate"')?>
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
                    	<div class="col-md-10" id="e2-visi"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Misi</label>
                    	<div class="col-md-10" id="e2-misi"></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Tujuan</label>
                    	<div class="col-md-10" id="e2-tujuan"></div>
                    </div>
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Sasaran</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e2-sasaran"  ></div>
                        </div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Detail Perencanaan</label>
                    	<div class="col-md-10" ><a href="#" id="e2-klikdisini">Klik Disini</a></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Program</label>
                    	<div class="col-md-10" id="e2-program"></div>
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
			load_profile_e2 = function(){
				var tahun = $('#e2-tahun').val();
				var kodee2 = $('#e2-kode_e2').val();
				
				$("#e2-visi").load("<?=base_url()?>laporan/renstra_eselon2/get_visi/"+tahun+"/"+kodee2);
				$("#e2-misi").load("<?=base_url()?>laporan/renstra_eselon2/get_misi/"+tahun+"/"+kodee2);
				$("#e2-tujuan").load("<?=base_url()?>laporan/renstra_eselon2/get_tujuan/"+tahun+"/"+kodee2);
			}
			
			 $("#e2-kode_e2").change(function(){
				load_profile_e2();
			}); 
			$("#e2-kode_e1").change(function(){
				$.ajax({
					url:"<?php echo site_url(); ?>laporan/renstra_eselon2/get_list_eselon2/"+this.value,
					success:function(result) {
						kode_e2 = $('#e2-kode_e2');
						kode_e2.empty();
						result = JSON.parse(result);
						for (k in result) {
							kode_e2.append(new Option(result[k],k));
						}
					}
				});
			});

		});
	</script>