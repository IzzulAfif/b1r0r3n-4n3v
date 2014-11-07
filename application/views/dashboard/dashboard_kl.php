<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
       <!--tab nav start-->
       <?php $no=1; foreach($graphData as $d):?>
            <section class="panel">
                <div class="panel-body">
					
                    <h4 align="center"><?=$d['nama_program']?></h4>
                	<div class="row">
                    	
                        <div class="col-md-6" align="center">
                        
                        	<div class="alert alert-info">
                               	<div id="container-g<?=$no?>" style="width: 100%; height: 200px;"></div>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-6" align="center">
                        	
                            <div class="alert alert-info">
                                <div id="container-r<?=$no?>" style="width: 100%; height: 200px;"></div>
                            </div>
                            
                    	</div>
                        
                    </div>
                    
                </div>
            </section>
            <!--tab nav end-->
            
		<?php $no++; endforeach; ?>
                           
        </section>
    </section>
    <!--main content end-->
    
<script>
	$(document).ready(function() {
		var gaugeOptions = {
		
			chart: {
				type: 'solidgauge'
			},
			exporting: {
				buttons: { 
					exportButton: {
						enabled:false
					},
					printButton: {
						enabled:false
					}
			
				}
			},
			title: null,
			
			pane: {
				center: ['50%', '85%'],
				size: '140%',
				startAngle: -90,
				endAngle: 90,
				background: {
					backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
					innerRadius: '60%',
					outerRadius: '100%',
					shape: 'arc'
				}
			},
	
			tooltip: {
				enabled: false
			},
			   
			// the value axis
			yAxis: {
				stops: [
					[0.1, '#55BF3B'], // green
					[0.5, '#DDDF0D'], // yellow
					[0.9, '#DF5353'] // red
				],
				lineWidth: 0,
				minorTickInterval: null,
				tickPixelInterval: 400,
				tickWidth: 0,
				title: {
					y: -70
				},
				labels: {
					y: 16
				}        
			},
			
			plotOptions: {
				solidgauge: {
					dataLabels: {
						y: 5,
						borderWidth: 0,
						useHTML: true
					}
				}
			}
		};
		
		<?php $no=1; foreach($graphData as $d):?>
		
		// The speed gauge
		$('#container-g<?=$no?>').highcharts(Highcharts.merge(gaugeOptions, {
			yAxis: {
				min: 0,
				max: 100,
				title: {
					text: 'Capaian Kinerja'
				}       
			},
	
			credits: {
				enabled: false
			},
		
			series: [{
				name: 'Speed',
				data: [<?=$d['capaian']?>],
				dataLabels: {
					format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
						((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' + 
						'<span style="font-size:12px;color:silver">%</span></div>'
				},
				tooltip: {
					valueSuffix: ' % '
				}
			}]
		
		}));
		
		// The RPM gauge
		$('#container-r<?=$no?>').highcharts(Highcharts.merge(gaugeOptions, {
			yAxis: {
				min: 0,
				max: 100,
				title: {
					text: 'Serapan Anggaran'
				}       
			},
		
			series: [{
				name: 'RPM',
				data: [<?=$d['serapan']?>],
				dataLabels: {
					format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
						((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y:.1f}</span><br/>' + 
						'<span style="font-size:12px;color:silver"> % </span></div>'
				},
				tooltip: {
					valueSuffix: ' % '
				}      
			}]
		
		}));
		
		<?php $no++; endforeach; ?>
	});
</script>	