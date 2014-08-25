<?php 
	$dTahun		= "";
	$dTarget	= "";
	$dRealisasi	= "";
	$dSimulasi	= "";
	foreach($gdata as $d):
		if(count($d)!=0):
			$dTahun		.= $d['tahun'].",";
			$dTarget	.= $d['target'].",";
			$dRealisasi	.= $d['realisasi'].",";
			$dSimulasi	.= "null,";
		endif;
			
	endforeach;
?>

<div id="chartKonten" style="height:400px;">
</div>

<script>
	$(document).ready(function() {
		var chart;
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chartKonten',
				marginTop: 120,
			},
			colors: ['#DB843D', '#3D96AE', '#89A54E', '#00FF40', '#E10000', '#CCCCCC'],
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
			subtitle: {
				text: '<?=$subtitle?>',
				style : { "font-size" : "13px" }
			},
			xAxis: {
				categories: [<?=$dTahun?><?=$simulasi['tahun']?>]
			},
			yAxis: {
				labels: {
					formatter: function () {
						return Highcharts.numberFormat(this.value,0);
					}
				},
				title: {
					text: ''
				},
				plotLines: [{
					value: <?=$simulasi['target']?>,
					color: '#89A54E',
					width: 2,
				}]
			},
			tooltip: {
				formatter: function() {
					var s;
					if (this.point.name) { // the pie chart
						s = ''+
							this.point.name +': '+ this.y +'';
					} else {
						s = this.series.name+' tahun '+this.x  +': '+ this.y;
					}
					return s;
				}
			},
			plotOptions: {
				spline: {
					marker: {
						enabled: false
					},
				}
			},
			series: [{
				type: 'column',
				name: 'Target',
				data: [<?=rtrim($dTarget,",")?>]
			}, {
				type: 'column',
				name: 'Realisasi',
				data: [<?=rtrim($dRealisasi,",")?>] 
			},{
				type: 'column',
				name: 'Simulasi',
				data: [<?=$dSimulasi?><?=$simulasi['target']?>]
			}, /*{
				type: 'spline',
				name: 'Trendline',
				data: [10, 50, 70, 10, 20]
			}, {
				type: 'spline',
				name: 'Targetline',
				data: [40, 70, 90, 10, 30]
			}*/]
		});
	});
</script>