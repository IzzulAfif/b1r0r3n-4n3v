<!--
 @author     : Didin
 @date       : 2014-08-12 23:30
 @revision	 :
-->    
    
    <?php
		$menu	= $this->mgeneral->getWhere(array('hide'=>"0"),"anev_menu","menu_id","ASC");
		foreach($menu as $m):
			if($m->menu_parent==""):
				$menuUtama[] = $m;
			else:
				$subMenu[$m->menu_parent][] = $m;
			endif;
		endforeach;	
	?>
    
    <aside>
    	<div id="sidebar" class="nav-collapse">
            
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion">
                	
					<?php foreach($menuUtama as $mu): 
						if(count($subMenu[$mu->menu_id])!=0): 
							$clsMenu = "sub-menu"; 
							$link	 = "javascript:;";
						else: 
							$clsMenu = ""; 
							$link	 = base_url()."".$mu->url;
						endif;
					?>
                    
						<li class="<?=$clsMenu?>">
                        	<?php if($cur_menu==$mu->menu_group): $aktif='class="active"'; else: $aktif=""; endif; ?>
                            <a href="<?=$link?>" <?=$aktif?> ><i class="fa <?=$mu->icon?>"></i> <span><?=$mu->menu_name?></span></a>
                            <?php 
								if($clsMenu!=""):
									echo '<ul class="sub">'; 
									foreach($subMenu[$mu->menu_id] as $sm):
							?>
                            			<li><a href="<?=base_url()."".$sm->url?>"><?=$sm->menu_name?></a></li>
                            <?php 
									endforeach;
									echo '</ul>';
								endif;
							?>
								
                        </li>	
					<?php endforeach;?>
                </ul>            
            </div>
            
        </div>
    </aside>
