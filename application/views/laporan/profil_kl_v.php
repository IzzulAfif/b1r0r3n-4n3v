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
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="kl-tahun" class="form-control input-sm"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kementerian</label>
                        <div class="col-md-4">
                         <?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="kl-kodekl" class="form-control input-sm"')?>
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
                
                <p class="text-primary">Profil Unit Kerja Kementerian</p><br />
                <table  class="display table table-bordered table-striped" id="tabel_capaian">
					<tr>
						<td class="col-sm-2">Tugas Pokok</td>
						<td width="1px">:&nbsp;</td>
						<td>
							<div id="kl-tugas" style="margin-left:-30px;">
								
							</div>
						</td>
					</tr>
					<tr>
						<td>Fungsi</td>
						<td>:&nbsp;</td>
						<td>
							<div id="kl-fungsi" style="margin-left:-30px;">
								
							</div>
						</td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:&nbsp;</td>
						<td>
							<div id="kl-unitkerja" style="margin-left:-30px;">
								
							</div>
						</td>
					</tr>
    	        </table>
                
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
			
			 $("#kl-kodekl").change(function(){
				load_profile();
			}); 
			
			
		});
	</script>