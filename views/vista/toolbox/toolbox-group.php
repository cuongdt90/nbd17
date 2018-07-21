<div class="v-toolbox-group v-toolbox-item" ng-class="stages[currentStage].states.isShowToolBox ? 'nbd-show' : ''" ng-show="stages[currentStage].states.isGroup" ng-style="stages[currentStage].states.toolboxStyle">
    <div class="v-triangle" data-pos="{{stages[currentStage].states.toolboxTriangle}}">
        <div class="header-box">
            <span>Group</span>
        </div>
        <div class="main-box">
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
        <div class="footer-box">
            <div class="main-footer" title="Done" ng-click="onClickDone()">
                <i class="nbd-icon-vista nbd-icon-vista-done"></i>
            </div>
        </div>
    </div>
</div>