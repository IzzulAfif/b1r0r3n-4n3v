<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		
       <!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Pemrograman Eselon II</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#kegiatan-content">
                               <i class="fa fa-list-ol"></i> Kegiatan Eselon II 
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#saskeg-content">
                                <i class="fa fa-bar-chart-o"></i> Sasaran Kegiatan Eselon II
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#ikk-content">
                                <i class="fa fa-align-center"></i> IKK Eselon II
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#pendanaan-content">
                                <i class="fa fa-clipboard"></i> Pendanaan Eselon II
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
						<div class="panel-body tab-pane fade active in" id="kegiatan-content"></div>
						<div class="panel-body tab-pane fade" id="saskeg-content"></div>
						<div class="panel-body tab-pane fade" id="ikk-content"></div>
						<div class="panel-body tab-pane fade" id="pendanaan-content"></div>
                </div>
            </section>
            <!--tab nav end-->
       
        </section>
    </section>
    <!--main content end-->
	
	<script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			$("#kegiatan-content").load("<?=base_url()?>pemrograman/pemrograman_eselon2/loadkegiatan");
			$("#saskeg-content").load("<?=base_url()?>pemrograman/pemrograman_eselon2/loadsaskeg");
			$("#ikk-content").load("<?=base_url()?>pemrograman/pemrograman_eselon2/loadikk");
			//$("#pendanaan-content").load("<?=base_url()?>pemrograman/pemrograman_eselon1/loadpendanaan");
			
		});
	</script>