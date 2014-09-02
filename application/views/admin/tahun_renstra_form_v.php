	
    <?php if (isset($data)) : ?>

            <input type="hidden" name="tahun_old" value="<?=$data[0]->tahun_renstra?>" />
            <?php
				if($data[0]->tahun_renstra!=""):
					$thn	= explode("-",$data[0]->tahun_renstra);
				else:
					$thn[0] = "";
					$thn[1]	= "";
				endif;
			?>
            <div class="form-group">
                <label class="col-sm-4 control-label">Tahun Renstra</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control input-sm" name="renstra1" value="<?=$thn[0]?>">
                </div>
                <div class="col-sm-1" align="center">s.d.</div>
                <div class="col-sm-2">
                    <input type="text" class="form-control input-sm" name="renstra2" value="<?=$thn[1]?>">
                </div>
            </div>
            
            
     <?php endif; ?>