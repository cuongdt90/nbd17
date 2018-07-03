<?php
    $dbID = nbdesigner_get_option('nbdesigner_dropbox_app_id');
?>
<div ng-if="settings['nbdesigner_enable_image'] == 'yes'" id="tab-photo" class="v-tab-content" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-photo" data-type="photo" data-offset="20">
    <span class="v-title">Image</span>
    <div class="v-content">
        <div class="tab-scroll">
            <div class="main-scrollbar">
                <div class="v-elements">
                    <div class="main-items">
                        <div class="items">
                            <div class="item" data-type="image-upload" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-file-upload"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Image upload"><?php _e('Image Upload','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-if="settings['nbdesigner_enable_image_url'] == 'yes'" class="item" data-type="image-url" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-attachment"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Image url"><?php _e('Image url','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-if="settings['nbdesigner_enable_facebook_photo'] == 'yes'" class="item" data-type="facebook" data-api="true">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-facebook-logo"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Facebook"><?php _e('Facebook','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-if="settings['nbdesigner_enable_instagram_photo'] == 'yes'" class="item" data-type="instagram" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-instagram-logo"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Instagram"><?php _e('Instagram','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-if="settings['nbdesigner_enable_dropbox_photo'] == 'yes'" class="item" data-type="dropbox" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-dropbox-logo"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Dropbox"><?php _e('Dropbox','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-if="settings['nbdesigner_enable_image_webcam'] == 'yes'" class="item" data-type="webcam" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-webcam"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Webcam"><?php _e('Webcam','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-click="onClickTab('Pixabay', 'photo')" ng-if="settings['nbdesigner_enable_pixabay'] == 'yes'" class="item" data-type="pixabay" data-api="true">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-pixabay"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Pixabay"><?php _e('Pixabay','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div ng-click="onClickTab('Unsplash', 'photo')" ng-if="settings['nbdesigner_enable_unsplash'] == 'yes'" class="item" data-type="unsplash" data-api="true">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-camera-alt"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Unsplash"><?php _e('Unsplash','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="none"></div>
                        </div>
                        <div class="pointer"></div>
                    </div>
                    <div class="result-loaded">
                        <div class="content-items">
                            <div ng-class="settings['nbdesigner_upload_show_term'] !== 'yes' ? 'accept' : '' " class="content-item type-upload" data-type="image-upload">

                                <div ng-show="settings.nbdesigner_upload_designs_php_logged_in == 'yes' && !settings.is_logged" class="text-center">
                                    <p style="margin-bottom: 15px"><?php _e('You need to be logged in to upload images!','web-to-print-online-designer'); ?></p>
                                    <button class="v-btn nbd-hover-shadow" ng-click="login()"><?php _e('Login','web-to-print-online-designer'); ?></button>
                                </div>

                                <div ng-hide="settings.nbdesigner_upload_designs_php_logged_in == 'yes' && !settings.is_logged">
                                    <div class="form-upload nbd-dnd-file" nbd-dnd-file="uploadFile(files)">
                                        <i class="nbd-icon-vista nbd-icon-vista-cloud-upload"></i>
                                        <span><?php _e('Click or drop images here','web-to-print-online-designer'); ?></span>
                                        <input type="file" accept="image/*" style="display: none;"/>
                                    </div>
                                    <div class="allow-size">
                                        <span><?php _e('Accept file types','web-to-print-online-designer'); ?>: <strong>png, jpg, gif</strong></span>
                                        <span><?php _e('Max file size','web-to-print-online-designer'); ?>: <strong>{{settings['nbdesigner_maxsize_upload']}} MB</strong></span>
                                        <span><?php _e('Min file size','web-to-print-online-designer'); ?>: <strong>{{settings['nbdesigner_minsize_upload']}} MB</strong></span>
                                    </div>
                                    <div ng-if="settings['nbdesigner_upload_show_term'] == 'yes'" class="nbd-term">
                                        <div class="nbd-checkbox">
                                            <input id="accept-term" type="checkbox">
                                            <label for="accept-term">&nbsp;</label>
                                        </div>
                                        <span class="term-read"><?php _e('I accept the terms','web-to-print-online-designer'); ?></span>
                                    </div>

                                    <div id="nbd-upload-wrap">
                                        <div class="mansory-wrap">
                                            <div nbd-drag="img.url" extenal="false" type="image" class="mansory-item" ng-click="addImageFromUrl(img.url, false, img.ilr)" ng-repeat="img in resource.upload.data track by $index" repeat-end="onEndRepeat('upload')"><img ng-src="{{img.url}}"><span class="photo-desc">{{img.des}}</span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="content-item type-url" data-type="image-url">
                                <div class="form-group">
                                    <label><?php _e('Image Url','web-to-print-online-designer'); ?></label>
                                    <div class="input-group">
                                        <input type="text" name="image-url"/>
                                        <button class="v-btn"><?php _e('insert','web-to-print-online-designer'); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="content-item type-facebook" data-type="facebook">
                                <?php _e('facebook','web-to-print-online-designer'); ?>
                            </div>
                            <div class="content-item type-instagram" data-type="instagram">
                                <button class="v-btn">
                                    <i class="nbd-icon-vista nbd-icon-vista-instagram-logo"></i>
                                    <span><?php _e('Login','web-to-print-online-designer'); ?></span>
                                </button>
                            </div>

                            <?php if($dbID != ''): ?>
                                <div class="content-item type-dropbox" data-type="dropbox" id="nbd-dropbox-wrap">
                                    <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php echo $dbID; ?>"></script>
                                    <script type="text/javascript">
                                        NBDESIGNCONFIG['enable_dropbox'] = true;
                                    </script>
                                    <div id="nbdesigner_dropbox" class="text-center" style="margin-bottom: 20px"></div>
                                    <div class="mansory-wrap">
                                        <div nbd-drag="img.url" extenal="true" type="image" class="mansory-item" ng-click="addImageFromUrl(img.url)" ng-repeat="img in resource.dropbox.data | limitTo: resource.dropbox.filter.perPage * resource.dropbox.filter.currentPage" repeat-end="onEndRepeat('dropbox')">
                                            <img ng-src="{{img.preview}}">
                                            <span class="photo-desc">{{img.des}}</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
<!--                            <div class="content-item type-dropbox text-center" data-type="dropbox">-->
<!--                                <a href="#" class="v-btn v-btn-dropbox">-->
<!--                                    <i class="nbd-icon-vista nbd-icon-vista-dropbox-logo"></i>-->
<!--                                    <span>Choose from Dropbox</span>-->
<!--                                </a>-->
<!--                            </div>-->
                            <div class="content-item type-webcam" data-type="webcam">
                                <?php _e('webcam','web-to-print-online-designer'); ?>
                            </div>
                        </div>
                        <!--                        <div class="nbdesigner-gallery" id="nbdesigner-gallery"></div>-->
                        <div class="nbdesigner-gallery" id="nbdesigner-gallery">
                            <div class="nbdesigner-item" ng-click="addImageFromUrl(img.url)" ng-repeat="img in resource.photo.data" repeat-end="onEndRepeat('photo')"><img ng-src="{{img.preview}}"><span class="photo-desc">{{img.des}}</span></div>
                        </div>
                        <div class="loading-photo" style="display: none; width: 40px; height: 40px;">
                            <svg class="circular" viewBox="25 25 50 50">
                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-support">
            <span>Facebook</span>
            <i class="nbd-icon-vista nbd-icon-vista-clear close-result-loaded"></i>
        </div>
    </div>
</div>