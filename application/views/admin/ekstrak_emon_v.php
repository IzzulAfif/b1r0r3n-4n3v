<div class="feed-box">
	<form>
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <div class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Jenis Data<span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tipe_data',$tipe_data,'0','id="emon-tipe_data" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					 <div class="form-group hide" id="div-emon-periode">
                        <label class="col-md-2 control-label">Periode Renstra<span class="text-danger">*</span></label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tahun_renstra',$tahun_renstra,'0','id="emon-tahun_renstra" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group hide" id="div-emon-tahun">
                        <label class="col-md-2 control-label">Tahun<span class="text-danger">*</span></label>
                        <div class="col-md-2">
							 <?=form_dropdown('tahun',array("0"=>"Pilih Tahun"),'0','id="emon-tahun"')?>
                        	
                        </div>
                    </div>
                   <div class="form-group hide" id="div-emon-unit_kerja">
                        <label class="col-md-2 control-label">Unit Kerja Eselon I</label>
                        <div class="col-md-6">
                       <?=form_dropdown('kode_e1',$eselon1,'0','id="emon-kode_e1" class="populate" style="width:100%"')?>
                        </div>
                    </div> 
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="emon-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>	
						
                </div>
            </div>
        </section>
		</form>
    </div>
<!--main content start-->

 	<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                  <div class="corner-ribon black-ribon hide">
                   <i class="fa fa-file-text"></i>
                </div>
                <form class="form-horizontal" role="form">
                     <div id="emon-detail-content" class="hide">
    
        
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
		$('#emon-tahun_renstra').change(function(){
			var periode_renstra = $("#emon-tahun_renstra");
			var tahun = $("#emon-tahun");
			
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
			 $('#emon-tahun').select2({minimumResultsForSearch: -1, width:'resolve'});
			
		});
		
		$("#emon-tipe_data").change(function(){
			$('#div-emon-periode').addClass("hide");
			$('#div-emon-tahun').addClass("hide");
			$('#div-emon-unit_kerja').addClass("hide");
			$('#emon-detail-content').empty();
			$('#emon-detail-content').addClass("hide");
			tipe = $('#emon-tipe_data').val();
			//alert(tipe);
			switch (tipe){
				case "23" : //item_satker
					$('#div-emon-periode').removeClass("hide");
					$('#div-emon-unit_kerja').removeClass("hide");					
				break;
				case "20" ://lokasi
					
				break;
				case "21" ://kabkkota
					
				break;
				case "22" ://satker
					$('#div-emon-periode').removeClass("hide");
					$('#div-emon-unit_kerja').removeClass("hide");					
				break;
				case "24" ://program
					$('#div-emon-periode').removeClass("hide");
					$('#div-emon-tahun').removeClass("hide");
					//$('#emon-unit_kerja').removeClass("hide");					
				break;
				default : 
					$('#emon-detail-content').addClass("hide");
				break;
			}
			
		});
		
		
		$("#emon-btn").click(function(){
			tipe = $('#emon-tipe_data').val();
			//alert(tipe);
			 var tahun_renstra = $('#emon-tahun_renstra').val();
			 var tahun = $('#emon-tahun').val();
			 var kode = $('#emon-kode_e1').val();
			
			switch (tipe){
				case "23" ://item_satker
					 $("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_itemsatker/loadpage/"+tipe+"/"+tahun+"/"+kode);
					 $('#emon-detail-content').removeClass("hide");
				break;
				case "20" ://lokasi
					 $("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_lokasi/loadpage/"+tipe);
					 $('#emon-detail-content').removeClass("hide");
				break;
				case "21" ://kabkota
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_kabkota/loadpage/"+tipe);
					$('#emon-detail-content').removeClass("hide");
				break;
				case "22" :	//satker				
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_satker/loadpage/"+tipe+"/"+tahun+"/"+kode);
					$('#emon-detail-content').removeClass("hide");
				break;
				case "24" :	//program
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_program/loadpage/"+tipe+"/"+tahun_renstra+"/"+tahun);
					$('#emon-detail-content').removeClass("hide");
				break;
				default : 
					//$('#emon-detail-content').addClass("hide");
				break;
			}
			
		});
		
	});
</script>		