
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
   			<input type="hidden" name="tipe" value="program" />
            <input type="hidden" name="id" value="<?=$data[0]->kode_program?>" />
            <input type="hidden" name="tahun_old" value="<?=$data[0]->tahun?>" />
            <div class="form-group">
                <label class="col-sm-4 control-label">Tahun</label>
                <div class="col-sm-8">
                	<input type="text" class="form-control input-sm" name="tahun" value="<?=$data[0]->tahun?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Unit Kerja</label>
                <div class="col-sm-8">
                	<select name="e1" class="populate" id="form-e1">
                    	<?php $no=0; foreach($eselon1 as $e): ?>
                        	<?php $val=$e->kode_e1; ?>
                            <?php if($data[0]->kode_e1==$e->kode_e1): $sel = "selected"; else: $sel=""; endif; ?>
                        	<option value="<?=$val?>" <?=$sel?>><?=$e->nama_e1?></option>
                        <?php $no++; endforeach; ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode Program</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_program?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Program</label>
                <div class="col-sm-8">
                    <textarea name="nama" class="form-control"><?=$data[0]->nama_program?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-4 control-label">Pagu</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="pagu" value="<?=$data[0]->pagu?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-4 control-label">Realisasi</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="realisasi" value="<?=$data[0]->realisasi?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-4 control-label">Persen</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="persen" value="<?=$data[0]->persen?>">
                </div>
            </div>
            
     <?php endif; ?>