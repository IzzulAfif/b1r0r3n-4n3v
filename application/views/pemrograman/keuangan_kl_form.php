	<style type="text/css">
		select {width:100%;}
	</style>

	<script>
        $(document).ready(function(){
            $('select').select2({minimumResultsForSearch: -1, width:'resolve'});	
		});
    </script>
    
        <?php if($form_tipe=="add"):?>
            <div class="form-group">
                <label class="col-sm-4 control-label">Periode Renstra</label>
                <div class="col-sm-8">
                    <?=form_dropdown('renstra',$renstra,'0','id="renstra" class="populate" style="width:100%"')?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-4 control-label">Program</label>
                <div class="col-sm-8">
                    <select name="program" class="populate" id="kd_prog">
                        <option value="">Pilih Program Kerja</option>
                        <?php foreach($program as $p):?>
                            <option value="<?=$p->kode_program?>"><?=$p->nama_program?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        <?php else: ?>
        	<input type="hidden" name="renstra" value="<?=$data[0]->tahun_renstra?>" />
            <input type="hidden" name="program" value="<?=$data[0]->kode_program?>" />
        	<div class="form-group">
                <label class="col-sm-4 control-label">Nama Program</label>
                <div class="col-sm-8">
                	<textarea name="deskripsi" readonly="readonly" rows="3" class="form-control input-sm"><?=$data[0]->nama_program?></textarea>
                </div>
            </div>
		<?php endif; ?>
        
        <div class="form-group">
        	<?php if(isset($data[0]->target_thn1)): $n1 = $data[0]->target_thn1; else: $n1 = 0; endif;?>
            <label class="col-sm-4 control-label">Target Tahun 1</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target1" value="<?=$n1?>">
            </div>
        </div>
        
        <div class="form-group">
        	<?php if(isset($data[0]->target_thn2)): $n2 = $data[0]->target_thn2; else: $n2 = 0; endif;?>
            <label class="col-sm-4 control-label">Target Tahun 2</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target2" value="<?=$n2?>">
            </div>
        </div>
        
        <div class="form-group">
        	<?php if(isset($data[0]->target_thn3)): $n3 = $data[0]->target_thn3; else: $n3 = 0; endif;?>
            <label class="col-sm-4 control-label">Target Tahun 3</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target3" value="<?=$n3?>">
            </div>
        </div>
        <div class="form-group">
        	<?php if(isset($data[0]->target_thn4)): $n4 = $data[0]->target_thn4; else: $n4 = 0; endif;?>
            <label class="col-sm-4 control-label">Target Tahun 4</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target4" value="<?=$n4?>">
            </div>
        </div>
        
        <div class="form-group">
        	<?php if(isset($data[0]->target_thn5)): $n5 = $data[0]->target_thn5; else: $n5 = 0; endif;?>
            <label class="col-sm-4 control-label">Target Tahun 5</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target5" value="<?=$n5?>">
            </div>
        </div>