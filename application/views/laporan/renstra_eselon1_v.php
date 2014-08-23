<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-2">
                         	<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e1-tahun" class="form-control input-sm"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja</label>
                        <div class="col-md-4">
                           <?=form_dropdown('kode_e1',$eselon1,'0','id="e1-kodee1" class="form-control input-sm"')?>
                        </div>
                    </div>
                  
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                
                <p class="text-primary">Rencana Strategis Eselon I</p><br />
                <table  class="display table table-bordered table-striped" id="tabel_capaian">
				<tr>
					<td class="col-sm-2">Visi</td>
					<td width="1px">:&nbsp;</td>
					<td>
						<div id="e1-visi" style="margin-left:-30px;">
							
						</div>
					</td>
				</tr>
				<tr>
					<td>Misi</td>
					<td>:&nbsp;</td>
					<td>
						<div id="e1-misi" style="margin-left:-30px;">
							
						</div>
					</td>
				</tr>
				<tr>
					<td>Tujuan</td>
					<td>:&nbsp;</td>
					<td>
						<div id="e1-tujuan" style="margin-left:-30px;">
							
						</div>
					</td>
				</tr>
				<tr>
						<td colspan="3">
							<div id="e1-sasaran"  >
								
							</div>
						</td>
						
					</tr>
					<tr>
						<td>Detail Perencanaan</td>
						<td>:&nbsp;</td>
						<td>
							<a href="#" id="e1-klikdisini">Klik Disini</a>
						</td>
					</tr>
					<tr>
						<td>Program</td>
						<td>:&nbsp;</td>
						<td>
							<div id="e1-program" style="margin-left:-30px;">
								
							</div>
						</td>
					</tr>
					<tr>
						<td>Kegiatan</td>
						<td>:&nbsp;</td>
						<td>
							<div id="e1-kegiatan" style="margin-left:-30px;">
								
							</div>
						</td>
					</tr>
    	        </table>
                
            </div>
        </section>
    </div>
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
	
                    
                
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			load_profile_e1 = function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kodee1').val();
				
				$("#e1-visi").load("<?=base_url()?>laporan/renstra_eselon1/get_visi/"+tahun+"/"+kodee1);
				$("#e1-misi").load("<?=base_url()?>laporan/renstra_eselon1/get_misi/"+tahun+"/"+kodee1);
				$("#e1-tujuan").load("<?=base_url()?>laporan/renstra_eselon1/get_tujuan/"+tahun+"/"+kodee1);
			}
			
			 $("#e1-kodee1").change(function(){
				load_profile_e1();
			}); 
		});
	</script>