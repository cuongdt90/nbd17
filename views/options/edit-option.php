<?php if (!defined('ABSPATH')) exit; ?>
<?php
    $link = add_query_arg(array(
            'paged'    => $_GET['paged']
        ), admin_url('admin.php?page=nbd_printing_options')); 
    $link_update = add_query_arg(array(
            'action' => 'update',
            'id'  =>  $options['id'],
        ), admin_url('admin.php?page=nbd_printing_options')); 
    $link_delete = add_query_arg(array(
            'action' => 'delete'
        ), $link);  
    wp_enqueue_media();
?>
<script type="text/javascript">
    var NBDOPTIONS = <?php echo json_encode($options); ?>;
    var NBDOPTION_FIELD = <?php echo json_encode($default_field); ?>;
</script>
<div class="wrap">
    <h2>
        <?php _e('Edit Global Options', 'web-to-print-online-designer'); ?>
    </h2>
</div>    
<div class="message">
    <?php if( isset($message['flag']) ){
        $message = nbd_custom_notices($message['flag'], $message['content']);
        echo $message;
    } ?>
</div>
<div class="wrap" ng-app="optionApp" ng-cloak>
    <div ng-controller="optionCtrl">
        <form name="nboForm" action="" method="post" id="post">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <div id="titlediv">
                            <div id="titlewrap">
                                <label class="screen-reader-text" id="title-prompt-text" for="title">Enter title here</label>
                                <input required="required" ng-model="options.title" type="text" name="title" size="30" value="<?php echo $options['title']; ?>" id="title" autocomplete="off">
                                <span style="color: red;" ng-show="nboForm.title.$invalid">* <small><i><?php _e('required', 'web-to-print-online-designer'); ?></i></small></span>
                            </div>
                        </div>
                    </div>
                    <div id="postbox-container-1" class="postbox-container">
                        <div id="submitdiv" class="postbox ">
                            <h2 class="hndle ui-sortable-handle"><span><?php _e('Publish', 'web-to-print-online-designer'); ?></span></h2>
                            <div class="inside">
                                <div class="submitbox" id="submitpost">
                                    <div id="minor-publishing">
                                        <div id="misc-publishing-actions">
                                            <div class="misc-pub-section misc-pub-priority" id="priority">
                                                <?php _e('Priority', 'web-to-print-online-designer'); ?>
                                                <input type="number" value="<?php echo $options['priority']; ?>" maxlength="3"
                                                    id="nbo_meta_priority" name="priority" class="meta-priority" min="1"
                                                    step="1"/>                                    
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>   
                                    <div id="major-publishing-actions">
                                        <div id="delete-action">
                                            <a class="submitdelete deletion"
                                               href="<?php echo $link_delete; ?>"><?php _e('Move to Trash', 'web-to-print-online-designer'); ?></a>                                 
                                        </div>   
                                        <div id="publishing-action">
                                            <?php if( $product_id > 0 ): ?>
                                            <input type="hidden" name="product_ids" value="<?php echo $product_id; ?>"/>
                                            <?php endif; ?>
                                            <input ng-disabled="!nboForm.$valid" name="save" type="submit" class="button button-primary button-large" id="publish"
                                                accesskey="p" value="<?php if($id != 0){ esc_attr_e( 'Update' ); }else{ esc_attr_e( 'Publish' ); }; ?>"/>                                        
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <div id="postbox-container-2" class="postbox-container">
                        <div class="postbox">
                            <div class="inside">
                                <div class="nbd-option-actions">
                                    <a class="button-primary"><span class="dashicons dashicons-plus"></span> <?php _e('Add section', 'web-to-print-online-designer'); ?></a>
                                    <span class="nbdesigner-right">
                                        <a class="button-primary"><span class="dashicons dashicons-migrate nbd-r180"></span> <?php _e('Import CSV', 'web-to-print-online-designer'); ?></a>
                                        <a class="button-primary"><span class="dashicons dashicons-migrate"></span> <?php _e('Export CSV', 'web-to-print-online-designer'); ?></a>
                                    </span>
                                </div> 
                            </div>    
                        </div>                    
                        <div class="postbox nbd-fields-wrap"> 
                            <h2><?php _e('Printing fields', 'web-to-print-online-designer'); ?></h2>
                            <div class="inside">
                                <div class="nbd-fields-picker">
                                    <a class="nbd-field-btn button-primary"><?php _e('Quantity', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><?php _e('Sides/Pages', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><?php _e('Color', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><?php _e('Size', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><?php _e('DPI', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><?php _e('Area design shape', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><?php _e('Time delivery', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><?php _e('Other', 'web-to-print-online-designer'); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2><?php _e('Printing options buider', 'web-to-print-online-designer'); ?></h2>
                            <div class="inside">
                                <div class="nbd-fields-builder">
                                    <?php include_once('quantity.php'); ?>
                                    <?php include_once('field.php'); ?>
                                </div>
                            </div>    
                        </div>                    
                    </div>                
                </div>
            </div>
            <div class="clear"></div>
        </form> 
        <div class="debug" ng-click="debug()">
            <span class="dashicons dashicons-hammer"></span>
        </div>       
        <?php include_once('preview.php'); ?>
        <?php include_once('price_matrix.php'); ?>
    </div>    
</div>