<div class="nbd-main-bar">
    <a href="#" class="logo"><img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/netbaseteam.png" alt="online design"></a>
    <ul class="nbd-main-menu menu-left">
        <li class="menu-item item-edit" data-overlay="overlay">
            <span>Edit</span>
            <div class="sub-menu" data-pos="left">
                <ul>
                    <li class="sub-menu-item flex space-between">
                        <span>Import file</span>
                        <small>(Ctrl+O)</small>
                    </li>
                    <li class="sub-menu-item flex space-between">
                        <span>Export file</span>
                        <small>(Ctrl+O)</small>
                    </li>
                    <li class="sub-menu-item flex space-between">
                        <span>Clear all design</span>
                        <small>(Ctrl+O)</small>
                    </li>
                </ul>
            </div>
            <div id="nbd-overlay"></div>
        </li>
        <li class="menu-item item-view">
            <span>View</span>
            <ul class="sub-menu" data-pos="left">
                <li class="sub-menu-item flex space-between">
                    <span>Show rule</span>
                    <small>(Ctrl+O)</small>
                </li>
                <li class="sub-menu-item flex space-between">
                    <span>show grid</span>
                    <small>(Ctrl+O)</small>
                </li>
                <li class="sub-menu-item flex space-between hover-menu">
                    <span>show guideline</span>
                    <small>(Ctrl+O)</small>
                    <i class="icon-nbd icon-nbd-arrow-drop-down rotate-90"></i>
                    <div class="hover-sub-menu-item">
                        <ul>
                            <li>Layer</li>
                            <li>Bounding</li>
                            <li>grid</li>
                        </ul>
                    </div>
                </li>
                <li class="sub-menu-item flex space-between">
                    <span>snap mode</span>
                    <small>(Ctrl+O)</small>
                </li>
                <li class="sub-menu-item flex space-between">
                    <span>snap warning</span>
                    <small>(Ctrl+O)</small>
                </li>
            </ul>
            <div id="nbd-overlay"></div>
        </li>

    </ul>
    <ul class="nbd-main-menu menu-center">

        <li class="menu-item">
            <i class="icon-nbd icon-nbd-undo2"></i>
            <span>undo</span>
        </li>

        <li class="menu-item active">
            <i class="icon-nbd icon-nbd-redo2"></i>
            <span>redo</span>
        </li>
    </ul>
    <ul class="nbd-main-menu menu-right">
        <li class="menu-item">
            <input type="text" name="title" class="title" placeholder="Title"/>
        </li>
        <li class="menu-item item-share nbd-show-popup-share"><i class="icon-nbd icon-nbd-share2"></i><span>Share</span></li>
        <li class="menu-item item-process" data-overlay="overlay">
            <i class="icon-nbd icon-nbd-process"></i><span>Process</span>
            <div class="sub-menu" data-pos="right">
                <div class="main-sub-menu">
                    <div class="sub-header">
                        <span>Product Option</span>
                        <i class="icon-nbd-clear nbd-close-sub-menu"></i>
                    </div>
                    <div class="sub-body">
                        <select class="process-select">
                            <option value="pdf-standard"><span>PDF-Standard</span></option>
                            <option value="pdf-print"><span>PDF-Standard</span></option>
                            <option value="jpg"><span>JPG</span></option>
                            <option value="png"><span>PNG</span></option>
                        </select>
                    </div>
                    <div class="sub-footer">
                        <button class="nbd-button nbd-add-to-cart">Add To Cart</button>
                        <i class="icon-nbd-info-circle nbd-show-popup-fileType nbd-hover-shadow"></i>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>