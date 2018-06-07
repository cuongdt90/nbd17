<div id="v-image-toolbar" class="v-tab-content">
    <span class="v-title">Image</span>
    <div class="v-content">
        <div class="v-scrollbar">
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
                            <div class="item" data-type="image-url" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-attachment"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Image url"><?php _e('Image url','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="facebook" data-api="true">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-facebook-logo"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Facebook"><?php _e('Facebook','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="instagram" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-instagram-logo"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Instagram"><?php _e('Instagram','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="dropbox" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-dropbox-logo"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Dropbox"><?php _e('Dropbox','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="webcam" data-api="false">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-webcam"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Webcam"><?php _e('Webcam','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="pixabay" data-api="true">
                                <div class="item-icon"><i class="nbd-icon-vista nbd-icon-vista-pixabay"></i></div>
                                <div class="item-info">
                                    <span class="item-name" title="Pixabay"><?php _e('Pixabay','web-to-print-online-designer'); ?></span>
                                </div>
                            </div>
                            <div class="item" data-type="unsplash" data-api="true">
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
                            <div class="content-item type-upload accept" data-type="image-upload">
                                <div class="form-upload">
                                    <i class="nbd-icon-vista nbd-icon-vista-cloud-upload"></i>
                                    <span><?php _e('Click or drop images here','web-to-print-online-designer'); ?></span>
                                </div>
                                <div class="allow-size">
                                    <span><?php _e('Accept file types','web-to-print-online-designer'); ?>: <strong>png, jpg, gif</strong></span>
                                    <span><?php _e('Max file size','web-to-print-online-designer'); ?>: <strong>80 MB</strong></span>
                                    <span><?php _e('Min file size','web-to-print-online-designer'); ?>: <strong>3 MB</strong></span>
                                </div>
                                <div class="nbd-term">
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
                            <div class="content-item type-dropbox" data-type="dropbox">
                                <a href="#" class="v-btn v-btn-dropbox">
                                    <i class="nbd-icon-vista nbd-icon-vista-dropbox-logo"></i>
                                    <span>Choose from Dropbox</span>
                                </a>
                            </div>
                            <div class="content-item type-webcam" data-type="webcam">
                                <?php _e('webcam','web-to-print-online-designer'); ?>
                            </div>
                        </div>
                        <div class="nbdesigner-gallery" id="nbdesigner-gallery"></div>
                    </div>
                    <div class="loading-photo" style="display: none; width: 40px; height: 40px;">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                        </svg>
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