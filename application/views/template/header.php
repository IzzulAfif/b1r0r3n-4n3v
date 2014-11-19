
<header class="header fixed-top clearfix">
   
    <!--logo start-->
    <div class="brand">
    
        <a href="<?=base_url()?>" class="logo">
            <img src="<?=base_url("static")?>/images/logo.png" alt="">
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    
    <div class="nav notify-row" id="top_menu">
    	<ul class="nav top-menu">
    		<li>
            	<img src="<?=base_url()?>static/images/title.gif" id="title-img" height="80" style="margin-top:-23px;"/>
            </li>
        </ul>
	</div>

    <div class="top-nav clearfix">
    
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="<?=base_url("static")?>/images/avatar1_small.jpg">
                    <span class="username">Nama User</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="#"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end 
            <li>
                <div class="toggle-right-box">
                    <div class="fa fa-bars"></div>
                </div>
            </li>-->
        </ul>
        
    </div>
</header>
