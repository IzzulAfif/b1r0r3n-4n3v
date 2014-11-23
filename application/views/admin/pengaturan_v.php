<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
		<!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Pengaturan</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#tahun-content">
                               <i class="fa fa-calendar"></i> Tahun Renstra
                            </a>
                        </li>   
						<li class="">
                            <a data-toggle="tab" href="#webservice-content">
                               <i class="fa fa-rss"></i> Web Service
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#info-content">
                               <i class="fa fa-clipboard"></i> Home Info
                            </a>
                        </li>                        
                        
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                       <div class="tab-pane fade active in" id="tahun-content"></div>
					   <div class="tab-pane fade" id="webservice-content"></div>
                       <div class="tab-pane fade" id="info-content"></div> 
					</div>	
								
                </div>
				
            </section>
            <!--tab nav end-->
			
			
                
      
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			$("#tahun-content").load("<?=base_url()?>admin/pengaturan/loadtahunrenstra");
			$("#webservice-content").load("<?=base_url()?>admin/pengaturan/loadwebservice");
			$("#info-content").load("<?=base_url()?>admin/pengaturan/loadinfo");
		});	
		
	</script>