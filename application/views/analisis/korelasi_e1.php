	
    <div class="feed-box">
     <form class="form-horizontal">
        <section class="panel tab-bg-form">
            <div class="panel-body">
               
                <div class="corner-ribon blue-ribon">
                   <i class="fa fa-cog"></i>
                </div>
                
                <div class="row">
                		
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Periode Renstra</b></p>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Unit Kerja</label>
                            <div class="col-sm-7">
                                <select name="unit_kerja" id="unit_kerja" class="populate" style="width:100%">
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
                                <select name="tahun" id="tahun" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Rentang Tahun</label>
                            <div class="col-sm-3">
                                <select name="tahun" id="tahun" class="populate" style="width:100%">
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="tahun" id="tahun" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                     </div>
                     
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Sasaran Program dan Indikator 1</b></p>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sasaran</label>
                            <div class="col-sm-9">
                                <select name="sasaran" id="sasaran" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Indikator</label>
                            <div class="col-sm-9">
                                <select name="indikator" id="indikator" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-9">
                                <label class="control-label" id="satuan"></label>
                            </div>
                        </div>
                     </div>
                     
                     <div class="col-sm-4">
                     	<p class="text-primary"><b>Sasaran Program dan Indikator 2</b></p>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sasaran</label>
                            <div class="col-sm-9">
                                <select name="sasaran2" id="sasaran2" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Indikator</label>
                            <div class="col-sm-9">
                                <select name="indikator2" id="indikator2" class="populate" style="width:100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-9">
                                <label class="control-label" id="satuan2"></label>
                            </div>
                        </div>
                     </div>
                        	
                </div>
                
                <hr />
                
                <div class="row">
                	
                    <div class="col-sm-4"><label class="col-sm-12 control-label">Perbesaran</label></div>
                    <div class="col-sm-4">
                    	 <div class="form-group">
                            <label class="col-sm-5 control-label">Zoom Sumbu X</label>
                            <div class="col-sm-7">
                                <div id="spinner4">
                                    <div class="input-group" style="width:150px;">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-up btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="spinner-input form-control input-sm" value="100%">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-down btn-warning btn-sm">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                            <label class="col-sm-5 control-label">Zoom Sumbu Y</label>
                            <div class="col-sm-7">
                                <div id="spinner4">
                                    <div class="input-group" style="width:150px;">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-up btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="spinner-input form-control input-sm" value="100%">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-down btn-warning btn-sm">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <hr />
                
                <div class="row">
                	<div class="col-sm-10">
                    	<p>Rata-rata Realisasi : Axis X : 163 - Axis Y : 140</p>
                    </div>
                	<div class="col-sm-2">
                    	<button type="button" class="btn btn-info" id="proses-c3">
                            <i class="fa fa-play"></i> Tampilkan Grafik
                        </button>
                    </div>
                </div>
                
             </div>
         </section>
     </form>
   </div>	
   
   <div class="alert alert-info hide" id="box-chart3">
        <div id="chartKontenKorelasi" style="height:400px;">
        </div>
   </div>
    
    <script type="text/javascript">
		
			var dataTooltip = "Target Indikator 1 : 161.2 <br>Realisasi Indikator 1 : 140 <br> Target Indikator 2 : 161.2 <br>Realisasi Indikator 2 : 140";
			
			$(document).ready(function() {
				$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
				$('#unit_kerja').change(function(){
					kd_unit	= $('#unit_kerja').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_tahun/"+kd_unit,
						success:function(result) {
							$('#tahun').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#tahun').append(new Option(result[a],result[a]));
							}
							$('#tahun').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#tahun').change(function(){
					kd_unit	= $('#unit_kerja').val();
					tahun	= $('#tahun').val();
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_sasaran/"+kd_unit+"/"+tahun,
						success:function(result) {
							$('#sasaran').empty();
							$('#sasaran2').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#sasaran').append(new Option(result[a].deskripsi,result[a].kode));
								$('#sasaran2').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#sasaran').select2({minimumResultsForSearch: -1, width:'resolve'});
							$('#sasaran2').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#sasaran').change(function(){
					kd_unit	= $('#unit_kerja').val();
					tahun	= $('#tahun').val();
					sasaran	= $('#sasaran').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_indikator/"+kd_unit+"/"+tahun+"/"+sasaran,
						success:function(result) {
							$('#indikator').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#indikator').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#indikator').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#indikator').change(function(){
					kd_unit		= $('#unit_kerja').val();
					tahun		= $('#tahun').val();
					indikator	= $('#indikator').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_satuan/"+kd_unit+"/"+tahun+"/"+indikator,
						success:function(result) {
							$('#satuan').html(result);
						}
					});
				});
				
				$('#sasaran2').change(function(){
					kd_unit	= $('#unit_kerja').val();
					tahun	= $('#tahun').val();
					sasaran	= $('#sasaran2').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_indikator/"+kd_unit+"/"+tahun+"/"+sasaran,
						success:function(result) {
							$('#indikator2').empty();
							result = JSON.parse(result);
							for (a in result) {
								$('#indikator2').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#indikator2').select2({minimumResultsForSearch: -1, width:'resolve'});
						}
					});
				});
				
				$('#indikator2').change(function(){
					kd_unit		= $('#unit_kerja').val();
					tahun		= $('#tahun').val();
					indikator	= $('#indikator2').val();
					
					$.ajax({
						url:"<?=site_url()?>analisis/trendline/get_satuan/"+kd_unit+"/"+tahun+"/"+indikator,
						success:function(result) {
							$('#satuan2').html(result);
						}
					});
				});
				
				$('#proses-c3').click(function(){
					$('#box-chart3').removeClass("hide");		
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'chartKontenKorelasi',
							type: 'scatter',
							zoomType: 'xy',
							marginTop: 80,
							marginRight: 20
						},
						exporting: {
							buttons: { 
								exportButton: {
									enabled:false
								},
								printButton: {
									enabled:true
								}
						
							}
						},
						title: {
							text: 'Analisis Korelasi Capaian Indikator Sasaran Strategis Dan Program',
							style : { "font-size" : "14px" }
						},
						subtitle: {
							text: 'Tahun 2012',
							style : { "font-size" : "14px" }
						},
						xAxis: {
							title: {
								enabled: true,
								text: 'Nama Indikator 2'
							},
							startOnTick: true,
							endOnTick: true,
							showLastLabel: true,
							plotLines: [{
								value: 163,
								color: '#090',
								width: 2
							}]
						},
						yAxis: {
							title: {
								text: 'Nama Indikator 1'
							},
							gridLineWidth: 0,
							minorGridLineWidth: 0,
							plotLines: [{
								value: 140,
								color: '#090',
								width: 2
							}]
						},
						legend: {
							enabled: false,
						},
						plotOptions: {
							scatter: {
								marker: {
									symbol : "triangle",
									states: {
										hover: {
											enabled: true,
											lineColor: 'rgb(100,100,100)'
										}
									}
								},
								states: {
									hover: {
										marker: {
											enabled: false
										}
									}
								},
								tooltip: {
									headerFormat: '<b>Provinsi : {series.name}</b><br>',
									pointFormat: '{point.myData}'
								}
							}
						},
						series: [
							{name: 'Aceh',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:161.2,y:81.6,myData : dataTooltip}]},
							{name: 'Bali',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:167.5,y:89.0,myData : dataTooltip}]},
							{name: 'Banten',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:172.5,y:85.2,myData : dataTooltip}]},
							{name: 'Bengkulu',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:162.0,y:95.0,myData : dataTooltip}]},
							{name: 'Gorontalo',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:155.0,y:125.9,myData : dataTooltip}]},
							{name: 'Jakarta',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:174.0,y:175.7,myData : dataTooltip}]},
							{name: 'Jambi',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:170.3,y:164.8,myData : dataTooltip}]},
							{name: 'Jawa Barat',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:154.5,y:149.0,myData : dataTooltip}]},
							{name: 'Jawa Tengah',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:159.5,y:147.6,myData : dataTooltip}]},
							{name: 'Jawa Timur',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:164.3,y:159.8,myData : dataTooltip}]},
							{name: 'Kalimantan Barat',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:178.0,y:170.6,myData : dataTooltip}]},
							{name: 'Kalimantan Selatan',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:149.5,y:144.8,myData : dataTooltip}]},
							{name: 'Kalimantan Tengah',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:169.4,y:163.4,myData : dataTooltip}]},
							{name: 'Kalimantan Timur',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:157.5,y:158.8,myData : dataTooltip}]}
						]
					});
				});
				
			});
				
		</script>