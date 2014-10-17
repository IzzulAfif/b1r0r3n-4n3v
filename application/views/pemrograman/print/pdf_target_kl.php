<page format="A4">
<?php $thn_renstra = explode("-",$renstra);?>
	<table cellpadding="4" cellspacing="0" border="1">
        <thead>
        <tr>
            <th rowspan="2" width="5%">No</th>
            <th rowspan="2" width="8%">Kode</th>
            <th rowspan="2" width="40%">Indikator Kerja Utama</th>
            <th rowspan="2">Satuan</th>
            <th colspan="5" width="40%" align="center"><center>Target Capaian</center></th>
        </tr>
        <tr>
        	<?php for($a=$thn_renstra[0]; $a<=$thn_renstra[1]; $a++): ?>
                <th><?=$a?></th>
            <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
        	
            <?php 
				$no=1;
				foreach($result as $d): 
					echo '<tr>
						<td width="5%">'.$no.'</td>
						<td width="8%">'.$d->kode_iku_kl.'</td>					
						<td width="40%">'.$d->deskripsi.'</td>
						<td>'.$d->satuan.'</td>					
						<td width="8%">'.cek_tipe_numerik($d->target_thn1).'</td>					
						<td width="8%">'.cek_tipe_numerik($d->target_thn2).'</td>					
						<td width="8%">'.cek_tipe_numerik($d->target_thn3).'</td>					
						<td width="8%">'.cek_tipe_numerik($d->target_thn4).'</td>					
						<td width="8%">'.cek_tipe_numerik($d->target_thn5).'</td>
					</tr>';
					$no++;
				endforeach;
			?>
            
        </tbody>
    </table>
</page>

<?php 
function cek_tipe_numerik($str)
{
	if(is_numeric($str)):
		$cekFormat = explode(".",$str);
		if(count($cekFormat)==1): $fangka = "0"; else: $fangka="2"; endif;
		$format = number_format($str,$fangka,',','.');
		return $format;
	else:
		return $str;
	endif;
}
?>