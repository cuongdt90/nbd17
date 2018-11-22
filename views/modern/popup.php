<div class="nbd-popup popup-share" data-animate="scale">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <div class="overlay-main active">
            <div class="loaded">
                <svg class="circular" viewBox="25 25 50 50" style="width: 40px;height: 40px;">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
            <h2><?php _e('Share this design','web-to-print-online-designer'); ?></h2>
        </div>
        <div class="body">
            <div class="share-with">
                <span><?php _e('Share with','web-to-print-online-designer'); ?>:</span>
                <ul class="socials">
                    <li ng-click="createShareLink('facebook', 'https://facebook.com/sharer/sharer.php?u=')" class="social facebook"><i class="icon-nbd icon-nbd-facebook-circle nbd-hover-shadow"></i></li>
                    <li ng-click="createShareLink('twitter', 'https://twitter.com/share?url=')" class="social twitter"><i class="icon-nbd icon-nbd-twitter-circle nbd-hover-shadow"></i></li>
                    <li ng-click="createShareLink('google', 'https://plus.google.com/share?url=')" class="social google-plus"><i class="icon-nbd icon-nbd-google-plus-circle nbd-hover-shadow"></i></li>
                </ul>
            </div>
            <div class="share-content">
                <textarea ng-change="updateShareLink()" placeholder="<?php _e('Write a comment'); ?>" ng-model="resource.social.comment"></textarea>
            </div>
            <div class="share-btn">
                <a href="{{resource.social.link}}" target="_blank" ng-class="resource.social.link != '' ? '' : 'nbd-disabled'" class="nbd-button nbd-hover-shadow"><?php _e('Share now','web-to-print-online-designer'); ?></a>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>
<div class="nbd-popup popup-webcam" data-animate="top-to-bottom">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
        </div>
        <div class="body">
            <div id="my_camera">
                <i class="icon-nbd icon-nbd-webcam"></i>
            </div>
        </div>
        <div class="footer">
            <div class="nbd-list-button">
                <button ng-click="pauseWebcam(true)" ng-class="resource.webcam.status ? '' : 'nbd-disabled'" class="nbd-button"><?php _e('Pause','web-to-print-online-designer'); ?></button>
                <button ng-click="pauseWebcam(false)" ng-class="resource.webcam.status ? '' : 'nbd-disabled'" class="nbd-button"><?php _e('Resume','web-to-print-online-designer'); ?></button>
                <button ng-click="resetWebcam()" class="nbd-button"><?php _e('Stop Webcam','web-to-print-online-designer'); ?></button>
                <button ng-click="takeSnapshot()" ng-class="resource.webcam.status ? '' : 'nbd-disabled'" class="nbd-button"><?php _e('Capture','web-to-print-online-designer'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="nbd-popup popup-keyboard" data-animate="fixed-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
            <div class="nbd-tab-nav">
                <ul class="nbd-tabs">
                    <li class="nbd-tab active" data-tab="nbd-keyboard-shortcut">
                        <span class="title"><?php _e('Keyboard shortcuts','web-to-print-online-designer'); ?></span>
                    </li>
                    <li class="nbd-tab" data-tab="nbd-keyboard-about">
                        <span class="title"><?php _e('About','web-to-print-online-designer'); ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="body">
            <div class="main-body">
                <div class="nbd-tab-contents">
                    <div class="tab-scroll">
                        <div id="nbd-keyboard-shortcut" class="nbd-tab-content active">
                            <table class="keyboard-mapping">
                                <tbody>
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>A</kbd>
                                    </td>
                                    <td><?php _e('Select all layers','web-to-print-online-designer'); ?></td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>D</kbd>
                                    </td>
                                    <td><?php _e('Deselect all layers','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>E</kbd>
                                    </td>
                                    <td><?php _e('Clear all layers','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Z</kbd>
                                    </td>
                                    <td><?php _e('Undo changes','web-to-print-online-designer'); ?></td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Y</kbd>
                                    </td>
                                    <td><?php _e('Redo changes','web-to-print-online-designer'); ?></td>
                                </tr>   
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>L</kbd>
                                    </td>
                                    <td><?php _e('Show/hide Bleed line','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>R</kbd>
                                    </td>
                                    <td><?php _e('Show/hide Ruler','web-to-print-online-designer'); ?></td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>H</kbd>
                                    </td>
                                    <td><?php _e('Align layer horizontal center','web-to-print-online-designer'); ?></td>
                                </tr>   
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>V</kbd>
                                    </td>
                                    <td><?php _e('Align layer vertical center','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>+</kbd>
                                    </td>
                                    <td><?php _e('Zoom In stage','web-to-print-online-designer'); ?></td>
                                </tr>   
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>-</kbd>
                                    </td>
                                    <td><?php _e('Zoom Out stage','web-to-print-online-designer'); ?></td>
                                </tr>     
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>0</kbd>
                                    </td>
                                    <td><?php _e('Fit stage with viewport','web-to-print-online-designer'); ?></td>
                                </tr>   
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>1</kbd>
                                    </td>
                                    <td><?php _e('Resize stage to real size','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>]</kbd>
                                    </td>
                                    <td><?php _e('Bring layer forward','web-to-print-online-designer'); ?></td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>[</kbd>
                                    </td>
                                    <td><?php _e('Bring layer backward','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>O</kbd>
                                    </td>
                                    <td><?php _e('Load your designs','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>O</kbd>
                                    </td>
                                    <td><?php _e('Load your designs','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>B</kbd>
                                    </td>
                                    <td><?php _e('Make your text bold','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>I</kbd>
                                    </td>
                                    <td><?php _e('Italicize your text','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>G</kbd>
                                    </td>
                                    <td><?php _e('Group layers','web-to-print-online-designer'); ?></td>
                                </tr>                                 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>P</kbd>
                                    </td>
                                    <td><?php _e('Duplicate layers','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Alt</kbd> +<kbd>U</kbd>
                                    </td>
                                    <td><?php _e('Make your text UPPERCASE','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Alt</kbd> +<kbd>L</kbd>
                                    </td>
                                    <td><?php _e('Make your text lowercase','web-to-print-online-designer'); ?></td>
                                </tr>                                 
                                <tr>
                                    <td class="keys">
                                        <kbd>Alt</kbd> +<kbd>←</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to left 1px','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Alt</kbd> +<kbd>→</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to right 1px','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Alt</kbd> +<kbd>↑</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to top 1px','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Alt</kbd> +<kbd>↓</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to bottom 1px','web-to-print-online-designer'); ?></td>
                                </tr>   
                                <tr>
                                    <td class="keys">
                                        <kbd>Alt</kbd> +<kbd><i style="color: #404762" class="icon-nbd icon-nbd-arrows-v rotate-45"></i></kbd>
                                    </td>
                                    <td><?php _e('Free transform','web-to-print-online-designer'); ?></td>
                                </tr>                                 
                                <tr>
                                    <td class="keys">
                                        <kbd>Shift</kbd> +<kbd>+</kbd>
                                    </td>
                                    <td><?php _e('Zoom out selected layers','web-to-print-online-designer'); ?></td>
                                </tr>    
                                <tr>
                                    <td class="keys">
                                        <kbd>Shift</kbd> +<kbd>-</kbd>
                                    </td>
                                    <td><?php _e('Zoom in selected layer','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Shift</kbd> +<kbd>G</kbd>
                                    </td>
                                    <td><?php _e('Show/hide Grid','web-to-print-online-designer'); ?></td>
                                </tr>    
                                <tr>
                                    <td class="keys">
                                        <kbd>Shift</kbd> +<kbd>L</kbd>
                                    </td>
                                    <td><?php _e('Clear all guidelines','web-to-print-online-designer'); ?></td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Shift</kbd> +<kbd><i style="color: #404762" class="icon-nbd icon-nbd-arrows-v rotate-45"></i></kbd>
                                    </td>
                                    <td><?php _e('Centered scaling','web-to-print-online-designer'); ?></td>
                                </tr>                                
                                <tr>
                                    <td class="keys">
                                        <kbd>←</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to left 10px','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>→</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to right 10px','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>↑</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to top 10px','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>↓</kbd>
                                    </td>
                                    <td><?php _e('Move the selected layers to bottom 10px','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Delete</kbd>
                                    </td>
                                    <td><?php _e('Delete selected layers','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>V</kbd>
                                    </td>
                                    <td><?php _e('Disable drawing mode','web-to-print-online-designer'); ?></td>
                                </tr>     
                                <tr>
                                    <td class="keys">
                                        <kbd>B</kbd>
                                    </td>
                                    <td><?php _e('Enable drawing mode','web-to-print-online-designer'); ?></td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Esc</kbd>
                                    </td>
                                    <td><?php _e('Quit text editing','web-to-print-online-designer'); ?></td>
                                </tr>                                
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>]</kbd>
                                    </td>
                                    <td><?php _e('Bring layer to front','web-to-print-online-designer'); ?></td>
                                </tr> 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>[</kbd>
                                    </td>
                                    <td><?php _e('Send layer to back','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>I</kbd>
                                    </td>
                                    <td><?php _e('Import Design','web-to-print-online-designer'); ?></td>
                                </tr>     
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>E</kbd>
                                    </td>
                                    <td><?php _e('Export Design','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>S</kbd>
                                    </td>
                                    <td><?php _e('Save Design for later','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>O</kbd>
                                    </td>
                                    <td><?php _e('Load Your Design in Cart','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>G</kbd>
                                    </td>
                                    <td><?php _e('Ungroup','web-to-print-online-designer'); ?></td>
                                </tr>                                 
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>L</kbd>
                                    </td>
                                    <td><?php _e('Clear all stages','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>&lt;</kbd>
                                    </td>
                                    <td><?php _e('Decreate font size','web-to-print-online-designer'); ?></td>
                                </tr>  
                                <tr>
                                    <td class="keys">
                                        <kbd>Ctrl</kbd> +<kbd>Shift</kbd> +<kbd>&gt;</kbd>
                                    </td>
                                    <td><?php _e('Increate font size','web-to-print-online-designer'); ?></td>
                                </tr>                                 
                                </tbody>
                            </table>
                        </div>
                        <div id="nbd-keyboard-about" class="nbd-tab-content">
                            <div class="text-center" style="margin-bottom: 40px; margin-top: 20px">
                                <?php if(isset($image['0'])): ?>
                                <img src="<?php echo $image['0'];?>" alt="online design">
                                <?php else: ?>
                                <?php echo get_bloginfo( 'name' ); ?>
                                <?php endif; ?>
                            </div>
                            <div class="copy-right">
                                <p class="text-center">Copyright © <script>document.write(new Date().getFullYear())</script>. <?php echo get_bloginfo( 'name' ); ?></p>
                                <p class="text-center">All Rights Reserved</p>
                                <p class="text-center">Powered by <a href="https://cmsmart.net/wordpress-plugins/woocommerce-online-product-designer-plugin" target="_blank">NBDesigner</a> version <?php echo NBDESIGNER_VERSION; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>
<div class="nbd-popup popup-fileType" data-animate="bottom-to-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head"></div>
        <div class="body">
            <div class="main-body"></div>
        </div>
        <div class="footer"></div>
    </div>
</div>
<div class="nbd-popup popup-term" data-animate="fixed-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head"><?php _e('Image upload terms','web-to-print-online-designer'); ?></div>
        <div class="body">
            <div class="main-body">
                <?php echo stripslashes(nbdesigner_get_option('nbdesigner_upload_term')); ?>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>
<div class="nbd-popup popup-select clear-stage-alert" data-animate="scale">
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
            <?php _e('Delete All Layers','web-to-print-online-designer'); ?>
        </div>
        <div class="body">
            <div class="main-body">
                <span class="title"><?php _e('Are you sure you want to delete all layers?','web-to-print-online-designer'); ?></span>
                <div class="main-select">
                    <button ng-click="closePopupClearStage()" class="nbd-button select-no"><i class="icon-nbd icon-nbd-clear"></i> <?php _e('No','web-to-print-online-designer'); ?></button>
                    <button ng-click="clearStage()" class="nbd-button select-yes"><i class="icon-nbd icon-nbd-fomat-done"></i> <?php _e('Yes','web-to-print-online-designer'); ?></button>
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>
<?php if( $task == 'create_template' ): ?>
<div class="nbd-popup popup-template" data-animate="bottom-to-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="overlay-main active">
            <div class="loaded">
                <svg class="circular" viewBox="25 25 50 50" style="width: 40px;height: 40px;">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
        <div class="head">
            <h2 style="font-size: 18px;margin: 0;margin-bottom: 20px;font-weight: bold;text-transform: uppercase;"><?php _e('Save this template','web-to-print-online-designer'); ?></h2>
        </div>
        <div class="body">
            <div class="main-body">
                <div>
                    <label style="min-width: 200px;" for="category_template"><?php _e('Category','web-to-print-online-designer'); ?></label>
                    <select style="line-height: 30px; width: 200px; height: 30px;" class="process-select" ng-model="templateCat" id="category_template">
                        <option ng-repeat="cat in templateCats" ng-value="{{cat.id}}"><span>{{cat.name}}</span></option>
                    </select>
                </div>
                <div style="margin-top: 20px;">
                    <label style="min-width: 200px;" for="template-name"><?php _e('Name','web-to-print-online-designer'); ?></label>
                    <input style="line-height: 30px; width: 200px;" ng-model="templateName" id="template-name"/>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <button ng-class="templateName != '' ? '' : 'nbd-disabled' " class="nbd-button" ng-click="saveData('template')">Save</button>
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>
<?php endif; ?>
<div class="nbd-popup popup-nbo-options" data-animate="bottom-to-top">
    <div class="overlay-popup"></div>
    <div class="main-popup" style="width: 80% !important; height: 90%; box-sizing: border-box;">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="overlay-main active">
            <div class="loaded">
                <svg class="circular" viewBox="25 25 50 50" style="width: 40px;height: 40px;">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
        <div class="head">
            <h2 style="font-size: 18px;margin: 0;margin-bottom: 20px;font-weight: bold;text-transform: uppercase;">{{settings.task2 == '' ? "<?php _e('Choose options','web-to-print-online-designer'); ?>" : "<?php _e('Options preview','web-to-print-online-designer'); ?>"}} <?php if($task2 != ''): ?><a style="font-size:14px;text-transform:capitalize;margin-left:15px;" href="<?php echo $link_edit_option; ?>"><?php _e('Edit options','web-to-print-online-designer'); ?></a><?php endif; ?> </h2>
        </div>
        <div class="body" style="height: calc(100% - 80px);">
            <div class="main-body" style="min-height: 300px; max-height: 100%; position: relative;" id="nbo-options-wrap">
            </div>
        </div>
        <div class="footer" style="border-top: 1px solid #ddd;">
            <span style="line-height: 36px;display: inline-block;margin-top: 10px;" ng-if="!printingOptionsAvailable" class="nbd-invalid-form"><?php _e('Please choose options before apply to start design!', 'web-to-print-online-designer'); ?></span><a ng-class="printingOptionsAvailable ? '' : 'nbd-disabled'" class="nbd-button nbo-apply" ng-click="applyOptions()">{{settings.task2 == '' ? "<?php _e('Apply options','web-to-print-online-designer'); ?>" : "<?php _e('Start design','web-to-print-online-designer'); ?>" }}</a>
        </div>
    </div>
</div>
<div class="nbd-popup popup-nbd-crop" data-animate="bottom-to-top">
    <div class="overlay-popup"></div>
    <div class="main-popup" style="width: 80% !important; height: 90%; box-sizing: border-box;">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="overlay-main active">
            <div class="loaded">
                <svg class="circular" viewBox="25 25 50 50" style="width: 40px;height: 40px;">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
        <div class="head">
            <h2 style="font-size: 18px;margin: 0;margin-bottom: 20px;font-weight: bold;text-transform: uppercase;"><?php _e('Crop image','web-to-print-online-designer'); ?></h2>
        </div>
        <div class="body" style="height: calc(100% - 80px);">
            <div class="main-body" style="height: 100%; position: relative;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; text-align: center;">
                    <img id="crop-source" style="max-height: 100%; max-width: 100%; display: inline-block;" ng-if="cropObj.status" ng-src="{{cropObj.src}}" />
                </div>
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; text-align: center;">
                    <div style="display: inline-block;">
                        <canvas id="crop-handle-wrap" style="display: inline-block;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer" style="border-top: 1px solid #ddd;">
            <button style="float: right" ng-click="cropImage()" class="nbd-button"><?php _e('Crop','web-to-print-online-designer'); ?> <i class="icon-nbd icon-nbd-fomat-done" style="color: #fff !important; font-size: 20px;"></i></button>
        </div>
    </div>
</div>