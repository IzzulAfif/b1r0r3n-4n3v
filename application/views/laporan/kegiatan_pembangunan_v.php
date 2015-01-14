	<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
                <section class="panel">
                    <header class="panel-heading tab-bg-light tab-right ">
                        <p class="pull-left"><b>Output Kegiatan Pembangunan Menurut Indikator</b></p>
                        <span class="pull-right">
                          
                         </span>
                    </header>
                    <div class="panel-body">
    <div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra<span class="text-danger">*</span></label>
                        <div class="col-md-3">
							 <?=form_dropdown('tahun_renstra',$tahun_renstra,'0','id="tahun_renstra"')?>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-md-2 control-label">Tahun<span class="text-danger">*</span></label>
                        <div class="col-md-2">
							 <?=form_dropdown('tahun',array("0"=>"Pilih Tahun"),'0','id="tahun"')?>
                        </div>
                    </div>
                  
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Kelompok Indikator<span class="text-danger">*</span></label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kelompok_indikator',$kelompok_indikator,'0','id="kelompok_indikator" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Program</label>
                        <div class="col-md-9">
                        	 <?=form_dropdown('program',array("0"=>"Semua Program"),'0','id="program" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Kegiatan</label>
                        <div class="col-md-9">
                        	 <?=form_dropdown('kegiatan',array("0"=>"Semua Kegiatan"),'0','id="kegiatan" class="populate"')?>
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-9">
                        	 <=form_dropdown('kode_e1',$eselon1,'0','id="kode_e1" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-9">
                        	 <=form_dropdown('kode_e2',array(),'0','id="kode_e2" class="populate"')?>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-md-2 control-label">Lokasi<span class="text-danger">*</span></label>
                        <div class="col-md-9">
                        	<=form_dropdown('kdlokasi',$lokasi,'0','id="list-kdlokasi" class="populate" style="width:100%"')?>
                        </div>
                    </div> -->
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="list-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                        
                </form>
            </div>
        </section>
    </div>
	</div>
		<div class="feed-box hide" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <p class="text-primary">Item Pekerjaan Pembangunan</p><br />
               <div id="div-pembangunan">
			   </div>
            </div>
			<div class="pull-right">
					<button type="button" class="btn btn-primary btn-sm" id="cetakpdf_realisasiprogram"><i class="fa fa-print"></i> Cetak PDF</button>          
					<button type="button" class="btn btn-primary btn-sm" id="cetakexcel_realisasiprogram"><i class="fa fa-download"></i> Ekspor Excel</button>
				</div>
			</section>
            </div>
        </section>
    </section>
    
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
    <!--js-->
    <script type="text/javascript">
    $(document).ready(function () {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		set_tahun = function(){
			var periode_renstra = $("#tahun_renstra");
			var tahun = $("#tahun");
			
			tahun.empty();
			tahun.append(new Option("Pilih Tahun","0"));
			 if (periode_renstra.val()!=0) {
				year = periode_renstra.val().split('-');
				//alert(year[0]);
				
				tahun.select2("val", "0");
				for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
					tahun.append(new Option(i,i));
					
				}
				
			 }
			 $('#tahun').select2({minimumResultsForSearch: -1, width:'resolve'});
		}
	
		$('#tahun_renstra').change(function(){
			//tahun	= $('#tahun_renstra').val();
			set_tahun();
			$('#tahun').change();
		});
		
		$('#tahun').change(function(){
			tahun	= $('#tahun').val();
		/*	$.ajax({
				url:"<?=site_url()?>laporan/realisasi_program/get_sastra/"+tahun,
				success:function(result) {
					$('#kelompok_indikator').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#kelompok_indikator').append(new Option(result[a],a));
					}
					$('#kelompok_indikator').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});*/
			
			$.ajax({
				url:"<?=site_url()?>laporan/kegiatan_pembangunan/get_program/"+tahun,
				success:function(result) {
					$('#program').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#program').append(new Option(result[a],a));
					}
					$('#program').select2({minimumResultsForSearch: -1, width:'resolve'});
					
					$('#program').select2("val", "0");
				}
			});
			$("#program").change();
		});
		
		
		$("#program").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>laporan/kegiatan_pembangunan/get_kegiatan/"+$('#tahun').val()+"/"+this.value,
				success:function(result) {
					
					$('#kegiatan').empty();					
					result = JSON.parse(result);
					for (k in result) {
						$('#kegiatan').append(new Option(result[k],k));
					}
					$('#kegiatan').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
		
		$("#kode_e1").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>laporan/kegiatan_pembangunan/get_list_eselon2/"+this.value,
				success:function(result) {
					
					$('#kode_e2').empty();					
					result = JSON.parse(result);
					for (k in result) {
						$('#kode_e2').append(new Option(result[k],k));
					}
				}
			});
		});
		
		$('#list-lokasi').change(function(){
			$('#box-result').removeClass("hide");
		});
		
		
		$("#list-btn").click(function(){
			tahun = $('#tahun').val();
			indikator = $('#kelompok_indikator').val();
			program = $('#program').val();
			kegiatan = $('#kegiatan').val();
			lokasi = "-1";//$('#list-kdlokasi').val();
			if ($('#tahun_renstra').val()=="0"){
				alert("Periode Renstra belum ditentukan");
				$('#tahun_renstra').select2('open');
			}
			else if (tahun=="0"){
				alert("Tahun belum ditentukan");
				$('#tahun').select2('open');
			}
			else if (indikator=="0"){
				alert("Kelompok Indikator belum ditentukan");
				$('#kelompok_indikator').select2('open');
			}
		/*	else if (program=="0"){
				alert("Program belum ditentukan");
				$('#program').select2('open');
			}
			else if (kegiatan=="0"){
				alert("Kegiatan belum ditentukan");
				$('#kegiatan').select2('open');
			}
			else if (lokasi=="0"){
				alert("Lokasi belum ditentukan");
				$('#list-kdlokasi').select2('open');
			}*/
			else {
				$("#div-pembangunan").load("<?=base_url()?>laporan/kegiatan_pembangunan/get_list_rincian/"+tahun+"/"+indikator+"/"+program+"/"+kegiatan+"/"+lokasi);
					$("#div-pembangunan").mCustomScrollbar({
								axis:"x",
								theme:"dark-2"
							});
					 $('#box-result').removeClass("hide");
				
			}
		});
		
		$('#cetakpdf_realisasiprogram').click(function(){				
				window.open('<?=base_url()?>laporan/kegiatan_pembangunan/print_pdf/'+$("#tahun_renstra").val()+"/"+$("#tahun").val()+"/"+$("#kelompok_indikator").val()+"/"+$("#program").val()+"/"+$("#kegiatan").val()+"/"+$("#list-kdlokasi").val(),'_blank');			
			});
		$('#cetakexcel_realisasiprogram').click(function(){				
				window.open('<?=base_url()?>laporan/kegiatan_pembangunan/excel/'+$("#tahun_renstra").val()+"/"+$("#tahun").val()+"/"+$("#kelompok_indikator").val()+"/"+$("#program").val()+"/"+$("#kegiatan").val()+"/"+$("#list-kdlokasi").val(),'_blank');			
			});
			
    });
    </script>
    <!--js-->