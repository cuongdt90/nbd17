<div class="tab" ng-if="settings['nbdesigner_enable_image'] == 'yes'" id="tab-photo" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-photo" data-type="photo" data-offset="20">
    <div class="nbd-search">
        <input ng-keyup="$event.keyCode == 13 && getPhoto(resource.photo.type, 'search')" type="search" name="search" placeholder="search" ng-model="resource.photo.photoSearch"/>
        <i class="icon-nbd icon-nbd-fomat-search"></i>
    </div>        
    <div class="tab-main tab-scroll">
        <div class="nbd-items-dropdown">
            <div class="main-items">
                <div class="items">
                    <div class="item" ng-if="settings['nbdesigner_enable_upload_image'] == 'yes'" data-type="image-upload" data-api="false">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-file-upload"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Image upload"><?php _e('Image Upload','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="item" ng-if="settings['nbdesigner_enable_image_url'] == 'yes'" data-type="image-url" data-api="false">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-attachment"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Image url"><?php _e('Image url','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php $fbID = nbdesigner_get_option('nbdesigner_facebook_app_id'); if($fbID != ''): ?>
                    <div class="item" data-type="facebook" ng-if="settings['nbdesigner_enable_facebook_photo'] == 'yes'" data-api="true">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-facebook-logo"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Facebook"><?php _e('Facebook','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php $insID = nbdesigner_get_option('nbdesigner_instagram_app_id'); if($insID != ''): ?>
                    <div class="item" ng-click="resource.personal = {status: true, type: 'instagram'}" data-type="instagram" ng-if="settings['nbdesigner_enable_instagram_photo'] == 'yes'" data-api="false">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-instagram-logo"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Instagram"><?php _e('Instagram','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php $dbID = nbdesigner_get_option('nbdesigner_dropbox_app_id'); if($dbID != ''): ?>
                    <div class="item" ng-click="resource.personal = {status: true, type: 'dropbox'}" ng-if="settings['nbdesigner_enable_dropbox_photo'] == 'yes'" data-type="dropbox" data-api="false">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-dropbox-logo"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Dropbox"><?php _e('Dropbox','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="item"  ng-click="initWebcam()" ng-if="hasGetUserMedia && !settings.is_mobile && settings['nbdesigner_enable_image_webcam'] == 'yes'" data-type="webcam" data-api="false">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-webcam"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Webcam"><?php _e('Webcam','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="item" ng-click="getPhoto('Pixabay')" ng-if="settings['nbdesigner_enable_pixabay'] == 'yes'" data-type="pixabay" data-api="true">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-pixabay"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Pixabay"><?php _e('Pixabay','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="item" ng-click="getPhoto('Unsplash')" ng-if="settings['nbdesigner_enable_unsplash'] == 'yes'" data-type="unsplash" data-api="true">
                        <div class="main-item">
                            <div class="item-icon"><i class="icon-nbd icon-nbd-camera-alt"></i></div>
                            <div class="item-info">
                                <span class="item-name" title="Unsplash"><?php _e('Unsplash','web-to-print-online-designer'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pointer"></div>
            </div>
            <div class="result-loaded">
                <div class="content-items">
                    <div ng-class="settings['nbdesigner_upload_show_term'] !== 'yes' ? 'accept' : '' " class="content-item type-upload" data-type="image-upload">
                        <div class="form-upload">
                            <i class="icon-nbd icon-nbd-cloud-upload"></i>
                            <span><?php _e('Click or drop images here','web-to-print-online-designer'); ?></span>
                        </div>
                        <div class="allow-size">
                            <span><?php _e('Accept file types','web-to-print-online-designer'); ?>: <strong>png, jpg, gif</strong></span>
                            <span><?php _e('Max file size','web-to-print-online-designer'); ?>: <strong>{{settings['nbdesigner_maxsize_upload']}} MB</strong></span>
                            <span><?php _e('Min file size','web-to-print-online-designer'); ?>: <strong>{{settings['nbdesigner_minsize_upload']}} MB</strong></span>
                        </div>
                        <div class="nbd-term" ng-if="settings['nbdesigner_upload_show_term'] == 'yes'">
                            <div class="nbd-checkbox">
                                <input id="accept-term" type="checkbox">
                                <label for="accept-term">&nbsp;</label>
                            </div>
                            <span class="term-read"><?php _e('I accept the terms','web-to-print-online-designer'); ?></span>
                        </div>
                        <div class="elements-uploaded"></div>
                    </div>
                    <div class="content-item type-url" data-type="image-url">
                        <div class="form-group">
                            <label><?php _e('Image Url','web-to-print-online-designer'); ?></label>
                            <div class="input-group">
                                <input type="text" name="image-url"/>
                                <button class="nbd-button"><?php _e('insert','web-to-print-online-designer'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="content-item type-facebook" data-type="facebook">
                        <?php _e('facebook','web-to-print-online-designer'); ?>
                    </div>
                    <?php if($dbID != ''): ?>
                    <div class="content-item type-instagram button-login" data-type="instagram" id="nbd-instagram-wrap">
                        <button class="nbd-button nbd-hover-shadow" ng-click="authenticateInstagram()" ng-hide="resource.instagram.token != ''">
                            <i class="icon-nbd icon-nbd-instagram-logo"></i>
                            <span><?php _e('Log in','web-to-print-online-designer'); ?></span>
                        </button>
                        <button class="nbd-button nbd-hover-shadow" ng-click="logoutInstagram()" ng-show="resource.instagram.token != ''">
                            <i class="icon-nbd icon-nbd-instagram-logo"></i>
                            <span><?php _e('Log out','web-to-print-online-designer'); ?></span>
                        </button>                        
                        <div class="mansory-wrap">
                            <div class="mansory-item in-view" ng-repeat="img in resource.instagram.data | limitTo: resource.instagram.filter.perPage * resource.instagram.filter.currentPage" repeat-end="onEndRepeat('instagram')"><img ng-src="{{img.preview}}"><span class="photo-desc">{{img.des}}</span></div>
                        </div>                         
                    </div>
                    <?php endif; ?>
                    <?php if($dbID != ''): ?>
                    <div class="content-item type-dropbox" data-type="dropbox" id="nbd-dropbox-wrap">
                        <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php echo $dbID; ?>"></script>
                        <script type="text/javascript">
                            NBDESIGNCONFIG['enable_dropbox'] = true;
                        </script>
                        <div id="nbdesigner_dropbox"></div>
                        <div class="mansory-wrap">
                            <div class="mansory-item in-view" ng-repeat="img in resource.dropbox.data | limitTo: resource.dropbox.filter.perPage * resource.dropbox.filter.currentPage" repeat-end="onEndRepeat('dropbox')"><img ng-src="{{img.preview}}"><span class="photo-desc">{{img.des}}</span></div>
                        </div>                        
                    </div>
                    <?php endif; ?>
                    <div class="content-item type-webcam" data-type="webcam">
                        <?php _e('webcam','web-to-print-online-designer'); ?>
                    </div>
                </div>
                <div class="nbdesigner-gallery" id="nbdesigner-gallery">
                    <div class="nbdesigner-item" ng-repeat="img in resource.photo.data" repeat-end="onEndRepeat('photo')"><img ng-src="{{img.preview}}"><span class="photo-desc">{{img.des}}</span></div>
                </div>
                <div class="loading-photo" style="width: 40px; height: 40px;">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                    </svg>
                </div>                
            </div>
            <div class="info-support">
                <span>Facebook</span>
                <i class="icon-nbd icon-nbd-clear close-result-loaded"></i>
            </div>
        </div>
    </div>
</div>