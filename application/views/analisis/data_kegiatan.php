	
    <div class="feed-box">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                <form class="form-horizontal" role="form">
                        
                    <div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra</label>
                        <div class="col-md-2">
                        	<select name="renstra" id="list-tahun_renstra" class="populate" style="width:100%">
                                <option value="">Pilih Renstra</option>
                                <option value="">2010 - 2014</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tahun</label>
                        <div class="col-md-2">
                        	<select name="tahun" id="list-tahun" class="populate" style="width:100%">
                                <option value="">Pilih Tahun</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Program</label>
                        <div class="col-md-9">
                        	<select name="program" id="list-program" class="populate" style="width:100%">
                            	<option value="">Pilih Program</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Kegiatan</label>
                        <div class="col-md-9">
                        	<select name="kegiatan" id="list-kegiatan" class="populate" style="width:100%">
                            	<option value="">Pilih Kegiatan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Lokasi</label>
                        <div class="col-md-9">
                        	<?=form_dropdown('kdlokasi',$lokasi,'0','id="list-kdlokasi" class="populate" style="width:100%"')?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="list-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>		
                        
                </form>
            </div>
        </section>
    </div>
    
    <div class="feed-box hide" id="box-result">
        <section class="panel tab-bg-form" style="background-color:#F9F9F9">
            <div class="panel-body">
               
                <div class="corner-ribon black-ribon">
                   <i class="fa fa-file-text"></i>
                </div>
                
                <p class="text-primary">Rincian Paket Pekerjaan</p><br />
                <table  class="display table table-bordered table-striped" id="list-tbl">
                	<thead>
                    	<tr>
                    		<th>No</th>
                            <th>Paket Pekerjaan</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Kabupaten/Kota</th>
                            <th>Status</th>
                        </tr>
                    </thead>
					 <tbody>
					 </tbody>
    	        </table>
                
            </div>
        </section>
    </div>
                    
    <!--main content end-->
    <style type="text/css">
        select {width:100%;}
        tr.detail_toggle{display: none;}
    </style>
    <!--js-->
    <script type="text/javascript">
    $(document).ready(function () {
		$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		$('#list-tahun').change(function(){
			tahun	= $('#list-tahun').val();
			$.ajax({
				url:"<?=site_url()?>analisis/kegiatan/get_program/"+tahun,
				success:function(result) {
					$('#list-program').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#list-program').append(new Option(result[a].nama_program,result[a].kode_program));
					}
					$('#list-program').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
		$('#list-program').change(function(){
			tahun	= $('#list-tahun').val();
			program	= $('#list-program').val();
			$.ajax({
				url:"<?=site_url()?>analisis/kegiatan/get_kegiatan/"+tahun+"/"+program,
				success:function(result) {
					$('#list-kegiatan').empty();
					result = JSON.parse(result);
					for (a in result) {
						$('#list-kegiatan').append(new Option(result[a].nama_kegiatan,result[a].kode_kegiatan));
					}
					$('#list-kegiatan').select2({minimumResultsForSearch: -1, width:'resolve'});
				}
			});
		});
		$('#list-lokasi').change(function(){
			$('#box-result').removeClass("hide");
		});
		
		
		$("#list-btn").click(function(){
			tahun = $('#list-tahun').val();
			program = $('#list-program').val();
			kegiatan = $('#list-kegiatan').val();
			lokasi = $('#list-kdlokasi').val();
			$.ajax({
                    url:"<?php echo site_url(); ?>analisis/kegiatan/get_list_rincian/"+tahun+"/"+program+"/"+kegiatan+"/"+lokasi,
                        success:function(result) {
                            table_body = $('#list-tbl tbody');
                            table_body.empty().html(result);        
                            $('#box-result').removeClass("hide");
                        }
                });  
		});
    });
    </script>
    <!--js-->