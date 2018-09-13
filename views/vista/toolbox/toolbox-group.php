<div class="v-toolbox-group v-toolbox-item nbd-main-tab nbd-shadow" ng-class="stages[currentStage].states.isShowToolBox ? 'nbd-show' : ''" ng-show="stages[currentStage].states.isGroup" ng-style="stages[currentStage].states.toolboxStyle">
    <div class="v-triangle" data-pos="{{stages[currentStage].states.toolboxTriangle}}">
        <div class="header-box has-box-more">
            <span><?php _e('Group','web-to-print-online-designer'); ?></span>
            <ul class="link-breadcrumb">
                <li class="link-item nbd-nav-tab nbd-ripple active" data-tab="tab-main-box"><i class="nbd-icon-vista nbd-icon-vista-cog"></i></li>
                <li class="link-item nbd-nav-tab nbd-ripple" data-tab="tab-box-position"><i class="nbd-icon-vista nbd-icon-vista-apps"></i></li>
                <li class="link-item nbd-nav-tab nbd-ripple" data-tab="tab-box-opacity"><i class="nbd-icon-vista nbd-icon-vista-opacity"></i></li>
            </ul>
        </div>
        <div class="nbd-tab-contents">
            <div class="main-box nbd-tab-content active" data-tab="tab-main-box">
                <?php include __DIR__ . '/../toollock.php'?>
                <div class="toolbox-row toolbox-second toolbox-general">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-vertical-center"
                            ng-click="alignLayer('vertical')"
                            title="Align Vertical Center">
                            <i class="rotate90 nbd-icon-vista nbd-icon-vista-vertical-align-center"></i>
                        </li>
                        <li class="item v-asset item-align-horizontal-center"
                            ng-click="alignLayer('horizontal')"
                            title="Align Horizontal Center">
                            <i class="nbd-icon-vista nbd-icon-vista-vertical-align-center"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="alignLayer('left')"
                            title="Align Left">
                            <i class="rotate-90 nbd-icon-vista nbd-icon-vista-vertical-align-top"></i>
                        </li>
                        <li class="item v-asset item-align-right"
                            ng-click="alignLayer('right')"
                            title="Align Right">
                            <i class="rotate90 nbd-icon-vista nbd-icon-vista-vertical-align-top"></i>
                        </li>
                        <li class="item v-asset item-align-top"
                            ng-click="alignLayer('top')"
                            title="Align Top">
                            <i class="nbd-icon-vista nbd-icon-vista-vertical-align-top"></i>
                        </li>
                    </ul>
                </div>

                <div class="toolbox-row">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-bottom"
                            ng-click="alignLayer('bottom')"
                            title="Align Bottom">
                            <i class="rotate180 nbd-icon-vista nbd-icon-vista-vertical-align-top"></i>
                        </li>
                        <li class="item v-asset item-distribute-horizontal"
                            ng-click="alignLayer('dis-horizontal')"
                            title="Distribute Horizontal">
                            <i class="rotate180 nbd-icon-vista nbd-icon-vista-dis-horizontal"></i>
                        </li>
                        <li class="item v-asset item-distribute-vertical"
                            ng-click="alignLayer('dis-vertical')"
                            title="Distribute-vertical">
                            <i class="rotate180 nbd-icon-vista nbd-icon-vista-dis-vertical"></i>
                        </li>
                        <li class="item v-asset" style="visibility: hidden"></li>
                        <li class="item v-asset" style="visibility: hidden"></li>
                    </ul>
                </div>

                <div class="toolbox-row toolbox-delete">
                    <ul class="items v-assets">
                        <li class="item v-asset item-delete"
                            ng-click="deleteLayers()"
                            title="Delete all layer">
                            <i class="nbd-icon-vista nbd-icon-vista-clear"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-box-more nbd-tab-content" data-tab="tab-box-position">
                <div class="toolbox-row toolbox-first toolbox-align">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('vertical')"
                            title="Position center horizontal">
                            <i class="nbd-icon-vista nbd-icon-vista-vertical-align-center"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('top-left')"
                            title="Position top right">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-90"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('top-center')"
                            title="Position top center">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-45"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('top-right')"
                            title="Position top left">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left"></i>
                        </li>
                        <li class="item v-asset item-align-left" ng-click="setStackPosition('bring-front')"
                            title="Bring to front">
                            <i class="nbd-icon-vista nbd-icon-vista-bring-to-front"></i>
                        </li>
                    </ul>
                </div>
                <div class="toolbox-row toolbox-second toolbox-align">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('horizontal')"
                            title="Position center vertical">
                            <i class="nbd-icon-vista nbd-icon-vista-vertical-align-center rotate90"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('middle-left')"
                            title="Position middle right">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-135"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('center')"
                            title="Position middle center">
                            <i class="nbd-icon-vista nbd-icon-vista-center"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('middle-right')"
                            title="Position middle left">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate45"></i>
                        </li>
                        <li class="item v-asset item-align-left" ng-click="setStackPosition('bring-forward')"
                            title="Bring forward">
                            <i class="nbd-icon-vista nbd-icon-vista-bring-forward"></i>
                        </li>
                    </ul>
                </div>
                <div class="toolbox-row toolbox-three toolbox-align">
                    <ul class="items v-assets">
                        <li class="item v-asset item-align-left" ng-click="rotateLayer('90cw')" title="Rotate">
                            <i class="nbd-icon-vista nbd-icon-vista-rotate-right"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('bottom-left')"
                            title="Position bottom left">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate-180"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('bottom-center')"
                            title="Position bottom center">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate135"></i>
                        </li>
                        <li class="item v-asset item-align-left"
                            ng-click="translateLayer('bottom-right')"
                            title="Position bottom right">
                            <i class="nbd-icon-vista nbd-icon-vista-top-left rotate90"></i>
                        </li>
                        <li class="item v-asset item-align-left" ng-click="setStackPosition('send-backward')"
                            title="Sent to backward">
                            <i class="nbd-icon-vista nbd-icon-vista-sent-to-backward"></i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-box-more nbd-tab-content" data-tab="tab-box-opacity">
                <div class="toolbox-row toolbox-first toolbox-align">
                    <div style="display: flex;justify-content: space-between; align-items: center">
                        <div>Opacity</div>
                        <div class="v-ranges">
                            <div class="main-track" style="display: flex">
                                <input class="slide-input" type="range" step="1" min="0" max="100" ng-change="setTextAttribute('opacity', stages[currentStage].states.opacity / 100)" ng-model="stages[currentStage].states.opacity">
                                <span class="range-track"></span>
                            </div>
                        </div>
                        <div>{{stages[currentStage].states.opacity}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-box">
            <div class="main-footer" title="Done" ng-click="onClickDone()">
                <i class="nbd-icon-vista nbd-icon-vista-done"></i>
            </div>
        </div>
    </div>
</div>