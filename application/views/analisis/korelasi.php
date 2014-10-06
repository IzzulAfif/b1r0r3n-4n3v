	
    <div class="feed-box">
     <form class="form-horizontal" id="form_korelasi_kl">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                
                <div class="row">
                		
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Periode Renstra</b></p>
                        <div class="form-group hide">
                            <label class="col-sm-5 control-label">Kementerian </label>
                            <div class="col-sm-7">
                                <select name="unit_kerja" id="unit_kerja_g3" class="populate" style="width:100%">
                                    <?php foreach($kl as $k): ?>
                                        <option value="<?=$k->kode_kl?>"><?=$k->nama_kl?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Periode renstra <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="renstra" id="renstra_g3" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Rentang Tahun <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="tahun1" id="tahun1_g3" class="populate" style="width:100%">
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="tahun2" id="tahun2_g3" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                     </div>
                     
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Sasaran Strategis dan Indikator 1</b></p>
                       <div class="form-group">
                            <label class="col-sm-4 control-label">Sasaran <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="sasaran" id="sasaran_g3" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Indikator <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="indikator" id="indikator_g3" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Satuan</label>
                            <div class="col-sm-8">
                                <label class="control-label" id="satuan_g3"></label>
                            </div>
                        </div>
                     </div>
                     
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Sasaran Strategis dan Indikator 2</b></p>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Sasaran <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="sasaran2" id="sasaran2_g3" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Indikator <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="indikator2" id="indikator2_g3" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Satuan</label>
                            <div class="col-sm-8">
                                <label class="control-label" id="satuan2_g3"></label>
                            </div>
                        </div>
                     </div>
                        	
                </div>
                
                <!--<hr />
                
                <div class="row">
                	
                    <div class="col-sm-2"><label class="col-sm-12 control-label">Perbesaran</label></div>
                    <div class="col-sm-5">
                    	 <div class="form-group">
                            <label class="col-sm-5 control-label">Zoom Sumbu X</label>
                            <div class="col-sm-6">
                                <div id="spinnerg31">
                                    <div class="input-group" style="width:100%;">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-up btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="spinner-input form-control input-sm" value="100">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-down btn-warning btn-sm">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class="col-sm-1 control-label">%</label>
                        </div>
                    </div>
                    <div class="col-sm-5">
                    	<div class="form-group">
                            <label class="col-sm-5 control-label">Zoom Sumbu Y</label>
                            <div class="col-sm-6">
                                <div id="spinnerg32">
                                    <div class="input-group" style="width:100%;">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-up btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="spinner-input form-control input-sm" value="100">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-down btn-warning btn-sm">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <label class="col-sm-1 control-label">%</label>
                        </div>
                    </div>
                    
                </div>-->
                
                <hr />
                
                <div class="row">
                	<div class="col-sm-10">
                    	<!---<p>Rata-rata Realisasi : Axis X : 163 - Axis Y : 140</p>-->
                    </div>
                	<div class="col-sm-2">
                    	<button type="submit" class="btn btn-info" id="proses-c3">
                            <i class="fa fa-arrow-circle-right"></i> Tampilkan Grafik
                        </button>
                    </div>
                </div>
                
             </div>
         </section>
     </form>
   </div>	
   
   <div class="alert alert-info hide" id="box-chart3">
   </div>
    
    <script type="text/javascript">
		
			$(document).ready(function() {
				$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
				$('#spinnerg31').spinner({value:100, min: 100, max: 1000});
				$('#spinnerg32').spinner({value:100, min: 100, max: 1000});
				
					kd_unit	= $('#unit_kerja_g3').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_renstra/"+kd_unit,
						success:function(result) {
							$('#renstra_g3').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#renstra_g3').append(new Option(result[a],result[a]));
							}
							$('#renstra_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				
				$('#renstra_g3').change(function(){
					kd_unit	= $('#unit_kerja_g3').val();
					renstra = $('#renstra_g3').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_tahun/"+kd_unit+'/'+renstra,
						success:function(result) {
							$('#tahun1_g3').empty();
							$('#tahun2_g3').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#tahun1_g3').append(new Option(result[a],result[a]));
								$('#tahun2_g3').append(new Option(result[a],result[a]));
							}
							$('#tahun1_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#tahun2_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#tahun2_g3').change(function(){
					kd_unit	= $('#unit_kerja_g3').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_sasaran/"+kd_unit,
						success:function(result) {
							$('#sasaran_g3').empty();
							$('#sasaran2_g3').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#sasaran_g3').append(new Option(result[a].deskripsi,result[a].kode));
								$('#sasaran2_g3').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#sasaran_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#sasaran2_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#sasaran_g3').change(function(){
					kd_unit	= $('#unit_kerja_g3').val();
					sasaran	= $('#sasaran_g3').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_indikator/"+kd_unit+"/"+sasaran,
						success:function(result) {
							$('#indikator_g3').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#indikator_g3').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#indikator_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#indikator_g3').change(function(){
					kd_unit		= $('#unit_kerja_g3').val();
					indikator	= $('#indikator_g3').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_satuan/"+kd_unit+"/"+indikator,
						success:function(result) {
							$('#satuan_g3').html(result);
						}
					});
				});
				
				$('#sasaran2_g3').change(function(){
					kd_unit	= $('#unit_kerja_g3').val();
					sasaran	= $('#sasaran2_g3').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_indikator/"+kd_unit+"/"+sasaran,
						success:function(result) {
							$('#indikator2_g3').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#indikator2_g3').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#indikator2_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#indikator2_g3').change(function(){
					kd_unit		= $('#unit_kerja_g3').val();
					indikator	= $('#indikator2_g3').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_satuan/"+kd_unit+"/"+indikator,
						success:function(result) {
							$('#satuan2_g3').html(result);
						}
					});
				});
				
				var options = { 
						target : '#box-chart3',
						url : '<?=base_url()?>analisis/korelasi/proses_kl',
						type : 'post',
						beforeSubmit:  showProcess,
						//success:     showResponse
    				}; 
				$('#form_korelasi_kl').submit(function() { 
					$(this).ajaxSubmit(options);
					return false; 
				});
				
			});
			
			function showProcess() { 
				$('#box-chart3').removeClass("hide");
				return true; 
			}
				
		</script>