<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
		<!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Ekstrak Data</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#eperformance-content">
                               <i class="fa fa-cogs"></i> E-Performance
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#emon-content">
                                <i class="fa fa-bar-chart-o"></i> E-Monitoring
                            </a>
                        </li>
                        
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                       <div class="tab-pane fade active in" id="eperformance-content"></div>
						<div class="tab-pane fade" id="emon-content"></div>
					</div>	
								
                </div>
				
            </section>
            <!--tab nav end-->
			
			
                
      
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			$("#emon-content").load("<?=base_url()?>admin/ekstrak/loademon");
			$("#eperformance-content").load("<?=base_url()?>admin/ekstrak/loadeperformance");
			
		
		});
		
		
		
	</script>