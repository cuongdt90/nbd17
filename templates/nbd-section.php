<?php
if (!defined('ABSPATH')) exit;
?>
<div class="nbdesigner_frontend_container">
    <p>
        <a class="button alt nbdesign-button nbdesigner-disable" id="triggerDesign" >
            <img class="nbdesigner-img-loading" src="<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/loading.gif' ?>"/>
            <?php _e('Start Design', 'web-to-print-online-designer'); ?>
        </a>
    </p>   
    <h4 id="nbdesigner-preview-title" style="display: none;"><?php _e('Custom design', 'web-to-print-online-designer'); ?></h4>
    <div id="nbd-actions" style="display: none;">
    <?php
        if( nbdesigner_get_option('nbdesigner_show_all_color') == 'yes' ):
    ?>
        <p>
            <a href="javascript:void(0)" onclick="NBDESIGNERPRODUCT.save_for_later()" class="button alt nbdesign-button nbd-save-for-later" id="nbd-save-for-later">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14">
                    <title>check2</title>
                    <path fill="#0085ba" d="M13.055 4.422c0 0.195-0.078 0.391-0.219 0.531l-6.719 6.719c-0.141 0.141-0.336 0.219-0.531 0.219s-0.391-0.078-0.531-0.219l-3.891-3.891c-0.141-0.141-0.219-0.336-0.219-0.531s0.078-0.391 0.219-0.531l1.062-1.062c0.141-0.141 0.336-0.219 0.531-0.219s0.391 0.078 0.531 0.219l2.297 2.305 5.125-5.133c0.141-0.141 0.336-0.219 0.531-0.219s0.391 0.078 0.531 0.219l1.062 1.062c0.141 0.141 0.219 0.336 0.219 0.531z"></path>
                </svg>
                <img class="nbd-save-loading hide" src="<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/loading.gif' ?>"/> 
                <?php _e('Save for later', 'web-to-print-online-designer'); ?>
            </a>
        </p>
    <?php endif; ?>
    <?php
        if( nbdesigner_get_option('nbdesigner_share_design') == 'yes' ):
    ?>  
        <p id="nbd-share-group">
            <a href="https://facebook.com/sharer/sharer.php?u=" target="_blank" class="nbd-social">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <title>facebook</title>
                    <path fill="#3b5998" d="M22.675 0h-21.351c-0.732 0-1.325 0.593-1.325 1.325v21.351c0 0.732 0.593 1.325 1.325 1.325h11.495v-9.294h-3.129v-3.621h3.129v-2.674c0-3.099 1.893-4.785 4.659-4.785 1.325 0 2.463 0.096 2.794 0.141v3.24h-1.92c-1.5 0-1.793 0.72-1.793 1.77v2.31h3.585l-0.465 3.63h-3.12v9.284h6.115c0.732 0 1.325-0.593 1.325-1.325v-21.351c0-0.732-0.593-1.325-1.325-1.325z"></path>
                </svg>           
            </a>
            <a href="https://plus.google.com/share?url=" class="nbd-social">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <title>google</title>
                    <path fill="#dc4e41" d="M7.635 10.909v2.618h4.335c-0.174 1.125-1.309 3.295-4.331 3.295-2.606 0-4.732-2.16-4.732-4.822s2.123-4.822 4.728-4.822c1.485 0 2.478 0.633 3.045 1.179l2.073-1.995c-1.331-1.245-3.056-1.995-5.115-1.995-4.226-0.002-7.638 3.418-7.638 7.634s3.414 7.635 7.635 7.635c4.41 0 7.332-3.097 7.332-7.461 0-0.501-0.054-0.885-0.12-1.264h-7.212zM24 10.909h-2.183v-2.182h-2.183v2.182h-2.181v2.181h2.182v2.182h2.19v-2.182h2.174z"></path>
                </svg>            
            </a>
            <a href="https://twitter.com/share?url=" target="_blank" class="nbd-social">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <title>twitter</title>
                    <path fill="#1da1f2" d="M24 4.557c-0.885 0.39-1.83 0.655-2.828 0.776 1.015-0.611 1.797-1.575 2.165-2.724-0.951 0.555-2.006 0.96-3.128 1.185-0.897-0.96-2.175-1.56-3.594-1.56-2.718 0-4.923 2.205-4.923 4.92 0 0.39 0.045 0.765 0.127 1.125-4.092-0.195-7.72-2.16-10.149-5.13-0.426 0.721-0.666 1.561-0.666 2.476 0 1.71 0.87 3.214 2.19 4.098-0.807-0.026-1.567-0.248-2.231-0.615v0.060c0 2.385 1.695 4.377 3.95 4.83-0.414 0.111-0.849 0.171-1.298 0.171-0.315 0-0.615-0.030-0.915-0.087 0.63 1.956 2.445 3.379 4.605 3.42-1.68 1.32-3.81 2.106-6.105 2.106-0.39 0-0.78-0.023-1.17-0.067 2.19 1.395 4.77 2.211 7.56 2.211 9.060 0 14.010-7.5 14.010-13.995 0-0.21 0-0.42-0.015-0.63 0.96-0.69 1.8-1.56 2.46-2.55z"></path>
                </svg>            
            </a>   
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=" target="_blank" class="nbd-social">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <title>linkedin</title>
                    <path fill="#0077b5" d="M20.448 20.453h-3.555v-5.569c0-1.329-0.027-3.037-1.851-3.037-1.852 0-2.136 1.446-2.136 2.94v5.667h-3.555v-11.453h3.414v1.56h0.045c0.477-0.9 1.638-1.85 3.37-1.85 3.6 0 4.267 2.37 4.267 5.456v6.282zM5.337 7.433c-1.143 0-2.064-0.926-2.064-2.065 0-1.137 0.921-2.063 2.064-2.063 1.14 0 2.064 0.925 2.064 2.063 0 1.14-0.926 2.065-2.064 2.065zM7.119 20.453h-3.564v-11.453h3.564v11.453zM22.224 0h-20.454c-0.978 0-1.77 0.774-1.77 1.73v20.541c0 0.956 0.792 1.729 1.77 1.729h20.453c0.978 0 1.777-0.774 1.777-1.73v-20.541c0-0.956-0.799-1.73-1.777-1.73z"></path>
                </svg>            
            </a>
            <a href="mailto:?subject=Check%20out%20my%20design!&body=" target="_blank" class="nbd-social">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <title>mail</title>
                    <path fill="#d14836" d="M24 4.5v15c0 0.851-0.649 1.5-1.5 1.5h-1.5v-13.612l-9 6.462-9-6.462v13.612h-1.5c-0.85 0-1.5-0.649-1.5-1.5v-15c0-0.425 0.162-0.8 0.43-1.068 0.27-0.272 0.646-0.432 1.070-0.432h0.499l10.001 7.25 10-7.25h0.5c0.424 0 0.799 0.162 1.069 0.432 0.269 0.268 0.431 0.644 0.431 1.068z"></path>
                </svg>            
            </a> 
        </p>
    <?php endif; ?>
    </div>    
    <div id="nbdesigner_frontend_area"></div>
    <h4 id="nbdesigner-upload-title" style="display: none;"><?php _e('Upload file', 'web-to-print-online-designer'); ?></h4>
    <div id="nbdesigner_upload_preview" style="margin-bottom: 15px;"></div>
    <?php if($extra_price != ''): ?>
    <p><?php _e('Extra price for design', 'web-to-print-online-designer'); ?> + <?php echo $extra_price; ?></p>
    <?php endif; ?>
</div>
<div style="position: fixed; top: 0; left: 0; z-index: 999999; opacity: 0; width: 100%; height: 100%;" id="container-online-designer">
    <iframe id="onlinedesigner-designer"  width="100%" height="100%" scrolling="no" frameborder="0" noresize="noresize" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" src="<?php echo $src; ?>"></iframe>
    <span id="closeFrameDesign"  class="nbdesigner_pp_close">&times;</span>
</div>
<style>
    a.nbd-save-for-later svg {
        display: none;
        margin-right: 5px;
    }
    a.nbd-save-for-later:focus {
        outline: none;
    }
    a.nbd-save-for-later.saved {
        pointer-events: none;
    }
    .nbd-social {
        width: 36px;
        height: 36px;
        display: inline-block;
        padding: 5px;
        border: 1px solid #ddd;
        margin: 0px;
        opacity: 0.8;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
        background: #fff;
        cursor: pointer;
    }    
    .nbd-save-loading {
        display: inline-block;
        margin-right: 5px;
    }
    .nbd-save-loading.hide {
        display: none;
    }
</style>
<script>
    var nbd_current_url = "<?php echo get_permalink($pid) ?>";
</script>