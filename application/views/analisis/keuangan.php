
	<section id="main-content" class="">
        <section class="wrapper">
       
            <!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Analisis dan Evaluasi Keuangan</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#kl-keuangan">
                               <i class="fa fa-list-ol"></i> Kementerian
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#es1-keuangan">
                                <i class="fa fa-list-ol"></i> Eselon I
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#es2-keuangan">
                                <i class="fa fa-list-ol"></i> Eselon II
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="kl-keuangan" class="tab-pane active"></div>
                        <div id="es1-keuangan" class="tab-pane "></div>
                        <div id="es2-keuangan" class="tab-pane "></div>
                    </div>
                </div>
            </section>
            <!--tab nav end-->
            
        </section>
    </section>
    
    <script  type="text/javascript" language="javascript">
		$(document).ready(function() {
				
			$("#kl-keuangan").load("<?=base_url()?>analisis/keuangan/kl");
			
		});
	</script>