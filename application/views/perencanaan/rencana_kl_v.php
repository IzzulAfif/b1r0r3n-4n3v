<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Perencanaan Kementerian</b>
                        
                    </header>
					<div class="panel-body">
					<div id="controls-tabs">
						<div class="wrap_controls">
							<ul class="ullist controls " id="myTab" style="margin: 0px; padding: 0px; list-style-type: none;">
							<li  class="active">
								<a title="Visi Kementerian" href="#visi-content" id="ullist_a_all" data-toggle="tab"  style="color: rgb(102, 102, 102); display: block; padding: 5px; font-size: inherit; text-decoration: none;"> <span>Visi</span></a>
							</li>
							<li class=""><a title="Misi Kementerian" href="#misi-content" id="ullist_a_1" data-toggle="tab"  style="color: rgb(102, 102, 102); display: block; padding: 5px; font-size: inherit; text-decoration: none;"><span>Misi</span></a>
							</li>
							<li class=""><a title="Tujuan Kementerian" href="#tujuan-content" id="ullist_a_2" data-toggle="tab"  style="color: rgb(102, 102, 102); display: block; padding: 5px; font-size: inherit; text-decoration: none;"><span>Tujuan</span></a></li>							
							<li class=""><a title="Sasaran Kementerian" href="#sasaran-content" id="ullist_a_2" data-toggle="tab"  style="color: rgb(102, 102, 102); display: block; padding: 5px; font-size: inherit; text-decoration: none;"><span>Sasaran</span></a></li>							
							</ul>
							<div class="tab-content" id="myTabContent">
									
								<div class="panel-body tab-pane fade active in" id="visi-content">						
							
								</div>
								<div class="panel-body tab-pane fade" id="misi-content">						
							
								</div>
								<div class="panel-body tab-pane fade" id="tujuan-content">						
							
								</div>
								<div class="panel-body tab-pane fade" id="sasaran-content">						
							
								</div>
								
							
							</div>
						</div>
					</div>
					</div>				
					
				
                </section>
            </div>
        </div>
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			$("#visi-content").load("<?=base_url()?>perencanaan/rencana_kl/loadvisi");
			$("#misi-content").load("<?=base_url()?>perencanaan/rencana_kl/loadmisi");
			$("#tujuan-content").load("<?=base_url()?>perencanaan/rencana_kl/loadtujuan");
			$("#sasaran-content").load("<?=base_url()?>perencanaan/rencana_kl/loadsasaran");
			$('#myTab a').click(function (e) {
				e.preventDefault();
				$(this).tab('show');
			})
			$('#myTab a:first').tab('show'); // Select first tab
		});
	</script>