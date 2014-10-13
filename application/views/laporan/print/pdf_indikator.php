<page format="A4">

   <!-- <table cellpadding="1" cellspacing="1" style="width:720px; border:0px #666666 solid; padding:10px 10px 10px 10px;"> -->
    <table border="0" cellpadding="4" cellspacing="0">
   
    	<tr style="border:1px #666666 solid"><td><b>Periode Renstra</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?=$renstra?>
            </td>
        </tr>
    	<tr style="border:1px #666666 solid"><td><b>Tahun</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?=$tahun?>
            </td>
        </tr>
		<tr style="border:1px #666666 solid"><td><b>Indikator</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?=$indikator?>
            </td>
        </tr>
		<? if ($showKl=="true"){?>
		<tr style="border:1px #666666 solid"><td><b>IKU Kementerian</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?php echo $ikuKl;				?>
            </td>
        </tr>
		<?}?>
		<? if (($showE1=="true")&&($showE2!="true")){?>
		<tr style="border:1px #666666 solid"><td><b>IKU Eselon I</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?php echo $ikuE1;				?>
            </td>
        </tr>
		<?} else if (($showE1=="true")&&($showE2=="true")){?>
		<tr style="border:1px #666666 solid"><td><b>IKU Eselon I dan IKK Eselon II</b></td></tr>
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?php echo $ikuE1;				?>
            </td>
        </tr>
		<?}else  if (($showE1!="true")&&($showE2=="true")){?>
		<tr style="border:1px #666666 solid"><td><b>IKK Eselon II</b></td></tr>
		<tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<?php echo $ikuE2;				?>
            </td>
        </tr>
		<?}?>
      
       
    </table>
</page>