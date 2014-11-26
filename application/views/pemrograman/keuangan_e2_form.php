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
            <label class="col-sm-4 control-label">Unit Kerja Eselon I</label>
            <div class="col-sm-8">
            	<?=form_dropdown('kode_e1',$eselon1,'0','id="target-kode_e2_form"  class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Unit Kerja Eselon II</label>
            <div class="col-sm-8">
            	<?=form_dropdown('kode_e2',array('0'=>"Pilih Unit Kerja"),'0','id="target-kode_e22_form"  class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4 control-label">Sasaran Kegiatan</label>
            <div class="col-md-8">
                <?=form_dropdown('sasaran',array('0'=>"Pilih Sasaran Kegiatan"),'','id="target-sasaran-form" class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4 control-label">IKK</label>
            <div class="col-md-8">
                <?=form_dropdown('ikk',array('0'=>"Pilih IKK"),'','id="ikk-e2-form" class="populate" style="width:100%"')?>
            </div>
        </div>
        <?php else: ?>
        	<input type="hidden" name="renstra" value="<?=$data[0]->tahun_renstra?>" />
            <input type="hidden" name="ikk" value="<?=$data[0]->kode_ikk?>" />
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
		$("#target-kode_e2_form").change(function(){
			$.ajax({
				url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_list_eselon2/"+this.value,
				success:function(result) {
					kode_e2=$("#target-kode_e22_form");
					kode_e2.empty();
					result = JSON.parse(result);
					for (k in result) {
						kode_e2.append(new Option(result[k],k));
					}
				}
			});
		});
		$('#target-kode_e22_form').change(function(){
            if (renstra.val()!="") {
				var arrayrenstra = $('#renstra').val().split('-');
				var kode_e1		 = $('#target-kode_e1_form').val();
                $.ajax({
                    url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_saskeg/"+arrayrenstra[0]+"/"+arrayrenstra[1]+"/"+kode_e1,
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
			var kode_sp		= $('#target-sasaran-form').val();
			var kode_e2		= $("#target-kode_e22_form").val();
			
			$.ajax({
				url:"<?php echo site_url(); ?>pemrograman/pemrograman_eselon2/get_ikk/"+kode_e2,
				success:function(result) {
					$('#ikk-e2-form').empty();
					result = JSON.parse(result);
					for (k in result) {
						$('#ikk-e2-form').append(new Option(result[k],k));
					}
					$('#iku-e2-form').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
        });
	</script>