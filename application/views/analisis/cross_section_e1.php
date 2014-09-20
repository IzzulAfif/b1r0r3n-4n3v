	
    <div class="feed-box">
     <form class="form-horizontal" id="form_crosssection_e1">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                
                <div class="row">
                	
                    <div class="col-sm-5">
                    	<p class="text-primary"><b>Periode Renstra</b></p>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Unit Kerja </label>
                            <div class="col-sm-7">
                                <select name="unit_kerja" id="unit_kerja_g2" class="populate" style="width:100%">
                                    <option value="">Pilih Unit Kerja</option>
                                    <?php foreach($esselon1 as $es1): ?>
                                        <option value="<?=$es1->kode_e1?>"><?=$es1->nama_e1?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Periode renstra </label>
                            <div class="col-sm-7">
                                <select name="renstra" id="renstra_g2" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Rentang Tahun</label>
                            <div class="col-sm-3">
                                <select name="tahun1" id="tahun1_g2" class="populate" style="width:100%">
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="tahun2" id="tahun2_g2" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                    	<p class="text-primary"><b>Sasaran Program dan Indikator</b></p>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sasaran</label>
                            <div class="col-sm-9">
                                <select name="sasaran" id="sasaran_g2" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Indikator</label>
                            <div class="col-sm-9">
                                <select name="indikator" id="indikator_g2" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-9">
                                <label class="control-label" id="satuan_g2"></label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <hr />
                <div class="row">
                
                    <div class="col-sm-12">
                    	<div class="pull-right">
                    	<button type="submit" class="btn btn-info" id="proses-c2">
                            <i class="fa fa-arrow-circle-right"></i> Tampilkan Grafik
                        </button>
                        </div>
                    </div>
                
                </div>
                
            </div>
         </section>
      </form>
   </div>	
   	
    <div class="alert alert-info hide" id="box-chart2">
    </div>
    
    <script type="text/javascript">
		
			$(document).ready(function() {
				$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
				$('#unit_kerja_g2').change(function(){
					kd_unit	= $('#unit_kerja_g2').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_renstra/"+kd_unit,
						success:function(result) {
							$('#renstra_g2').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#renstra_g2').append(new Option(result[a],result[a]));
							}
							$('#renstra_g2').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#renstra_g2').change(function(){
					kd_unit	= $('#unit_kerja_g2').val();
					renstra = $('#renstra_g2').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_tahun/"+kd_unit+'/'+renstra,
						success:function(result) {
							$('#tahun1_g2').empty();
							$('#tahun2_g2').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#tahun1_g2').append(new Option(result[a],result[a]));
								$('#tahun2_g2').append(new Option(result[a],result[a]));
							}
							$('#tahun1_g2').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#tahun2_g2').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#tahun2_g2').change(function(){
					kd_unit	= $('#unit_kerja_g2').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_sasaran/"+kd_unit,
						success:function(result) {
							$('#sasaran_g2').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#sasaran_g2').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#sasaran_g2').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#sasaran_g2').change(function(){
					kd_unit	= $('#unit_kerja_g2').val();
					sasaran	= $('#sasaran_g2').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_indikator/"+kd_unit+"/"+sasaran,
						success:function(result) {
							$('#indikator_g2').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#indikator_g2').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#indikator_g2').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#indikator_g2').change(function(){
					kd_unit		= $('#unit_kerja_g2').val();
					indikator	= $('#indikator_g2').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_satuan/"+kd_unit+"/"+indikator,
						success:function(result) {
							$('#satuan_g2').html(result);
						}
					});
				});
				
				var options = { 
						target : '#box-chart2',
						url : '<?=base_url()?>analisis/cross_section/proses_e1',
						type : 'post',
						beforeSubmit:  showProcess,
						//success:     showResponse
    				}; 
				$('#form_crosssection_e1').submit(function() { 
					$(this).ajaxSubmit(options);
					return false; 
				});
					
			});
			
			function showProcess() { 
				$('#box-chart2').removeClass("hide");
				return true; 
			}
				
		</script>