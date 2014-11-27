<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Jenis Data<span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tipe_data',$tipe_data,'0','id="eperformance-tipe_data" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					 <div class="form-group" id="div-eperform-tahun_renstra">
                        <label class="col-md-2 control-label">Periode Renstra<span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         		<?=form_dropdown('periode',$tahun_renstra,'0','id="eperform-tahun_renstra" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                  <div class="form-group hide" id="div-eperform-tahun">
                        <label class="col-md-2 control-label">Tahun<span class="text-danger">*</span></label>
                        <div class="col-md-2">
							 <?=form_dropdown('tahun',array("0"=>"Pilih Tahun"),'0','id="eperform-tahun"')?>
                        	
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="eperformance-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                </form>
            </div>
        </section>
    </div>
<!--main content start-->

 	
  <div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                  <div class="corner-ribon black-ribon hide">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal" role="form">
                     <div id="eperformance-detail-content" class="hide">
    
        
					</div>    
                 
						
                </form>
            </div>
        </section>
    </div>
    <!--main content end-->
	
<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$('#eperform-tahun_renstra').change(function(){
			var periode_renstra = $("#eperform-tahun_renstra");
			var tahun = $("#eperform-tahun");
			
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
			 $('#eperform-tahun').select2({minimumResultsForSearch: -1, width:'resolve'});
			
		});
		
		$("#eperformance-tipe_data").change(function(){
			
			$('#div-eperform-tahun').addClass("hide");			
			$('#eperformance-detail-content').empty();
			$('#eperformance-detail-content').addClass("hide");
			tipe = $('#eperformance-tipe_data').val();
			//alert(tipe);
			switch (tipe){
				
				case "4" ://program
					
					$('#div-eperform-tahun').removeClass("hide");
					
				break;
				default : 
					$('#eperformance-detail-content').addClass("hide");
				break;
			}
			
		});
		
		$("#eperformance-btn").click(function(){
			//alert('tes');
			periode = $('#eperform-tahun_renstra').val();//addClass("hide");
			tipe    = $('#eperformance-tipe_data').val();//("hide");
			tahun = $('#eperform-tahun').val();
			if (tipe=="0") {
				alert("Jenis Data belum ditentukan");
				$('#eperformance-tipe_data').select2('open');
				return;
			} else if (periode=="0") {
				alert("Periode Renstra belum ditentukan");
				$('#eperform-tahun_renstra').select2('open');
				return;
			}
			 //= $(this).val();
			 $("#eperformance-detail-content").html("");
			switch (tipe){
				case "1" : $("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_kl/loadpage/"+tipe+"/"+periode,function(){
					
					$('#eperformance-detail-content').removeClass("hide");
				});	
				break;
				case "2" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_e1/loadpage/"+tipe+"/"+periode,function(){
					
					$('#eperformance-detail-content').removeClass("hide");
						});	
					
				break;
				case "3" :
					
					
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_e2/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");
					
					});
				break;
				case "4" : ///program
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_program/loadpage/"+tipe+"/"+periode+"/"+tahun,function(){
						$('#eperformance-detail-content').removeClass("hide");
					});
				break;
				case "5" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_kegiatan/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");					
					});
				break;
				case "6" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_iku_kl/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");
					
					});
				break;
				case "7" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_iku_e1/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");
					
					});
				break;
				case "8" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_ikk/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");
					
					});
				break;
				case "9" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_kinerja_kl/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");
					
					});
				break;
				case "10" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_kinerja_e1/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");
					
					});
				break;
				case "11" :
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_kinerja_e2/loadpage/"+tipe+"/"+periode,function(){
						$('#eperformance-detail-content').removeClass("hide");
					
					});
				break;
			}
		});
	});
</script>		