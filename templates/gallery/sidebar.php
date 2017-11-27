<div class="nbd-category nbd-sidebar-con">
    <p class="nbd-sidebar-h3"><?php _e('Design Category', 'web-to-print-online-designer'); ?></p>
    <?php
        $walker = new NBD_Category();
        echo "<ul>";
        echo call_user_func_array( array(&$walker, 'walk'), array($categories, 0, array()) );
        echo "</ul>";
    ?>
</div>    
<div class="nbd-designers nbd-sidebar-con">
    <p class="nbd-sidebar-h3"><?php _e('Designer', 'web-to-print-online-designer'); ?></p>
    <div style="padding: 14px;">
        <?php foreach( $designers as $designer ): 
            $link_designer = add_query_arg(array('id' => $designer['art_id']), getUrlPageNBD('designer'));
        ?>
        <a href="<?php echo $link_designer; ?>" class="nbd-tag"><span><?php echo $designer['art_name']; ?></span></a>        
        <?php endforeach; ?>
    </div>
</div>  
<div class="nbd-designers nbd-sidebar-con">
    <p class="nbd-sidebar-h3"><?php _e('Products', 'web-to-print-online-designer'); ?></p>
    <div style="padding: 14px;">
        <?php 
        
        foreach( $products as $product ): 
            //$link_designer = add_query_arg(array('id' => $designer['art_id']), getUrlPageNBD('designer'));
        ?>
        <a href="<?php echo $product['url']; ?>"><span><?php echo $product['name']; ?></span></a>        
        <?php endforeach; ?>        
    </div>
</div>