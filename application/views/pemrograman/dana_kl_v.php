            
<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
   <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                   <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         	<?=form_dropdown('tahun',$renstra,'0','id="dana-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group <?php if($page=="kl"): echo "hide"; endif; ?>">
                        <label class="col-md-2 control-label">Unit Kerja</label>
                        <div class="col-md-6">
                         <?=form_dropdown('kode_e1',$eselon1,'0','id="dana-kode_e1"  class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="dana-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>					 
                </form>
            </div>
        </section>
    </div>
                   
	<div id="dana_kl_konten" class="hide">
        
        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="dana-tbl">
                <thead>
                <tr>
                	<th rowspan="2">No</th>
                    <th rowspan="2">Nama Program</th>
                    <th colspan="5"><center>Alokasi Pendanaan</center></th>
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                	<th><span id="dana-tahun1">-</span></th>
                    <th><span id="dana-tahun2">-</span></th>
                    <th><span id="dana-tahun3">-</span></th>
                    <th><span id="dana-tahun4">-</span></th>
                    <th><span id="dana-tahun5">-</span></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
	
    	<div class="pull-right">
            <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_danakl"><i class="fa fa-print"></i> Cetak PDF</button>          
            <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_danakl"><i class="fa fa-download"></i> Ekspor Excel</button>
        </div>
        
    </div>
    
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$("#dana-btn").click(function(){
			tahun = $('#dana-tahun').val();
			kode = $('#dana-kode_e1').val();
			if (tahun=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#dana-tahun').select2('open');
			}
			else {
				var arrayrenstra = tahun.split('-');
				//alert(arrayrenstra[0]);
				var no = 1;
				for (i = arrayrenstra[0]; i <=arrayrenstra[1]; i++) { 
					$('#dana-tahun'+no).html(i);
					no++;
				}
			$.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_body_pendanaan/"+tahun+"/"+kode,
                        success:function(result) {
                            table_body = $('#dana-tbl tbody');
                            table_body.empty().html(result);        
                            $('#dana_kl_konten').removeClass("hide");
                        }
                });
			}
		});
		$('#cetakpdf_danakl').click(function(){
			tahun = $('#dana-tahun').val();
			kode = $('#dana-kode_e1').val();
			window.open('<?=base_url()?>pemrograman/pemrograman_kl/print_dana_pdf/'+tahun+"/"+kode,'_blank');			
		});
	})
	</script>	        