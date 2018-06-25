<!------------------------------------------------------------------------------------
                data-animate:
                    + bottom-to-top
                    + top-to-bottom
                    + left-to-right
                    + right-to-left
                    + scale
                    + fixed-top
                    + none
------------------------------------------------------------------------------------->
<?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
$srcDefault = NBDESIGNER_PLUGIN_URL.'assets/images/logo.svg';
$srcImage = (isset($image['0'])) ? $image[0] : $srcDefault;
?>

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
            <h2><?php _e('Share this design','nbd-online-design'); ?></h2>
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
                <a href="{{resource.social.link}}" target="_blank" ng-class="resource.social.link != '' ? '' : 'nbd-disabled'" class="nbd-button nbd-hover-shadow"><?php _e('Share now','nbd-online-design'); ?></a>
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
                                    <th></th>
                                    <th><?php _e('Site wide shortcuts','web-to-print-online-designer'); ?></th>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>ctrl</kbd>
                                        or
                                        <kbd>s</kbd>
                                    </td>
                                    <td><?php _e('Focus search bar','web-to-print-online-designer'); ?></td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>shift</kbd>
                                        or
                                        <kbd>s</kbd>
                                    </td>
                                    <td>Focus search bar</td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Delete</kbd>
                                        or
                                        <kbd>s</kbd>
                                    </td>
                                    <td>Focus search bar</td>
                                </tr>
                                <tr>
                                    <td class="keys">
                                        <kbd>Delete</kbd>
                                        or
                                        <kbd>s</kbd>
                                    </td>
                                    <td>Focus search bar</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="nbd-keyboard-about" class="nbd-tab-content">
                            <div class="text-center" style="margin-bottom: 40px; margin-top: 20px">
                                <img src="<?php echo $srcImage ?>" alt="Logo Online Design" style="width: 80px">
                            </div>
                            <div class="copy-right">
                                <p class="text-center">Online Design - Copyright © <script>document.write(new Date().getFullYear())</script><a href="#" target="_blank"> Onlinde Design Team </a>.</p>
                                <p class="text-center">All Rights Reserved</p>
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
<!--    <div class="overlay-popup"></div>-->
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
            Delete All Layers
        </div>
        <div class="body">
            <div class="main-body">
                <span class="title">Are you sure you want to delete all layers?</span>
                <div class="main-select">
                    <button ng-click="closePopupClearStage()" class="nbd-button select-no"><i class="icon-nbd icon-nbd-clear"></i> No</button>
                    <button ng-click="clearStage()" class="nbd-button select-yes"><i class="icon-nbd icon-nbd-fomat-done"></i> Yes</button>
                </div>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>
<!--<div class="nbd-popup popup-import-file" data-animate="fixed-top">-->
<!--    <div class="overlay-popup"></div>-->
<!--    <div class="main-popup">-->
<!--        <i class="icon-nbd icon-nbd-clear close-popup"></i>-->
<!--        <div class="head"></div>-->
<!--        <div class="body">-->
<!--            -->
<!--        </div>-->
<!--        <div class="footer"></div>-->
<!--    </div>-->
<!--</div>-->