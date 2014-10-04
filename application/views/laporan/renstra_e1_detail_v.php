<!--main content start-->

        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Detail Perencanaan</b>
                        <span class="pull-right">
                            
                         </span> 
                    </header>
                    <div class="panel-body">
						
                    <div id="detail_rencana" >
							<?=$data?>	
					</div>
                    
                    </div>
                </section>
            </div>
        </div>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			load_detail = function(){
				var tahun = $('#tahun').val();
				var kodekl = $('#kodee1').val();
				
				$("#detail_rencana").load("<?=base_url()?>laporan/renstra_eselon1/get_rencana_detail/"+tahun+"/"+kodekl);
				
			}
			
			//load_detail();
		});
	</script>