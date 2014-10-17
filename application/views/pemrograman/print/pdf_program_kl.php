<page format="A4">
	<table border="1" cellpadding="4" cellspacing="0">
        <tr>
            <th width="5%">No</th>
            <th width="35%">Unit Kerja</th>
            <th width="10%">Kode</th>
            <th width="50%">Nama Program</th>
        </tr>
	<?php 
		$no=1;
		foreach($result as $d): 
		echo '<tr>
			<td>'.$no.'</td>
			<td>'.$d->nama_e1.'</td>
			<td>'.$d->kode_program.'</td>
			<td>'.$d->nama_program.'</td>
		</tr>';
		$no++;
		endforeach;
	?>
    </table>
</page>