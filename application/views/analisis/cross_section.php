
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
                                
                                	<div class="col-sm-4">
                                    	
                                        <div class="well wellform">
                                        	<form class="form-horizontal">
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Tahun</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control input-sm">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <p class="text-primary"><b>Sasaran dan Indikator</b></p>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Sasaran</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control input-sm">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Indikator</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control input-sm">
                                                        <option>Option 1</option>
                                                        <option>Option 2</option>
                                                        <option>Option 3</option>
                                                    </select>
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
                                                	<i class="fa fa-check-square-o"></i> Perbaharui Grafik
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
						marginTop: 50,
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
						text: 'Analisis Cross Section'
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
							color: 'red',
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
									this.point.name +': '+ this.y +' fruits';
							} else {
								s = ''+
									this.x  +': '+ this.y;
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