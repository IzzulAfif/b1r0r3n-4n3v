
	<section id="main-content" class="">
        <section class="wrapper">
       
            <!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Analisis dan Evaluasi Capaian Program</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#list-konten">
                               <i class="fa fa-list-ol"></i> List
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#trendline-konten">
                                <i class="fa fa-bar-chart-o"></i> Trendline
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#section-konten">
                                <i class="fa fa-align-center"></i> Cross Section
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#korelasi-konten">
                                <i class="fa fa-clipboard"></i> Korelasi
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="list-konten" class="tab-pane active"></div>
                        <div id="trendline-konten" class="tab-pane"></div>
                        <div id="section-konten" class="tab-pane"></div>
                        <div id="korelasi-konten" class="tab-pane"></div>
                    </div>
                </div>
            </section>
            <!--tab nav end-->
            
        </section>
    </section>
    
    <script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			
			$("#list-konten").load("<?=base_url()?>evaluasi/program");
			$("#trendline-konten").load("<?=base_url()?>analisis/trendline/eselon1");
			$("#section-konten").load("<?=base_url()?>analisis/cross_section/eselon1");
			$("#korelasi-konten").load("<?=base_url()?>analisis/korelasi/eselon1");
			
		});
	</script>