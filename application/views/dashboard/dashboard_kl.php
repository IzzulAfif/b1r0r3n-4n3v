<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <div class="feed-box">
        <section class="panel">
            <div class="panel-body">
				
   				<div class="corner-ribon blue-ribon">
                	<i class="fa fa-cog"></i>
                </div>
                
                <form action="<?=base_url()?>dashboard/dsb_kl" class="form-horizontal" role="form" method="post">
                	<div class="form-group">
                        <label class="col-md-2 control-label">Periode Renstra <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <?=form_dropdown('renstra',$renstra,'0','id="es1-renstra" class="populate" style="width:100%"')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">&nbsp;</label>
                        <button type="submit" class="btn btn-info" id="es1keu-btn" style="margin-left:15px;">
                            <i class="fa fa-check-square-o"></i> Tampilkan Data
                        </button>
                    </div>
                </form>
                
             </div>
        </section>
        </div>
        
        <section class="panel">
            <div class="panel-body">
				<h4 align="center">RATA-RATA CAPAIAN KINERJA DAN SERAPAN ANGGARAN<br />KEMENTERIAN PERHUBUNGAN<br />TAHUN <?=$tahun1?> – <?=$tahun2?></h4>
        		<hr />
                <div class="row">
                	<h5 align="left" style="margin-left:20px;"><b>Rata-rata Capaian Kinerja (%)</b></h5>
                    
                    <div class="col-md-3" align="center">
                        <div class="alert alert-info">
                            <canvas id="gaugeCP<?=$tahun1?>"></canvas>
                        	<p><b><?=$tahun1?></b></p>
                        </div>
                    </div>
                    
                    <?php for($a=($tahun1+1); $a<=($tahun2-1);$a++):?>
                    <div class="col-md-2" align="center">
                        <div class="alert alert-info">
                            <canvas id="gaugeCP<?=$a?>"></canvas>
                            <p><b><?=$a?></b></p>
                        </div>
                    </div>
                    <?php endfor; ?>
                    
                    <div class="col-md-3" align="center">
                        <div class="alert alert-info">
                            <canvas id="gaugeCP<?=$tahun2?>"></canvas>
                            <p><b><?=$tahun2?></b></p>
                        </div>
                    </div> 
                               
                </div>
                    
                <div class="row">
                	<h5 align="left" style="margin-left:20px;"><b>Serapan Anggaran (%)</b></h5>
                    
                    <div class="col-md-3" align="center">
                        <div class="alert alert-success">
                            <canvas id="gaugeSP<?=$tahun1?>"></canvas>
                        	<p><b><?=$tahun1?></b></p>
                        </div>
                    </div>
                    
                    <?php for($a=($tahun1+1); $a<=($tahun2-1);$a++):?>
                    <div class="col-md-2" align="center">
                        <div class="alert alert-success">
                            <canvas id="gaugeSP<?=$a?>"></canvas>
                            <p><b><?=$a?></b></p>
                        </div>
                    </div>
                    <?php endfor; ?>
                    
                    <div class="col-md-3" align="center">
                        <div class="alert alert-success">
                            <canvas id="gaugeSP<?=$tahun2?>"></canvas>
                            <p><b><?=$tahun2?></b></p>
                        </div>
                    </div>
                     
                               
                </div>
                
        	</div>
        </section>
                               
        </section>
    </section>
    <!--main content end-->
    
<script>
	$(document).ready(function() {
	$('select').select2({minimumResultsForSearch: -1, width:'resolve'});
		
		<?php for($a=$tahun1; $a<=$tahun2; $a++):?>
		
			var gaugeCP<?=$a?> = new Gauge({
			renderTo  : 'gaugeCP<?=$a?>',
			width     : 130,
			height    : 120,
			glow      : true,
			units     : '%',
			minValue  : 0,
			maxValue  : 200,
			strokeTicks : false,
			valueFormat : { int : 2, dec : 0 },
			highlights : [{
				from  : 10,
				to    : 49,
				color : '#FF0000'
			}, {
				from  : 50,
				to    : 79,
				color : '#FFFF00'
			}, {
				from  : 80,
				to    : 100,
				color : '#00FF00'
			}, {
				from  : 101,
				to    : 200,
				color : '#0000A0'
			}],
			animation : {
				delay : 10,
				duration: 300,
				fn : 'bounce'
			}
		});
		
		<?php 
			if(isset($capaianKl[$a])): $nilai = $capaianKl[$a]; else: $nilai = "0"; endif;
		?>
		
		gaugeCP<?=$a?>.onready = function() {
			gaugeCP<?=$a?>.setValue("<?=$nilai?>");
		};
		gaugeCP<?=$a?>.draw();
		
		var gaugeSP<?=$a?> = new Gauge({
			renderTo  : 'gaugeSP<?=$a?>',
			width     : 130,
			height    : 120,
			glow      : true,
			units     : '%',
			minValue  : 0,
			maxValue  : 200,
			strokeTicks : false,
			valueFormat : { int : 2, dec : 0 },
			highlights : [{
				from  : 10,
				to    : 49,
				color : '#FF0000'
			}, {
				from  : 50,
				to    : 79,
				color : '#FFFF00'
			}, {
				from  : 80,
				to    : 100,
				color : '#00FF00'
			}, {
				from  : 101,
				to    : 200,
				color : '#0000A0'
			}],
			animation : {
				delay : 10,
				duration: 300,
				fn : 'bounce'
			}
		});
		
		<?php 
			if(isset($serapanKl[$a])): $nilai = $serapanKl[$a]; else: $nilai = "0"; endif;
		?>
		
		gaugeSP<?=$a?>.onready = function() {
			gaugeSP<?=$a?>.setValue("<?=$nilai?>");
		};
		gaugeSP<?=$a?>.draw();
		
		<?php endfor; ?>
		
	});
</script>	