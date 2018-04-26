<div class="nbd-toolbar">
    <div style="display: none" class="toolbar-text">
        <ul class="nbd-main-menu menu-left">
            <li class="menu-item item-font-familly">
                <button class="toolbar-bottom">
                    <span class="toolbar-label toolbar-label-font">Roboto</span>
                    <i class="icon-nbd icon-nbd-dropdown-arrows"></i>
                </button>
                <div class="sub-menu" data-pos="left">
                    <div class="toolbar-font-search">
                        <input type="search" name="font-search" value="" placeholder="Search"/>
                    </div>
                    <div id="toolbar-font-familly-dropdown">
                        <div class="group-font">
                            <div class="toolbar-menu-header">
                                <div class="toolbar-header-line"></div>
                                <div class="toolbar-separator">Font document</div>
                                <div class="toolbar-header-line"></div>
                            </div>
                            <ul>
                                <li class="sub-menu-item chosen">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/ABeeZee.png" alt="ABeeZee"/>
                                    <i class="icon-nbd icon-nbd-fomat-done"></i>
                                </li>

                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Abel.png" alt="Abel"/>
                                </li>

                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Abhaya Libre.png" alt="Abhaya Libre"/>
                                </li>

                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Abril Fatface.png" alt="Abril Fatface"/>
                                </li>
                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Aclonica.png" alt="Aclonica"/>
                                </li>
                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Acme.png" alt="Acme"/>
                                </li>
                            </ul>
                        </div>
                        <div class="group-font">
                            <div class="toolbar-menu-header">
                                <div class="toolbar-header-line"></div>
                                <div class="toolbar-separator">Font Vietnamese</div>
                                <div class="toolbar-header-line"></div>
                            </div>
                            <ul>
                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Actor.png" alt="Actor"/>
                                </li>
                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Adamina.png" alt="Adamina"/>
                                </li>
                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Advent Pro.png" alt="Advent Pro"/>
                                </li>
                                <li class="sub-menu-item">
                                    <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>/data/google-font-images/Aguafina Script.png" alt="Aguafina Script"/>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="menu-item item-font-size">
                <button class="toolbar-bottom">
                    <input class="toolbar-input" type="text" name="font-size" value="12"/>
                    <i class="icon-nbd icon-nbd-dropdown-arrows"></i>
                    <div class="sub-menu" data-pos="left">
                        <div id="toolbar-font-size-dropdown">
                            <ul>
                                <li class="sub-menu-item chosen">
                                    <span>12</span>
                                    <i class="icon-nbd icon-nbd-fomat-done"></i>
                                </li>

                                <li class="sub-menu-item">
                                    <span>14</span>
                                </li>

                                <li class="sub-menu-item">
                                    <span>16</span>
                                </li>

                                <li class="sub-menu-item">
                                    <span>18</span>
                                </li>
                                <li class="sub-menu-item">
                                    <span>20</span>
                                </li>
                                <li class="sub-menu-item">
                                    <span>22</span>
                                </li>
                                <li class="sub-menu-item">
                                    <span>24</span>
                                </li>
                                <li class="sub-menu-item">
                                    <span>26</span>
                                </li>
                                <li class="sub-menu-item">
                                    <span>28</span>
                                </li>
                                <li class="sub-menu-item">
                                    <span>30</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </button>
            </li>
        </ul>
        <ul class="nbd-main-menu menu-right">
            <li class="menu-item">
                <i class="icon-nbd icon-nbd-format-align-center nbd-tooltip-hover" title="Text align"></i>
                <div class="sub-menu" data-pos="center">
                    <ul>
                        <li class="sub-menu-item"><i class="icon-nbd icon-nbd-format-align-left nbd-tooltip-hover" title="Text align left"></i></li>
                        <li class="sub-menu-item"><i class="icon-nbd icon-nbd-format-align-center nbd-tooltip-hover" title="Text align justify"></i></li>
                        <li class="sub-menu-item"><i class="icon-nbd icon-nbd-format-align-justify nbd-tooltip-hover" title="Text align center"></i></li>
                        <li class="sub-menu-item"><i class="icon-nbd icon-nbd-format-align-right nbd-tooltip-hover" title="Text align right"></i></li>
                    </ul>
                </div>
            </li>
            <li class="menu-item"><i class="icon-nbd icon-nbd-uppercase nbd-tooltip-hover" title="Uppercase / Lowercase"></i></li>
            <li class="menu-item"><i class="icon-nbd icon-nbd-format-bold nbd-tooltip-hover" title="Text style bold"></i></li>
            <li class="menu-item"><i class="icon-nbd icon-nbd-format-italic nbd-tooltip-hover" title="Text style italic"></i></li>
            <li class="menu-item"><i class="icon-nbd icon-nbd-format-underlined nbd-tooltip-hover" title="Text underline"></i></li>
        </ul>
    </div>
    <div class="toolbar-image">
        <ul class="nbd-main-menu">
            <li class="menu-item menu-filter">
                <span>Filter</span>
                <div class="sub-menu" data-pos="left">
                    <ul class="filter-presets">
                        <li class="filter-scroll scrollLeft disable"><i class="icon-nbd icon-nbd-arrow-drop-down"></i></li>
                        <li class="container-presets">
                            <ul class="main-presets">
                                <li class="preset active">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>
                                <li class="preset">
                                    <div class="image">
                                        <div class="inner">
                                            <img src="<?php echo NBDESIGNER_PLUGIN_URL;?>assets/images/background/49.png"  alt="imge filter">
                                        </div>
                                    </div>
                                    <span class="title">Grayscale</span>
                                </li>

                            </ul>
                        </li>
                        <li class="filter-scroll scrollRight"><i class="icon-nbd icon-nbd-arrow-drop-down"></i></li>
                    </ul>
                    <div class="filter-ranges">
                       <ul class="main-ranges">
                           <li class="range range-brightness">
                               <label>Brightness</label>
                               <div class="main-track">
                                   <input class="slide-input" type="range" step="1" min="-100" max="100" value="50">
                                   <span class="range-track"></span>
                                   <span class="snap-guide"></span>
                               </div>
                               <span class="value-display">0</span>
                           </li>
                           <li class="range range-brightness">
                               <label>Brightness</label>
                               <div class="main-track">
                                   <input class="slide-input" type="range" step="1" min="-100" max="100" value="50">
                                   <span class="range-track"></span>
                                   <span class="snap-guide"></span>
                               </div>
                               <span class="value-display">50</span>
                           </li>
                           <li class="range range-brightness">
                               <label>Brightness</label>
                               <div class="main-track">
                                   <input class="slide-input" type="range" step="1" min="-100" max="100" value="50">
                                   <span class="range-track"></span>
                                   <span class="snap-guide"></span>
                               </div>
                               <span class="value-display">50</span>
                           </li>
                           <li class="range range-brightness">
                               <label>Brightness</label>
                               <div class="main-track">
                                   <input class="slide-input" type="range" step="1" min="-100" max="100" value="50">
                                   <span class="range-track"></span>
                                   <span class="snap-guide"></span>
                               </div>
                               <span class="value-display">50</span>
                           </li>
                           <li class="range range-brightness">
                               <label>Brightness</label>
                               <div class="main-track">
                                   <input class="slide-input" type="range" step="1" min="-100" max="100" value="50">
                                   <span class="range-track"></span>
                                   <span class="snap-guide"></span>
                               </div>
                               <span class="value-display">50</span>
                           </li>
                           <li class="range range-brightness">
                               <label>Brightness</label>
                               <div class="main-track">
                                   <input class="slide-input" type="range" step="1" min="-100" max="100" value="50">
                                   <span class="range-track"></span>
                                   <span class="snap-guide"></span>
                               </div>
                               <span class="value-display">50</span>
                           </li>
                       </ul>
                    </div>
                </div>
            </li>
            <li class="menu-item menu-crop">Crop</li>
        </ul>
    </div>
    <div class="toolbar-common">
        <ul class="nbd-main-menu">
            <li class="menu-item item-color-fill">
                <i class="icon-nbd icon-nbd-format-color-fill nbd-tooltip-hover font-21 color-fill" title="color"></i>
                <div class="sub-menu" data-pos="center">
                    <div class="nbd-color-palette" style="position: relative">
                        <h3 class="color-palette-label">Color document</h3>
                        <div class="working-palette">
                            <ul class="main-color-palette">
                                <li class="color-palette-add"></li>
                                <li class="color-palette-item" data-color="#253702" title="#253702" style="color: red;"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                            </ul>
                            <ul class="main-color-palette">
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                            </ul>
                        </div>
                        <h3 class="color-palette-label">Color document</h3>
                        <div class="pinned-palette">
                            <ul class="main-color-palette">
                                <li class="color-palette-item" data-color="#253702" title="#253702" style="color: red;"></li>
                                <li class="color-palette-item" data-color="#253702" title="#253702" style="color: green;"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                            </ul>
                        </div>
                        <div class="pinned-palette">
                            <ul class="main-color-palette">
                                <li class="color-palette-item" data-color="#253702" title="#253702" style="color: red;"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                                <li class="color-palette-item"></li>
                            </ul>
                        </div>

                        <div class="color-palette-popup"></div>

                    </div>
                </div>
            </li>
            <li class="menu-item item-stack">
                <i class="icon-nbd icon-nbd-layer-stack nbd-tooltip-hover" title="layer stack"></i>
                <div class="sub-menu" data-pos="right">
                    <ul>
                        <li class="sub-menu-item">
                            <span><i class=""></i> Bring to Front</span>
                            <span>Ctrl+Shift+]</span>
                        </li>
                        <li class="sub-menu-item">
                            <span><i class=""></i> Bring Forward</span>
                            <span>Ctrl+]</span>
                        </li>
                        <li class="sub-menu-item">
                            <span><i class=""></i> Send to Backward</span>
                            <span>Ctrl+[</span>
                        </li>
                        <li class="sub-menu-item">
                            <span><i class=""></i> Send to Back</span>
                            <span>Ctrl+Shift+[</span>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item item-position">
                <i class="icon-nbd icon-nbd-apps nbd-tooltip-hover" title="layer position" style="font-size: 21px;"></i>
                <div class="sub-menu" data-pos="right">
                    <ul>
                        <li class="title">
                            <span>Layer position</span>
                            <i class="colse"></i>
                        </li>
                        <li><i class="icon-nbd icon-nbd-fomat-vertical-align-center nbd-tooltip-hover" title="Center vertical"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-90" title="Top left"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-45" title="Top center"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover" title="Top right"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-vertical-align-center nbd-tooltip-hover rotate90" title="Center horizontal"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-135" title="Middle left"></i></li>
                        <li><i class="icon-nbd icon-nbd-bottom-center nbd-tooltip-hover middle-center" title="Middle center"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate45" title="Middle right"></i></li>
                        <li><i class="icon-nbd icon-nbd-info-circle nbd-tooltip-hover" title="Intro"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate-180" title="Bottom left"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate135" title="Bottom center"></i></li>
                        <li><i class="icon-nbd icon-nbd-fomat-top-left nbd-tooltip-hover rotate90" title="Bottom right"></i></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>