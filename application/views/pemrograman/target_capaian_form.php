	<style type="text/css">
		select {width:100%;}
	</style>

	<script>
        $(document).ready(function(){
            $('select').select2({minimumResultsForSearch: -1, width:'resolve'});	
		});
    </script>
    	
        <div class="form-group">
            <label class="col-sm-4 control-label">Periode Renstra</label>
            <div class="col-sm-8">
            	<?=form_dropdown('renstra',$renstra,'0','id="renstra" class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Unit Kerja</label>
            <div class="col-sm-8">
            	<?=form_dropdown('kode_e1',$eselon1,'0','id="target-kode_e1_form"  class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4 control-label">Sasaran Strategis</label>
            <div class="col-md-8">
                <?=form_dropdown('sasaran',array('0'=>"Pilih Sasaran Strategis"),'','id="target-sasaran-form" class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4 control-label">IKU</label>
            <div class="col-md-8">
                <?=form_dropdown('iku',array('0'=>"Pilih IKU"),'','id="iku-e1-form" class="populate" style="width:100%"')?>
            </div>
        </div>
                    
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 1</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target1" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 2</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target2" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 3</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target3" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 4</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target4" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 5</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target5" value="0">
            </div>
        </div>
    
    <script>
		$('#target-kode_e1_form').change(function(){
            if (renstra.val()!="") {
				var arrayrenstra = $('#renstra').val().split('-');
				var kode_e1		 = $('#target-kode_e1_form').val();
                $.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_sasprog/"+arrayrenstra[0]+"/"+arrayrenstra[1]+"/"+kode_e1,
                    success:function(result) {
                        $('#target-sasaran-form').empty();
                        result = JSON.parse(result);
                        for (k in result) {
                            $('#target-sasaran-form').append(new Option(result[k],k));
                        }
                        $('#target-sasaran-form').select2({minimumResultsForSearch: -1, width:'resolve'});
                    }
                });
            }
        });
		$('#target-sasaran-form').change(function(){
			var kode_sp		 = $('#target-sasaran-form').val();
			$.ajax({
				url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon1/get_iku_e1/"+kode_sp,
				success:function(result) {
					$('#iku-e1-form').empty();
					result = JSON.parse(result);
					for (k in result) {
						$('#iku-e1-form').append(new Option(result[k],k));
					}
					$('#iku-e1-form').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
        });
	</script>