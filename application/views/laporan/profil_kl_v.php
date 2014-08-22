
					
                    <div class="panel-body">
						<div class="row">
							<div class="well wellform">
							<form class="form-horizontal">
								<p class="text-primary"><b>Profil Unit Kerja Kementerian</b></p>
								<div class="form-group">
									<label class="col-sm-2 control-label">Periode Renstra</label>
									<div class="col-sm-2">				
										<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="kl-tahun" class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nama Kementerian</label>
									<div class="col-sm-3">				
										<?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="kl-kodekl" class="form-control input-sm"')?>
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
		
                    </div>
               
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
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