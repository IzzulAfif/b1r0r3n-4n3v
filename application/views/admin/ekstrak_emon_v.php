<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <div class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Jenis Data</label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tipe_data',$tipe_data,'0','id="emon-tipe_data" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					 <div class="form-group hide" id="emon-periode">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tahun',$tahun_renstra,'0','id="emon-tahun" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                   <div class="form-group hide" id="emon-unit_kerja">
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
    </div>
<!--main content start-->

 	<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                  <div class="corner-ribon black-ribon">
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
		
		$("#emon-tipe_data").change(function(){
			$('#emon-periode').addClass("hide");
			$('#emon-unit_kerja').addClass("hide");
			tipe = $('#emon-tipe_data').val();
			switch (tipe){
				case "item" :
					$('#emon-periode').removeClass("hide");
					$('#emon-unit_kerja').removeClass("hide");
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_itemsatker/loadpage");
					$('#emon-detail-content').removeClass("hide");
				break;
				case "lokasi" :
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_lokasi/loadpage");
					$('#emon-detail-content').removeClass("hide");
				break;
				case "kota" :
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_kabkota/loadpage");
					$('#emon-detail-content').removeClass("hide");
				break;
				case "satker" :
					$('#emon-periode').removeClass("hide");
					$('#emon-unit_kerja').removeClass("hide");
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_satker/loadpage");
					$('#emon-detail-content').removeClass("hide");
				break;
			}
			
		});
		
	});
</script>		