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
    .bounding-layers-inner {
        position: relative;
        width: 100%;
        height: 100%;
    }
</style>
<div class="nbd-stages">
    <div class="stages-inner">
        <div class="stage" ng-repeat="stage in stages" id='stage-container-{{$index}}' ng-click="onClickStage($event)" ng-class="{'hidden':$index > 0}" >
            <div class="stage-main">
                <div class="stage-background"></div>
                <div class="design-zone">
                    <canvas nbd-canvas stage="stage" ctx="ctxMenuStyle" index="{{$index}}" id="nbd-stage-{{$index}}"></canvas>
                </div>
                <div class="stage-grid"></div>
                <div class="bounding-layers">
                    <div class="bounding-layers-inner">
                        <div
                            
                        >
                        </div>
                    </div>
                </div>
                <div class="stage-snapLines"></div>
                <div class="stage-overlay"></div>
				<div class="nbd-warning">
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