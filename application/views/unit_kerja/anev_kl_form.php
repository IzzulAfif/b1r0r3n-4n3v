	
    <?php if (isset($data)) : ?>
    		<input type="hidden" name="tipe" value="id" />
            <input type="hidden" name="id" value="<?=$data[0]->kode_kl?>" />
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
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode Kementrian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_kl?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Kementerian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="nama" value="<?=$data[0]->nama_kl?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Singkatan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="singkatan" value="<?=$data[0]->singkatan?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Tugas</label>
                <div class="col-sm-8">
                    <textarea name="tugas" class="form-control"><?=$data[0]->tugas_kl?></textarea>
                </div>
            </div>
            
     <?php endif; ?>