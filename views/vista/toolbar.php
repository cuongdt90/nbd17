<div class="v-toolbar">
    <div class="main-toolbar">
        <div class="v-toolbar-item left-toolbar">
            <ul class="v-tabs tabs-toolbar v-main-menu">
                <?php if (wp_is_mobile()): ?>
                <li class="v-tab v-menu-item v-tab-layer active">
                    <i class="nbd-icon-vista nbd-icon-vista-proof"></i><span>Layer</span>
                </li>
                <?php endif; ?>
                <li class="v-tab v-menu-item <?php echo (wp_is_mobile()) ? '' : 'active';?>" data-tab="tab-design">
                    <i class="nbd-icon-vista nbd-icon-vista-group-work"></i><span>Design</span>
                </li>
                <li class="v-tab v-menu-item" data-tab="tab-text" ng-if="settings['nbdesigner_enable_text'] == 'yes'">
                    <i class="nbd-icon-vista nbd-icon-vista-text"></i><span>Text</span>
                </li>
                <li ng-if="settings['nbdesigner_enable_image'] == 'yes'" class="v-tab v-menu-item" data-tab="tab-photo">
                    <i class="nbd-icon-vista nbd-icon-vista-image"></i><span>Image</span>
                </li>
                <li class="v-tab v-menu-item" data-tab="tab-more">
                    <i class="nbd-icon-vista nbd-icon-vista-more"></i><span>More</span></a>
                </li>
            </ul>
        </div>
        <div class="v-toolbar-item right-toolbar">
            <ul class="v-main-menu">
                <li class="v-menu-item"><i class="nbd-icon-vista nbd-icon-vista-undo"></i><span>undo</span></li>
                <li class="v-menu-item"><i class="nbd-icon-vista nbd-icon-vista-redo"></i><span>redo</span></li>
                <li class="v-menu-item"><i class="nbd-icon-vista nbd-icon-vista-proof"></i><span>proof</span></li>
<!--                                        <li class="v-menu-item"><i class="nbd-icon-vista nbd-icon-vista-save"></i><span>save</span></li>-->
            </ul>
        </div>
    </div>
</div>
