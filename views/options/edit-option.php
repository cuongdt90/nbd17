<?php if (!defined('ABSPATH')) exit; ?>
<?php
    $link = add_query_arg(array(
            'paged'    => $_GET['paged'],
            '_wpnonce'    => $_GET['_wpnonce']
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
    <?php if( $message['content'] != '' ){
        $message = nbd_custom_notices($message['flag'], $message['content']);
        echo $message;
    } ?>
</div>
<div class="wrap" ng-app="optionApp" ng-cloak>
    <div ng-controller="optionCtrl">
        <form name="post" action="" method="post" id="post">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <div id="titlediv">
                            <div id="titlewrap">
                                <label class="screen-reader-text" id="title-prompt-text" for="title">Enter title here</label>
                                <input type="text" name="title" size="30" value="<?php echo $options['title']; ?>" id="title" autocomplete="off">
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
                                                       id="tm_meta_priority" name="priority" class="meta-priority" min="1"
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
                                            <input name="save" type="submit" class="button button-primary button-large" id="publish"
                                                accesskey="p" value="<?php esc_attr_e( 'Update' ) ?>"/>                                        
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
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-editor-textcolor"></span> <?php _e('Text box', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-marker"></span> <?php _e('Radio', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-yes"></span> <?php _e('Check box', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-menu"></span></span> <?php _e('Dropdown', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-admin-settings"></span> <?php _e('Ranger slider', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-art"></span> <?php _e('Color swatch', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-grid-view"></span> <?php _e('Price matrix', 'web-to-print-online-designer'); ?></a>
                                    <a class="nbd-field-btn button-primary"><span class="dashicons dashicons-calendar-alt"></span></span> <?php _e('Date time', 'web-to-print-online-designer'); ?></a>
                                </div> 
                            </div>    
                        </div>
                        <div class="postbox">
                            <h2><?php _e('Printing options buider', 'web-to-print-online-designer'); ?></h2>
                            <div class="inside">
                                <div class="nbd-fields-builder">
                                    <?php include_once('quantity.php'); ?>
                                    <?php include_once('global_field.php'); ?>
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