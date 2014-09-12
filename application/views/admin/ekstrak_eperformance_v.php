<div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Jenis Data</label>
                        <div class="col-md-3">
                         		<?=form_dropdown('tipe_data',$tipe_data,'0','id="eperformance-tipe_data" class="populate" style="width:100%"')?>
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
               
                  <div class="corner-ribon black-ribon">
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
		$("#eperformance-tipe_data").change(function(){
			alert('tes');
			tipe = $(this).val();
			switch (tipe){
				case "1" :
					//$('#emon-periode').removeClass("hide");
					//$('#emon-unit_kerja').removeClass("hide");
					$("#eperformance-detail-content").load("<?=base_url()?>admin/ekstrak_unitkerja/loadpage/"+tipe);
					$('#eperformance-detail-content').removeClass("hide");
				break;
			}
		});
	});
</script>		