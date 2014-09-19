<?php
	$bar 	= "";
	$nilai 	= "";
	foreach($gdata as $d):
		$bar	.= "'".$d['nama']."',";
		$nilai	.= $d['rata2'].",";
	endforeach;
?>
<div id="chartKontenSection" style="height:400px;">
	
</div>

<script>
	$(document).ready(function() {
		var chart;
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chartKontenSection',
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
				text: '<?=$title?>',
				style : { "font-size" : "14px" }
			},
			xAxis: {
				categories: [<?=rtrim($bar,",")?>]
			},
			yAxis: {
				title: {
					text: null
				},
				plotLines: [{
					value: <?=$rata2?>,
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
			series: [{
				name: 'Rata-rata Pencapaian',
				type: 'bar',
				data: [<?=rtrim($nilai,",")?>]
			}]
		});
	});
</script>