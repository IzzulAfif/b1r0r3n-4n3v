<?php
	$rata1	= $gdata1['rata2'];
	$rata2	= $gdata2['rata2'];
	$grafd1	= $gdata1['gdata'];
	$grafd2	= $gdata2['gdata'];
	
		foreach($grafd1 as $g1):
			$dg1[$g1['kode']] = array('kode'=>$g1['kode'],'nama'=> $g1['nama'],'nilai'=>$g1['rata2']);
		endforeach;
		
		foreach($grafd2 as $g2):
			$dg2[$g2['kode']] = array('kode'=>$g1['kode'],'nama'=> $g2['nama'],'nilai'=>$g2['rata2']);
		endforeach;
	
	$tipe = "";
	if(count($dg1)>=count($dg2)):
		foreach($dg1 as $d1):
		if(isset($dg2[$d1['kode']]['nilai'])):
			 $nilaiy = $dg2[$d1['kode']]['nilai'];
		else:
			$nilaiy  = 0;
		endif;
		
			$data_graf[]= array('nama'		=>$d1['nama'],
								'nilaix'	=>$d1['nilai'],
								'nilaiy'	=>$nilaiy);
			
			if($tipe!="not numeric"):
				if(!is_numeric($d1['nilai']) || !is_numeric($nilaiy)):
					$tipe = "not numeric";
				else:
					$tipe = "numeric";
				endif;
			endif;
			
		endforeach;
	else:
		foreach($dg2 as $d2):
			if(isset($dg1[$d2['kode']]['nilai'])):
				 $nilaix = $dg1[$d2['kode']]['nilai'];
			else:
				$nilaix  = 0;
			endif;
		
			$data_graf[]= array('nama'		=>$d2['nama'],
								'nilaiy'	=>$d2['nilai'],
								'nilaix'	=>$nilaix);
			
			if($tipe!="not numeric"):
				if(!is_numeric($d2['nilai']) || !is_numeric($nilaix)):
					$tipe = "not numeric";
				else:
					$tipe = "numeric";
				endif;
			endif;
			
		endforeach;
	endif;
?>

<div id="chartKontenKorelasi" style="height:400px;">
</div>
<br />
<section class="panel">
    <div class="panel-body">
            
        <table  class="display table table-bordered table-striped">
        <thead>
        <tr>
            <th>Unit Kerja</th>
            <th>Indikator 1 (x)</th>
            <th>Indikator 2 (y)</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($data_graf as $d): ?>
            	
                <tr>
                    <td><?=$d['nama']?></td>
                    <td><?=$d['nilaix']?></td>
                    <td><?=$d['nilaiy']?></td>
                </tr>
                    
            <?php endforeach; ?>
        </tbody>
        </table>
        
    </div>
</section>

<script>
	$(document).ready(function() {
		chart = new Highcharts.Chart({
		chart: {
			renderTo: 'chartKontenKorelasi',
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
			text: 'ANALISIS KORELASI CAPAIAN INDIKATOR DAN SASARAN STRATEGIS',
			style : { "font-size" : "14px" }
		},
		subtitle: {
			text: 'PERIODE TAHUN <?=$tahun1?> s.d. <?=$tahun2?>',
			style : { "font-size" : "13px" }
		},
		xAxis: {
			title: {
				enabled: true,
				text: '<?=ucwords($title2)?>'
			},
			startOnTick: true,
			endOnTick: true,
			showLastLabel: true,
			plotLines: [{
				value: '<?=$rata2?>',
				color: '#090',
				width: 2
			}]
		},
		yAxis: {
			title: {
				text: '<div title="<?=ucwords($title1)?>"><p align="center"><?=substr(ucwords($title1),0,50)?> ...</p></div>',
				useHTML : true,
			},
			gridLineWidth: 0,
			minorGridLineWidth: 0,
			plotLines: [{
				value: '<?=$rata1?>',
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
					headerFormat: '<b>{series.name}</b><br>',
					pointFormat: '{point.myData}'
				}
			}
		},
		series: [
			<?php foreach($data_graf as $gd): ?>
			{name: '<?=$gd['nama']?>',marker: { fillColor: '#BF0B23', symbol : "triangle",radius:6},data: [{x:<?=$gd['nilaix']?>,y:<?=$gd['nilaiy']?>,myData : "Rata-rata Pencapaian Indikator 1 : <?=$gd['nilaix']?> <br> Rata-rata Pencapaian Indikator 2 : <?=$gd['nilaiy']?>"}]},
			<?php endforeach; ?>
		]
	});
	});
</script>