<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Profil Unit Kerja Eselon II</b>
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
									<label class="col-sm-2 control-label">Unit Kerja Eselon I</label>
									<div class="col-sm-5">				
										<?=form_dropdown('kode_e1',$eselon1,'0','id="kode_e1" class="form-control input-sm"')?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Unit Kerja Eselon II</label>
									<div class="col-sm-5">				
										<?=form_dropdown('kode_e2',array(),'','id="kode_e2" class="form-control input-sm"')?>
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
								<td><div id="tugas" style="margin-left:-30px;">
										
									</div></td>
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
			 kode_e1 = $("#kode_e1");
			 kode_e2 = $("#kode_e2");
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
				
			load_profile = function(){
				var v_tahun = $('#tahun').val();
				var v_kode_e2 = $('#kode_e2').val();
				//$("#unitkerja").load("<?=base_url()?>laporan/profil_eselon1/get_unit_kerja/"+kodee1);
				$("#fungsi").load("<?=base_url()?>laporan/profil_eselon2/get_fungsi/"+v_tahun+"/"+v_kode_e2);
				$("#tugas").load("<?=base_url()?>laporan/profil_eselon2/get_tugas/"+v_tahun+"/"+v_kode_e2);
			}
			
			 $("#kode_e1").change(function(){
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

			$("#kode_e2").change(function(){
				load_profile();
			}); 
		});
	</script>