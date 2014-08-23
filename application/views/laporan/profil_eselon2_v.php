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
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e2-tahun" class="form-control input-sm"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="e2-kode_e1" class="form-control input-sm"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e2',array(),'','id="e2-kode_e2" class="form-control input-sm"')?>
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
                
                <p class="text-primary">Profil Unit Kerja Eselon II</p><br />
                <table  class="display table table-bordered table-striped" id="tabel_capaian">
					<tr>
						<td class="col-sm-2">Tugas Pokok</td>
						<td width="1px">:&nbsp;</td>
						<td><div id="e2-tugas" style="margin-left:-30px;">
								
							</div></td>
					</tr>
					<tr>
						<td>Fungsi</td>
						<td>:&nbsp;</td>
						<td>
							<div id="e2-fungsi" style="margin-left:-30px;">
								
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
			 kode_e1 = $("#e2-kode_e1");
			 kode_e2 = $("#e2-kode_e2");
			 $.ajax({
                    url:"<?php echo site_url(); ?>laporan/profil_eselon2/get_list_eselon1",
                    success:function(result) {
                        kode_e1.empty();
                        result = JSON.parse(result);
                        for (k in result) {
                            kode_e1.append(new Option(result[k],k));
                        }
                    }
                });
				
			load_profile_e2 = function(){
				var v_tahun = $('#e2-tahun').val();
				var v_kode_e2 = $('#e2-kode_e2').val();
				
				$("#e2-fungsi").load("<?=base_url()?>laporan/profil_eselon2/get_fungsi/"+v_tahun+"/"+v_kode_e2);
				$("#e2-tugas").load("<?=base_url()?>laporan/profil_eselon2/get_tugas/"+v_tahun+"/"+v_kode_e2);
			}
			
			 $("#e2-kode_e1").change(function(){
				$.ajax({
                    url:"<?php echo site_url(); ?>laporan/profil_eselon2/get_list_eselon2/"+this.value,
                    success:function(result) {
                        kode_e2.empty();
                        result = JSON.parse(result);
                        for (k in result) {
                            kode_e2.append(new Option(result[k],k));
                        }
                    }
                });
			});

			$("#e2-kode_e2").change(function(){
				load_profile_e2();
			}); 
		});
	</script>