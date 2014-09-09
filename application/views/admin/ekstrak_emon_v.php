<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <div class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Ekstrak Data</label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tipe_data',$tipe_data,'0','id="emon-tipe_data" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                  
						
                </div>
            </div>
        </section>
    </div>
<!--main content start-->

 	
    <div id="emon-detail-content" class="hide">
    
        
	</div>

    <!--main content end-->
	
<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		
		$("#emon-tipe_data").change(function(){
			tipe = $('#emon-tipe_data').val();
			switch (tipe){
				case "item" :
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_item_satker/loadpage");
				break;
				
				case "satker" :
					$("#emon-detail-content").load("<?=base_url()?>admin/ekstrak_satker/loadpage");
					$('#emon-detail-content').removeClass("hide");
				break;
			}
			
		});
		
	});
</script>		