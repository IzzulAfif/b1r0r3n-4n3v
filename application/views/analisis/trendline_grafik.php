<?php 
	$dTahun		= "";
	$dTarget	= "";
	$dRealisasi	= "";
	$dSimulasi	= "";
	$dTrendline	= "";
	$dTargetline= "";
	$dSimTarget	= "";
	$dCapaian	= "";
	#print_r($target);
	
	$tahun_renstra = explode("-",$target[0]->tahun_renstra);
	$no=1;
	for($a=$tahun_renstra[0]; $a<=$tahun_renstra[1];$a++):
		switch($no):
			case "1"; $arrTahun[$a] = $target[0]->target_thn1; break;
			case "2"; $arrTahun[$a] = $target[0]->target_thn2; break;
			case "3"; $arrTahun[$a] = $target[0]->target_thn3; break;
			case "4"; $arrTahun[$a] = $target[0]->target_thn4; break;
			case "5"; $arrTahun[$a] = $target[0]->target_thn5; break;
		endswitch;
		$no++;
	endfor;
	
	foreach($gdata as $d):
		if(count($d)!=0):
			$dTahun		.= $d['tahun'].",";
			$dTarget	.= $d['target'].",";
			$dRealisasi	.= $d['realisasi'].",";
			$dSimulasi	.= $d['simulasi'].",";
			$dTrendline	.= $d['trendline'].",";
			$dTargetline.= $d['targetline'].",";
			$dCapaian	.= $arrTahun[$d['tahun']].",";
			
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
            <th>Target (<?=$satuan?>)</th>
            <th>Realisasi (<?=$satuan?>)</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($gdata as $d): ?>
            	
				<?php if($d['tahun']==$post['tahun']): ?>
					<tr><td colspan="3">Simulasi Target dan Realisasi</td></tr>
                    <tr>
                    	<td><?=$d['tahun']?></td>
                        <td><?=$this->template->cek_tipe_numerik($post['target'])?></td>
                        <td><?=$this->template->cek_tipe_numerik($d['simulasi'])?></td>
                    </tr>
				<?php else: ?>
                	<tr>
                        <td><?=$d['tahun']?></td>
                        <td><?=$this->template->cek_tipe_numerik($d['target'])?></td>
                        <td><?=$this->template->cek_tipe_numerik($d['realisasi'])?></td>
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
				text: '<?=strtoupper($title)?>',
				style : { "font-size" : "14px" }
			},
			subtitle: {
				text: '<?=strtoupper($subtitle)?>',
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
			series: [
			{
				type: 'column',
				name: 'Target Simulasi',
				data: [<?=rtrim($dSimTarget,",")?>],
			},{
				type: 'column',
				name: 'Realisasi Simulasi',
				data: [<?=rtrim($dSimulasi,",")?>],
			},{
				type: 'column',
				name: 'Target Renstra',
				data: [<?=rtrim($dCapaian,",")?>],
			},{
				type: 'column',
				name: 'PK',
				data: [<?=rtrim($dTarget,",")?>],
			}, {
				type: 'column',
				name: 'Realisasi',
				data: [<?=rtrim($dRealisasi,",")?>],
			}
			<?php if($post['trendline']=="ok"):?>
			,{
				type: 'spline',
				name: 'Trendline',
				data: [<?=rtrim($dTrendline,",")?>],
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