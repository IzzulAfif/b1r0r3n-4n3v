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
                         	<?=form_dropdown('tahun',$renstra,'0','id="e1-tahun" class="populate"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-4">
                           <?=form_dropdown('kode_e1',array("0"=>"Semua Unit Kerja Eselon I"),'0','id="e1-kodee1" class="populate"')?>
                        </div>
                    </div>
                   	<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="renstrae1-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box hide" id="box-result-e1">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal grid-form" role="form">                	
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Visi</label>
                    	<div class="col-md-10" id="e1-visi"></div>
                    </div>
                    <div class="form-group">
                    	<label class="col-md-2 text-primary">Misi</label>
                    	<div class="col-md-10" id="e1-misi"></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Tujuan</label>
                    	<div class="col-md-10" id="e1-tujuan"></div>
                    </div>
					<div class="form-group">
                    	<p class="text-primary col-md-12" ><b>Sasaran Strategis dan IKU</b></p>
                        <div class="adv-table" style="padding:10px 5px 10px 5px">
                            <div id="e1-sasaran"  ></div>
                        </div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Target Capaian Kinerja</label>
                    	<div class="col-md-10" ><a href="#" id="e1-klikdisini">Klik Disini</a></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Kegiatan</label>
                    	<div class="col-md-10" id="e1-kegiatan"></div>
                    </div>
					<div class="form-group">
                    	<label class="col-md-2 text-primary">Kebutuhan Pendanaan</label>
                    	<div class="col-md-10" ><a href="#" id="e1-dana_klik">Klik Disini</a></div>
                    </div>
                </form>
                
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
			load_profile_e1 = function(tahun,kodee1){
				
				
				$("#e1-visi").load("<?=base_url()?>laporan/renstra_eselon1/get_visi/"+tahun+"/"+kodee1);
				$("#e1-misi").load("<?=base_url()?>laporan/renstra_eselon1/get_misi/"+tahun+"/"+kodee1);
				$("#e1-tujuan").load("<?=base_url()?>laporan/renstra_eselon1/get_tujuan/"+tahun+"/"+kodee1);
				$("#e1-kegiatan").load("<?=base_url()?>laporan/renstra_eselon1/get_kegiatan/"+tahun+"/"+kodee1);
				$("#e1-sasaran").load("<?=base_url()?>laporan/renstra_eselon1/get_sasaran/"+tahun+"/"+kodee1);
			}
			
			 $("#e1-tahun").change(function(){
				 $.ajax({
					url:"<?php echo site_url(); ?>laporan/renstra_eselon1/get_list_eselon1/"+this.value,
					success:function(result) {
						$('#e1-kodee1').empty();
						//alert('kadieu');
						result = JSON.parse(result);
						for (k in result) {
							$('#e1-kodee1').append(new Option(result[k],k));
						}
						$("#e1-kodee1").select2("val", "0");
					}
				});
			});
			
			$("#renstrae1-btn").click(function(){
			    var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kodee1').val();
				if (tahun=="0") {
					alert("Periode Renstra belum ditentukan");
					$('#e1-tahun').select2('open');
				}
				/*else if (kodee1=="0") {
					alert("Unit Kerja belum ditentukan");
					$('#e1-kodee1').select2('open');
				}*/
				else {
					load_profile_e1(tahun,kodee1);
					$('#box-result-e1').removeClass("hide");
				}
			});
			
			$("#e1-klikdisini").click(function(){
				var tahun = $('#e1-tahun').val();
				var kodee1 = $('#e1-kodee1').val();
				window.open("<?=base_url()?>laporan/renstra_eselon1/get_detail/"+tahun+"/"+kodee1);
			}); 
		});
	</script>