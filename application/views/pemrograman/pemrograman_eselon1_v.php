<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
       <!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Pemrograman Eselon I</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#program-content">
                               <i class="fa fa-list-ol"></i> Program
                            </a>
                        </li>
                        <!--<li class="">
                            <a data-toggle="tab" href="#sasprog-content">
                                <i class="fa fa-bar-chart-o"></i> Sasaran Program
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#iku-content">
                                <i class="fa fa-align-center"></i> IKU
                            </a>
                        </li>-->
                        <li class="">
                            <a data-toggle="tab" href="#target-content">
                                <i class="fa fa-clipboard"></i> Target Capaian Kinerja
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#pendanaan-content">
                                <i class="fa fa-clipboard"></i> Kebutuhan Pendanaan
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
						<div class="panel-body tab-pane fade active in" id="program-content"></div>
						<!--<div class="panel-body tab-pane fade" id="sasprog-content"></div>
						<div class="panel-body tab-pane fade" id="iku-content"></div>-->
                        <div class="panel-body tab-pane fade" id="target-content"></div>
						<div class="panel-body tab-pane fade" id="pendanaan-content"></div>
                </div>
            </section>
            <!--tab nav end-->
       
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			$("#program-content").load("<?=base_url()?>pemrograman/pemrograman_eselon1/loadprogram");
			$("#target-content").load("<?=base_url()?>pemrograman/pemrograman_eselon1/loadtarget");
			$("#pendanaan-content").load("<?=base_url()?>pemrograman/pemrograman_eselon1/loadpendanaan");
			//$("#pendanaan-content").load("<?=base_url()?>pemrograman/pemrograman_eselon1/loadpendanaan");
			
		});
	</script>