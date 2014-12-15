
     <script>
		 $(document).ready(function(){
			$('select').select2({minimumResultsForSearch: -1,width:'resolve'});
			$('#form-tahun').change(function(){
				tahun	= $('#form-tahun').val();
				$.ajax({
					url:"<?=site_url()?>unit_kerja/anev_kl/get_kementerian/"+tahun,
					success:function(result) {
						$('#form-kl').empty();
						result = JSON.parse(result);
						for (a in result) {
							$('#form-kl').append(new Option(result[a].nama,result[a].kode));
						}
						$('#form-kl').select2({minimumResultsForSearch: -1, width:'resolve'});
					}
				});
			});
		 });
	 </script>
     
    <?php if (isset($data)) : ?>
   			<input type="hidden" name="tipe" value="visi" />
            <input type="hidden" name="id" value="<?=$data[0]->kode_visi_kl?>" />
            <input type="hidden" name="tahun_old" value="<?=$data[0]->tahun_renstra?>" />
            <div class="form-group">
                <label class="col-sm-4 control-label">Periode Renstra <span class="text-danger">*</span></label>
                <div class="col-sm-7">
                	<select name="tahun" class="populate" id="form-tahun">
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
                	<select name="kl" class="populate" id="form-kl">
                    	<?php if($data[0]->kode_kl!=""): ?>
                    	<option value="<?=$data[0]->kode_kl?>"><?=$data[0]->nama_kl?></option>
                    	<?php endif; ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode Visi <span class="text-danger">*</span></label>
                <div class="col-sm-7">
                    <input type="text" id="form-kode-visi" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_visi_kl?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Visi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <textarea name="visi" class="form-control" id="form-visi"><?=$data[0]->visi_kl?></textarea>
                </div>
            </div>
            
     <?php endif; ?>