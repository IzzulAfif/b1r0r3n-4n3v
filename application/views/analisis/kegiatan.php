
	<section id="main-content" class="">
        <section class="wrapper">
       
            <!--tab nav start-->
            <section class="panel">
                <header class="panel-heading tab-bg-light tab-right ">
                	<p class="pull-left"><b>Analisis dan Evaluasi Kegiatan</b></p>
                    <ul class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#list-konten">
                               <i class="fa fa-list-ol"></i> List
                            </a>
                        </li>
						<li class="">
                            <a data-toggle="tab" href="#detail-konten">
                                <i class="fa fa-bars"></i> Detail
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#peta-konten">
                                <i class="fa fa-camera-retro"></i> Map
                            </a>
                        </li> 
						
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="list-konten" class="tab-pane active"></div>
                        <div id="peta-konten" class="tab-pane "></div>
                        <div id="detail-konten" class="tab-pane "></div>
                    </div>
                </div>
            </section>
            <!--tab nav end-->
            
        </section>
    </section>
    
    <script  type="text/javascript" language="javascript">
		$(document).ready(function() {
			//list isinya diganti , yg lama dipindah ke tab detail	
			$("#detail-konten").load("<?=base_url()?>analisis/kegiatan/data");
			$("#peta-konten").load("<?=base_url()?>analisis/kegiatan/map");
			
		});
	</script>