<!--main content start-->

        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>MATRIKS CAPAIAN PEMBANGUNAN SEKTOR TRANSPORTASI <?=$periode?></b>
                        <span class="pull-right">
                            
                         </span> 
                    </header>
                    <div class="panel-body">
						
                    <div id="detail_rencana" >
							<?=$data?>	
					</div>
                    <div class="pull-right">
					<button type="button" class="btn btn-primary btn-sm" id=	"cetakpdf_matriks"><i class="fa fa-print"></i> Cetak PDF</button>          
					<button type="button" class="btn btn-primary btn-sm" id="cetakexcel_matriks"><i class="fa fa-download"></i> Ekspor Excel</button>
				</div>
                    </div>
                </section>
            </div>
        </div>
    <!--main content end-->
	<script type='text/javascript'>
				$('#cetakpdf_matriks').click(function(){				
				window.open('<?=base_url()?>laporan/matriks_pembangunan/print_pdf/<?=$renstra?>/<?=$rentang_awal?>/<?=$rentang_akhir?>/<?=$kl?>','_blank');			
			});
			</script>
		