<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Profil Unit Kerja Kementerian</b>
                        
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
							<table class="display table">
							<tr>
								<td class="col-sm-2">Tugas Pokok</td>
								<td width="1px">:&nbsp;</td>
								<td>
									<div id="tugas" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr>
							<tr>
								<td>Fungsi</td>
								<td>:&nbsp;</td>
								<td>
									<div id="fungsi" style="margin-left:-30px;">
										
									</div>
								</td>
							</tr>
							<tr>
								<td>Unit Kerja</td>
								<td>:&nbsp;</td>
								<td>
									<div id="unitkerja" style="margin-left:-30px;">
										
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
				$("#unitkerja").load("<?=base_url()?>laporan/profil_kl/get_unit_kerja/"+kodekl);
				$("#fungsi").load("<?=base_url()?>laporan/profil_kl/get_fungsi/"+tahun+"/"+kodekl);
				$("#tugas").load("<?=base_url()?>laporan/profil_kl/get_tugas/"+tahun+"/"+kodekl);
			}
			
			 $("#kodekl").change(function(){
				load_profile();
			}); 
		});
	</script>