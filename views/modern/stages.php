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
                </div>
            </div>
        </div>
    </div>
</div>