	
    <div class="feed-box">
     <form class="form-horizontal" id="form_korelasi_kl">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                
                <div class="row">
                		
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Periode Renstra dan Tahun</b></p>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Unit Kerja <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="unit_kerja" id="unit_kerja_g3" class="populate" style="width:100%">
                                    <option value="">Pilih Unit Kerja</option>
                                    <?php foreach($esselon1 as $es1): ?>
                                        <option value="<?=$es1->kode_e1?>"><?=$es1->nama_e1?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Periode Renstra <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="renstra" id="renstra_g3" class="populate" style="width:100%">
                                	<option value="0">Pilih Periode Renstra</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Rentang Tahun <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="tahun1" id="tahun1_g3" class="populate" style="width:100%">
                                	<option value="0">Pilih Tahun</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="tahun2" id="tahun2_g3" class="populate" style="width:100%">
                                	<option value="0">Pilih Tahun</option>
                                </select>
                            </div>
                        </div>
                     </div>
                     
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Sasaran dan Indikator I (Independent)</b></p>
                       <div class="form-group">
                            <label class="col-sm-4 control-label">Sasaran <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="sasaran" id="sasaran_g3" class="populate" style="width:100%">
                                	<option value="0">Pilih Sasaran</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Indikator <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="indikator" id="indikator_g3" class="populate" style="width:100%">
                                	<option value="0">Pilih Indikator</option>
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
                     	<p class="text-primary"><b>Sasaran dan Indikator II (Dependent)</b></p>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Sasaran <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="sasaran2" id="sasaran2_g3" class="populate" style="width:100%">
                                	<option value="0">Pilih Sasaran</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Indikator <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="indikator2" id="indikator2_g3" class="populate" style="width:100%">
                                	<option value="0">Pilih Indikator</option>
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
				
				$('#unit_kerja_g3').change(function(){
					kd_unit	= $('#unit_kerja_g3').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_renstra/"+kd_unit,
						success:function(result) {
							$('#renstra_g3').empty();
							
							$('#tahun1_g3').empty();
								$('#tahun1_g3').append(new Option("Pilih Tahun","0"));
								$('#tahun1_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#tahun2_g3').empty();
								$('#tahun2_g3').append(new Option("Pilih Tahun","0"));
								$('#tahun2_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#sasaran_g3').empty();
								$('#sasaran_g3').append(new Option("Pilih Sasaran","0"));
								$('#sasaran_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#sasaran2_g3').empty();
								$('#sasaran2_g3').append(new Option("Pilih Sasaran","0"));
								$('#sasaran2_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#indikator_g3').empty();
								$('#indikator_g3').append(new Option("Pilih Indikator","0"));
								$('#indikator_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#indikator2_g3').empty();
								$('#indikator2_g3').append(new Option("Pilih Indikator","0"));
								$('#indikator2_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
							
							result = JSON.parse(result);
							for (a in result) {
								$('#renstra_g3').append(new Option(result[a],result[a]));
							}
							$('#renstra_g3').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
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
						url : '<?=base_url()?>analisis/korelasi/proses_e1',
						type : 'post',
						beforeSubmit:  showProcess,
						//success:     showResponse
    				}; 
				$('#form_korelasi_kl').submit(function() { 
					if($('#renstra_g3').val()=="Pilih Periode Renstra"){
						alert("Periode Renstra belum ditentukan");
						$('#renstra_g3').select2('open');
						return false;
					}
					else if($('#tahun1_g3').val()==0 || $('#tahun1_g3').val() == "Pilih Tahun"){
						alert("Rentang tahun belum ditentukan");
						$('#tahun1_g3').select2('open');
						return false;
					}
					else if($('#tahun2_g3').val() == 0 || $('#tahun2_g3').val() == "Pilih Tahun"){
						alert("Rentang tahun belum ditentukan");
						$('#tahun2_g3').select2('open');
						return false;
					}
					else if($('#sasaran_g3').val()==0 || $('#sasaran_g3').val() == ""){
						alert("Sasaran belum ditentukan");
						$('#sasaran_g3').select2('open');
						return false;
					}
					else if($('#indikator_g3').val()==0 || $('#indikator_g3').val() == ""){
						alert("Indikator belum ditentukan");
						$('#indikator_g3').select2('open');
						return false;
					}
					else if($('#sasaran2_g3').val()==0 || $('#sasaran2_g3').val() == ""){
						alert("Sasaran belum ditentukan");
						$('#sasaran2_g3').select2('open');
						return false;
					}
					else if($('#indikator2_g3').val()==0 || $('#indikator2_g3').val() == ""){
						alert("Indikator belum ditentukan");
						$('#indikator2_g3').select2('open');
						return false;
					}
					else{
						$(this).ajaxSubmit(options);
						return false; 
					}
				});
				
			});
			
			function showProcess() { 
				$('#box-chart3').removeClass("hide");
				return true; 
			}
				
		</script>