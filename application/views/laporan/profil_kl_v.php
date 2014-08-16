<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Profil Unit Kerja Kementerian
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
						<td>Nama Kementerian</td>
						<td>:&nbsp;</td>
						<td>
							<select id="kodekl">
								<option value="-1">--</option>
								<option value="022">Kementerian Perhubungan</option>
								
							</select>
						</td>
					</tr>
                    <tr>
						<td>Tugas Pokok</td>
						<td>:&nbsp;</td>
						<td></td>
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
			load_profile = function(){
				var tahun = $('#tahun').val();
				var kodekl = $('#kodekl').val();
				$("#unitkerja").load("<?=base_url()?>laporan/profil_kl/get_unit_kerja/"+kodekl);
				$("#fungsi").load("<?=base_url()?>laporan/profil_kl/get_fungsi/"+tahun+"/"+kodekl);
			}
			
			 $("#kodekl").change(function(){
				load_profile();
			}); 
		});
	</script>