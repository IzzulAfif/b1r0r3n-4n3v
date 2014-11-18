	<style type="text/css">
		select {width:100%;}
	</style>

	<script>
        $(document).ready(function(){
            $('select').select2({minimumResultsForSearch: -1, width:'resolve'});	
		});
    </script>
    	
        <div class="form-group">
            <label class="col-sm-4 control-label">Periode Renstra</label>
            <div class="col-sm-8">
            	<?=form_dropdown('renstra',$renstra,'0','id="renstra" class="populate" style="width:100%"')?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Program</label>
            <div class="col-sm-8">
            	<select name="program" class="populate" id="kd_prog">
                	<option value="">Pilih Program Kerja</option>
                    <?php foreach($program as $p):?>
                    	<option value="<?=$p->kode_program?>"><?=$p->nama_program?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 1</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target1" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 2</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target2" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 3</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target3" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 4</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target4" value="0">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Target Tahun 5</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="target5" value="0">
            </div>
        </div>
    