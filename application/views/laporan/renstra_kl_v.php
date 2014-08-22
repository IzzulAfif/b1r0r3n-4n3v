
                    <div class="panel-body">
						<div class="row">
							<div class="well wellform">
							<form class="form-horizontal">
								<p class="text-primary"><b>Rencana Strategis Kementerian</b></p>
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
							<table class="display table" border="0">										
							<tr>
								<td class="col-sm-2">Visi</td>
								<td width="1px">:&nbsp;</td>
								<td>
									<div id="kl-visi" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr>
							<tr>
								<td>Misi</td>
								<td>:&nbsp;</td>
								<td>
									<div id="kl-misi" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr>
							<tr>
								<td>Tujuan</td>
								<td>:&nbsp;</td>
								<td>
									<div id="kl-tujuan" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr> 
							<tr>
								<td colspan="3">
									<div id="kl-sasaran"  >
										
									</div>
								</td>
								
							</tr>
							<tr>
								<td>Detail Perencanaan</td>
								<td>:&nbsp;</td>
								<td>
									<a href="#" id="kl-klikdisini">Klik Disini</a>
								</td>
							</tr>
							<tr>
								<td>Program</td>
								<td>:&nbsp;</td>
								<td>
									<div id="kl-program" style="margin-left:-30px;">
										
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
				
				$("#kl-visi").load("<?=base_url()?>laporan/renstra_kl/get_visi/"+tahun+"/"+kodekl);
				$("#kl-misi").load("<?=base_url()?>laporan/renstra_kl/get_misi/"+tahun+"/"+kodekl);
				$("#kl-tujuan").load("<?=base_url()?>laporan/renstra_kl/get_tujuan/"+tahun+"/"+kodekl);
				$("#kl-sasaran").load("<?=base_url()?>laporan/renstra_kl/get_sasaran/"+tahun+"/"+kodekl);
				$("#kl-program").load("<?=base_url()?>laporan/renstra_kl/get_program/"+tahun+"/"+kodekl);
			}
			
			 $("#kl-kodekl").change(function(){
				load_profile();
			}); 
			
			$("#kl-klikdisini").click(function(){
				var tahun = $('#kl-tahun').val();
				var kodekl = $('#kl-kodekl').val();
				window.open("<?=base_url()?>laporan/renstra_kl/get_detail/"+tahun+"/"+kodekl);
			}); 
		});
	</script>