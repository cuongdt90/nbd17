<?php
if (!defined('ABSPATH')) exit;
?>
<div class="nbdesigner_frontend_container">
    <p>
        <a class="button nbdesign-button nbdesigner-disable" id="triggerDesign" >
            <img class="nbdesigner-img-loading" src="<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/loading.gif' ?>"/>
            <?php _e('Start Design', 'web-to-print-online-designer'); ?>
        </a>
    </p>   
    <h4 id="nbdesigner-preview-title" style="display: none;"><?php _e('Preview your design', 'web-to-print-online-designer'); ?></h4>
    <div id="nbdesigner_frontend_area"></div>
</div>
<div style="position: fixed; top: 0; left: 0; z-index: 999999; opacity: 0; width: 100%; height: 100%;" id="container-online-designer">
    <iframe id="onlinedesigner-designer"  width="100%" height="100%" scrolling="no" frameborder="0" noresize="noresize" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" src="<?php echo $src; ?>"></iframe>
    <span id="closeFrameDesign"  class="nbdesigner_pp_close">&times;</span>
</div>
    