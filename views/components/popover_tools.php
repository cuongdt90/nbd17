<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="pop-tools shadow active" ng-show="currentLayers.length > 0">
    <h2><i class="fa fa-arrows" aria-hidden="true"></i><span>{{(langs['TOOL']) ? langs['TOOL'] : "Tools"}}</span></h2>
    <div class="tools-con">
        <span class="fa fa-chevron-left" ng-click="ShiftLeft()" title="Move left"></span>      
        <span class="fa fa-chevron-right" ng-click="ShiftRight()" title="Move right"></span>  
        <span class="fa fa-chevron-up" ng-click="ShiftUp()" title="Move up"></span>
        <span class="fa fa-chevron-down" ng-click="ShiftDown()" title="Move down"></span>      
        <span class="fa fa-exchange" ng-click="flipVertical()" title="Flip Horizontal"></span>      
        <span class="fa fa-exchange rotate90" ng-click="flipHorizontal()" title="Flip Vertical"></span>      
        <span class="glyphicon glyphicon-object-align-vertical" ng-click="setHorizontalCenter()" title="Center Horizontal"></span>      
        <span class="glyphicon glyphicon-object-align-horizontal" ng-click="setVerticalCenter()" title="Center Vertical"></span>   
        <span class="fa fa-trash-o" onclick="deleteObject()" title="Delete"></span>      
        <span class="fa fa-files-o" ng-click="duplicateItem()" title="Copy"></span>      
        <span class="fa fa fa-plus" ng-click="scaleItem('+')" title="Zoom In"></span>      
        <span class="fa fa fa-minus" ng-click="scaleItem('-')" title="Zoom Out"></span>   
        <span ng-click="setStackPosition('bringToFront')" title="Bring To Front">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" focusable="false">
                    <g id="bring-front">
                        <path d="M2,2H11V6H9V4H4V9H6V11H2V2M22,13V22H13V18H15V20H20V15H18V13H22M8,8H16V16H8V8Z"></path>
                    </g>
                </svg>  
            </span>   
        </span>
        <span ng-click="setStackPosition('bringForward')" title="Bring Forward">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" focusable="false">
                    <g id="bring-forward">
                        <path d="M2,2H16V16H2V2M22,8V22H8V18H10V20H20V10H18V8H22Z"></path>
                    </g>
                </svg>                
            </span>
        </span>
        <span ng-click="setStackPosition('sendBackwards')" title="Send Backward">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" focusable="false">
                    <g id="send-backward">
                        <path d="M2,2H16V16H2V2M22,8V22H8V18H18V8H22M4,4V14H14V4H4Z"></path>
                    </g>
                </svg> 
            </span>    
        </span>
        <span ng-click="setStackPosition('sendToBack')" title="Send To Back">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" focusable="false"
                    <g id="send-back">
                        <path d="M2,2H11V11H2V2M9,4H4V9H9V4M22,13V22H13V13H22M15,20H20V15H15V20M16,8V11H13V8H16M11,16H8V13H11V16Z"></path>
                    </g>
                </svg>                
            </span>
        </span>
    </div>
</div>


