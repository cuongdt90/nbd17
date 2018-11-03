<?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
?>
<div class="nbd-main-bar">
    <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="logo <?php if(!isset($image['0'])) echo ' logo-without-image'; ?>">
        <?php if(isset($image['0'])): ?>
        <img src="<?php echo $image['0'];?>" alt="online design">
        <?php else: ?>
        <?php _e('Home','web-to-print-online-designer'); ?>
        <?php endif; ?>
    </a>
    <i class="icon-nbd icon-nbd-menu menu-mobile"></i>
    <ul class="nbd-main-menu menu-left">
        <li class="menu-item item-edit">
            <span><?php _e('File','web-to-print-online-designer'); ?></span>
            <div class="sub-menu" data-pos="left">
                <ul>
                    <li class="sub-menu-item flex space-between item-import-file" ng-click="loadMyDesign(null, false)">
                        <span><?php _e('Open My Design','web-to-print-online-designer'); ?></span>
                        <small>{{ 'M-O' | keyboardShortcut }}</small>
                    </li>
                    <li class="sub-menu-item flex space-between item-import-file" ng-click="loadMyDesign(null, true)">
                        <span><?php _e('My Design in Cart','web-to-print-online-designer'); ?></span>
                        <small>{{ 'M-S-O' | keyboardShortcut }}</small>
                    </li>                    
                    <li class="sub-menu-item flex space-between item-import-file" ng-click="importDesign()">
                        <span><?php _e('Import Design','web-to-print-online-designer'); ?></span>
                        <small>{{ 'M-S-I' | keyboardShortcut }}</small>
                    </li>
                    <li class="sub-menu-item flex space-between" ng-click="exportDesign()">
                        <span><?php _e('Export Design','web-to-print-online-designer'); ?></span>
                        <small>{{ 'M-S-E' | keyboardShortcut }}</small>
                    </li>                 
                </ul>
            </div>
            <div id="nbd-overlay"></div>
        </li>
        <li class="menu-item item-edit">
            <span><?php _e('Edit','web-to-print-online-designer'); ?></span>
            <div class="sub-menu" data-pos="left">
                <ul>
                    <li class="sub-menu-item flex space-between" ng-click="clearAllStage()">
                        <span><?php _e('Clear all design','web-to-print-online-designer'); ?></span>
                        <small>{{ 'M-E' | keyboardShortcut }}</small>
                    </li>
                    <li ng-if="settings.nbdesigner_save_for_later == 'yes'" class="sub-menu-item flex space-between" ng-click="saveForLater()">
                        <span><?php _e('Save for later','web-to-print-online-designer'); ?></span>
                        <small>{{ 'M-S-S' | keyboardShortcut }}</small>
                    </li>                    
                </ul>
            </div>
            <div id="nbd-overlay"></div>
        </li>
        <li class="menu-item item-view">
            <span><?php _e('View','web-to-print-online-designer'); ?></span>
            <ul class="sub-menu" data-pos="left">
                <li class="sub-menu-item flex space-between" ng-click="settings.showRuler = !settings.showRuler" ng-class="settings.showRuler ? 'active' : ''">
                    <span class="title-menu"><?php _e('Ruler','web-to-print-online-designer'); ?></span>
                    <small>{{ 'M-R' | keyboardShortcut }}</small>
                </li>
                <li class="sub-menu-item flex space-between" ng-click="settings.showGrid = !settings.showGrid" ng-class="settings.showGrid ? 'active' : ''">
                    <span class="title-menu"><?php _e('Show grid','web-to-print-online-designer'); ?></span>
                    <small>{{ 'S-G' | keyboardShortcut }}</small>
                </li>
                <li class="sub-menu-item flex space-between" ng-click="settings.bleedLine = !settings.bleedLine" ng-class="settings.bleedLine ? 'active' : ''">
                    <span class="title-menu"><?php _e('Show bleed line','web-to-print-online-designer'); ?></span>
                    <small>{{ 'M-L' | keyboardShortcut }}</small>
                </li>
<!--                <li class="sub-menu-item flex space-between hover-menu active" data-animate="bottom-to-top">
                    <span class="title-menu"><?php _e('Snap to','web-to-print-online-designer'); ?></span>
                    <i class="icon-nbd icon-nbd-arrow-drop-down rotate-90"></i>
                    <div class="hover-sub-menu-item">
                        <ul>
                            <li class="active"><span class="title-menu"><?php _e('Layer','web-to-print-online-designer'); ?></span></li>
                            <li><span class="title-menu"><?php _e('Bounding','web-to-print-online-designer'); ?></span></li>
                            <li><span class="title-menu"><?php _e('Grid','web-to-print-online-designer'); ?></span></li>
                        </ul>
                    </div>
                </li>-->
		<li class="sub-menu-item flex space-between hover-menu" data-animate="bottom-to-top">
                    <span class="title-menu"><?php _e('Show warning','web-to-print-online-designer'); ?></span>
                    <i class="icon-nbd icon-nbd-arrow-drop-down rotate-90"></i>
                    <div class="hover-sub-menu-item">
                        <ul>
                            <li ng-click="settings.showWarning.oos = !settings.showWarning.oos" ng-class="settings.showWarning.oos ? 'active' : ''"><span class="title-menu"><?php _e('Out of stage','web-to-print-online-designer'); ?></span></li>
                            <li ng-click="settings.showWarning.ilr = !settings.showWarning.ilr" ng-class="settings.showWarning.ilr ? 'active' : ''"><span class="title-menu"><?php _e('Image low resolution','web-to-print-online-designer'); ?></span></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <div id="nbd-overlay"></div>
        </li>
        <?php if( $show_nbo_option ): ?>
        <li class="menu-item item-nbo-options" ng-click="getPrintingOptions()">
            <span><?php _e('Options','web-to-print-online-designer'); ?></span>
        </li>
        <?php endif; ?> 
    </ul>
    <ul class="nbd-main-menu menu-center">
        <li class="menu-item undo-redo" ng-click="undo()" ng-class="stages[currentStage].states.isUndoable ? 'in' : 'nbd-disabled'">
            <i class="icon-nbd-baseline-undo" style="font-size: 24px"></i>
            <span style="font-size: 12px;"><?php _e('Undo','web-to-print-online-designer'); ?></span>
        </li>
        <li class="menu-item undo-redo" ng-click="redo()" ng-class="stages[currentStage].states.isRedoable ? 'in' : 'nbd-disabled'">
            <i class="icon-nbd-baseline-redo" style="font-size: 24px"></i>
            <span style="font-size: 12px;"><?php _e('Redo','web-to-print-online-designer'); ?></span>
        </li>
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item item-title animated slideInDown animate700">
            <input type="text" name="title" class="title" placeholder="Title" ng-model="stages[currentStage].config.name"/>
        </li>
        <li ng-if="settings.nbdesigner_share_design == 'yes'" class="menu-item item-share nbd-show-popup-share animated slideInDown animate800" ng-click="saveData('share')"><i class="icon-nbd icon-nbd-share2"></i></li>
        <?php if( $task == 'create_template' ): ?>
        <li class="menu-item item-process animated slideInDown animate900" id="save-template" ng-click="loadTemplateCat()">
            <span><?php _e('Save Template','web-to-print-online-designer'); ?></span><i class="icon-nbd icon-nbd-arrow-upward rotate90"></i>
        </li>
        <?php else: ?>        
        <li class="menu-item item-process animated slideInDown animate900" data-overlay="overlay" ng-click="saveData()">
            <span><?php _e('Process','web-to-print-online-designer'); ?></span><i class="icon-nbd icon-nbd-arrow-upward rotate90"></i>
            <div class="sub-menu" data-pos="right" style="display: none;">
                <div class="main-sub-menu">
                    <div class="sub-header">
                        <span><?php _e('Product Option','web-to-print-online-designer'); ?></span>
                        <i class="icon-nbd-clear nbd-close-sub-menu"></i>
                    </div>
                    <div class="sub-body">
                        <select class="process-select">
                            <option value="pdf-standard"><span><?php _e('PDF-Standard','web-to-print-online-designer'); ?></span></option>
                            <option value="pdf-print"><span><?php _e('PDF-Standard','web-to-print-online-designer'); ?></span></option>
                            <option value="jpg"><span>JPG</span></option>
                            <option value="png"><span>PNG</span></option>
                        </select>
                    </div>
                    <div class="sub-footer">
                        <button class="nbd-button nbd-add-to-cart"><?php _e('Add To Cart','web-to-print-online-designer'); ?></button>
                        <i style="display: none" class="icon-nbd-info-circle nbd-show-popup-fileType nbd-hover-shadow"></i>
                    </div>
                </div>
            </div>
        </li>
        <?php endif; ?> 
    </ul>
</div>