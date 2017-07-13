<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="pop-tools shadow active" ng-show="currentLayers.length > 0">
    <h2><i class="fa fa-arrows" aria-hidden="true"></i><span>{{(langs['TOOL']) ? langs['TOOL'] : "Tools"}}</span></h2>
    <div class="tools-con">
        <span class="fa fa-chevron-left" ng-click="ShiftLeft()"></span>      
        <span class="fa fa-chevron-right" ng-click="ShiftRight()"></span>  
        <span class="fa fa-chevron-up" ng-click="ShiftUp()"></span>
        <span class="fa fa-chevron-down" ng-click="ShiftDown()"></span>      
        <span class="fa fa-exchange" ng-click="flipVertical()"></span>      
        <span class="fa fa-exchange rotate90" ng-click="flipHorizontal()"></span>      
        <span class="glyphicon glyphicon-object-align-vertical" ng-click="setHorizontalCenter()"></span>      
        <span class="glyphicon glyphicon-object-align-horizontal" ng-click="setVerticalCenter()"></span>   
        <span class="fa fa-trash-o" onclick="deleteObject()"></span>      
        <span class="fa fa-files-o" ng-click="duplicateItem()"></span>      
        <span class="fa fa fa-plus" ng-click="scaleItem('+')"></span>      
        <span class="fa fa fa-minus" ng-click="scaleItem('-')"></span>   
        <span ng-click="setStackPosition('bringToFront')">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" focusable="false">
                    <g id="bring-front">
                        <path d="M2,2H11V6H9V4H4V9H6V11H2V2M22,13V22H13V18H15V20H20V15H18V13H22M8,8H16V16H8V8Z"></path>
                    </g>
                </svg>  
            </span>   
        </span>
        <span ng-click="setStackPosition('bringForward')">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" focusable="false">
                    <g id="bring-forward">
                        <path d="M2,2H16V16H2V2M22,8V22H8V18H10V20H20V10H18V8H22Z"></path>
                    </g>
                </svg>                
            </span>
        </span>
        <span ng-click="setStackPosition('sendBackwards')">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" focusable="false">
                    <g id="send-backward">
                        <path d="M2,2H16V16H2V2M22,8V22H8V18H18V8H22M4,4V14H14V4H4Z"></path>
                    </g>
                </svg> 
            </span>    
        </span>
        <span ng-click="setStackPosition('sendToBack')">
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


