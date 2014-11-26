	<style type="text/css">
		select {width:100%;}
	</style>

	<script>
        $(document).ready(function(){
            $('select').select2({minimumResultsForSearch: -1, width:'resolve'});	
		});
    </script>
    
    	<?php if($form_tipe=="add"): ?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Periode Renstra</label>
            <div class="col-sm-8">
            	<?=form_dropdown('renstra',$renstra,'0','id="renstra" class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4 control-label">Sasaran Strategis</label>
            <div class="col-md-8">
                <?=form_dropdown('sasaran',$ss,0,'id="target-sasaran-form" class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4 control-label">IKU</label>
            <div class="col-md-8">
                <?=form_dropdown('iku',array('0'=>"Pilih IKU"),'0','id="iku-kl-form" class="populate" style="width:100%"')?>
            </div>
        </div>
        <?php else: ?>
        	<input type="hidden" name="sasaran" value="<?=$data[0]->kode_ss_kl?>" />
            <input type="hidden" name="iku" value="<?=$data[0]->kode_iku_kl?>" />
        <?php endif; ?>
                    
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 1</label>
            <div class="col-sm-8">
            	<?php if(isset($data[0]->target_thn1)): $n1 = $data[0]->target_thn1; else: $n1 = 0; endif;?>
                <input type="text" class="form-control input-sm" name="target1" value="<?=$n1?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 2</label>
            <div class="col-sm-8">
            	<?php if(isset($data[0]->target_thn2)): $n2 = $data[0]->target_thn2; else: $n2 = 0; endif;?>
                <input type="text" class="form-control input-sm" name="target2" value="<?=$n2?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 3</label>
            <div class="col-sm-8">
            	<?php if(isset($data[0]->target_thn3)): $n3 = $data[0]->target_thn3; else: $n3 = 0; endif;?>
                <input type="text" class="form-control input-sm" name="target3" value="<?=$n3?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 4</label>
            <div class="col-sm-8">
            	<?php if(isset($data[0]->target_thn4)): $n4 = $data[0]->target_thn4; else: $n4 = 0; endif;?>
                <input type="text" class="form-control input-sm" name="target4" value="<?=$n4?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 5</label>
            <div class="col-sm-8">
            	<?php if(isset($data[0]->target_thn5)): $n5 = $data[0]->target_thn5; else: $n5 = 0; endif;?>
                <input type="text" class="form-control input-sm" name="target5" value="<?=$n5?>">
            </div>
        </div>
    
    <script>
		$('#target-sasaran-form').change(function(){
			var kode_ss		 = $('#target-sasaran-form').val();
			$.ajax({
				url:"<?php echo site_url(); ?>pemrograman/pemrograman_kl/get_iku_kl/"+kode_ss,
				success:function(result) {
					$('#iku-kl-form').empty();
					result = JSON.parse(result);
					for (k in result) {
						$('#iku-kl-form').append(new Option(result[k],k));
					}
					$('#iku-kl-form').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
        });
	</script>