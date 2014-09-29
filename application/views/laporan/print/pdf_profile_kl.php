<page format="A4">
	<h4 align="center">Profil Unit Kerja Kementerian</h4>
    <table cellpadding="1" cellspacing="1" style="width:720px; border:0px #666666 solid; padding:10px 10px 10px 10px;">
    	<tr style="border:1px #666666 solid"><td><b>Periode Renstra</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?=$renstra?>
            </td>
        </tr>
        <tr style="border:1px #666666 solid"><td><b>Nama Kementerian</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?=$kementerian?>
            </td>
        </tr>
        <tr style="border:1px #666666 solid"><td><b>Tugas Pokok</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?php
					foreach($tugas as $t):
						echo $t->tugas_kl;
					endforeach;
				?>
            </td>
        </tr>
        <tr style="border:1px #666666 solid"><td><b>Fungsi</b></td></tr>
        <tr style="border:1px #666666 solid">
            <td>
            	<ol>
            	<?php
					foreach($fungsi as $f):
						echo "<li>".$f->fungsi_kl."</li>";
					endforeach;
				?>
                </ol>
            </td>
        </tr>
        <tr><td><b>Unit Kerja</b></td></tr>
        <tr>
            <td>
            	<ol>
            	<?php
					foreach($unit_kerja as $u):
						echo "<li>".$u->nama_e1."</li>";
					endforeach;
				?>
                </ol>
            </td>
        </tr>
    </table>
</page>