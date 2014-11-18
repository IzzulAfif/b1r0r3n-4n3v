	<style type="text/css">
		select {width:100%;}
	</style>

	<script>
        $(document).ready(function(){
            $('select').select2({minimumResultsForSearch: -1, width:'resolve'});	
		});
    </script>
    	
        <div class="form-group">
            <label class="col-sm-4 control-label">Tahun Renstra</label>
            <div class="col-sm-2">
                <input type="text" class="form-control input-sm" name="renstra1" value="">
            </div>
            <div class="col-sm-1" align="center">s.d.</div>
            <div class="col-sm-2">
                <input type="text" class="form-control input-sm" name="renstra2" value="">
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
    