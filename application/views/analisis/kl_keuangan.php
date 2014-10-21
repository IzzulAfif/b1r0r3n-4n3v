            
<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
				
   <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <?=form_dropdown('renstra',$renstra,'0','id="renstra" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Rentang Tahun <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_awal',array("Pilih Tahun"),'','id="tahun_awal" class="populate" style="width:100%"')?>
                        </div>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_akhir',array("Pilih Tahun"),'','id="tahun_akhir" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="klkeu-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                    
                </form>
            </div>
        </section>
    </div>
                   
	<div id="keuangan_kl_konten" class="hide">

        <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="target-tbl">
            <thead>
            <tr>
                <th width="3%">No</th>
                <th>Program</th>
                <th>Uraian</th>
                <th><span id="klkeu-tahun1">-</span></th>
                <th><span id="klkeu-tahun2">-</span></th>
                <th><span id="klkeu-tahun3">-</span></th>
                <th><span id="klkeu-tahun4">-</span></th>
                <th><span id="klkeu-tahun5">-</span></th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
        
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_targetkl"><i class="fa fa-print"></i> Cetak PDF</button>          
            <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_targetkl"><i class="fa fa-download"></i> Ekspor Excel</button>
        </div>
	
    </div>
    
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		renstra = $('#renstra');
        tahun_awal = $('#tahun_awal');
        tahun_akhir = $('#tahun_akhir');
        renstra.change(function(){
            tahun_awal.empty(); tahun_akhir.empty();
            if (renstra.val()!=0) {
                year = renstra.val().split('-');
                for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
                    tahun_awal.append(new Option(i,i));
                    tahun_akhir.append(new Option(i,i));
                }
                tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); 
				tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
            }
        });
		
		$("#klkeu-btn").click(function(){
			
			tahun = $('#renstra').val();
			tahun_awal = $('#tahun_awal').val();
        	tahun_akhir = $('#tahun_akhir').val();
			
			if (tahun=="0")
			{
				alert("Periode Renstra belum ditentukan");
				$('#renstra').select2('open');
			}
			else {
				var arrayrenstra = tahun.split('-');
				var no = 1;
				for (i = arrayrenstra[0]; i <=arrayrenstra[1]; i++) { 
					$('#klkeu-tahun'+no).html(i);
					no++;
				}
			}
			$.ajax({
                    url:"<?php echo site_url(); ?>analisis/keuangan/get_body_kl_keu/"+tahun+'/'+tahun_awal+'/'+tahun_akhir,
                        success:function(result) {
                            //table_body = $('#target-tbl tbody');
                            //table_body.empty().html(result);        
                            $('#keuangan_kl_konten').removeClass("hide");
							$('#keuangan_kl_konten').html(result);
                        }
                });
		});
		
		$('#cetakpdf_targetkl').click(function(){
			tahun = $('#target-tahun').val();
			sasaran = $('#target-sasaran').val();
			window.open('<?=base_url()?>pemrograman/pemrograman_kl/print_target_pdf/'+tahun+"/"+sasaran,'_blank');			
		});
	})
	</script>	        