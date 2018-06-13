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
    .nbd-main-menu button.menu-item.disabled, .nbd-main-menu li.menu-item.disabled {
        pointer-events: none;
        opacity: 0.3;
    }
    .nbd-disabled {
        pointer-events: none;
        opacity: 0.3;
    }
    .color-palette-add {
        position: relative;
    }
    .color-palette-add:after {
        content: '+';
        position: absolute;
        top: 0;
        left:0;
        width: 40px;
        height: 40px;  
        display: inline-block;
        line-height: 40px;
        content: "\e908";
        text-align: center;
        color: #888888;
        font-family: online-design!important;
        font-size: 20px;
    }
    .nbd-text-color-picker {
        position: absolute; 
        left: 40px; 
        top: 50px;
        -webkit-transform: scale(.8);
        -ms-transform: scale(.8);
        transform: scale(.8); 
        visibility: hidden;
        opacity: 0;
        -webkit-transition: all .3s;
        -moz-transition: all .3s;        
        transition: all .3s; 
        -webkit-box-shadow: 1px 0 15px rgba(0,0,0,.2);    
        box-shadow: 1px 0 15px rgba(0,0,0,.2);    
        background-color: #fff;
        overflow: hidden;
    }
    .nbd-text-color-picker.active {
        opacity: 1;
        visibility: visible;
        -webkit-transform: scale(1);
        -ms-transform: scale(1);
        transform: scale(1);        
    }
    .nbd-color-palette {
        opacity: 0;
        display: block !important;
        visibility: hidden;
        -webkit-transform: scale(0.8);
        -ms-transform: scale(0.8);
        transform: scale(0.8);  
        -webkit-transition: all .4s;
        -moz-transition: all .4s;        
        transition: all .4s;         
    }
    .nbd-color-palette-inner .nbd-perfect-scroll{
        max-height: 200px;        
    }
    .nbd-color-palette.show {
        opacity: 1;
        visibility: visible;
        -webkit-transform: scale(1);
        -ms-transform: scale(1);
        transform: scale(1);           
    }    
    .nbd-sp.sp-container {
        box-shadow: none;
    }
    .nbd-text-color-picker .nbd-button {
        margin-top: 0;
        margin-left: 11px;
        margin-bottom: 10px;        
    }
    .nbd-workspace .main {
        overflow: hidden;
    }
    .tab-main .loading-photo {
        position: absolute;
        z-index: 99;
        left: 50%;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
    }    
    .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item {
        opacity: 0;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -ms-transition: all 0.4s;
        transition: all 0.4s;
    }
    .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item.in-view {
        opacity: 1;
    }
    .nbd-sidebar #tab-typography .tab-main .typography-body .typography-item img {
        background: none;
    }
    .popup-share.nbd-popup .overlay-main {
        background: rgba(255,255,255,0.85);
    }
    .nbd-tool-lock {
        top: 50px;
    }
    .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .sub-menu>div#toolbar-font-size-dropdown {
        max-height: 240px;
    } 
    .nbd-toolbar .toolbar-text .nbd-main-menu.menu-right .sub-menu ul li.selected {
        background-color: rgba(158,158,158,.2);
    }
    @keyframes timeline {
        0% {
            background-position: -350px 0;
        }
        100% {
            background-position: 400px 0;
        }
    }
    .font-loading {
        animation: timeline;
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
        background-size: 800px auto;
        background-position: 100px 0;
        pointer-events: none;
        opacity: 0.7;
    }
    .group-font li {
        cursor: pointer;
    }
    .nbd-main-menu .sub-menu li span.font-name-wrap {
        line-height: 40px;
        width: 100%;
        display: flex;
        justify-content: space-between;
    }
    .nbd-main-menu .sub-menu li span.font-name {
        margin-right: 10px;
        font-size: 18px;
    }
    .nbd-main-menu .sub-menu li .font-selected {
        line-height: 40px;
        margin-left: 5px;
        color: #404762;
    }
    .toolbar-font-search i.icon-nbd-clear {
        position: absolute;
        right: 15px;
        top: 10px;
        width: 24px;
        height: 33px;
        line-height: 33px;
        cursor: pointer;
    }
    .clipart-wrap .clipart-item,
    .mansory-wrap .mansory-item {
        visibility: visible !important; 
        width: 33.33%;
        padding: 2px;
        opacity: 0;
        z-index: 3;
        cursor: pointer;
    }
    .mansory-wrap{
        margin-top: 15px;
    }
    .clipart-wrap .clipart-item img {
        border: 4px solid rgba(64, 71, 98, 0.08);
        background: #d0d6dd;
    }
    .mansory-wrap .mansory-item.in-view,
    .clipart-wrap .clipart-item.in-view {
        opacity: 1;
    }
    .mansory-wrap .mansory-item .photo-desc {
        position: absolute;
        opacity: 0;
        visibility: hidden;
        -webkit-transform: translateY(50%);
        -ms-transform: translateY(50%);
        transform: translateY(50%);
        -webkit-transition: all .2s;
        transition: all .2s;
        bottom: 2px;
        left: 2px;
        padding: 2px 10px;
        display: block;
        width: -webkit-calc(100% - 4px);
        width: calc(100% - 4px);
        text-align: left;
        background: rgba(0,0,0,.3);
        color: #fff;
        font-size: 10px;        
    }
    .mansory-wrap .mansory-item:hover .photo-desc {
        opacity: 1;
        visibility: visible;
        -webkit-transform: translateY(0);
        -ms-transform: translateY(0);
        transform: translateY(0);        
    }
    .mansory-wrap .mansory-item 
    .nbd-sidebar #tab-svg .cliparts-category {
        margin-top: 70px;
        padding: 0px 10px 10px;        
    }
    .nbd-perfect-scroll {
        position: relative;
        overflow: hidden;        
    }
    .nbd-onload {
        pointer-events: none;
        opacity: 0.7;
    }
    .nbd-color-picker-preview {
        width: 24px;
        height: 24px;
        border-radius: 4px;
        display: inline-block;
        box-shadow: rgba(0, 0, 0, 0.15) 1px 1px 6px inset, rgba(255, 255, 255, 0.25) -1px -1px 0px inset;        
    }
    .nbd-toolbar .main-toolbar .tool-path li.menu-item.item-color-fill {
        margin: 0;
        padding: 2px;
    }
    .nbd-sidebar #tab-photo .nbd-items-dropdown .main-items .items .item[data-type="pixabay"] .main-item .item-icon {
        padding: 10px 20px;
    }
    .nbd-sidebar #tab-photo .nbd-items-dropdown .main-items .items .item[data-type="pixabay"] .main-item .item-icon i {
        font-size: 60px;
    }
    .nbd-sidebar .nbd-items-dropdown .result-loaded .nbdesigner-gallery .nbdesigner-item .photo-desc {
        font-size: 10px;
    }
    .nbd-sidebar #tab-photo .nbd-items-dropdown .loading-photo {
        width: 40px;
        height: 40px;
        position: unset;
        margin-left: 50%;
        margin-top: 20px;        
    }
    .nbd-sidebar .nbd-items-dropdown .info-support {
        top: 62px;
    }
    .nbd-sidebar .nbd-items-dropdown .info-support i.close-result-loaded {
        right: 0;
    }
    .nbd-sidebar .nbd-items-dropdown .info-support i, .nbd-sidebar .nbd-items-dropdown .info-support span {
        background: #404762;
    }    
    #tab-photo .ps-scrollbar-x-rail {
        display: none;
    }
    .type-instagram.button-login {
        display: flex;
        margin: auto;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;        
    }
    .type-instagram.button-login .icon-nbd {
        color: #fff;
        vertical-align: middle;
        font-size: 20px;
        margin-right: 5px;        
    }
    .type-instagram.button-login span {
        color: #fff;
    }
    .popup-term .head {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;        
    }
    .form-control:focus {
        border-color: rgba(64, 71, 98, 1);
        outline: 0;
        box-shadow: none;
    }    
    .nbd-dnd-file {
        cursor: pointer;
    }
    .nbd-dnd-file.highlight {
        border: 2px dashed rgba(64, 71, 98, 1) !important;
    }
    .nbd-sidebar .tab-scroll{
        -ms-overflow-style:none;
    }
    .nbd-onloading {
        pointer-events: none;
    }  
    .nbd-stages .stage {
        padding: 40px 50px 50px;
        overflow: hidden;
        height: 100%;
        width: 100%;
        position: absolute;
        display: block;
        text-align: center;
    }  
    .nbd-toolbar-zoom {
        bottom: 15px;
    }
    .nbd-stages .stage .page-toolbar {
        position: absolute;
        top: calc(50% + 30px);
        right: -40px;
        transform: translateY(-50%);
        height: unset;
        margin: 0;
    }
    .nbd-toolbar-zoom .zoomer-toolbar .nbd-main-menu {
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12); 
    }
    .bleed-line, .safe-line {
        box-sizing: border-box;
        position: absolute;
    }
    .bleed-line {
        border: 1px solid red;
    }
    .safe-line {
        border: 1px solid green;
    }   
    .fullScreenMode .design-zone {
        pointer-events: none;
    }
    .fullScreenMode .page-toolbar {
        display: none;
    }
    .fullScreenMode .stage{
        background: #000;
        padding: 0;
    }
    .nbd-sidebar #tab-element .main-items .item[data-type=draw] .item-icon i {
        color: #404762;
    }   
    .nbd-sidebar #tab-layer .inner-tab-layer .menu-layer .menu-item.active {
        border: 1px solid #404762;
    }
    .sortable-placeholder {
        border: 3px dashed #aaa;
        height: 50px;
        display: flex;
        margin: 4px;
    }
    .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .toolbar-bottom span {
        line-height: 24px;
    }
    .nbd-sidebar #tab-element .nbd-items-dropdown .content-items .content-item.type-qrcode .main-input input {
        padding: 10px;
    }
    .nbd-hiden {
        visibility: hidden;
    }
    @media screen and (max-width: 767px) {
        .nbd-toolbar .toolbar-common .nbd-main-menu li.menu-item.active > i {
            color: #404762;
        }
        .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .toolbar-input {
            width: 50px;
        }
        .nbd-toolbar .toolbar-text .nbd-main-menu.menu-left .menu-item .toolbar-bottom {
            padding: 0px 10px;
        }
        .nbd-stages .stage {
            padding: 10px;
        }
    }
</style>
<div class="nbd-stages">
    <div class="stages-inner">
        <div class="stage" ng-repeat="stage in stages" id='stage-container-{{$index}}' ng-click="onClickStage($event)" ng-class="{'hidden':$index > 0}" >
            <div style="display: inline-block;position: relative;">
                <?php include 'warning.php'?>
                <div class="stage-main" ng-style="{'width' : calcStyle(stage.config.width * stage.states.scaleRange[stage.states.currentScaleIndex].ratio),
                    'height' : calcStyle(stage.config.height * stage.states.scaleRange[stage.states.currentScaleIndex].ratio)}">
                    <div class="stage-background" ></div>
                    <div class="design-zone">
                        <canvas nbd-canvas stage="stage" ctx="ctxMenuStyle" index="{{$index}}" id="nbd-stage-{{$index}}"></canvas>
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
                        <div style="position: relative;">
                            <div ng-show="settings.bleedLine" class="bleed-line" ng-style="{'width' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.width - 2 * stage.config.bleed_lr)),
                                'height' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.height - 2 * stage.config.bleed_tb)),
                                'left' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * stage.config.bleed_lr),
                                'top' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * stage.config.bleed_tb)}"></div>
                            <div ng-show="settings.bleedLine" class="safe-line" ng-style="{'width' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.width - 2 * stage.config.bleed_lr - 2 * stage.config.margin_lr)),
                                'height' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.height - 2 * stage.config.bleed_tb - 2 * stage.config.margin_tb)),
                                'left' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_lr+stage.config.margin_lr)),
                                'top' : calcStyle(stage.states.scaleRange[stage.states.currentScaleIndex].ratio * (stage.config.bleed_tb+stage.config.margin_tb))}"></div>                            
                        </div>
                    </div>
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
</div>