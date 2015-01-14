<!--main content start-->

        <!-- page start-->
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>TARGET CAPAIAN KINERJA <?=$unitkerja?></b><br>
						TAHUN <?=$periode?>
                        <span class="pull-right">
                            
                         </span> 
                    </header>
                    <div class="panel-body">
						
						<div id="detail_rencana" >
								<?=$data?>	
						</div>
						<div class="pull-right">
							<button type="button" class="btn btn-primary btn-sm" id=	"cetakpdf_detaile1"><i class="fa fa-print"></i> Cetak PDF</button>          
							<button type="button" class="btn btn-primary btn-sm hide" id="cetakexcel_detaile1"><i class="fa fa-download"></i> Ekspor Excel</button>
						</div>
                    </div>
                </section>
            </div>
        </div>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			$('#cetakpdf_detaile1').click(function(){				
				window.open('<?=base_url()?>laporan/renstra_eselon1/target_print_pdf/<?=$periode?>/<?=$e1?>','_blank');			
			});
		});
	</script>