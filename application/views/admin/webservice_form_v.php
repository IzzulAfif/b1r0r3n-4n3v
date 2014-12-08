	
    <?php if (isset($data)) : ?>

            <input type="hidden" name="id" value="<?=$data[0]->id?>" />
            
            <div class="form-group">
                <label class="col-sm-4 control-label">Tipe Aplikasi</label>
                <label class="col-sm-7 control-label" style="text-align: left"><?=$data[0]->tipe_aplikasi?></label>
                
            </div> 
			 <div class="form-group">
                <label class="col-sm-4 control-label">Jenis Data</label>
                <label class="col-sm-7 control-label" style="text-align: left"><?=$data[0]->jenis_data?></label>
                
            </div> 
			<div class="form-group">
                <label class="col-sm-4 control-label">URL</label>
                <div class="col-sm-7">
                   <textarea class="form-control input-sm" name="url"><?=$data[0]->url?></textarea>
                </div>
            </div>
            
            
     <?php endif; ?>