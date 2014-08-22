<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <?=$this->session->flashdata('msg')?>
                
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Rencana Strategis</b>
                        
                    </header>
					<div class="panel-body">
					<div id="controls-tabs">
						<div class="wrap_controls">
							<ul class="ullist controls " id="myTab" style="margin: 0px; padding: 0px; list-style-type: none;">
							<li  class="active">
								<a title="Rencana Strategis Kementerian" href="#kl-content" id="ullist_a_all" data-toggle="tab"  style="color: rgb(102, 102, 102); display: block; padding: 5px; font-size: inherit; text-decoration: none;"> <span>Kementerian</span></a>
							</li>
							<li class=""><a title="Rencana Strategis Eselon I" href="#e1-content" id="ullist_a_1" data-toggle="tab"  style="color: rgb(102, 102, 102); display: block; padding: 5px; font-size: inherit; text-decoration: none;"><span>Eselon I</span></a>
							</li>
							<li class=""><a title="Rencana Strategis Eselon II" href="#e2-content" id="ullist_a_2" data-toggle="tab"  style="color: rgb(102, 102, 102); display: block; padding: 5px; font-size: inherit; text-decoration: none;"><span>Eselon II</span></a>
							</li>							
							</ul>
							<div class="tab-content" id="myTabContent">
									
								<div class="panel-body tab-pane fade active in" id="kl-content">						
							
								</div>
								<div class="panel-body tab-pane fade" id="e1-content">						
							
								</div>
								<div class="panel-body tab-pane fade" id="e2-content">						
							
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
			
			$("#kl-content").load("<?=base_url()?>laporan/renstra_kl/loadprofile");
			$("#e1-content").load("<?=base_url()?>laporan/renstra_eselon1/loadprofile");
			$("#e2-content").load("<?=base_url()?>laporan/renstra_eselon2/loadprofile");
			$('#myTab a').click(function (e) {
				e.preventDefault();
				$(this).tab('show');
			})
			$('#myTab a:first').tab('show'); // Select first tab
		});
	</script>