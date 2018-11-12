<?php include 'nbdesignconfig.php';?>
<?php include "loading-app.php"; ?>
<div class="nbdpb-popup popup-design <?php echo (is_admin_bar_showing()) ? 'is-admin-bar' : ''; ?>" data-animate="scale">
    <i class="icon-nbd icon-nbd-clear close-popup"></i>
    <div id="nbdpb-app" class="nbdpb-product-builder nbdpb-full-contain" ng-app="nbdpb-app">
        <div ng-controller="designCtrl" class="nbdpb-full-contain">
            <div id="design-container" class="nbdpb-full-contain">
                <div class="design-main nbdpb-full-contain">
                    <div class="design-layer">
                        <div class="design-stages nbdpb-carousel-outer">
                            <div class="nbdpb-carousel">
                                <div ng-repeat="stage in stages" ng-class="{'nbdpb-active': $index == 0}" class="nbdpb-carousel-item nbdpb-full-contain">
                                    <div class="stage nbdpb-full-contain" id='stage-{{$index}}' data-stage="{{$index}}">
                                        <div class="stage-main">
                                            <div class="design-zone nbdpb-full-contain">
                                                <canvas nbd-canvas class="nbdpb-full-contain" stage="stage" index="{{$index}}" id="canvas-{{$index}}" last="{{$last ? 1 : 0}}"></canvas>
                                            </div>
                                        </div>
                                        <div class="attr-name" style="display: none"><span>{{resource.proAttrs[resource.proAttrActive].name}}</span></div>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="nbdpb-owl-nav">-->
<!--                                <button type="button" role="presentation" class="nbdpb-owl-prev js-nav-item">-->
<!--                                    <i aria-label="Previous" class="icon-nbd icon-nbd-chevron-right rotate180"></i>-->
<!--                                </button>-->
<!--                                <button type="button" role="presentation" class="nbdpb-owl-next js-nav-item">-->
<!--                                    <i aria-label="Next" class="icon-nbd icon-nbd-chevron-right"></i>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                            <div class="nbdpb-owl-dots">-->
<!--                                <button role="button" class="nbdpb-owl-dot nbdpb-active"><span></span></button>-->
<!--                                <button role="button" class="nbdpb-owl-dot"><span></span></button>-->
<!--                                <button role="button" class="nbdpb-owl-dot"><span></span></button>-->
<!--                            </div>-->
                        </div>
                        <div class="design-finish">
                            <button class="nbdpb-btn btn-finish" ng-click="saveData()">Done</button>
                        </div>
                        <div class="design-admin-tool" ng-class="showAdminTool ? 'nbdpb-show' : ''">
                            <div class="tools">
<!--                                <div class="tool-item" title="Bring To Front" ng-click="setStackPosition('bring-front')"><i class="icon-nbd icon-nbd-bring-to-front"></i></div>-->
                                <div class="tool-item" title="Bring Forward" ng-click="setStackPosition('bring-forward')"><i class="icon-nbd icon-nbd icon-nbd-bring-forward"></i></div>
                                <div class="tool-item" title="Send To Backward" ng-click="setStackPosition('send-backward')"><i class="icon-nbd icon-nbd-sent-to-backward"></i></div>
<!--                                <div class="tool-item" title="Send To Back" ng-click="setStackPosition('send-back')"><i class="icon-nbd icon-nbd-send-to-back"></i></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="design-sidebar">
                        <div ng-class="(!resource.showValue) ? 'nbdpb-show' : ''" class="sidebar-item sidebar-attribute nbdpb-full-contain">
                            <div class="attribute-main nbdpb-full-contain">
                                <div class="nbdpb-scroll">
                                    <div class="product-attr">
                                        <div ng-repeat="proAttr in resource.proAttrs" ng-click="showValue($index)" class="attr-item">
                                            <div class="attr-img">
                                                <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>{{proAttr.img}}" alt="Product Attribute">
                                            </div>
                                            <span class="attr-name">{{proAttr.name}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="design-finish">
                                <span>Done</span>
                            </div>
                        </div>
                        <div ng-class="(resource.showValue) ? 'nbdpb-show' : ''" class="sidebar-item sidebar-value nbdpb-full-contain">
                            <div class="product-value nbdpb-full-contain">
                                <div class="attr-name">
                                    <span>{{resource.proAttrs[resource.proAttrActive].name}}</span>
                                </div>
                                <div class="product-value-main">
                                    <div class="nbdpb-scroll">
                                        <div class="values">
                                            <div ng-repeat="proValue in resource.proAttrs[resource.proAttrActive].proValue" ng-click="addProValue($index)" class="value-item">
                                                <div class="value-color"></div>
                                                <span class="value-name">{{proValue.name}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product-value-act">
                                    <div class="value-act-close value-act-item" ng-click="showValue()"><i class="icon-nbd icon-nbd-clear"></i></div>
                                    <div class="value-act-finish value-act-item" ng-click="saveDesign()"><i class="icon-nbd icon-nbd-fomat-done"></i></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
