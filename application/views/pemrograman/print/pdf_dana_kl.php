<page format="A4">
<?php $thn_renstra = explode("-",$renstra);?>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
        <tr>
            <th rowspan="2" width="5%">No</th>
            <th rowspan="2" width="17%">Nama Program</th>
            <th colspan="5" align="center" width="65%"><center>Alokasi Pendanaan</center></th>
            <th rowspan="2" width="13%">Total</th>
        </tr>
        <tr>
            <?php for($a=$thn_renstra[0]; $a<=$thn_renstra[1]; $a++): ?>
                <th width="13%"><?=$a?></th>
            <?php endfor; ?>
        </tr>
        </thead>
        <tbody>
        
			<?php
				$no=1; $total = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total_all = 0;
			foreach($result as $d): 
				$total = $d->target_thn1+$d->target_thn2+$d->target_thn3+$d->target_thn4+$d->target_thn5;
				echo '<tr class="gradeX">
					<td width="5%">'.$no.'</td>
					<td width="17%">'.$d->nama_program.'</td>
					<td width="13%">'.cek_tipe_numerik($d->target_thn1).'</td>
					<td width="13%">'.cek_tipe_numerik($d->target_thn2).'</td>
					<td width="13%">'.cek_tipe_numerik($d->target_thn3).'</td>
					<td width="13%">'.cek_tipe_numerik($d->target_thn4).'</td>
					<td width="13%">'.cek_tipe_numerik($d->target_thn5).'</td>
					<td width="13%">'.cek_tipe_numerik($total).'</td>
				</tr>';
				$total1 = $total1+$d->target_thn1;
				$total2 = $total2+$d->target_thn2;
				$total3 = $total3+$d->target_thn3;
				$total4 = $total4+$d->target_thn4;
				$total5 = $total5+$d->target_thn5;
				$total_all = $total_all+$total;
				$no++;
				endforeach; 
				echo '<tr class="gradeX">
						<td colspan="2"><center><b>Total</b></center></td>
						<td width="13%"><b>'.cek_tipe_numerik($total1).'</b></td>
						<td width="13%"><b>'.cek_tipe_numerik($total2).'</b></td>
						<td width="13%"><b>'.cek_tipe_numerik($total3).'</b></td>
						<td width="13%"><b>'.cek_tipe_numerik($total4).'</b></td>
						<td width="13%"><b>'.cek_tipe_numerik($total5).'</b></td>
						<td width="13%"><b>'.cek_tipe_numerik($total_all).'</b></td>
					 </tr>
				';
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