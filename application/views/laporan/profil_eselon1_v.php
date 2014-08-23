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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e1-tahun" class="form-control input-sm"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="e1-kode_e1" class="form-control input-sm"')?>
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
                
                <p class="text-primary">Profil Unit Kerja Eselon I</p><br />
                <table  class="display table table-bordered table-striped" id="tabel_capaian">
					<tr>
						<td class="col-sm-2">Tugas Pokok</td>
						<td width="1px">:&nbsp;</td>
						<td><div id="e1-tugas" style="margin-left:-30px;">
								
							</div></td>
					</tr>
					<tr>
						<td>Fungsi</td>
						<td>:&nbsp;</td>
						<td>
							<div id="e1-fungsi" style="margin-left:-30px;">
								
							</div>
						</td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:&nbsp;</td>
						<td>
							<div id="e1-unitkerja" style="margin-left:-30px;">
								
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
	
	
                 
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			load_profile_e1 = function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kode_e1').val();
				$("#e1-unitkerja").load("<?=base_url()?>laporan/profil_eselon1/get_unit_kerja/"+kodee1);
				$("#e1-fungsi").load("<?=base_url()?>laporan/profil_eselon1/get_fungsi/"+tahun+"/"+kodee1);
				$("#e1-tugas").load("<?=base_url()?>laporan/profil_eselon1/get_tugas/"+tahun+"/"+kodee1);
			}
			
			 $("#e1-kode_e1").change(function(){
				load_profile_e1();
			}); 
		});
	</script>