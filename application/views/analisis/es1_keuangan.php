            
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
                            <?=form_dropdown('renstra',$renstra,'0','id="es1-renstra" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Rentang Tahun <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_awal',array("Pilih Tahun"),'','id="es1-tahun_awal" class="populate" style="width:100%"')?>
                        </div>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_akhir',array("Pilih Tahun"),'','id="es1-tahun_akhir" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="es1-kode" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="es1keu-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                    
                </form>
            </div>
        </section>
    </div>
                   
	<div id="keuangan_es1_tabel" class="hide">
		
        <div id="keuangan_es1_konten">
        </div>
        
        <div style="margin-bottom:5px;" align="right">
            <button type="button" class="btn btn-warning btn-sm" onclick="chart.print();"><i class="fa fa-print"></i> Cetak Grafik</button>
        </div>
            
        <div id="grafik_es1" style="padding:10px 5px 10px 5px; width:100%;">                    
        </div>
                        
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_keuanganes1"><i class="fa fa-print"></i> Cetak PDF</button>          
            <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_keuanganes1"><i class="fa fa-download"></i> Ekspor Excel</button>
        </div>
	
    </div>
    
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		renstra = $('#es1-renstra');
        tahun_awale1 = $('#es1-tahun_awal');
        tahun_akhire1 = $('#es1-tahun_akhir');
        renstra.change(function(){
            tahun_awale1.empty(); tahun_akhire1.empty();
            if (renstra.val()!=0) {
                year = renstra.val().split('-');
                for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
                    tahun_awale1.append(new Option(i,i));
                    tahun_akhire1.append(new Option(i,i));
                }
                tahun_awale1.select2({minimumResultsForSearch: -1, width:'resolve'}); 
				tahun_akhire1.select2({minimumResultsForSearch: -1, width:'resolve'});
            }
        });
		
		$("#es1-tahun_akhir").change(function(){
			var renstra_thn = $('#es1-renstra').val();
			 $.ajax({
				url:"<?php echo site_url(); ?>unit_kerja/eselon1/get_list_eselon1/"+renstra_thn,
				success:function(result) {
					$('#es1-kode').empty();
					//alert('kadieu');
					result = JSON.parse(result);
					for (k in result) {
						$('#es1-kode').append(new Option(result[k],k));
					}
					$("#es1-kode").select2("val", "0");
				}
			});
		});
		
		$("#es1keu-btn").click(function(){
			
			tahun = $('#es1-renstra').val();
			tahun_awal = $('#es1-tahun_awal').val();
        	tahun_akhir = $('#es1-tahun_akhir').val();
			es1			= $('#es1-kode').val();
			
			if (tahun=="0")
			{
				alert("Periode Renstra belum ditentukan");
				$('#es1-renstra').select2('open');
			}
			else if (es1=="0")
			{
				alert("Unit Kerja belum ditentukan");
				$('#es1-kode').select2('open');
			}
			else{
			
				$.ajax({
						url:"<?php echo site_url(); ?>analisis/keuangan/get_body_es1_keu/"+tahun+'/'+tahun_awal+'/'+tahun_akhir+'/'+es1,
							success:function(result) {   
								$('#keuangan_es1_tabel').removeClass("hide");
								$('#keuangan_es1_konten').html(result);
							}
					});
				
			}
		});
		
		$('#cetakpdf_keuanganes1').click(function(){
			tahun 		= $('#es1-renstra').val();
			tahun_awal 	= $('#es1-tahun_awal').val();
        	tahun_akhir = $('#es1-tahun_akhir').val();
			es1			= $('#es1-kode').val();
			window.open('<?=base_url()?>analisis/keuangan/print_keuanganes1_pdf/'+tahun+'/'+tahun_awal+'/'+tahun_akhir+'/'+es1,'_blank');			
		});
		$('#cetakexcel_keuanganes1').click(function(){
			tahun 		= $('#es1-renstra').val();
			tahun_awal 	= $('#es1-tahun_awal').val();
        	tahun_akhir = $('#es1-tahun_akhir').val();
			es1			= $('#es1-kode').val();
			window.open('<?=base_url()?>analisis/keuangan/print_keuanganes1_excel/'+tahun+'/'+tahun_awal+'/'+tahun_akhir+'/'+es1,'_blank');			
		});
	})
	</script>	        