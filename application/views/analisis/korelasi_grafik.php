<?php
	$rata1	= $gdata1['rata2'];
	$rata2	= $gdata2['rata2'];
	$grafd1	= $gdata1['gdata'];
	$grafd2	= $gdata2['gdata'];
	$dg1    = array();
	$dg2	= array();
	$data_graf = array();
	
	if(count($grafd1)!=0):
		foreach($grafd1 as $g1):
			$dg1[$g1['kode']] = array('kode'=>$g1['kode'],'nama'=> $g1['nama'],'nilai'=>$g1['rata2'],'detail'=>$g1['detail']);
		endforeach;
	endif;
	
	if(count($grafd2)!=0):
		foreach($grafd2 as $g2):
			$dg2[$g2['kode']] = array('kode'=>$g2['kode'],'nama'=> $g2['nama'],'nilai'=>$g2['rata2'],'detail'=>$g2['detail']);
		endforeach;
	endif;
	
	$tipe = "";
	if(count($dg1)>=count($dg2)):
		foreach($dg1 as $d1):
		if(isset($dg2[$d1['kode']]['nilai'])):
			 $nilaiy = $dg2[$d1['kode']]['nilai'];
			 
			 $detailyText  = "<table class='display table table-bordered'>";
			 $detailyText .= "<thead><tr><th>Indikator Kerja Utama</th><th>Tahun</th><th>Target</th><th>Realisasi</th><th>Persen</th></tr>";
			 $detailyText .= "<tbody>";
			 $total_persen = 0;
			
			  #menghitung jumlah value dalam array
			  $TotalArray = array();				 
				 foreach ($dg2[$d1['kode']]['detail'] as $array)
				 {
					 foreach ($array as $key => $string)
					 {
						 if(!isset($TotalArray[$string])): $TotalArray[$string] = 0; endif;
						 $TotalArray[$string] = $TotalArray[$string] + 1;
					 }
				}
			 
			 $namaRow1 = "";			 
			 foreach($dg2[$d1['kode']]['detail'] as $dy):
				
				if($namaRow1!=$dy->nama_iku):
					$detailyText .= "<tr><td rowspan='".$TotalArray[$dy->nama_iku]."'>".$dy->nama_iku."</td><td>";
				else:
					$detailyText .= "<tr><td>";
				endif;
				
				$detailyText .= $dy->tahun."</td><td>";
				$detailyText .= $this->utility->cek_tipe_numerik($dy->target)."</td><td>";
				$detailyText .= $this->utility->cek_tipe_numerik($dy->realisasi)."</td><td>";
					if($dy->target!="0" && $dy->target!=""):
						$persen = ((2*$dy->target-$dy->realisasi)/$dy->target)*100;
						#$persen = ($dy->realisasi/$dy->target)*100;
						$total_persen = $total_persen+$persen;
					else:
						$persen = 100;
						$total_persen = $total_persen+$persen;
					endif;
				$detailyText .= $this->utility->cek_tipe_numerik($persen)."</td></tr>";
				$namaRow1 = $dy->nama_iku;
				
			 endforeach;
			 $rata2y = $total_persen/count($dg2[$d1['kode']]['detail']);
			 $detailyText .= "<tr><td colspan='4'>% Rata-rata Capaian</td><td><b>".$this->utility->cek_tipe_numerik($rata2y)."</b></td></tr>"; 
			 $detailyText .= "</tbody>";
			 $detailyText .= "</table>";
			 
			 $detaily= $detailyText;
		else:
			$nilaiy  = 0;
			$detaily = "";
		endif;
			
			 $detailxText = "<table  class='display table table-bordered'>";
			 $detailxText .= "<thead><tr><th>Indikator Kerja Utama</th><th>Tahun</th><th>Target</th><th>Realisasi</th><th>Persen</th></tr>";
			 $detailxText .= "<tbody>";
			 $total_persen = 0;
			 
			 #menghitung jumlah value dalam array
			  $TotalArray2 = array();				 
				 foreach ($d1['detail'] as $array)
				 {
					 foreach ($array as $key => $string)
					 {
						 if(!isset($TotalArray2[$string])): $TotalArray2[$string] = 0; endif;
						 $TotalArray2[$string] = $TotalArray2[$string] + 1;
					 }
				}
			 
			 $namaRow2 = "";
			 foreach($d1['detail'] as $dx):
			 
			 	if($namaRow2!=$dx->nama_iku):
					$detailxText .= "<tr><td rowspan='".$TotalArray2[$dx->nama_iku]."'>".$dx->nama_iku."</td><td>";
				else:
					$detailxText .= "<tr><td>";
				endif;
				
				$detailxText .= $dx->tahun."</td><td>";
				$detailxText .= $this->utility->cek_tipe_numerik($dx->target)."</td><td>";
				$detailxText .= $this->utility->cek_tipe_numerik($dx->realisasi)."</td><td>";
					if($dx->target!="0" && $dx->target!="" && is_numeric($dx->target)):
						#$persen = ((2*$dx->target-$dx->realisasi)/$dx->target)*100;
						$persen = ($dx->realisasi/$dx->target)*100;
						$total_persen = $total_persen+$persen;
					else:
						$persen = 100;
						$total_persen = $total_persen+$persen;
					endif;
			 	$detailxText .= $this->utility->cek_tipe_numerik($persen)."</td></tr>"; 
				$namaRow2 = $dx->nama_iku;
			 endforeach;
			 $rata2x = $total_persen/count($d1['detail']);
			 $detailxText .= "<tr><td colspan='4'>% Rata-rata Capaian</td><td><b>".$this->utility->cek_tipe_numerik($rata2x)."</b></td></tr>";
			 $detailxText .= "</tbody>";
			 $detailxText .= "</table>";
			
			 $detailx= $detailxText;
				 
			$data_graf[]= array('nama'		=>$d1['nama'],
								'nilaix'	=>$d1['nilai'],
								'detailx'	=>$detailx,
								'nilaiy'	=>$nilaiy,
								'detaily'	=>$detaily);
			#print_r($data_graf);
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
				 
				 $detailxText  = "<table class='display table table-bordered'>";
			 	 $detailxText .= "<thead><tr><th>Indikator Kerja Utama</th><th>Tahun</th><th>Target</th><th>Realisasi</th><th>Persen</th></tr>";
			 	 $detailxText .= "<tbody>";
				 $total_persen = 0;

				 #menghitung jumlah value dalam array
				  $TotalArray3 = array();				 
					 foreach ($dg1[$d2['kode']]['detail'] as $array)
					 {
						 foreach ($array as $key => $string)
						 {
							 if(!isset($TotalArray3[$string])): $TotalArray3[$string] = 0; endif;
							 $TotalArray3[$string] = $TotalArray3[$string] + 1;
						 }
					}
				
				 $namaRow3 = "";	
				 foreach($dg1[$d2['kode']]['detail'] as $dx):
				 	
					if($namaRow3!=$dx->nama_iku):
				 		$detailxText .= "<tr><td rowspan='".$TotalArray3[$dx->nama_iku]."'>".$dx->nama_iku."</td><td>";
				 	else:
						$detailxText .= "<tr><td>";
					endif;
					
					$detailxText .= $dx->tahun."</td><td>";
					$detailxText .= $this->utility->cek_tipe_numerik($dx->target)."</td><td>";
					$detailxText .= $this->utility->cek_tipe_numerik($dx->realisasi)."</td><td>";
						if($dx->target!="0" && $dx->target!=""):
							#$persen = ((2*$dx->target-$dx->realisasi)/$dx->target)*100;
							$persen = ($dx->realisasi/$dx->target)*100;
							$total_persen = $total_persen+$persen;
						else:
							$persen = 100;
							$total_persen = $total_persen+$persen;
						endif;
					$detailxText .= $this->utility->cek_tipe_numerik($persen)."</td></tr>";
					$namaRow3 = $dx->nama_iku;
				 endforeach;
				$rata2x = $total_persen/count($dg1[$d2['kode']]['nilai']);
			 	$detailxText .= "<tr><td colspan='4'>% Rata-rata Capaian</td><td><b>".$this->utility->cek_tipe_numerik($rata2x)."</b></td></tr>";
			 	$detailxText .= "</tbody>";
			 	$detailxText .= "</table>";
				 
				 $detailx= $detailxText;
			else:
				$nilaix  = 0;
				$detailx = "";
			endif;
			
			 $detailyText  = "<table class='display table table-bordered'>";
			 $detailyText .= "<thead><tr><th>Indikator Kerja Utama</th><th>Tahun</th><th>Target</th><th>Realisasi</th><th>Persen</th></tr>";
			 $detailyText .= "<tbody>";
			 $total_persen = 0;
			 	
				#menghitung jumlah value dalam array
				  $TotalArray4 = array();				 
					 foreach ($d2['detail'] as $array)
					 {
						 foreach ($array as $key => $string)
						 {
							 if(!isset($TotalArray4[$string])): $TotalArray4[$string] = 0; endif;
							 $TotalArray4[$string] = $TotalArray4[$string] + 1;
						 }
					}
			
			 $namaRow4 = "";
			 foreach($d2['detail'] as $dy):
			 	
				if($namaRow4!=$dy->nama_iku):
					$detailyText .= "<tr><td rowspan='".$TotalArray4[$dy->nama_iku]."'>".$dy->nama_iku."</td><td>";
				else:
					$detailyText .= "<tr><td>";
				endif;
				
				$detailyText .= $dy->tahun."</td><td>";
				$detailyText .= $this->utility->cek_tipe_numerik($dy->target)."</td><td>";
				$detailyText .= $this->utility->cek_tipe_numerik($dy->realisasi)."</td><td>";
					if($dy->target!="0" && $dy->target!=""):
						#$persen = ((2*$dy->target-$dy->realisasi)/$dy->target)*100;
						//handle divby zero by chan
						if($dy->target!="0" && $dy->target!="" && is_numeric($dy->target)):
							$persen = ($dy->realisasi/$dy->target)*100;
						else:
							$persen = 0;
						endif;	
						$total_persen = $total_persen+$persen;
					else:
						$persen = 100;
						$total_persen = $total_persen+$persen;
					endif;
				$detailyText .= $this->utility->cek_tipe_numerik($persen)."</td></tr>";
			 $namaRow4 = $dy->nama_iku;
			 endforeach;
			 
			 $rata2y = $total_persen/count($d2['detail']);
			 $detailyText .= "<tr><td colspan='4'>% Rata-rata Capaian</td><td><b>".$this->utility->cek_tipe_numerik($rata2y)."</b></td></tr>";
			 $detailyText .= "</tbody>";
			 $detailyText .= "</table>";
			 
			 $detaily= $detailyText;
			 
			$data_graf[]= array('nama'		=>$d2['nama'],
								'nilaiy'	=>$d2['nilai'],
								'detaily'	=>$detaily,
								'nilaix'	=>$nilaix,
								'detailx'	=>$detailx);	
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


	
	<?php if(count($data_graf)==0): ?>
    	<div class="alert alert-danger">
        	<p>Grafik tidak dapat ditampilkan, data tidak tersedia atau berupa numerik</p>
        </div>
    <?php else : ?>
    	<div style="margin-bottom:5px;" align="right">
    		<button type="button" class="btn btn-warning btn-sm" onclick="chart.print();"><i class="fa fa-print"></i> Cetak Grafik</button>
        </div>
        <div id="chartKontenKorelasi" style="height:400px;">
		</div>
        
        <br />
<section class="panel">
    <div class="panel-body">
            
        <table  class="display table table-bordered table-striped">
        <thead>
        <tr>
            <th>Unit Kerja</th>
            <th>Indikator Independent</th>
            <th>Indikator Dependent</th>
        </tr>
        </thead>
        <tbody>
        	<?php if(count($data_graf)==0): ?>
            
            	<tr><td colspan="3">Tidak ada data</td></tr>
                
            <?php else: ?>
            
				<?php $no=1; foreach($data_graf as $d): ?>
                    
                    <tr>
                        <td><?=$d['nama']?></td>
                        <td>
                            <?php if($d['nilaix']!=0): ?>
                                <a href="#detailKorelasixModal<?=$no?>" data-toggle="modal"><?=$d['nilaix']?></a>
                            <?php else: echo $d['nilaix']; endif; ?>
                        </td>
                        <td>
                            <?php if($d['nilaiy']!=0): ?>
                                <a href="#detailKorelasiyModal<?=$no?>" data-toggle="modal"><?=$d['nilaiy']?></a>
                            <?php else: echo $d['nilaiy']; endif; ?>
                        </td>
                    </tr>
                        
                <?php $no++; endforeach; ?>
        		
                <tr>
                	<td>Rata - rata</td>
                    <td><?=$rata1?></td>
                    <td><?=$rata2?></td>
                </tr>
                
        	<?php endif; ?>
        	
        </tbody>
        </table>
        
    </div>
</section>

<?php $no=1; foreach($data_graf as $d): ?>

	<?php if($detailx!=""): ?>
        <div aria-hidden="true" role="dialog" tabindex="-1" id="detailKorelasixModal<?=$no?>" class="modal fade">
            <div class="modal-dialog">   
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                        <h5 class="modal-title"><?=$d['nama']?></h5>
                    </div>
                    <div class="modal-body">
                       <?=$d['detailx']?> 
                    </div>
                    <div class="modal-footer">
                        <div class="pull-right">
                            <button type="button" id="btn-close" class="btn btn-warning" data-dismiss="modal" class="close">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if($detaily!=""): ?>
        <div aria-hidden="true" role="dialog" tabindex="-1" id="detailKorelasiyModal<?=$no?>" class="modal fade">
            <div class="modal-dialog">   
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                        <h5 class="modal-title"><?=$d['nama']?></h5>
                    </div>
                    <div class="modal-body">
                       <?=$d['detaily']?> 
                    </div>
                    <div class="modal-footer">
                        <div class="pull-right">
                            <button type="button" id="btn-close" class="btn btn-warning" data-dismiss="modal" class="close">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
<?php $no++; endforeach; ?>
	<?php endif; ?>

<script>
	$(document).ready(function() {
		
	<?php if(count($data_graf)!=0): ?>
	
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
					enabled:false,
				}
		
			}
		},
		title: {
			text: 'ANALISIS KORELASI INDIKATOR INDEPENDENT DAN DEPENDENT',
			style : { "font-size" : "14px" }
		},
		subtitle: {
			text: 'PERIODE TAHUN <?=$tahun1?> s.d. <?=$tahun2?>',
			style : { "font-size" : "13px" }
		},
		xAxis: {
			title: {
				enabled: true,
				text: 'Indikator Independent<?php #ucwords($title2); ?>'
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
		//<div title="<?=ucwords($title1)?>"><p align="center"><?=substr(ucwords($title1),0,50)?> ...</p></div>
		yAxis: {
			title: {
				text: 'Indikator Dependent',
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
			<?php foreach($data_graf as $gd): if($gd['nama']=="Kementerian"): $fillColor="#3D96AE"; else: $fillColor="#BF0B23"; endif;?>
			{name: '<?=$gd['nama']?>',marker: { fillColor: '<?=$fillColor?>', symbol : "triangle",radius:6},data: [{x:<?=$gd['nilaix']?>,y:<?=$gd['nilaiy']?>,myData : "Rata-rata Pencapaian Indikator 1 : <?=$gd['nilaix']?> <br> Rata-rata Pencapaian Indikator 2 : <?=$gd['nilaiy']?>"}]},
			<?php endforeach; ?>
		]
	});
	
	<?php endif; ?>
	
	});
</script>