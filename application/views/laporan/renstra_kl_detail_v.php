<!--main content start-->

        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Detail Perencanaan
                        <span class="pull-right">
                            
                         </span> 
                    </header>
                    <div class="panel-body">
						<!--<table class="display table table-bordered table-striped">
						<tr>
							<td width="30%">Sasaran</td>
							<td width="40%">Sasaran Strategis</td>
							<td width="30%">Indikator</td>
						</tr>
						<tr>
							<td rowspan="5"> sasaran 1</td>
							<td rowspan="3"> sastra 1</td>
							<td > iku 1</td>
						</tr>
						<tr>
							<td > iku 2</td>
						</tr>
						<tr>
							<td > iku 3</td>
						</tr>
						<tr>
							<td rowspan="3" > Sastra 2</td>
							<td > iku 21</td>
						</tr>
						<tr>
							<td > iku 22</td>
						</tr>
						</table> -->
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
				var kodekl = $('#kodekl').val();
				
				$("#detail_rencana").load("<?=base_url()?>laporan/renstra_kl/get_rencana_detail/"+tahun+"/"+kodekl);
				
			}
			
			//load_detail();
		});
	</script>