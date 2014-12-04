	            
	<style type="text/css">
		select {width:100%;}
	</style>

	<script>
        $(document).ready(function(){
            $('select').select2({minimumResultsForSearch: -1, width:'resolve'});		
            $('#ide1-tahun').change(function(){
                tahun	= $('#ide1-tahun').val();
                $.ajax({
                    url:"<?=site_url()?>unit_kerja/anev_kl/get_kementerian/"+tahun,
                    success:function(result) {
                        $('#ide1-kl').empty();
                        result = JSON.parse(result);
                        for (a in result) {
                            $('#ide1-kl').append(new Option(result[a].nama,result[a].kode));
                        }
                        $('#ide1-kl').select2({minimumResultsForSearch: -1, width:'resolve'});
                    }
                });
            });
        });
    </script>
			
			<input type="hidden" name="kode_e1_old" value="<?=$data[0]->kode_e1_old?>"/>
			<input type="hidden" name="tahun_renstra_old" value="<?=$data[0]->tahun_renstra_old?>"/>
            <div class="form-group">
                <label class="col-sm-4 control-label">Periode Renstra <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                	<select name="tahun" class="populate" id="ide1-tahun">
                    	<?php $no=0; foreach($renstra as $r): ?>
                        	<?php if($no==0): $val = ""; else: $val=$r; endif; ?>
                            <?php if($data[0]->tahun_renstra_old==$r): $sel = "selected"; else: $sel=""; endif; ?>
                        	<option value="<?=$val?>" <?=$sel?> ><?=$r?></option>
                        <?php $no++; endforeach; ?>
                    </select>
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-4 control-label">Nama Kementerian <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                	<select name="kl" class="populate" id="ide1-kl">
                    	<?php if($data[0]->kode_kl!=""): ?>
                    	<option value="<?=$data[0]->kode_kl?>"><?=$data[0]->nama_kl?></option>
                    	<?php endif; ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode Unit Kerja</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_e1?>" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Unit Kerja</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="nama" value="<?=$data[0]->nama_e1?>" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Singkatan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="singkatan" value="<?=$data[0]->singkatan?>" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Tugas</label>
                <div class="col-sm-8">
                    <textarea name="tugas" class="form-control"><?=$data[0]->tugas_e1?></textarea>
                </div>
            </div>