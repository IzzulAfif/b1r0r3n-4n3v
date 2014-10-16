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
                         		<?=form_dropdown('tahun',$renstra,'0','id="e2-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',array("0"=>"Pilih Unit Kerja Eselon I"),'0','id="e2-kode_e1" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e2',array("0"=>"Pilih Unit Kerja Eselon II"),'0','id="e2-kode_e2" class="populate"')?>
                        </div>
                    </div>
					    <div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="profilee2-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box hide" id="box-resulte2">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">                	
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Tugas</label>
                    	<div class="col-md-10" id="e2-tugas"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Fungsi</label>
                    	<div class="col-md-10" id="e2-fungsi"></div>
                    </div>
                </form>
                
                  <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="cetakpdf_profilee2"><i class="fa fa-print"></i> Cetak PDF</button>          
                    <button type="button" class="btn btn-primary btn-sm" id="cetakexcel_profilee2"><i class="fa fa-download"></i> Ekspor Excel</button>
                </div>
                
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
	$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
	 kode_e1 = $("#e2-kode_e1");
	 kode_e2 = $("#e2-kode_e2");
	
		
	load_profile_e2 = function(v_tahun,v_kode_e2){
	
		
		$("#e2-fungsi").load("<?=base_url()?>laporan/profil_eselon2/get_fungsi/"+v_tahun+"/"+v_kode_e2);
		$("#e2-tugas").load("<?=base_url()?>laporan/profil_eselon2/get_tugas/"+v_tahun+"/"+v_kode_e2);
	}
	
	 $("#e2-tahun").change(function(){
		 $.ajax({
			url:"<?php echo site_url(); ?>laporan/profil_eselon2/get_list_eselon1/"+this.value,
			success:function(result) {
				kode_e1.empty();
				result = JSON.parse(result);
				for (k in result) {
					kode_e1.append(new Option(result[k],k));
				}
				$("#e2-kode_e1").select2("val", "0");
				 $("#e2-kode_e1").change();
			}
		});
	});
	
	 $("#e2-kode_e1").change(function(){
		$.ajax({
			url:"<?php echo site_url(); ?>laporan/profil_eselon2/get_list_eselon2/"+ $('#e2-tahun').val()+"/"+this.value,
			success:function(result) {
				kode_e2.empty();
				result = JSON.parse(result);
				for (k in result) {
					kode_e2.append(new Option(result[k],k));
				}
				$("#e2-kode_e2").select2("val", "0");
			}
		});
	});
	
	 $("#profilee2-btn").click(function(){
				var tahun = $('#e2-tahun').val();
				var kodee1 = $('#e2-kode_e1').val();
				var kodee2 = $('#e2-kode_e2').val();
				if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#e2-tahun').select2('open');
				}
				else if (kodee1=="0") {
					alert("Unit Kerja Eselon I belum ditentukan");
					$('#e2-kode_e1').select2('open');
				}
				else if (kodee2=="0") {
					alert("Unit Kerja Eselon II belum ditentukan");
					$('#e2-kode_e2').select2('open');
				}else {
					load_profile_e2(tahun,kodee2);
					$('#box-resulte2').removeClass("hide");
				}
			}); 

	$('#cetakpdf_profilee2').click(function(){
		var tahun = $('#e2-tahun').val();
		var kodee2 = $('#e2-kode_e2').val();
		window.open('<?=base_url()?>laporan/profil_eselon2/print_pdf/'+tahun+'/'+kodee2,'_blank');			
	});
			
});
</script>