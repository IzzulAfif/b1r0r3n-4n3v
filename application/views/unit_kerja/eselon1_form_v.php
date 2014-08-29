            <div class="form-group">
				<input type="hidden" name="kode_e1_old" value="<?=$data[0]->kode_e1_old?>"/>
				<input type="hidden" name="tahun_renstra_old" value="<?=$data[0]->tahun_renstra_old?>"/>
                <label class="col-sm-4 control-label">Tahun Renstra</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control input-sm" name="tahun_renstra1" value="<?=$data[0]->tahun_renstra1?>"> 
                </div>
				<label class="col-sm-1 control-label">s.d.</label>
				<div class="col-sm-2">
                    <input type="text" class="form-control input-sm" name="tahun_renstra2" value="<?=$data[0]->tahun_renstra2?>">
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-4 control-label">Kementerian</label>
                <div class="col-sm-8">
                    <?=form_dropdown('kode_kl',$kementerian,$data[0]->kode_kl,'id="id-kodekl" class="populate" style="width:100%"')?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Kode</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="kode" value="<?=$data[0]->kode_e1?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Unit Kerja</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="nama" value="<?=$data[0]->nama_e1?>">
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
                    <textarea name="tugas" class="form-control"><?=$data[0]->tugas_e1?></textarea>
                </div>
            </div>
            
<style type="text/css">
	select {width:100%;}
</style>
<script>
	$(document).ready(function(){
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		
	});
</script>		