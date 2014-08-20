
    <section id="main-content" class="">
        <section class="wrapper">
        
        	<div class="row">
                <div class="col-lg-12">
                        
                        <section class="panel">
                            <header class="panel-heading">
                                <b>Analisis cross section capaian indikator sasaran strategis dan program</b>
                            </header>
                            <div class="panel-body">
                                
                                <div class="row">
                                	<div class="col-sm-2">
                                    	Unit Kerja
                                    </div>
                                    <div class="col-sm-10">
                                    	<select name="unit_kerja" id="unit_kerja" class="populate" style="width:100%">
                                        	<option value="">Pilih Unit Kerja</option>
                                        	<?php foreach($kl as $k): ?>
                                            	<option value="<?=$k->kode_kl?>"><?=$k->nama_kl?></option>
                                            <?php endforeach; ?>
                                            <?php foreach($esselon1 as $es1): ?>
                                            	<option value="<?=$es1->kode_e1?>"><?=$es1->nama_e1?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                
                                <div class="row">
                                
                                	<div class="col-sm-4">
                                    	
                                        <div class="well wellform">
                                        	<form class="form-horizontal">
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Tahun</label>
                                                <div class="col-sm-9">
                                                    <select name="tahun" id="tahun" class="populate" style="width:100%">
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <p class="text-primary"><b>Sasaran dan Indikator</b></p>
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
                                            
                                            <p class="text-primary"><b>Rata-rata Realisasi</b></p>
                                            <p>Rata-rata : 400</p>
                                            <p>BPM : 0</p>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked="checked"> Tampilkan Rata-rata
                                                </label>
                                            </div>
											<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked="checked"> Tampilkan BPM
                                                </label>
                                            </div> 
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked="checked"> Tampilkan terurut
                                                </label>
                                            </div> 
                                            <br />
                                            <div class="row">
                                            	<button type="button" class="btn btn-warning btn-block">
                                                	<i class="fa fa-play"></i> Tampilkan Grafik
                                            	</button>
                                            </div>
                                                                                   
                                            </form>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-sm-8">
                                    	
                                        <div class="well wellform">
                                        	
                                            <div id="chartKonten" style="height:600px;">
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
    
                            </div>
                        </section>
    
                </div>
        	</div>
        </section>
    </section>
    <script type="text/javascript">
		
			var chart;
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
							result = JSON.parse(result);
							for (a in result) {
								$('#sasaran').append(new Option(result[a].deskripsi,result[a].kode));
							}
							$('#sasaran').select2({minimumResultsForSearch: -1, width:'resolve'});
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
				
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'chartKonten',
						options3d: {
							enabled: false,
							alpha: 0,
							beta: 0,
							viewDistance: 0,
							depth: 45
						},
						marginTop: 80,
						marginRight: 20
					},
					colors: ['#3D96AE', '#DB843D', '#E10000'],
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
						text: 'Analisis Cross Section Capaian Indikator Sasaran Strategis Dan Program',
						style : { "font-size" : "14px" }
					},
					subtitle: {
						text: 'Tahun 2012',
						style : { "font-size" : "14px" }
					},
					xAxis: {
						categories: ['Aceh', 'Bali', 'Banten', 'Bengkulu', 'Gorontalo','Jakarta','Jambi','Jawa Barat','Jawa Tengah','Jawa Timur','Kalimantan Barat','Kalimantan Selatan','Kalimantan Tengah','Kalimantan Timur','Kalimantan Utara','Kep. Bangka Belitung','Kep. Riau','Lampung','Maluku','Maluku Utara','Nusa Tenggara Barat','Nusa Tenggara Timur']
					},
					yAxis: {
						title: {
							text: null
						},
						plotLines: [{
							value: 400,
							color: '#090',
							width: 2,
							label: {
								text: 'rata-rata',
								align: 'center'
							}
						}]
					},
					plotOptions: {
						spline: {
							marker: {
								enabled: false
							},
						}
					},
					tooltip: {
						formatter: function() {
							var s;
							if (this.point.name) { // the pie chart
								s = ''+
									this.point.name +': '+ this.y;
							} else {
								s = 'provinsi '+this.x +'<br>'+this.series.name+' :'+this.y;
							}
							return s;
						}
					},
					series: [{
						name: 'Realisasi',
						type: 'bar',
						data: [300, 400,200,200,500,300,600,300,400,500,300,400,300, 400,200,200,500,300,600,300,400,500]
					},{
						name: 'Target',
						type: 'bar',
						data: [300, 400,200,200,500,300,600,300,400,500,300,400,300, 400,200,200,500,300,600,300,400,500]
					}]
				});
				
				
			});
				
		</script>