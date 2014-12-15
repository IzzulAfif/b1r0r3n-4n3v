
     <script>
		 $(document).ready(function(){
			$('select').select2({minimumResultsForSearch: -1,width:'resolve'});
			$('#form-tahun-misi').change(function(){
				tahun	= $('#form-tahun-misi').val();
				$.ajax({
					url:"<?=site_url()?>unit_kerja/anev_kl/get_kementerian/"+tahun,
					success:function(result) {
						$('#form-kl-misi').empty();
						result = JSON.parse(result);
						for (a in result) {
							$('#form-kl-misi').append(new Option(result[a].nama,result[a].kode));
						}
						$('#form-kl-misi').select2({minimumResultsForSearch: -1, width:'resolve'});
					}
				});
			});
		 });
	 </script>
     
    <?php if (isset($data)) : ?>
   			<input type="hidden" name="tipe" value="misi" />
            <input type="hidden" name="id" value="<?=$data[0]->kode_misi_kl?>" />
            <input type="hidden" name="tahun_old" value="<?=$data[0]->tahun_renstra?>" />
            <div class="form-group">
                <label class="col-sm-4 control-label">Periode Renstra <span class="text-danger">*</span></label>
                <div class="col-sm-7">
                	<select name="tahun" class="populate" id="form-tahun-misi">
                    	<?php $no=0; foreach($renstra as $r): ?>
                        	<?php if($no==0): $val = ""; else: $val=$r; endif; ?>
                            <?php if($data[0]->tahun_renstra==$r): $sel = "selected"; else: $sel=""; endif; ?>
                        	<option value="<?=$val?>" <?=$sel?>><?=$r?></option>
                        <?php $no++; endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Kementerian <span class="text-danger">*</span></label>
                <div class="col-sm-7">
                	<select name="kl" class="populate" id="form-kl-misi">
                    	<?php if($data[0]->kode_kl!=""): ?>
                    	<option value="<?=$data[0]->kode_kl?>"><?=$data[0]->nama_kl?></option>
                    	<?php endif; ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode Misi <span class="text-danger">*</span></label>
                <div class="col-sm-7">
                    <input type="text" id="form-kode-misi" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_misi_kl?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Misi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <textarea name="misi" id="form-misi" class="form-control"><?=$data[0]->misi_kl?></textarea>
                </div>
            </div>
            
     <?php endif; ?>