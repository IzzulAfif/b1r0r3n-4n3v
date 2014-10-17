<?php 
	$dTahun		= "";
	$dTarget	= "";
	$dRealisasi	= "";
	$dSimulasi	= "";
	$dTrendline	= "";
	$dTargetline= "";
	$dSimTarget	= "";
	
	foreach($gdata as $d):
		if(count($d)!=0):
			$dTahun		.= $d['tahun'].",";
			$dTarget	.= $d['target'].",";
			$dRealisasi	.= $d['realisasi'].",";
			$dSimulasi	.= $d['simulasi'].",";
			$dTrendline	.= $d['trendline'].",";
			$dTargetline.= $d['targetline'].",";
			
			if($d['tahun']==$post['tahun']):
				$dSimTarget .= $post['target'].",";
			else:
				$dSimTarget .= "0,";
			endif;
			if($tipe!="not numeric"):
				if(!is_numeric($d['tahun']) || !is_numeric($d['target']) || !is_numeric($d['realisasi']) || !is_numeric($d['simulasi']) || !is_numeric($d['trendline']) || !is_numeric($d['targetline'])):
					$tipe = "not numeric";
				else:
					$tipe = "numeric";
				endif;
			endif;
			
		endif;
	endforeach;
?>

<div id="chartKonten" style=" <?php if($tipe=="numeric"): ?>height:400px; <?php endif; ?>">
	<?php if($tipe!="numeric"): ?>
    	<div class="alert alert-danger">Grafik tidak dapat ditampilkan, data tidak tersedia atau bukan numeric.</div>
	<?php endif; ?>
</div>
<br />

<?php if(count($gdata)!=0): ?>
<section class="panel">
    <div class="panel-body">
            
        <table  class="display table table-bordered table-striped">
        <thead>
        <tr>
            <th>Tahun</th>
            <th>Target</th>
            <th>Realisasi</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($gdata as $d): ?>
            	
				<?php if($d['tahun']==$post['tahun']): ?>
					<tr><td colspan="3">Simulasi Target dan Pencapaian</td></tr>
                    <tr>
                    	<td><?=$d['tahun']?></td>
                        <td><?=$post['target']?></td>
                        <td><?=$d['simulasi']?></td>
                    </tr>
				<?php else: ?>
                	<tr>
                        <td><?=$d['tahun']?></td>
                        <td><?=$d['target']?></td>
                        <td><?=$d['realisasi']?></td>
                    </tr>
				<?php endif; ?>
            
            <?php endforeach; ?>
        </tbody>
        </table>
        
    </div>
</section>

<script>
	$(document).ready(function() {
	<?php if($tipe=="numeric"): ?>
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
				data: [<?=rtrim($dTarget,",")?>],
			}, {
				type: 'column',
				name: 'Realisasi',
				data: [<?=rtrim($dRealisasi,",")?>],
			},{
				type: 'column',
				name: 'Simulasi Target',
				data: [<?=rtrim($dSimTarget,",")?>],
			},{
				type: 'column',
				name: 'Simulasi Pencapaian',
				data: [<?=rtrim($dSimulasi,",")?>],
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
		<?php endif; ?>
	});
</script>
<?php endif; ?>