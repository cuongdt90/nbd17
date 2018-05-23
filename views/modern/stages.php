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
</style>
<div class="nbd-stages">
    <div class="stages-inner">
        <div class="stage" ng-repeat="stage in stages">
            <div class="stage-main">
                <div class="stage-background"></div>
                <div class="design-zone">
                    <canvas nbd-canvas stage="stage" index="{{$index}}" id="nbd-stage-{{$index}}"></canvas>
                </div>
                <div class="stage-grid"></div>
                <div class="bounding-layers"></div>
                <div class="stage-snapLines"></div>
                <div class="stage-overlay"></div>
                <div class="stage-guideline"></div>
            </div>
            <div class="page-toolbar">
                <div class="page-main">
                    <ul>
                        <li class="disabled"><i class="icon-nbd icon-nbd-arrow-upward" title="Prev Page"></i></li>
                        <li><span>1</span></li>
                        <li><i class="icon-nbd icon-nbd-arrow-upward rotate-180" title="Next Page"></i></li>
                        <li><i class="icon-nbd icon-nbd-content-copy" title="Copy Design"></i></li>
                        <li><i class="icon-nbd icon-nbd-refresh" title="Reset Design"></i></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>