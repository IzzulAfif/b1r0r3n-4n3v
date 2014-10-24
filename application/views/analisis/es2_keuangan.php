            
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
                            <?=form_dropdown('renstra',$renstra,'0','id="es2-renstra" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Rentang Tahun <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_awal',array("Pilih Tahun"),'','id="es2-tahun_awal" class="populate" style="width:100%"')?>
                        </div>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_akhir',array("Pilih Tahun"),'','id="es2-tahun_akhir" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                       <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="kodees1" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                       	<?=form_dropdown('kode_e2',array("0"=>"Semua Unit Kerja Eselon II"),'0','id="kodees2" class="populate"  style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="es2keu-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                    
                </form>
            </div>
        </section>
    </div>
                   
	<div id="keuangan_es2_tabel" class="hide">
		
        <div id="keuangan_es2_konten">
        </div>
        
        <div id="grafik_es2" style="padding:10px 5px 10px 5px">                    
        </div>
                        
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_keuanganes2"><i class="fa fa-print"></i> Cetak PDF</button>          
            <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_targetes2"><i class="fa fa-download"></i> Ekspor Excel</button>
        </div>
	
    </div>
    
	<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		renstra3 = $('#es2-renstra');
        tahun_awale2 = $('#es2-tahun_awal');
        tahun_akhire2 = $('#es2-tahun_akhir');
        renstra3.change(function(){
            tahun_awale2.empty(); tahun_akhire2.empty();
            if (renstra3.val()!=0) {
                year = renstra3.val().split('-');
                for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
                    tahun_awale2.append(new Option(i,i));
                    tahun_akhire2.append(new Option(i,i));
                }
                tahun_awale2.select2({minimumResultsForSearch: -1, width:'resolve'}); 
				tahun_akhire2.select2({minimumResultsForSearch: -1, width:'resolve'});
            }
        });
		
		$("#es2-tahun_akhir").change(function(){
			var renstra_thn2 = $('#es2-renstra').val();
			
			 $.ajax({
				url:"<?php echo site_url(); ?>unit_kerja/eselon1/get_list_eselon1/"+renstra_thn2,
				success:function(result) {
					$('#kodees1').empty();
					//alert('kadieu');
					result = JSON.parse(result);
					for (k in result) {
						$('#kodees1').append(new Option(result[k],k));
					}
					$("#kodees1").select2("val", "0");
				}
			});
		});
		
		$("#kodees1").change(function(){
			var renstra_thn2 = $('#es2-renstra').val();
			$.ajax({
				url:"<?php echo site_url(); ?>unit_kerja/eselon2/get_list_eselon2/"+renstra_thn2+"/"+this.value,
				success:function(result) {
					
					$("#kodees2").empty();
					result = JSON.parse(result);
					for (k in result) {
						$("#kodees2").append(new Option(result[k],k));
					}
					$("#kodees2").select2("val", "0");
				}
			});
		});
			
		$("#es2keu-btn").click(function(){
			
			tahun = $('#es2-renstra').val();
			tahun_awal = $('#es2-tahun_awal').val();
        	tahun_akhir = $('#es2-tahun_akhir').val();
			es1			= $('#kodees1').val();
			es2			= $('#kodees2').val();
			
			if (tahun=="0")
			{
				alert("Periode Renstra belum ditentukan");
				$('#es1-renstra').select2('open');
			}
			else if (es1=="0")
			{
				alert("Unit Kerja Eselon I belum ditentukan");
				$('#kodees1').select2('open');
			}
			else if (es2=="0")
			{
				alert("Unit Kerja Eselon II belum ditentukan");
				$('#kodees2').select2('open');
			}
			else{
			
				$.ajax({
						url:"<?php echo site_url(); ?>analisis/keuangan/get_body_es2_keu/"+tahun+'/'+tahun_awal+'/'+tahun_akhir+'/'+es1+'/'+es2,
							success:function(result) {   
								$('#keuangan_es2_tabel').removeClass("hide");
								$('#keuangan_es2_konten').html(result);
							}
					});
				
			}
		});
		
		$('#cetakpdf_keuanganes2').click(function(){
			tahun = $('#es2-renstra').val();
			tahun_awal = $('#es2-tahun_awal').val();
        	tahun_akhir = $('#es2-tahun_akhir').val();
			es1			= $('#kodees1').val();
			es2			= $('#kodees2').val();
			window.open('<?=base_url()?>analisis/keuangan/print_keuanganes2_pdf/'+tahun+'/'+tahun_awal+'/'+tahun_akhir+'/'+es1+'/'+es2,'_blank');			
		});
	})
	</script>	        