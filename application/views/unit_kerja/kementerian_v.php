<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
		<!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Unit Kerja Kementerian</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#id-content">
                               <i class="fa fa-list-ol"></i> Identitas dan Tugas Pokok Kementerian
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#fungsi-content">
                                <i class="fa fa-bar-chart-o"></i> Fungsi Kementerian
                            </a>
                        </li>
                        
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                       <div class="panel-body tab-pane fade active in" id="id-content"></div>
						<div class="panel-body tab-pane fade" id="fungsi-content"></div>
					</div>	
								
                </div>
				
            </section>
            <!--tab nav end-->
			
			
                
      
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			$("#id-content").load("<?=base_url()?>unit_kerja/anev_kl/loadidentitas");
			$("#fungsi-content").load("<?=base_url()?>unit_kerja/anev_kl/loadfungsi");
			
		
		});
	</script>