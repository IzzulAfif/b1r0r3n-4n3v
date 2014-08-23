<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
       <!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Profil Unit Kerja</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#kl-content">
                               <i class="fa fa-list-ol"></i> Kementerian
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#e1-content">
                                <i class="fa fa-bar-chart-o"></i> Eselon I
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#e2-content">
                                <i class="fa fa-align-center"></i> Eselon II
                            </a>
                        </li>                        
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                      	<div class="panel-body tab-pane fade active in" id="kl-content"></div>
						<div class="panel-body tab-pane fade" id="e1-content"></div>
						<div class="panel-body tab-pane fade" id="e2-content"></div>
                </div>
            </section>
            <!--tab nav end-->
       
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			$("#kl-content").load("<?=base_url()?>laporan/profil_kl/loadprofile");
			$("#e1-content").load("<?=base_url()?>laporan/profil_eselon1/loadprofile");
			$("#e2-content").load("<?=base_url()?>laporan/profil_eselon2/loadprofile");
			
		});
	</script>