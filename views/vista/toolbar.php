<div class="v-toolbar">
    <div class="main-toolbar">
        <div class="v-toolbar-item left-toolbar">
            <ul class="v-tabs tabs-toolbar v-main-menu">
                <?php if (wp_is_mobile()): ?>
                <li class="v-tab v-menu-item v-tab-layer active" id="design-tab">
                    <i class="nbd-icon-vista nbd-icon-vista-proof"></i><span>Layer</span>
                </li>
                <?php endif; ?>
                <li ng-if="resource.templates.length > 0" class="v-tab v-menu-item <?php echo (wp_is_mobile()) ? '' : 'active';?>" data-tab="tab-design" ng-click="disableDrawMode();">
                    <i class="nbd-icon-vista nbd-icon-vista-group-work"></i><span>Design</span>
                </li>
                <li ng-class="resource.templates.length < 1 ? 'active' : ''" class="v-tab v-menu-item" data-tab="tab-text" ng-if="settings['nbdesigner_enable_text'] == 'yes'" ng-click="disableDrawMode();">
                    <i class="nbd-icon-vista nbd-icon-vista-text"></i><span>Text</span>
                </li>
                <li ng-if="settings['nbdesigner_enable_image'] == 'yes'" class="v-tab v-menu-item" data-tab="tab-photo" ng-click="disableDrawMode();">
                    <i class="nbd-icon-vista nbd-icon-vista-image"></i><span>Image</span>
                </li>
                <li class="v-tab v-menu-item" data-tab="tab-element" ng-click="disableDrawMode();">
                    <i class="nbd-icon-vista nbd-icon-vista-more"></i><span>More</span>
                </li>
            </ul>
        </div>
        <div class="v-toolbar-item right-toolbar">
            <ul class="v-main-menu">
                <li class="v-menu-item" ng-click="undo()" ng-class="stages[currentStage].states.isUndoable ? 'in' : 'nbd-disabled'">
                    <i class="nbd-icon-vista nbd-icon-vista-undo"></i>
                    <span>undo</span>
                </li>
                <li class="v-menu-item" ng-click="redo()" ng-class="stages[currentStage].states.isRedoable ? 'in' : 'nbd-disabled'">
                    <i class="nbd-icon-vista nbd-icon-vista-redo"></i>
                    <span>redo</span>
                </li>
<!--                <li class="v-menu-item"><i class="nbd-icon-vista nbd-icon-vista-proof"></i><span>proof</span></li>-->
<!--                <li class="v-menu-item" ng-click="debug()"><i class="nbd-icon-vista nbd-icon-vista-save"></i><span>Debug</span></li>-->
            </ul>
        </div>
    </div>
</div>
