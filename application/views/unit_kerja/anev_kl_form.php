
	<script>
		$(document).ready(function(){
            $('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		});
	</script>	
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
                <label class="col-sm-4 control-label">Periode Renstra <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                	<select name="tahun" class="populate" id="ide1-tahun">
                    	<?php $no=0; foreach($renstra as $r): ?>
                        	<?php if($no==0): $val = ""; else: $val=$r; endif; ?>
                            <?php if($data[0]->tahun_renstra==$r): $sel = "selected"; else: $sel=""; endif; ?>
                        	<option value="<?=$val?>" <?=$sel?> ><?=$r?></option>
                        <?php $no++; endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode Kementerian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_kl?>" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Kementerian</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="nama" value="<?=$data[0]->nama_kl?>" readonly="readonly">
                </div>
            </div>
            <div class="form-group hide">
                <label class="col-sm-4 control-label">Singkatan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="singkatan" value="<?=$data[0]->singkatan?>" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Tugas <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <textarea name="tugas" class="form-control"><?=$data[0]->tugas_kl?></textarea>
                </div>
            </div>
            
     <?php endif; ?>