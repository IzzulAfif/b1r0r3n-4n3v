<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tahun',array("0"=>"Pilih Periode Renstra","2010-2014"=>"2010-2014"),'0','id="e2-tahun" class="populate"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Kelompok Indikator</label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kelompok_indikator',$kelompok_indikator,'0','id="e2-kelompok_indikator" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Rentang Tahun</label>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_awal',array("0"=>"Pilih Tahun"),'','id="e2-tahun_awal"')?>
                        </div>
                        <div class="col-md-2">
                            <?=form_dropdown('tahun_akhir',array("0"=>"Pilih Tahun"),'','id="e2-tahun_akhir"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="e2-kode_e1" class="populate"')?>
                        </div>
                    </div>
					  <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon II</label>
                        <div class="col-md-4">
                       <?=form_dropdown('kode_e2',array("0"=>"Pilih Unit Kerja Eselon II"),'','id="e2-kode_e2" class="populate"')?>
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
    
     
     <div class="feed-box hide" id="e2-box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                
                <p class="text-primary">Daftar IKK</p><br />
                 
				    <div class="adv-table" id="e2-data" style="width:100%; overflow: auto; padding:10px 5px 10px 5px;">
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
	
	 renstra = $('#e2-tahun');
	tahun_awal = $('#e2-tahun_awal');
	tahun_akhir = $('#e2-tahun_akhir');
	e2_kodee1 = $('#e2-kode_e1');
	e2_kodee2 = $('#e2-kode_e2');
	renstra.change(function(){
		tahun_awal.empty(); tahun_akhir.empty();
		tahun_awal.append(new Option("Pilih Tahun","0"));
		tahun_akhir.append(new Option("Pilih Tahun","0"));
		$("#e2-tahun_awal").select2("val", "0");
		$("#e2-tahun_akhir").select2("val", "0");
		if (renstra.val()!=0) {
			//alert('here');
			year = renstra.val().split('-');
			
			for (i=parseInt(year[0]);i<=parseInt(year[1]);i++)  {
				tahun_awal.append(new Option(i,i));
				tahun_akhir.append(new Option(i,i));
			}
			tahun_awal.select2({minimumResultsForSearch: -1, width:'resolve'}); tahun_akhir.select2({minimumResultsForSearch: -1, width:'resolve'});
			
		}
	});
	
	 $.ajax({
			url:"<?php echo site_url(); ?>laporan/kelompok_indikator_eselon2/get_list_eselon1",
			success:function(result) {
				e2_kodee1.empty();
				result = JSON.parse(result);
				for (k in result) {
					e2_kodee1.append(new Option(result[k],k));
				}
			}
		});
		
	load_data_e2 = function(){
		var e2_tahun_awal = $('#e2-tahun_awal').val();
		var e2_tahun_akhir = $('#e2-tahun_akhir').val();
		
		var e2_indikator = $('#e2-kelompok_indikator').val();
		$("#e2-data").load("<?=base_url()?>laporan/kelompok_indikator_eselon2/getindikator/"+e2_indikator+"/"+e2_tahun_awal+"/"+e2_tahun_akhir+"/"+e2_kodee1.val()+"/"+e2_kodee2.val());
		$("#e2-data").mCustomScrollbar({
						axis:"x",
						theme:"dark-2"
					});
		 
	}
	
	 $("#e2-kode_e1").change(function(){
		
		$.ajax({
			url:"<?php echo site_url(); ?>laporan/kelompok_indikator_eselon2/get_list_eselon2/"+this.value,
			success:function(result) {
				e2_kodee2.empty();
				e2_kodee2.append(new Option("Pilih Unit Kerja Eselon II","0"));
				$("#e2-kode_e2").select2("val", "0");
				result = JSON.parse(result);
				for (k in result) {
					e2_kodee2.append(new Option(result[k],k));
				}
			}
		});
	});

	 $("#profilee2-btn").click(function(){
		load_data_e2();
		$('#e2-box-result').removeClass("hide");
	}); 
});
</script>