<style type="text/css">
    .stage-background, .design-zone, .stage-grid, .bounding-layers, .stage-snapLines, .stage-overlay, .stage-guideline {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .stage-background, .stage-grid, .bounding-layers, .stage-snapLines, .stage-overlay, .stage-guideline {
        pointer-events: none;
    }
    .nbd-stages .stage {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }
    .stage.hidden {
        opacity: 0;
        z-index: 0;
        -webkit-transform: translate3d(0, -100%, 0);
        transform: translate3d(0, -100%, 0);
    }  
    .nbd-stages .stage .page-toolbar .page-main ul li.disabled {
        opacity: .3;
        pointer-events: none;
    }  
    .bounding-layers-inner,
    .stage-snapLines-inner {
        position: relative;
        width: 100%;
        height: 100%;
    }
    .bounding-rect {
        position: absolute;
        display: inline-block;
        visibility: hidden;
        top: -20px;
        left: -20px;
        width: 10px;
        height: 10px;
        border: 1px dashed #ddd;
        transform-origin: 0% 0%;
    }
    .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item {
        cursor: pointer;
    }
    .text-heading {
        font-size: 40px;
        font-weight: 700;        
    }
    .text-sub-heading {
        font-size: 24px;
        font-weight: 500;        
    } 
    .text-heading, .text-sub-heading, .text-body {
        color: #4F5467;
        cursor: pointer;
        display: block;
    }
    .nbd-signal {
        position: absolute;
        bottom: 15px;
        left: 5px;
        height: 20px;
        display: inline-block;
        border-radius: 20px;
        background: #fff;
        line-height: 17px;
        padding-right: 5px;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }
    .nbd-signal a {
        font-size: 9px;
        color: #404762;  
        font-family: arial, sans-serif;
    }
    .nbd-signal:hover {
        background: #055b39;
        -webkit-box-shadow: 1px 0 10px rgba(0,0,0,.08);
        box-shadow: 1px 0 10px rgba(0,0,0,.08);        
    }
    .nbd-signal:hover a{
        text-decoration: none;
        color: #fff;        
    }
    .nbd-signal svg {
        vertical-align: top;
        background: #fff;
        border-radius: 50%;
    }
    .nbd-input {
        border: none;
    }
    .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload i {
        vertical-align: middle;
        margin-right: 5px;     
        color: #404762;
    }
    .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload   {
        border: 2px dashed #fff;
        padding: 30px 10px;        
    } 
    .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload i:before,
    .nbd-sidebar #tab-photo .result-loaded .content-items div[data-type=image-upload] .form-upload{
        color: #404762;
        font-weight: bold;
    }
    .layer-coordinates {
        position: absolute;
        display: inline-block;
        font-size: 9px;
        font-family: monospace;
        color: #404762;   
        visibility: hidden;
        transform: translate(calc(-100% - 10px), calc(-100% + 5px));
        text-shadow: 1px 1px #fff;
    }
    .layer-angle {
        position: absolute;
        display: inline-block;
        font-family: monospace;
        color: #404762;   
        visibility: hidden;
        text-shadow: 1px 1px #fff;        
    }
    .layer-angle span {
        font-size: 9px !important;
        display: inline-block;
    }
    .snapline {
        position: absolute;
    }
    .h-snapline {
        top: -9999px;
        left: -20px;
        width: calc(100% + 40px);
        height: 3px !important;
        background-image: linear-gradient(to right,rgba(214,96,96,.95) 1px,transparent 1px);
        background-size: 2px 1px;
        background-repeat: repeat-x;     
    }
    .v-snapline {
        left: -9999px;
        top: -20px;
        height: calc(100% + 40px);
        width: 3px!important;
        background-image: linear-gradient(to bottom,rgba(214,96,96,.95) 1px,transparent 1px);
        background-size: 1px 2px;
        background-repeat: repeat-y;
    }    
</style>
<div class="nbd-stages">
    <div class="stages-inner">
        <div class="stage" ng-repeat="stage in stages" id='stage-container-{{$index}}' ng-click="onClickStage($event)" ng-class="{'hidden':$index > 0}" >
            <div class="nbd-warning" style="display: none;">
                <div class="item main-warning nbd-show">
                    <i class="icon-nbd icon-nbd-baseline-warning warning"></i>
                    <span class="title-warning">Warning Trouble</span>
                    <i class="icon-nbd icon-nbd-clear close-warning"></i>
                </div>

                <div class="item main-warning nbd-show">
                    <i class="icon-nbd icon-nbd-baseline-warning warning"></i>
                    <span class="title-warning">Warning Trouble</span>
                    <i class="icon-nbd icon-nbd-clear close-warning"></i>
                </div>

                <div class="item main-warning nbd-show">
                    <i class="icon-nbd icon-nbd-baseline-warning warning"></i>
                    <span class="title-warning">Warning Trouble</span>
                    <i class="icon-nbd icon-nbd-clear close-warning"></i>
                </div>

            </div>            
            <div class="stage-main">
                <div class="stage-background" ng-style="{background: stages[currentStage].config.background}"></div>
                <div class="design-zone">
                    <canvas nbd-canvas stage="stage" ctx="ctxMenuStyle" index="{{$index}}" id="nbd-stage-{{$index}}"></canvas>
                </div>
                <div class="stage-grid"></div>
                <div class="bounding-layers">
                    <div class="bounding-layers-inner">
                        <div class="bounding-rect" ng-style="stages[currentStage].states.boundingObject"></div>
                        <div class="layer-coordinates" ng-style="stages[currentStage].states.coordinates.style">{{stages[currentStage].states.coordinates.top}} {{stages[currentStage].states.coordinates.left}}</div>
                        <div class="layer-angle" ng-style="stages[currentStage].states.rotate.style"><span ng-style="{transform: 'rotate(-'+stages[currentStage].states.rotate.angle+'deg)'}">{{stages[currentStage].states.rotate.angle}}</span></div>
                    </div>
                </div>
                <div class="stage-snapLines">
                    <div class="stage-snapLines-inner">
                        <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.ht"></div>
                        <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.hc"></div>
                        <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.hb"></div>
                        <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vl"></div>
                        <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vc"></div>
                        <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vr"></div>
                        <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.hcc"></div>
                        <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vcc"></div>
                        <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vel"></div>
                        <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.ver"></div>
                        <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.het"></div>
                        <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.heb"></div>
                    </div>                    
                </div>
                <div class="stage-overlay"></div>				
                <div class="stage-guideline"></div>
            </div>
            <div class="page-toolbar">
                <div class="page-main">
                    <ul>
                        <li ng-class="$index == 0 ? 'disabled' : ''" ng-click="switchStage($index, 'prev')"><i class="icon-nbd icon-nbd-arrow-upward" title="<?php _e('Prev Page','web-to-print-online-designer'); ?>"></i></li>
                        <li><span>{{$index + 1}}</span></li>
                        <li ng-class="$index == (stages.length - 1) ? 'disabled' : ''" ng-click="switchStage($index, 'next')"><i class="icon-nbd icon-nbd-arrow-upward rotate-180" title="<?php _e('Next Page','web-to-print-online-designer'); ?>"></i></li>
                        <li><i class="icon-nbd icon-nbd-content-copy" title="<?php _e('Copy Design','web-to-print-online-designer'); ?>"></i></li>
                        <li><i class="icon-nbd icon-nbd-refresh" title="<?php _e('Clear Design','web-to-print-online-designer'); ?>"></i></li>
                    </ul>
<div class="nbd-stages" id="nbd-stages">
    <div class="stages-inner">
        <div class="stage" ng-repeat="stage in stages" id='stage-container-{{$index}}' ng-click="onClickStage($event)" ng-class="{'hidden':$index > 0}" >
            <div style="display: inline-block;position: relative;">
                <?php include 'warning.php'?>
                <div class="stage-main" ng-style="{'width' : calcStyle(stage.config.cwidth * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                    'height' : calcStyle(stage.config.cheight * stage.states.scaleRange[stage.states.currentScaleIndex].ratio)}">
                    <div class="stage-background" ng-style="{'background-color': stage.config.bgColor}">
                        <img style="" ng-if="stage.config.bgType == 'iimage'" ng-src='{{stage.config.bgImage}}'/>
                    </div>
                    <div class="design-wrap" ng-style="{'width' : calcStyle(stage.config.width * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                        'height' : calcStyle(stage.config.height * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                        'top' : calcStyle(stage.config.top * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                        'left' : calcStyle(stage.config.left * stage.states.scaleRange[stage.states.currentScaleIndex].ratio)}">
                        <div class="design-zone">
                            <canvas nbd-canvas stage="stage" ctx="ctxMenuStyle" index="{{$index}}" id="nbd-stage-{{$index}}" last="{{$last ? 1 : 0}}"></canvas>
                        </div>
                        <div class="stage-grid">
                            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" ng-show="settings.showGrid">
                                <defs>
                                    <pattern id="grid10" width="10" height="10" patternUnits="userSpaceOnUse">
                                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="gray" stroke-width="0.5"/>
                                    </pattern>
                                    <pattern id="grid100" width="100" height="100" patternUnits="userSpaceOnUse">
                                        <rect width="100" height="100" fill="url(#grid10)"/>
                                        <path d="M 100 0 L 0 0 0 100" fill="none" stroke="gray" stroke-width="1"/>
                                    </pattern>
                                </defs>
                                <rect width="100%" height="100%" fill="url(#grid100)" />
                            </svg>                     
                        </div>
                        <div class="bounding-layers">
                            <div class="bounding-layers-inner">
                                <div class="bounding-rect" ng-style="stages[currentStage].states.boundingObject"></div>
                                <div class="bounding-rect" ng-style="stages[currentStage].states.uploadZone" style="background: rgba(255,255,255,0.85); overflow: hidden;display: flex; justify-content: center; align-items: center;flex-direction: column;position: relative;">
                                    <i style="color: rgb(194, 194, 194); position: absolute; font-size: 70px;z-index: 0;" ng-style="{transform: 'rotate(-'+stages[currentStage].states.rotate.angle+'deg)'}" class="icon-nbd icon-nbd-replace-image"></i>
                                    <span style="font-weight: bold; z-index: 1;" ng-style="{transform: 'rotate(-'+stages[currentStage].states.rotate.angle+'deg)'}"><?php _e('Drop to replace'); ?></span>
                                </div>
                                <div class="layer-coordinates" ng-style="stages[currentStage].states.coordinates.style">{{stages[currentStage].states.coordinates.top}} {{stages[currentStage].states.coordinates.left}}</div>
                                <div class="layer-angle" ng-style="stages[currentStage].states.rotate.style"><span ng-style="{transform: 'rotate(-'+stages[currentStage].states.rotate.angle+'deg)'}">{{stages[currentStage].states.rotate.angle}}</span></div>
                            </div>
                        </div>
                        <div class="stage-snapLines">
                            <div class="stage-snapLines-inner">
                                <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.ht"></div>
                                <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.hc"></div>
                                <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.hb"></div>
                                <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vl"></div>
                                <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vc"></div>
                                <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vr"></div>
                                <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.hcc"></div>
                                <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vcc"></div>
                                <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.vel"></div>
                                <div class="snapline v-snapline" ng-style="stages[currentStage].states.snaplines.ver"></div>
                                <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.het"></div>
                                <div class="snapline h-snapline" ng-style="stages[currentStage].states.snaplines.heb"></div>
                            </div>                    
                        </div>
                        <div class="stage-overlay"></div>				
                        <div class="stage-guideline">
                            <div style="position: relative; width: 100%; height: 100%;">
                                <div ng-show="settings.bleedLine" class="bleed-line" ng-style="{'width' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.width - 2 * stage.config.bleed_lr)),
                                    'height' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.height - 2 * stage.config.bleed_tb)),
                                    'left' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_lr)),
                                    'top' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_tb))}"></div>
                                <div ng-show="settings.bleedLine" class="safe-line" ng-style="{'width' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.width - 2 * stage.config.bleed_lr - 2 * stage.config.margin_lr)),
                                    'height' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.height - 2 * stage.config.bleed_tb - 2 * stage.config.margin_tb)),
                                    'left' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_lr+stage.config.margin_lr)),
                                    'top' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_tb+stage.config.margin_tb))}"></div>                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-toolbar">
                    <div class="page-main">
                        <ul>
                            <li ng-class="$index == 0 ? 'disabled' : ''" ng-click="switchStage($index, 'prev')"><i class="icon-nbd icon-nbd-arrow-upward" title="<?php _e('Prev Page','web-to-print-online-designer'); ?>"></i></li>
                            <li><span style="font-size: 14px;">{{$index + 1}}/{{stages.length}}</span></li>
                            <li ng-class="$index == (stages.length - 1) ? 'disabled' : ''" ng-click="switchStage($index, 'next')"><i class="icon-nbd icon-nbd-arrow-upward rotate-180" title="<?php _e('Next Page','web-to-print-online-designer'); ?>"></i></li>
<!--                            <li><i class="icon-nbd icon-nbd-content-copy" title="<?php _e('Copy Design','web-to-print-online-designer'); ?>"></i></li>-->
                            <li><i class="icon-nbd icon-nbd-refresh" title="<?php _e('Clear Design','web-to-print-online-designer'); ?>"></i></li>
                        </ul>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="nbd-toolbar-zoom fullscreen-stage-nav">
        <div class="zoomer">
            <div class="zoomer-toolbar">
                <ul class="nbd-main-menu">
                    <li class="menu-item zoomer-item zoomer-fullscreen" ng-click="exitFullscreenMode()"><i class="icon-nbd icon-nbd-fullscreen"></i></li>
                    <li class="menu-item" ng-click="switchStage(currentStage, 'prev')" ng-class="currentStage > 0 ? '' : 'nbd-disabled'"><i class="icon-nbd icon-nbd-arrow-upward rotate-90"></i></li>
                    <li class="menu-item zoomer-item zoomer-level">{{currentStage+1}}/{{stages.length}}</li>
                    <li class="menu-item" ng-click="switchStage(currentStage, 'next')" ng-class="currentStage < (stages.length - 1) ? '' : 'nbd-disabled'"><i class="icon-nbd icon-nbd-arrow-upward rotate90"></i></li>
                </ul>
            </div>
        </div>
    </div>    
</div>