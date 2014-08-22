
                    <div class="panel-body">
						<div class="row">
							<div class="well wellform">
							<form class="form-horizontal">
								<p class="text-primary"><b>Profil Unit Kerja Eselon I</b></p>
								<div class="form-group">
									<label class="col-sm-2 control-label">Periode Renstra</label>
									<div class="col-sm-2">				
										<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e1-tahun" class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nama Unit Kerja</label>
									<div class="col-sm-5">				
										<?=form_dropdown('kode_e1',$eselon1,'0','id="e1-kode_e1" class="form-control input-sm"')?>
									</div>
								</div>
							</form>
							</div>
						</div>
						<br>
						<div class="row">
							<table class="display table" >					
					
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
						
                    
                    </div>
               
    <!--main content end-->
	
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