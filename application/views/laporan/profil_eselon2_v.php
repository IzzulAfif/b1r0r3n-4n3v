<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Profil Unit Kerja Eselon II
                        <span class="pull-right">
                            <!--<a href="<?=base_url()?>unit_kerja/eselon1/add" class="btn btn-primary btn-sm" style="margin-top:-5px;"><i class="fa fa-plus"></i> Tambah</a>-->
                         </span>
                    </header>
                    <div class="panel-body">
                    
                    <table class="table" border="0">
					<tr>
						<td width="200px">Tahun Renstra</td>
						<td width="5px">:&nbsp;</td>
						<td>
							<select id="tahun">
								<option value="2010-2014">2010-2014</option>
								
							</select>
						</td>
					</tr>
					<tr>
						<td>Nama Unit Kerja Eselon I</td>
						<td>:&nbsp;</td>
						<td><?=form_dropdown('kode_e1',array(),'','id="kode_e1"')?>
						</td>
					</tr>
					<tr>
						<td>Nama Unit Kerja Eselon II</td>
						<td>:&nbsp;</td>
						<td><?=form_dropdown('kode_e2',array(),'','id="kode_e2"')?>
						</td>
					</tr>
                    <tr>
						<td>Tugas Pokok</td>
						<td>:&nbsp;</td>
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