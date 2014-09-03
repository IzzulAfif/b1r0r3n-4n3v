			
			<input type="hidden" name="kode_e2_old" value="<?=$data[0]->kode_e2?>"/>
			<input type="hidden" name="tahun_renstra_old" value="<?=$data[0]->tahun_renstra?>"/>
            <div class="form-group">
                <label class="col-sm-4 control-label">Tahun Renstra</label>
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
                <label class="col-sm-4 control-label">Unit Kerja Eselon 1</label>
                <div class="col-sm-8">
                    <select name="es1" class="populate" id="ide1-es1">
                    	<option value="<?=$data[0]->kode_e1?>"><?=$data[0]->nama_e1?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_e2?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Unit Kerja</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="nama" value="<?=$data[0]->nama_e2?>">
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
                    <textarea name="tugas" class="form-control"><?=$data[0]->tugas_e2?></textarea>
                </div>
            </div>
            
<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$('#ide1-tahun').change(function(){
			tahun	= $('#ide1-tahun').val();
			$.ajax({
				url:"<?=site_url()?>unit_kerja/eselon1/get_es1/"+tahun,
				success:function(result) {
					$('#ide1-es1').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#ide1-es1').append(new Option(result[a].nama,result[a].kode));
					}
					$('#ide1-es1').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
	});
</script>