<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Rencana Strategis Kementerian</b>
                    </header>
                    <div class="panel-body">
						<div class="row">
							<div class="well wellform">
							<form class="form-horizontal">
								<p class="text-primary"><b>Kriteria</b></p>
								<div class="form-group">
									<label class="col-sm-2 control-label">Periode Renstra</label>
									<div class="col-sm-2">				
										<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="tahun" class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nama Kementerian</label>
									<div class="col-sm-3">				
										<?=form_dropdown('kodekl',array("-1"=>"Pilih Kementerian","022"=>"Kementerian Perhubungan"),'0','id="kodekl" class="form-control input-sm"')?>
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
									<div id="visi" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr>
							<tr>
								<td>Misi</td>
								<td>:&nbsp;</td>
								<td>
									<div id="misi" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr>
							<tr>
								<td>Tujuan</td>
								<td>:&nbsp;</td>
								<td>
									<div id="tujuan" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr> 
							<tr>
								<td colspan="3">
									<div id="sasaran"  >
										
									</div>
								</td>
								
							</tr>
							<tr>
								<td>Detail Perencanaan</td>
								<td>:&nbsp;</td>
								<td>
									<a href="#" id="klikdisini">Klik Disini</a>
								</td>
							</tr>
							<tr>
								<td>Program</td>
								<td>:&nbsp;</td>
								<td>
									<div id="program" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr>
							
							</table>	
						</div>
                    
                    </div>
                </section>
            </div>
        </div>
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			load_profile = function(){
				var tahun = $('#tahun').val();
				var kodekl = $('#kodekl').val();
				
				$("#visi").load("<?=base_url()?>laporan/renstra_kl/get_visi/"+tahun+"/"+kodekl);
				$("#misi").load("<?=base_url()?>laporan/renstra_kl/get_misi/"+tahun+"/"+kodekl);
				$("#tujuan").load("<?=base_url()?>laporan/renstra_kl/get_tujuan/"+tahun+"/"+kodekl);
				$("#sasaran").load("<?=base_url()?>laporan/renstra_kl/get_sasaran/"+tahun+"/"+kodekl);
				$("#program").load("<?=base_url()?>laporan/renstra_kl/get_program/"+tahun+"/"+kodekl);
			}
			
			 $("#kodekl").change(function(){
				load_profile();
			}); 
			
			$("#klikdisini").click(function(){
				var tahun = $('#tahun').val();
				var kodekl = $('#kodekl').val();
				window.open("<?=base_url()?>laporan/renstra_kl/get_detail/"+tahun+"/"+kodekl);
			}); 
		});
	</script>