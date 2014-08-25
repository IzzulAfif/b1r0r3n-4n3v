<?php 
	$dTahun		= "";
	$dTarget	= "";
	$dRealisasi	= "";
	$dSimulasi	= "";
	$dTrendline	= "";
	$dTargetline= "";
	
	foreach($gdata as $d):
		if(count($d)!=0):
			$dTahun		.= $d['tahun'].",";
			$dTarget	.= $d['target'].",";
			$dRealisasi	.= $d['realisasi'].",";
			$dSimulasi	.= $d['simulasi'].",";
			$dTrendline	.= $d['trendline'].",";
			$dTargetline.= $d['targetline'].",";
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
				categories: [<?=$dTahun?>]
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
					value: <?=$post['target']?>,
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
				data: [<?=rtrim($dSimulasi,",")?>]
			}
			<?php if($post['trendline']=="ok"):?>
			,{
				type: 'spline',
				name: 'Trendline',
				data: [<?=rtrim($dTrendline,",")?>]
			}
			<?php endif; ?>
			<?php if($post['targetline']=="ok"):?>
			, {
				type: 'spline',
				name: 'Targetline',
				data: [<?=rtrim($dTargetline,",")?>]
			}
			<?php endif; ?>
			]
		});
	});
</script>