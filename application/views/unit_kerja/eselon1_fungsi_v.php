            
<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});		
		$('#form-tahun').change(function(){
			tahun	= $('#form-tahun').val();
			$.ajax({
				url:"<?=site_url()?>unit_kerja/eselon1/get_es1/"+tahun,
				success:function(result) {
					$('#form-es1').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#form-es1').append(new Option(result[a].nama,result[a].kode));
					}
					$('#form-es1').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
	});
</script>								
            <input type="hidden" name="tipe" value="fungsi" />
			<input type="hidden" name="kode_fungsi_old" value="<?=$data[0]->kode_fungsi_e1?>"/>
			<input type="hidden" name="tahun_renstra_old" value="<?=$data[0]->tahun_renstra?>"/>
            <div class="form-group">
                <label class="col-sm-4 control-label">Periode Renstra <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                	<select name="tahun" class="populate" id="form-tahun">
                    	<?php $no=0; foreach($renstra as $r): ?>
                        	<?php if($no==0): $val = ""; else: $val=$r; endif; ?>
                            <?php if($data[0]->tahun_renstra==$r): $sel = "selected"; else: $sel=""; endif; ?>
                        	<option value="<?=$val?>" <?=$sel?> ><?=$r?></option>
                        <?php $no++; endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <select name="es1" class="populate" id="form-es1">
                    	<option value="<?=$data[0]->kode_e1?>"><?=$data[0]->nama_e1?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode Fungsi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="form-kode" name="kode" value="<?=$data[0]->kode_fungsi_e1?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Fungsi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <textarea name="fungsi" class="form-control" id="form-fungsi"><?=$data[0]->fungsi_e1?></textarea>
                </div>
            </div>
