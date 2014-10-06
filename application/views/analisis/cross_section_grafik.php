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

<br />
<section class="panel">
    <div class="panel-body">
            
        <table  class="display table table-bordered table-striped">
        <thead>
        <tr>
            <th>Unit Kerja</th>
            <th>Rata-rata Pencapaian</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($gdata as $d): ?>
            	
                <tr>
                    <td><?=$d['nama']?></td>
                    <td><?=$d['rata2']?> %</td>
                </tr>
                    
            <?php endforeach; ?>
            <tr><td><b>Rata-rata</b></td><td><b><?=$rata2?> %</b></td></tr>
        </tbody>
        </table>
        
    </div>
</section>

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
						text: 'rata-rata (<?=$rata2?>)',
						align: 'left'
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
				data: [<?=rtrim($nilai,",")?>],
				dataLabels: {enabled: true},
			}]
		});
	});
</script>