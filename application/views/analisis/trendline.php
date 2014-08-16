
    <section id="main-content" class="">
        <section class="wrapper">
        
        	<div class="row">
                <div class="col-lg-12">
                        
                        <section class="panel">
                            <header class="panel-heading">
                                <b>Analisis trendline capaian indikator sasaran strategis dan program</b>
                            </header>
                            <div class="panel-body">
                                
                                <div class="row">
                                
                                	<div class="col-sm-4">
                                    	
                                        <div class="well wellform">
                                        	<form class="form-horizontal">
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Lokasi</label>
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
                                            
                                            
                                            <p class="text-primary"><b>Simulasi Pencapaian</b></p>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Tahun</label>
                                                <div class="col-sm-9">
                                                    <div id="spinner4">
                                                        <div class="input-group" style="width:150px;">
                                                            <div class="spinner-buttons input-group-btn">
                                                                <button type="button" class="btn spinner-up btn-primary btn-sm">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" class="spinner-input form-control input-sm" value="2013">
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
                                                <label class="col-sm-3 control-label">Target</label>
                                                <div class="col-sm-9">
                                                    <div id="spinner4">
                                                        <div class="input-group" style="width:150px;">
                                                            <div class="spinner-buttons input-group-btn">
                                                                <button type="button" class="btn spinner-up btn-primary btn-sm">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" class="spinner-input form-control input-sm" value="600">
                                                            <div class="spinner-buttons input-group-btn">
                                                                <button type="button" class="btn spinner-down btn-warning btn-sm">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <hr />
                                        	<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked="checked"> Tampilkan trendline
                                                </label>
                                            </div>
											<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked="checked"> Tampilkan targetline
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
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'chartKonten'
					},
					title: {
						text: 'Analisis Trendline'
					},
					xAxis: {
						categories: ['2010', '2011', '2012', '2013', '2014']
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
						type: 'column',
						name: 'Target',
						data: [300, 600, 900, 1200]
					}, {
						type: 'column',
						name: 'Realisasi',
						data: [400, 700, 800, 1100] 
					},{
						type: 'column',
						name: 'Simulasi',
						data: [0,0,0,0,1400]
					}, {
						type: 'spline',
						name: 'Trendline',
						data: [300, 500, 700, 1000, 1200]
					}, {
						type: 'spline',
						name: 'Targetline',
						data: [400, 700, 900, 1000, 1300]
					}]
				});
				
				
			});
				
		</script>