<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Matriks Pembangunan Bidang Transportasi
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
						<td>Visi</td>
						<td>:&nbsp;</td>
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
							<div id="sasaran"  class="panel-body" style="margin-left:-30px;">
								
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