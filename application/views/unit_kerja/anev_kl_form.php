	
    <?php if (isset($data)) : ?>
    
            <input type="hidden" name="id" value="<?=$data[0]->kode_kl?>" />
            <div class="form-group">
                <label class="col-sm-4 control-label">Tahun Renstra</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="kode" value="<?=$data[0]->tahun_renstra?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode</label>
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
                <label class="col-sm-4 control-label">Tugas Pokok</label>
                <div class="col-sm-8">
                    <textarea name="tugas" class="form-control"><?=$data[0]->tugas_kl?></textarea>
                </div>
            </div>
            
     <?php endif; ?>