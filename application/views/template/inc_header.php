	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="e-Anev">
    
    <link rel="shortcut icon" href="<?=base_url()?>/favicon.ico">
    <title>.:: ANEV - Kementerian Perhubungan ::.</title>
    <link href="<?=base_url("static")?>/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/css/clndr.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/css/style.css" rel="stylesheet">
    <link href="<?=base_url("static")?>/css/style-responsive.css" rel="stylesheet"/>
    
    <?php switch($pg_aktif): 
		 	case "dashboard":?>
    
    		<link href="<?=base_url("static")?>/js/css3clock/css/style.css" rel="stylesheet">
    		<link rel="stylesheet" href="<?=base_url("static")?>/js/morris-chart/morris.css">
   		<?php break; ?>
        
        <?php case "datatables": ?>
    		<link href="<?=base_url("static")?>/js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    		<link rel="stylesheet" href="<?=base_url("static")?>/js/data-tables/DT_bootstrap.css" />
    	<?php break; ?>
        
    <?php endswitch; ?>
    <script src="<?=base_url("static")?>/js/jquery.js"></script>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="<?=base_url("static")?>/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->