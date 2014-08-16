
	
	<script src="<?=base_url("static")?>/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="<?=base_url("static")?>/bs3/js/bootstrap.min.js"></script>
	<script src="<?=base_url("static")?>/js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="<?=base_url("static")?>/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url("static")?>/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
	<script src="<?=base_url("static")?>/js/jquery.nicescroll.js"></script>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?=base_url("static")?>/js/flot-chart/excanvas.min.js"></script><![endif]-->
	<script src="<?=base_url("static")?>/js/skycons/skycons.js"></script>
	<script src="<?=base_url("static")?>/js/jquery.scrollTo/jquery.scrollTo.js"></script>
	<script src="<?=base_url("static")?>/js/jquery.easing.min.js"></script>
    <script src="<?=base_url("static")?>/js/jquery.customSelect.min.js" ></script>
	
	
    <?php switch($pg_aktif): 
		 	case "dashboard":?>
    	            
            <!--jQuery Flot Chart -->
            <script src="<?=base_url("static")?>/js/flot-chart/jquery.flot.js"></script>
            <script src="<?=base_url("static")?>/js/flot-chart/jquery.flot.tooltip.min.js"></script>
            <script src="<?=base_url("static")?>/js/flot-chart/jquery.flot.resize.js"></script>
            <script src="<?=base_url("static")?>/js/flot-chart/jquery.flot.pie.resize.js"></script>
            <script src="<?=base_url("static")?>/js/flot-chart/jquery.flot.animator.min.js"></script>
            <script src="<?=base_url("static")?>/js/flot-chart/jquery.flot.growraf.js"></script>
    		
            <script src="<?=base_url("static")?>/js/calendar/clndr.js"></script>
			<script src="<?=base_url("static")?>/js/underscore-min.js"></script>
			<script src="<?=base_url("static")?>/js/calendar/moment-2.2.1.js"></script>
			<script src="<?=base_url("static")?>/js/evnt.calendar.init.js"></script>
			<script src="<?=base_url("static")?>/js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
			<script src="<?=base_url("static")?>/js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>    	
			<script src="<?=base_url("static")?>/js/dashboard.js"></script>
    		<script src="<?=base_url("static")?>/js/gauge/gauge.js"></script>
            <script src="<?=base_url("static")?>/js/css3clock/js/css3clock.js"></script>
            <script src="<?=base_url("static")?>/js/morris-chart/morris.js"></script>
			<script src="<?=base_url("static")?>/js/morris-chart/raphael-min.js"></script>
			<script src="<?=base_url("static")?>/js/easypiechart/jquery.easypiechart.js"></script>
			<script src="<?=base_url("static")?>/js/sparkline/jquery.sparkline.js"></script>
        
    	<?php break; ?>
        <?php case "datatables": ?>
        
        	<script type="text/javascript" language="javascript" src="<?=base_url("static")?>/js/advanced-datatable/js/jquery.dataTables.js"></script>
			<script type="text/javascript" src="<?=base_url("static")?>/js/data-tables/DT_bootstrap.js"></script>
    		<script src="<?=base_url("static")?>/js/dynamic_table_init.js"></script>
            
   		<?php break; ?>
        <?php case "chart": ?>
        
        	<script type="text/javascript" src="<?=base_url("static")?>/js/highchart/highcharts.js"></script>
            <script type="text/javascript" src="<?=base_url("static")?>/js/highchart/highcharts-3d.js"></script>
            <script type="text/javascript" src="<?=base_url("static")?>/js/highchart/exporting.js"></script>
            
		<?php break; ?>
        
    <?php endswitch; ?>
    
    <!--common script init for all pages-->
	<script src="<?=base_url("static")?>/js/scripts.js"></script>