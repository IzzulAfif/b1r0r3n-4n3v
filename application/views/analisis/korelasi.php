
    <section id="main-content" class="">
        <section class="wrapper">
        
        	<div class="row">
                <div class="col-lg-12">
                        
                        <section class="panel">
                            <header class="panel-heading">
                                <b>Analisis korelasi capaian indikator sasaran strategis dan program</b>
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
                                            
                                            
                                            <p class="text-primary"><b>Sasaran dan Indikator 1</b></p>
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
                                            
                                            <p class="text-primary"><b>Sasaran dan Indikator 2</b></p>
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
                                            <div class="row">
                                            	<div class="col-sm-6">Axis X : 163</div>
                                                <div class="col-sm-6">Axis Y : 140</div>
                                            </div><br />
                                            
                                            <p class="text-primary"><b>Perbesaran</b></p>
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
                                        	
                                            <div id="chartKonten">
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
			var dataTooltip = "Target Indikator 1 : 161.2 <br>Realisasi Indikator 1 : 140 <br> Target Indikator 2 : 161.2 <br>Realisasi Indikator 2 : 140";
			
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'chartKonten',
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
				
		</script>