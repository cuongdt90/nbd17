<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div class="form-group">
    <h2>{{(langs['UPLOAD_DESIGN']) ? langs['UPLOAD_DESIGN'] : "Upload design"}}</h2>
    <p>
        <!-- check number upload files -->
        <input type="file" id="nbd-file-upload" autocomplete="off" ng-file-select="onFileUploadSelect($files)" class="inputfile"/> 
        <label for="nbd-file-upload">
            <span></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"> 
                </path>
            </svg>
            <span>{{(langs['CHOOSE_FILE']) ? langs['CHOOSE_FILE'] : "Choose a file to upload"}}</span>
        </label>
    </p>
    <p ng-if="fileUpload.length > 0" class="file-upload-name">{{fileUpload[0]['name']}}</p>
    <p ng-show="fileUpload.length > 0">
        <button class="btn btn-primary shadow nbdesigner_upload" ng-click="startUploadDesign()">{{(langs['UPLOAD']) ? langs['UPLOAD'] : "Upload"}}</button>
    </p>
    <div class="progress progress-bar-container" ng-show="loading">
        <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="{{progressUpload}}"
             aria-valuemin="0" aria-valuemax="100" ng-style="{'width': progressUpload + '%'}" >{{progressUpload}}%</div>
    </div>     
    <div class="upload-design-preview" id="upload-design-preview">
        <!-- show preview design -->
        <div ng-repeat="file in listFileUpload" class="nbd-upload-items">
            <div class="nbd-upload-items-inner">
                <img ng-src="{{file}}" class="shadow nbd-upload-item"/>
                <span ng-click="deleteUploadfile($index)" class="shadow"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
    <div ng-show="listFileUpload.length > 0">
        <span class="submit-upload-design shadow" ng-click="completeUpload()">{{(langs['COMPLETE']) ? langs['COMPLETE'] : "Complete"}}</span>
    </div>
    <p style="margin: 10px;"><a ng-click="changeDesignMode('custom')">{{(langs['OR_DESIGN_YOUR_OWN']) ? langs['OR_DESIGN_YOUR_OWN'] : "Or design your own"}}</a></p>
</div>

