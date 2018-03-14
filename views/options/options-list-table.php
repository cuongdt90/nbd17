<?php if (!defined('ABSPATH')) exit; ?>
<div class="wrap">
    <h1 class="nbd-title">
        <?php _e('Printing options', 'web-to-print-online-designer'); ?>
    </h1>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                    <?php
                        $nbd_options->prepare_items();
                        $nbd_options->display();
                    ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>    
</div>
