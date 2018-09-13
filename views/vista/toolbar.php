<div class="v-toolbar nbd-shadow">
    <div class="main-toolbar">
        <div class="v-toolbar-item left-toolbar">
            <ul class="v-tabs tabs-toolbar v-main-menu">
                <div id="selectedTab" style="display: none"></div>
                <?php if (wp_is_mobile()): ?>
                <li class="v-tab v-menu-item v-tab-layer active" id="design-tab">
<!--                    <i class="nbd-icon-vista nbd-icon-vista-proof"></i>-->
                    <span>Layer</span>
                </li>
                <?php endif; ?>
                <li ng-if="resource.templates.length > 0" class="v-tab v-menu-item <?php echo (wp_is_mobile()) ? '' : 'active';?>" data-tab="tab-design" ng-click="disableDrawMode();">
                    <span>Design</span>
                </li>
                <li ng-class="resource.templates.length < 1 ? 'active' : ''" class="v-tab v-menu-item" data-tab="tab-text" ng-if="settings['nbdesigner_enable_text'] == 'yes'" ng-click="disableDrawMode();">
                    <span>Text</span>
                </li>
                <li ng-if="settings['nbdesigner_enable_image'] == 'yes'" class="v-tab v-menu-item" data-tab="tab-photo" ng-click="disableDrawMode();">
                    <span>Image</span>
                </li>
                <li class="v-tab v-menu-item" data-tab="tab-element" ng-click="disableDrawMode();">
                    <span>More</span>
                </li>
            </ul>
        </div>
        <div class="v-toolbar-item right-toolbar">
            <ul class="v-main-menu">
                <li data-ripple="rgba(0,0,0, 0.1)" class="v-menu-item" ng-click="undo()" ng-class="stages[currentStage].states.isUndoable ? 'in' : 'nbd-disabled'">
                    <i class="nbd-icon-vista nbd-icon-vista-undo"></i>
                    <span>undo</span>
                </li>
                <li data-ripple="rgba(0,0,0, 0.1)" class="v-menu-item" ng-click="redo()" ng-class="stages[currentStage].states.isRedoable ? 'in' : 'nbd-disabled'">
                    <i class="nbd-icon-vista nbd-icon-vista-redo"></i>
                    <span>redo</span>
                </li>
<!--                <li class="v-menu-item"><i class="nbd-icon-vista nbd-icon-vista-proof"></i><span>proof</span></li>-->
<!--                <li class="v-menu-item" ng-click="debug()"><i class="nbd-icon-vista nbd-icon-vista-save"></i><span>Debug</span></li>-->
            </ul>
        </div>
    </div>
</div>
