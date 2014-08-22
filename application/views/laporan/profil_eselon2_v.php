
                    <div class="panel-body">
					
                    <div class="row">
							<div class="well wellform">
							<form class="form-horizontal">
								<p class="text-primary"><b>Profil Unit Kerja Eselon II</b></p>
								<div class="form-group">
									<label class="col-sm-2 control-label">Periode Renstra</label>
									<div class="col-sm-2">				
										<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e2-tahun" class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Unit Kerja Eselon I</label>
									<div class="col-sm-5">				
										<?=form_dropdown('kode_e1',$eselon1,'0','id="e2-kode_e1" class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Unit Kerja Eselon II</label>
									<div class="col-sm-5">				
										<?=form_dropdown('kode_e2',array(),'','id="e2-kode_e2" class="form-control input-sm"')?>
									</div>
								</div>
							</form>
							</div>
						</div>
						<br>
						<div class="row">
							<table class="display table">
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
                    
                    </div>
              
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