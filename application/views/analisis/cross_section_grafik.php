<?php
	$bar 	= "";
	$nilai 	= "";
	$tipe	= "";
	foreach($gdata as $d):
		$bar	.= "'".$d['nama']."',";
		if($d['color']=="DB843D"):
			$nilai	.= "{y: ".$d['rata2'].", color: '#DB843D'},";
		else:
			$nilai	.= $d['rata2'].",";
		endif;
		
		if(!is_numeric($d['rata2']) && $tipe!="not numeric"):
			$tipe = "not numeric";
		elseif(is_numeric($d['rata2']) && $tipe!="not numeric"):
			$tipe = "numeric";
		endif;
		
	endforeach;
?>
<div id="chartKontenSection" style=" <?php if($tipe=="numeric"): ?>height:400px; <?php endif; ?>">
	<?php if($tipe!="numeric"): ?>
    	<div class="alert alert-danger">Grafik tidak dapat ditampilkan, data tidak tersedia atau bukan numeric.</div>
	<?php endif; ?>
</div>

<br />
<section class="panel">
    <div class="panel-body">
            
        <table  class="display table table-bordered table-striped">
        <thead>
        <tr>
            <th>Unit Kerja</th>
            <th>% Rata-rata Capaian</th>
        </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($gdata as $d): ?>
            	
                <tr>
                    <td><a href="#detailCrossModal<?=$no?>" data-toggle="modal"><?=$d['nama']?></a></td>
                    <td><a href="#detailCrossModal<?=$no?>" data-toggle="modal"><?=$d['rata2']?> %</a></td>
                </tr>
                    
            <?php $no++; endforeach; ?>
            <tr><td><b>Rata-rata</b></td><td><b><?=$rata2?> %</b></td></tr>
        </tbody>
        </table>
        
    </div>
</section>

<?php $no=1; foreach($gdata as $d): ?>
<div aria-hidden="true" role="dialog" tabindex="-1" id="detailCrossModal<?=$no?>" class="modal fade">
    <div class="modal-dialog">   
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                <h5 class="modal-title"><?=$d['nama']?></h5>
            </div>
            <div class="modal-body">
                
                <table class="display table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Indikator Kinerja Utama</th>
                        <th>Tahun</th>
                        <th>Target</th>
                        <th>Realisasi</th>
                        <th>Persen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_persen=0; foreach($d['detail'] as $dd): ?>
                        <tr>
                            <td><?=$dd->nama_iku?></td>
                            <td><?=$dd->tahun?></td>
                            <td><?=$this->utility->cek_tipe_numerik($dd->target)?></td>
                            <td><?=$this->utility->cek_tipe_numerik($dd->realisasi)?></td>
                            <?php 
                                if($dd->target!=0 && $dd->target!=""): $persen=((2*$dd->target-$dd->realisasi)/$dd->target)*100; else: $persen="100"; endif;
                                $total_persen = $total_persen+$persen;
                            ?>
                            <td><?=$this->utility->cek_tipe_numerik($persen)?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4"> % Rata-rata Capaian</td>
                        <td><b><?=$this->utility->cek_tipe_numerik($total_persen/count($d['detail']))?></b></td>
                    </tr>
                </tbody>
                </table>
                
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="btn-close" class="btn btn-warning" data-dismiss="modal" class="close">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $no++; endforeach; ?>

<script>
	$(document).ready(function() {
	<?php if($tipe=="numeric"): ?>
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
				text: '<?=strtoupper($title)?>',
				style : { "font-size" : "14px" }
			},
			subtitle: {
				text: '<?=strtoupper($subtitle)?>',
				style : { "font-size" : "13px" }
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
				name: '% Rata-rata Capaian',
				type: 'bar',
				data: [<?=rtrim($nilai,",")?>],
				dataLabels: {enabled: true},
			}]
		});
		<?php endif; ?>
	});
</script>