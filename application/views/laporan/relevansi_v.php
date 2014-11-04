<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
        <!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Cascading Sasaran dan Indikator</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#ss-content">
                               <i class="fa fa-list-ol"></i> Cascading Sasaran Strategis
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#ii-content">
                                <i class="fa fa-bar-chart-o"></i> Cascading IKU/IKK
                            </a>
                        </li>  
						<li class="">
                            <a data-toggle="tab" href="#ssii-content">
                                <i class="fa fa-bar-chart-o"></i> Cascading Sasaran dan IKU/IKK
                            </a>
                        </li>                        
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                      	<div class="tab-pane fade active in" id="ss-content"></div>
						<div class="tab-pane fade" id="ii-content"></div>
						<div class="tab-pane fade" id="ssii-content"></div>
						
                </div>
            </section>
            <!--tab nav end-->
                
        
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {			
			$("#ss-content").load("<?=base_url()?>laporan/relevansi_sastra/loadpage");		
			$("#ii-content").load("<?=base_url()?>laporan/relevansi_iku/loadpage");		
			$("#ssii-content").load("<?=base_url()?>laporan/relevansi_sastraiku/loadpage");		
			
		});
	</script>