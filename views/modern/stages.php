<div class="nbd-stages" id="nbd-stages">
    <div class="stages-inner">
        <div class="stage" ng-repeat="stage in stages" id='stage-container-{{$index}}' ng-mousedown="onClickStage($event)" ng-class="{'hidden':$index > 0}" >
            <div ng-click="addRulerGuideLine( $event, 'hors' );$event.stopPropagation();" ng-style="{'padding-left': calcRulerPaddingLeft(stage.config.cwidth * stage.states.scaleRange[stage.states.currentScaleIndex].ratio)}" ng-class="settings.showRuler ? '' : 'nbd-hide'" class="nbd-hoz-ruler">
                <svg class="nbd-prevent-select" ng-style="{'width': calcStyle(stage.config.cwidth * stage.states.scaleRange[stage.states.currentScaleIndex].ratio + 30)}" id="hoz-ruler-{{$index}}" xmlns="http://www.w3.org/2000/svg"></svg>
            </div>
            <div ng-click="addRulerGuideLine( $event, 'vers' ); $event.stopPropagation()" ng-style="{'padding-top': calcRulerPaddingTop(stage.config)}" ng-class="settings.showRuler ? '' : 'nbd-hide'" class="nbd-ver-ruler">
                <svg class="nbd-prevent-select" ng-style="{'height': calcStyle(stage.config.cheight * stage.states.scaleRange[stage.states.currentScaleIndex].ratio + 30)}" id="ver-ruler-{{$index}}" xmlns="http://www.w3.org/2000/svg"></svg>
            </div>
            <div style="display: inline-block;position: relative;">
                <div class="stage-main" ng-class="stage.config.bgType == 'image' ? 'nbd-without-shadow' : ''" ng-style="{'width' : calcStyle(stage.config.cwidth * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                    'height' : calcStyle(stage.config.cheight * stage.states.scaleRange[stage.states.currentScaleIndex].ratio)}">
                    <div class="stage-background">
                        <img style="width: 100%; height: 100%;" ng-if="stage.config.bgType == 'image'" ng-src='{{stage.config.bgImage}}'/>
                    </div>
                    <div class="design-wrap" ng-style="{'width' : calcStyle(stage.config.width * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                        'height' : calcStyle(stage.config.height * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                        'top' : calcStyle(stage.config.top * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                        'left' : calcStyle(stage.config.left * stage.states.scaleRange[stage.states.currentScaleIndex].ratio)}">
                        <div class="design-zone" ng-class="stage.config.area_design_type == '2' ? 'nbd-round' : ''">
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
                                <div class="bounding-rect" ng-style="stages[currentStage].states.boundingObject">
                                    <span ng-if="settings.nbdesigner_show_layer_size == 'yes'" class="bounding-rect-real-size" ng-style="{'transform': stages[currentStage].states.boundingRealSize.transform}">{{stages[currentStage].states.boundingRealSize.size}}</span>
                                </div>
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
                        <div class="stage-overlay">
                            <img style="width: 100%; height: 100%;" ng-if="stage.config.show_overlay == '1'" ng-src='{{stage.config.img_overlay}}'/>
                        </div>				
                        <div class="stage-guideline">
                            <div style="position: relative; width: 100%; height: 100%;">
                                <div ng-class="stage.config.area_design_type == '2' ? 'nbd-round' : ''" ng-show="settings.bleedLine" class="bleed-line" ng-style="{'width' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.width - 2 * stage.config.bleed_lr)),
                                    'height' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.height - 2 * stage.config.bleed_tb)),
                                    'left' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_lr)),
                                    'top' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_tb))}"></div>
                                <div ng-class="stage.config.area_design_type == '2' ? 'nbd-round' : ''" ng-show="settings.bleedLine" class="safe-line" ng-style="{'width' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.width - 2 * stage.config.bleed_lr - 2 * stage.config.margin_lr)),
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
                            <?php if( $task == 'create_template' ): ?>
                            <li ng-click="addStage()"><i class="icon-nbd icon-nbd-content-copy" title="<?php _e('Add page','web-to-print-online-designer'); ?>"></i></li>
                            <?php endif; ?>
                            <li><i nbd-clear-stage class="icon-nbd icon-nbd-refresh" title="<?php _e('Clear Design','web-to-print-online-designer'); ?>"></i></li>
                        </ul>
                    </div>
                </div>
            </div> 
            <div class="nbd-prevent-event guide-backdrop"></div>
            <div ng-repeat="line in stage.rulerLines.hors" ng-style="calcStyleGuideline(line, stage.config, stage.states.scaleRange[stage.states.currentScaleIndex].ratio, 'hor')" data-cwidth="{{stage.config.cwidth}}" data-ratio="{{stage.states.scaleRange[stage.states.currentScaleIndex].ratio}}" data-offset="line.top" class="ruler-guideline-hor" ruler-guideline="hor"></div>
            <div ng-repeat="line in stage.rulerLines.vers" ng-style="calcStyleGuideline(line, stage.config, stage.states.scaleRange[stage.states.currentScaleIndex].ratio, 'ver')" data-cwidth="{{stage.config.cwidth}}" data-ratio="{{stage.states.scaleRange[stage.states.currentScaleIndex].ratio}}" data-offset="line.left" class="ruler-guideline-ver" ruler-guideline="ver"></div>            
        </div>
    </div>
    <div class="nbd-toolbar-zoom fullscreen-stage-nav">
        <div class="zoomer">
            <div class="zoomer-toolbar">
                <ul class="nbd-main-menu">
                    <li class="menu-item zoomer-item zoomer-fullscreen" ng-click="exitFullscreenMode()"><i class="icon-nbd icon-nbd-fullscreen"></i></li>
                    <li class="menu-item" ng-click="switchStage(currentStage, 'prev')" ng-class="currentStage > 0 ? '' : 'nbd-disabled'"><i class="icon-nbd icon-nbd-arrow-upward rotate-90"></i></li>
                    <li class="menu-item zoomer-item zoomer-level nbd-prevent-select">{{currentStage+1}}/{{stages.length}}</li>
                    <li class="menu-item" ng-click="switchStage(currentStage, 'next')" ng-class="currentStage < (stages.length - 1) ? '' : 'nbd-disabled'"><i class="icon-nbd icon-nbd-arrow-upward rotate90"></i></li>
                </ul>
            </div>
        </div>
    </div>    
</div>