<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_merchant_screen extends ecjia_screen {
    
    public function render_screen_meta() {
        
        // Time to render!
        if (!empty($this->_nav_here)) :
        ?>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo RC_Uri::url('merchant/dashboard/init');?>">管理主页</a></li>
            <?php
			foreach ($this->_nav_here as $nav_here) :
			    if (end($this->_nav_here) === $nav_here) {
                    $last_css = ' class="active"';
                }
				if ($nav_here->get_link()) :
            ?>
			<li<?php echo $last_css;?>><a href="<?php echo $nav_here->get_link();?>"><?php echo $nav_here->get_label();?></a></li>
            <?php else : ?>
            <li<?php echo $last_css;?>><?php echo $nav_here->get_label();?></li>
            <?php
		       endif;
		   endforeach;
			?>
        </ol>
        
        <?php 
        endif;
    }
}

// end