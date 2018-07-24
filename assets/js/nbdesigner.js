jQuery(document).ready(function () {
    if( jQuery('#triggerDesign').length > 0 && nbds_frontend.hide_cart_button == 'yes'){
        jQuery('button[type="submit"].single_add_to_cart_button').hide();
    };
    var width = jQuery(window).innerWidth();
    var height = jQuery(window).height();
    var w = -width;
    var h = -height;
    var nbd_append_iframe = false;
    var showDesignFrame = function(){
        jQuery('body').addClass('nbd-prevent-scroll');
        if( nbd_layout == 'c' ){
            if( !nbd_append_iframe ){
                var iframe_src = jQuery('#container-online-designer').attr('data-iframe');
                if( jQuery('input[name="variation_id"]').length ){
                    iframe_src = addParameter(iframe_src, 'variation_id', jQuery('input[name="variation_id"]').val(), false);
                }
                jQuery('#nbd-custom-design-wrap').prepend('<iframe id="onlinedesigner-designer"  width="100%" height="100%" scrolling="no" frameborder="0" noresize="noresize" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" src="'+iframe_src+'"></iframe>');
                nbd_append_iframe = true;
            }
        }else{
            if(is_nbd_upload_without_design){
                jQuery('#nbd-m-upload-design-wrap').addClass('is-visible');
            }else if( !is_nbd_upload ){
                if( !nbd_append_iframe ){
                    var iframe_src = jQuery('#container-online-designer').attr('data-iframe');
                    if( jQuery('input[name="variation_id"]').length ){
                        iframe_src = addParameter(iframe_src, 'variation_id', jQuery('input[name="variation_id"]').val(), false);
                    }
                    jQuery('#nbd-m-custom-design-wrap').prepend('<iframe id="onlinedesigner-designer"  width="100%" height="100%" scrolling="no" frameborder="0" noresize="noresize" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" src="'+iframe_src+'"></iframe>');        
                    nbd_append_iframe = true;
                }
                jQuery('#nbd-m-custom-design-wrap').addClass('is-visible');
            }
        }
        jQuery('#container-online-designer').addClass('is-visible');
    };
    jQuery('#triggerDesign').on('click', function () {
        if(jQuery(this).hasClass('nbdesigner_disable')){
            jQuery('.single_add_to_cart_button').trigger('click');
        }else{
            showDesignFrame();
        }
    });
    jQuery('#closeFrameDesign').on('click', function () {
        hideDesignFrame();
    });
    jQuery('#nbd__content__overlay').on('click', function (event) {
       if(event.target.id == 'nbd__content__overlay'){
           hideDesignFrame();
       }
    });
    jQuery('#open_m-custom-design-wrap').on('click', function (event) {
        jQuery('.nbd-popup-wrap').addClass('is-hidden');
        if( !nbd_append_iframe ){
            var iframe_src = jQuery('#container-online-designer').attr('data-iframe');
            if( jQuery('input[name="variation_id"]').length ){
                iframe_src = addParameter(iframe_src, 'variation_id', jQuery('input[name="variation_id"]').val(), false);
            }
            jQuery('#nbd-m-custom-design-wrap').prepend('<iframe id="onlinedesigner-designer"  width="100%" height="100%" scrolling="no" frameborder="0" noresize="noresize" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" src="'+iframe_src+'"></iframe>');        
            nbd_append_iframe = true;
        }
        jQuery('#nbd-m-custom-design-wrap').addClass('is-visible');
    });    
    jQuery('#open_m-upload-design-wrap').on('click', function (event) {
        jQuery('.nbd-popup-wrap').addClass('is-hidden');
        jQuery('#nbd-m-upload-design-wrap').addClass('is-visible');
    });  
    backtoOption = function(){
        jQuery('#nbd-m-upload-design-wrap').removeClass('is-visible');
        jQuery('#nbd-m-custom-design-wrap').removeClass('is-visible');
        jQuery('.nbd-popup-wrap').removeClass('is-hidden');
    };    
    hideDesignFrame = function (mes) {
        jQuery('body').removeClass('nbd-prevent-scroll');
        jQuery('#container-online-designer').removeClass('is-visible');
        backtoOption();
        if (mes != null) {
            setTimeout(function () {
                alert(mes);
            }, 700);
        }
    };
    show_upload_thumb = function( arr ){
        if( arr.length ){
            jQuery('#nbdesigner-upload-title').show();     
        }else{
            jQuery('#nbdesigner-upload-title').hide();     
        };    
        var html = '';
        var d = new Date();
        jQuery.each(arr, function (key, val) {
            html += '<div class="img-con" style=\"display: inline-block; margin-right: 15px;\"><img src="' + val.src + '?t=' + d.getTime() +'" style=\"width: 100px;\"/><p class="nbd-file-title">'+val.name+'</p></div>'
        });
        jQuery('#nbdesigner_upload_preview').html('').append(html);         
    }
    jQuery('#nbdesign-new-template').on('click', function(){
        showDesignFrame();
    });
    jQuery(window).on('resize', function () {
        var width = jQuery(window).width(),
                height = jQuery(window).height();
        //jQuery('#container-online-designer').css({'height': height});
    });  
    jQuery('.nbd-order-download-pdf-action').each(function(index) {
        var download_pdf = jQuery(this),
            loading_src = download_pdf.attr('data-loading-img'),
            download_action = download_pdf.attr('data-action');
        download_pdf.prepend('<span class="nbd-loading"><img class="nbd-pdf-loading hide" src="'+loading_src+'"/></span>');
        download_pdf.on('click', function(e){
            download_action == 'download_pdf_in_order' ? NBDESIGNERPRODUCT.download_pdf_in_order(e, jQuery(this)) : NBDESIGNERPRODUCT.nbd_download_final_pdf(e, jQuery(this));
        });        
    });
    jQuery('.nbd-pdf-options').show();
    jQuery.each(jQuery('.nbd-order-item-download-section'), function( index, value ){
        var self = jQuery(this),
            link = self.attr('data-href'),
            download_title = self.attr('data-title'),
            type = JSON.parse( self.attr('data-type') ),
            type_len = 0,
            op_el = '<select onchange="NBDESIGNERPRODUCT.change_nbd_download_type( this )">';
        jQuery.each(type, function( index, value ){
            op_el += '<option value="'+index+'">'+value+'</option>';
            type_len++;
        });
        op_el += '</select>';
        if( type_len ) {
            self.append(op_el);
            self.append('<a class="button nbd-order-download-file" href="'+link+'&type=png">'+download_title+'</a>');
            self.show()            
        };    
    });
    /* Drag & Drop uplod file */
        var nbdDropArea = jQuery('label[for="nbd-file-upload"]'),
        nbdInput = jQuery('#nbd-file-upload');
        var listFileUpload = [];
        ['dragenter', 'dragover'].forEach(function(eventName){
            nbdDropArea.on(eventName, highlight)
        });
        ['dragleave', 'drop'].forEach(function(eventName){
            nbdDropArea.on(eventName, unhighlight)
        });
        function highlight(e) {
            e.preventDefault();
            e.stopPropagation();
            nbdDropArea.addClass('highlight');
        };
        function unhighlight(e) {
            e.preventDefault();
            e.stopPropagation();
            nbdDropArea.removeClass('highlight');
        };
        nbdDropArea.on('drop', handleDrop);
        function handleDrop(e) {
            if( jQuery('#accept-term').length && !jQuery('#accept-term').is(':checked') ) {
                alert(NBDESIGNCONFIG.nbdlangs.alert_upload_term);
                return;
            }else{
                if(e.originalEvent.dataTransfer){
                    if(e.originalEvent.dataTransfer.files.length) {
                        e.preventDefault();
                        e.stopPropagation();
                        handleFiles(e.originalEvent.dataTransfer.files);
                    }                        
                }                        
            }
        };
        nbdInput.on('click', function(e){
            e.stopPropagation();
        });
        nbdInput.on('change', function(){
            handleFiles(this.files);
        });               
        function handleFiles(files) {
            if(files.length > 0) uploadFile(files);
        }    
        function uploadFile(files){
            var file = files[0],
            type = file.type.toLowerCase();
            if( listFileUpload.length > (nbd_number-1) ) {
                alert('Exceed number of upload files!');
                return;                  
            }
            type = type == 'image/jpeg' ? 'image/jpg' : type;
            if( nbd_disallow_type != '' ){
                var nbd_disallow_type_arr = nbd_disallow_type.toLowerCase().split(',');
                var check = false;
                nbd_disallow_type_arr.forEach(function(value){
                    value = value == 'jpeg' ? 'jpg' : value;
                    if( type.indexOf(value) > -1 ){
                        check = true;
                    }                    
                });
                if( check ){
                    alert('Disallow extensions: ' + nbd_disallow_type);
                    return;                    
                }                
            }            
            if( nbd_allow_type != '' ){
                var nbd_allow_type_arr = nbd_allow_type.toLowerCase().split(',');
                var check = false;
                nbd_allow_type_arr.forEach(function(value){
                    value = value == 'jpeg' ? 'jpg' : value;
                    if( type.indexOf(value) > -1 ){
                        check = true;
                    }
                });   
                if( !check ){
                    alert('Only support: ' + nbd_allow_type);
                    return;                    
                }
            }
            if (file.size > nbd_maxsize * 1024 * 1024 ) {
                alert('Max file size' + nbd_maxsize + " MB");
                return;            
            }else if(file.size < nbd_minsize * 1024 * 1024){
                alert('Min file size' + nbd_minsize + " MB");
                return;
            };
            var formData = new FormData;
            formData.append('file', file);
            jQuery('.nbd-upload-loading').addClass('is-visible');
            jQuery('.upload-zone label').addClass('is-loading');
            jQuery('.nbd-m-upload-design-wrap').addClass('is-loading');
            var first_time = listFileUpload.length > 0 ? 2 : 1;
            var product_id = jQuery('[name="add-to-cart"]').attr('value');
            var variation_id = jQuery('[name="variation_id"]').length > 0 ? jQuery('[name="variation_id"]').attr('value') : 0;
            formData.append('first_time', first_time);
            formData.append('action', 'nbd_upload_design_file');
            formData.append('task', 'new');
            formData.append('product_id', product_id);
            formData.append('variation_id', variation_id);
            formData.append('nonce', nbds_frontend.nonce);
            jQuery.ajax({
                url: nbds_frontend.url,
                method: "POST",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                complete: function() {
                    jQuery('.nbd-upload-loading').removeClass('is-visible');
                    jQuery('.upload-zone label').removeClass('is-loading');
                    jQuery('.nbd-m-upload-design-wrap').removeClass('is-loading');
                },                
                success: function(data) {console.log(data);
                    if( data.flag == 1 ){
                        listFileUpload.push( { src : data.src, name : data.name } );
                        buildPreviewUpload();
                    }else{
                        alert(data.mes);
                    }
                }
            });
        }
        window.removeUploadFile = function(index){console.log(2225);
            listFileUpload.splice(index, 1);
            buildPreviewUpload();
        };
        function buildPreviewUpload(){
            show_upload_thumb(listFileUpload);
            NBDESIGNERPRODUCT.update_nbu_value(listFileUpload);            
            var html = '';
            listFileUpload.forEach(function(file, index){
                html += '<div class="nbd-upload-items"><div class="nbd-upload-items-inner"><img src="'+file.src+'" class="shadow nbd-upload-item"/><p class="nbd-upload-item-title">'+file.name+'</p><span class="shadow" onclick="removeUploadFile('+index+')" >&times;</span></div></div>';
            });
            jQuery('.upload-design-preview').html(html);
        }
    NBDESIGNERPRODUCT.nbdesigner_ready();
    jQuery('input[name="variation_id"]').on('change', function(){
        if(jQuery('input[name="variation_id"]').val() != ''){
            NBDESIGNERPRODUCT.nbdesigner_ready();
        }else{
            jQuery('#triggerDesign').addClass('nbdesigner_disable');
        }
    });   
});
var share_image_url = '';
var NBDESIGNERPRODUCT = {
    hide_loading_iframe: function(){
        jQuery("#nbd_processing").hide();
    },
    save_for_later: function(){
        jQuery('img.nbd-save-loading').removeClass('hide');
        jQuery.ajax({
            url: nbds_frontend.url,
            method: "POST",
            data: {
                action   :    'nbd_save_for_later',
                product_id :   NBDESIGNERPRODUCT.product_id,
                variation_id :   NBDESIGNERPRODUCT.variation_id,
                folder: NBDESIGNERPRODUCT.folder,
                nonce: nbds_frontend.nonce
            }            
        }).done(function(data){
            if( data.flag == 1 ){
                jQuery('img.nbd-save-loading').addClass('hide');
                jQuery('a.nbd-save-for-later').addClass('saved');
                jQuery('a.nbd-save-for-later svg').show();
                
                jQuery.each( jQuery('#nbd-share-group a'), function(){
                    var d = new Date();
                    var href = jQuery(this).attr('data-href');
                    var share_url =nbd_create_own_page + '?product_id=' + NBDESIGNERPRODUCT.product_id + '&variation_id=' + NBDESIGNERPRODUCT.variation_id + '&reference=' + data.folder + '&nbd_share_id=' + data.folder + '&t=' + d.getTime();
                    var _href = href + encodeURIComponent(share_url);
                    if( jQuery(this).attr('id') == 'nbd-pinterest' ) _href += '&media=' + encodeURIComponent(share_image_url) + '&description=' + jQuery(this).attr('data-description');
                    if( jQuery(this).attr('data-text') != undefined ) _href += '&text=' + jQuery(this).attr('data-text');
                    jQuery(this).attr('href', _href);
                });	                
            }else{
                alert('Opps! Error while save design!');
            };
        });        
    },
    download_pdf: function(){
        jQuery('img.nbd-pdf-loading').removeClass('hide');
        jQuery.ajax({
            url: nbds_frontend.url,
            method: "POST",
            data: {
                action   :    'nbd_frontend_download_pdf',
                nbd_item_key :   NBDESIGNERPRODUCT.folder,
                nonce: nbds_frontend.nonce
            }            
        }).done(function(data){
            jQuery('img.nbd-pdf-loading').addClass('hide');
            var data = JSON.parse(data);
            var filename = 'design.pdf',
            a = document.createElement('a');
            a.setAttribute('href', data[0].link);
            a.setAttribute('download', filename);
            a.click()             
        });         
    },
    download_pdf_in_order: function( e, el ){
        e.preventDefault();
        var sefl = el,
            nbd_item_key = sefl.attr('data-nbd-item'),
            order_id = sefl.attr('data-order');
        sefl.find('span').addClass('active');
        jQuery.ajax({
            url: nbds_frontend.url,
            method: "POST",
            data: {
                action   :    'nbd_frontend_download_pdf',
                nbd_item_key :   nbd_item_key,
                order_id :   order_id,
                nonce: nbds_frontend.nonce
            }            
        }).done(function(data){
            sefl.find('span').removeClass('active');
            var data = JSON.parse(data);
            var filename = 'design.pdf',
            a = document.createElement('a');
            a.setAttribute('href', data[0].link);
            a.setAttribute('download', filename);
            a.click()             
        });         
    },  
    nbd_download_final_pdf: function( e, el ){
        e.preventDefault();
        var sefl = el,
            nbd_item_key = sefl.attr('data-nbd-item');
        sefl.find('span').addClass('active');
        jQuery.ajax({
            url: nbds_frontend.url,
            method: "POST",
            data: {
                action   :    'nbd_download_final_pdf',
                nbd_item_key :   nbd_item_key,
                nonce: nbds_frontend.nonce
            }            
        }).done(function(data){
            sefl.find('span').removeClass('active');
            var data = JSON.parse(data);
            if( data.flag == 1 ){
                data.pdf.forEach(function(item, index){
                    var filename = 'design_' + index + '.pdf',
                    a = document.createElement('a');
                    a.setAttribute('href', item);
                    a.setAttribute('download', filename);
                    a.click()                        
                });     
            }
        });         
    },    
    insert_customer_design: function (data) {

    },
    hide_iframe_design: function () {
        var height = -jQuery(window).height();
        jQuery('#container-online-designer').removeClass('show');
        jQuery('#container-online-designer').stop().animate({
            top: height,
            opacity: 0
        }, 500);
    },
    show_design_thumbnail: function (arr, task) {
        if( jQuery('#triggerDesign').length > 0 ){
            jQuery('button[type="submit"].single_add_to_cart_button').show();
        };
        jQuery('#nbdesigner-preview-title').show();
        jQuery('#nbd-actions').show();
        jQuery('#nbdesign-new-template').show();
        if(task == 'create_template' || task == 'edit_template'){
            jQuery('#triggerDesign').text('Edit Template');
        }
        var html = '';
        var d = new Date();
        var count = 1;
        jQuery.each(arr, function (key, val) {
            if(count == 1) share_image_url = val;
            count++;
            html += '<div class="img-con"><img src="' + val + '?t=' + d.getTime() +'" /></div>'
        });
        jQuery.each( jQuery('#nbd-share-group a'), function(){
            var d = new Date();
            var href = jQuery(this).attr('data-href');
            var share_url =nbd_create_own_page + '?product_id=' + NBDESIGNERPRODUCT.product_id + '&variation_id=' + NBDESIGNERPRODUCT.variation_id + '&reference=' + NBDESIGNERPRODUCT.folder + '&nbd_share_id=' + NBDESIGNERPRODUCT.folder + '&t=' + d.getTime();
            var _href = href + encodeURIComponent(share_url);
            if( jQuery(this).attr('id') == 'nbd-pinterest' ) _href += '&media=' + encodeURIComponent(share_image_url) + '&description=' + jQuery(this).attr('data-description');
            if( jQuery(this).attr('data-text') != undefined ) _href += '&text=' + jQuery(this).attr('data-text');
            jQuery(this).attr('href', _href);
        });
        jQuery('#nbdesigner_frontend_area').html('');
        jQuery('#nbdesigner_frontend_area').append(html);
        hideDesignFrame();

        var flipbook = jQuery("[class*=real3dflipbook]:first");
        /* Integate with real3dflipbook */
        if( flipbook.length > 0 ){
            var _class = flipbook.attr('class'),
                obj = 'real3dflipbook_' + _class.substring(_class.length - 1);  
            var options = window[obj];
            var json_str = options.replace(/&quot;/g, '"');
            json_str = json_str.replace(/“/g, '"');
            json_str = json_str.replace(/”/g, '"');
            json_str = json_str.replace(/″/g, '"');
            json_str = json_str.replace(/„/g, '"');

            json_str = json_str.replace(/«&nbsp;/g, '"');
            json_str = json_str.replace(/&nbsp;»/g, '"');


            options = jQuery.parseJSON(json_str);
            options.assets = {
                preloader: options.rootFolder + "images/preloader.jpg",
                left: options.rootFolder + "images/left.png",
                overlay: options.rootFolder + "images/overlay.jpg",
                flipMp3: options.rootFolder + "mp3/turnPage.mp3",
                shadowPng: options.rootFolder + "images/shadow.png"
            };
            var pages = [];    
            jQuery.each(arr, function (key, val) {
                pages.push({
                    htmlContent: '',
                    src: val,
                    thumb: val,
                    title: key
                });
            });
            options.pages = pages;
            options.pdfjsworkerSrc = options.rootFolder + 'js/pdf.worker.min.js'
            function convertStrings(obj) {
                jQuery.each(obj, function (key, value) {
                    if (typeof (value) == 'object' || typeof (value) == 'array') {
                        convertStrings(value)
                    } else if (!isNaN(value)) {
                        if (obj[key] === "")
                            delete obj[key]
                        else
                            obj[key] = Number(value)
                    } else if (value == "true") {
                        obj[key] = true
                    } else if (value == "false") {
                        obj[key] = false
                    }
                });

            }
            convertStrings(options);
            for (var i = 0; i < options.pages.length; i++) {
                if (typeof (options.pages[i].htmlContent) != 'undefined' && options.pages[i].htmlContent != "" && options.pages[i].htmlContent != "undefined")
                    options.pages[i].htmlContent = unescape(options.pages[i].htmlContent)
                else
                    delete options.pages[i].htmlContent
            }
            options.social = [];
            if (options.facebook == "")
                delete options.facebook
            if (options.twitter == "")
                delete options.twitter
            if (options.google_plus == "")
                delete options.google_plus
            if (options.pinterest == "")
                delete options.pinterest
            if (options.email == "")
                delete options.email
            if (options.pageWidth == "")
                delete options.pageWidth
            if (options.pageHeight == "")
                delete options.pageHeight

            if (typeof (options.btnShare) == 'undefined' || !options.btnShare)
                options.btnShare = {enabled: false}
            if (typeof (options.btnNext) == 'undefined' || !options.btnNext)
                options.btnNext = {enabled: false}
            if (typeof (options.btnPrev) == 'undefined' || !options.btnPrev)
                options.btnPrev = {enabled: false}
            if (typeof (options.btnZoomIn) == 'undefined' || !options.btnZoomIn)
                options.btnZoomIn = {enabled: false}
            if (typeof (options.btnZoomOut) == 'undefined' || !options.btnZoomOut)
                options.btnZoomOut = {enabled: false}
            if (typeof (options.btnToc) == 'undefined' || !options.btnToc)
                options.btnToc = {enabled: false}
            if (typeof (options.btnThumbs) == 'undefined' || !options.btnThumbs)
                options.btnThumbs = {enabled: false}
            if (typeof (options.btnDownloadPages) == 'undefined' || !options.btnDownloadPages)
                options.btnDownloadPages = {enabled: false}
            if (typeof (options.btnDownloadPdf) == 'undefined' || !options.btnDownloadPdf)
                options.btnDownloadPdf = {enabled: false}
            if (typeof (options.btnExpand) == 'undefined' || !options.btnExpand)
                options.btnExpand = {enabled: false}
            if (typeof (options.btnExpandLightbox) == 'undefined' || !options.btnExpandLightbox)
                options.btnExpandLightbox = {enabled: false}
            if (typeof (options.btnSound) == 'undefined' || !options.btnSound)
                options.btnSound = {enabled: false}
            if (typeof (options.btnShare.icon) == 'undefined' || options.btnShare.icon == '')
                options.btnShare.icon = "fa-share";
            if (typeof (options.btnShare.title) == 'undefined' || options.btnShare.title == '')
                options.btnShare.title = "Share";

            if (typeof (options.btnNext.icon) == 'undefined' || options.btnNext.icon == '')
                options.btnNext.icon = "fa-chevron-right";
            if (typeof (options.btnNext.title) == 'undefined' || options.btnNext.title == '')
                options.btnNext.title = "Next page";

            if (typeof (options.btnPrev.icon) == 'undefined' || options.btnPrev.icon == '')
                options.btnPrev.icon = "fa-chevron-left";
            if (typeof (options.btnPrev.title) == 'undefined' || options.btnPrev.title == '')
                options.btnPrev.title = "Previous page";

            if (typeof (options.btnZoomIn.icon) == 'undefined' || options.btnZoomIn.icon == '')
                options.btnZoomIn.icon = "fa-plus";
            if (typeof (options.btnZoomIn.title) == 'undefined' || options.btnZoomIn.title == '')
                options.btnZoomIn.title = "Zoom in";

            if (typeof (options.btnZoomOut.icon) == 'undefined' || options.btnZoomOut.icon == '')
                options.btnZoomOut.icon = "fa-minus";
            if (typeof (options.btnZoomOut.title) == 'undefined' || options.btnZoomOut.title == '')
                options.btnZoomOut.title = "Zoom out";

            if (typeof (options.btnToc.icon) == 'undefined' || options.btnToc.icon == '')
                options.btnToc.icon = "fa-list-ol";
            if (typeof (options.btnToc.title) == 'undefined' || options.btnToc.title == '')
                options.btnToc.title = "Table of content";

            if (typeof (options.btnThumbs.icon) == 'undefined' || options.btnThumbs.icon == '')
                options.btnThumbs.icon = "fa-th-large";
            if (typeof (options.btnThumbs.title) == 'undefined' || options.btnThumbs.title == '')
                options.btnThumbs.title = "Pages";

            if (typeof (options.btnDownloadPages.icon) == 'undefined' || options.btnDownloadPages.icon == '')
                options.btnDownloadPages.icon = "fa-download";
            if (typeof (options.btnDownloadPages.title) == 'undefined' || options.btnDownloadPages.title == '')
                options.btnDownloadPages.title = "Download pages";
            // if(options.downloadPagesUrl)
            // options.btnDownloadPages.url = options.downloadPagesUrl;

            if (typeof (options.btnDownloadPdf.icon) == 'undefined' || options.btnDownloadPdf.icon == '')
                options.btnDownloadPdf.icon = "fa-file";
            if (typeof (options.btnDownloadPdf.title) == 'undefined' || options.btnDownloadPdf.title == '')
                options.btnDownloadPdf.title = "Download PDF";
            // if(options.downloadPdfUrl)
            // options.btnDownloadPdf.url = options.downloadPdfUrl;

            if (typeof (options.btnExpand.icon) == 'undefined' || options.btnExpand.icon == '')
                options.btnExpand.icon = "fa-expand";
            if (typeof (options.btnExpand.iconAlt) == 'undefined' || options.btnExpand.iconAlt == '')
                options.btnExpand.iconAlt = "fa-compress";
            if (typeof (options.btnExpand.title) == 'undefined' || options.btnExpand.title == '')
                options.btnExpand.title = "Toggle fullscreen";

            if (typeof (options.btnExpandLightbox.icon) == 'undefined' || options.btnExpandLightbox.icon == '')
                options.btnExpandLightbox.icon = "fa-expand";
            if (typeof (options.btnExpandLightbox.iconAlt) == 'undefined' || options.btnExpandLightbox.iconAlt == '')
                options.btnExpandLightbox.iconAlt = "fa-compress";
            if (typeof (options.btnExpandLightbox.title) == 'undefined' || options.btnExpandLightbox.title == '')
                options.btnExpandLightbox.title = "Toggle fullscreen";

            if (typeof (options.btnSound.icon) == 'undefined' || options.btnSound.icon == '')
                options.btnSound.icon = "fa-volume-up";
            if (typeof (options.btnSound.title) == 'undefined' || options.btnSound.title == '')
                options.btnSound.title = "Sound";

            if (typeof (options.viewMode) == 'undefined')
                options.viewMode = "webgl"

            if (options.btnDownloadPages.url) {
                options.btnDownloadPages.url = options.btnDownloadPages.url.replace(/\\/g, '/')
                options.btnDownloadPages.enabled = true
            } else
                options.btnDownloadPages.enabled = false

            if (options.btnDownloadPdf.url) {
                options.btnDownloadPdf.url = options.btnDownloadPdf.url.replace(/\\/g, '/')
                options.btnDownloadPdf.enabled = true
            } else
                options.btnDownloadPdf.enabled = false;


            var flipcon = jQuery('.real3dflipbook-1');
            flipcon.flipBook(options);
        }
        
    },
    nbdesigner_ready: function(){ 
        if(jQuery('input[name="variation_id"]').length > 0){
            var vid = jQuery('input[name="variation_id"]').val();
            if( ( "undefined" != typeof is_nbd_bulk_variation) || ( vid != '' &&  parseInt(vid) > 0 ) ) {
                jQuery('#triggerDesign').removeClass('nbdesigner_disable');
            }
        }else{
            jQuery('#triggerDesign').removeClass('nbdesigner_disable');
        }
        jQuery('.nbdesigner-img-loading').addClass('hide');
    },
    nbdesigner_unready: function(){
        jQuery('#triggerDesign').addClass('nbdesigner_disable');
        jQuery('.nbdesigner-img-loading').removeClass('hide');
    },
    get_sugget_design: function(product_id, variation_id){
        if(!jQuery('.nbdesigner-related-product-image').length) return;
        var products = [];
        jQuery.each(jQuery('.nbdesigner-related-product-image'), function(){
            products.push(jQuery(this).attr('data-id'));
            jQuery(this).parent('.nbdesigner-related-product-item').find('.nbdesigner-overlay').addClass('open');
        });
        if( !products.length ) return;
        jQuery.ajax({
            url: nbds_frontend.url,
            method: "POST",
            data: {
                "action": "nbdesigner_get_suggest_design",
                "products": products,
                "product_id" : product_id,
                "variation_id" : variation_id,
                "nonce": nbds_frontend.nonce
            }            
        }).done(function(data){
            data = JSON.parse(data);
            jQuery.each(jQuery('.nbdesigner-related-product-image'), function(){
                if(data['flag']){
                    var href = jQuery(this).attr('href'),
                    data_id = jQuery(this).attr('data-id');
                    jQuery(this).attr('href', addParameter(href, 'nbds-ref', data['nbd_item_key'], false));       
                    jQuery(this).find('img').attr({'src' : data['images'][data_id], 'srcset' : ''});
                }
                jQuery(this).parent('.nbdesigner-related-product-item').find('.nbdesigner-overlay').removeClass('open');
            });
        });
    },
    update_nbu_value: function( arr ){
        var files = '';
        jQuery.each(arr, function (key, val) {
            files += key == 0 ? val.name : '|' + val.name;
        });
        if( jQuery('#triggerDesign').length > 0 ){
            jQuery('button[type="submit"].single_add_to_cart_button').show();
        };          
        jQuery('input[name="nbd-upload-files"]').val( files );
    },
    remove_design: function(type, cart_item_key){
        jQuery('form.woocommerce-cart-form').addClass( 'processing' ).block( {
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        } );
        jQuery.ajax({
            url: nbds_frontend.url,
            method: "POST",
            data: {
                "action": "nbd_remove_cart_design",
                "type": type,
                "cart_item_key": cart_item_key,
                "nonce": nbds_frontend.nonce
            }            
        }).done(function(data){
            jQuery('form.woocommerce-cart-form').removeClass( 'processing' ).unblock();
            if(data == 'success'){
                var designSection = jQuery('#nbd' + cart_item_key),
                    uploadSection = jQuery('#nbu' + cart_item_key),
                    extraPrice = jQuery('#nbx' + cart_item_key);
                var sections =  designSection.length + uploadSection.length;
                if( type == 'custom' ) {
                    designSection.remove();
                }else {
                    uploadSection.remove();
                }
                if( sections < 2 ) {
                    extraPrice.remove();
                    /* Update cart after remove design and upload files */
                    jQuery( '.woocommerce-cart-form input[name="update_cart"]' ).prop( 'disabled', false ).trigger( 'click' );
                }
            }
        });
    },
    delete_my_design: function( e ){
        var con = confirm('Are you sure you want to delete this design?');
        if( con ){
            var sefl = jQuery(e),
            design_id = sefl.attr('data-design'),
            tr_con = sefl.parents('tr.order');
            jQuery('.container-design').addClass( 'processing' ).block( {
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            } );        
            jQuery.ajax({
                url: nbds_frontend.url,
                method: "POST",
                data: {
                    action   :    'nbd_delete_my_design',
                    design_id :   design_id,
                    nonce: nbds_frontend.nonce
                }            
            }).done(function(data){
                jQuery('.container-design').removeClass( 'processing' ).unblock();
                if(data.flag == 1){
                    tr_con.remove();
                    alert('Delete successfully!')
                }
            })   
        }
    },
    add_design_to_cart: function(e){
        var sefl = jQuery(e),
        design_id = sefl.attr('data-design');
        jQuery('.container-design').addClass( 'processing' ).block( {
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        } );        
        jQuery.ajax({
            url: nbds_frontend.url,
            method: "POST",
            data: {
                action   :    'nbd_add_design_to_cart',
                design_id :   design_id,
                nonce: nbds_frontend.nonce
            }            
        }).done(function(data){
            jQuery('.container-design').removeClass( 'processing' ).unblock();
            if(data.flag == 1){
                window.location = nbds_frontend.cart_url;
            }else{
                alert('Opp! Try again later')
            }
        })         
    },
    add_variation_bulk_form: function(){
        var variation_wrap = jQuery('.nbd-variation-wrap').first(),
        new_variation_wrap = variation_wrap.clone();
        new_variation_wrap.appendTo('#nbd-variations-wrap');  
        jQuery(new_variation_wrap).find('.nbd-variation-quantity').val(1);
        this.init_nbd_variation_value();
    },
    remove_variation_bulk_form: function(e){
        var self = jQuery(e),
            wrap =  self.closest('.nbd-variation-wrap');  
        wrap.remove(); 
        this.init_nbd_variation_value();
    },
    init_nbd_variation_value: function(){
        var nbd_variation_value = '',
            has_quantity = false;        
        jQuery('.nbd-variation-value').val(nbd_variation_value);
        jQuery('.nbd-variation-wrap').each(function(index){
            var variation_id = jQuery(this).find('select').val();
            var quantity = jQuery(this).find('input').val();
            if( quantity > 0 ) has_quantity = true;
            nbd_variation_value += index > 0 ? '|' : '';
            nbd_variation_value += variation_id + '_' + quantity;
        });
        jQuery('.nbd-variation-value').val(nbd_variation_value);
        if( has_quantity ){
            jQuery('.single_add_to_cart_button').removeClass('disabled wc-variation-selection-needed');
        }else{
            jQuery('.single_add_to_cart_button').addClass('disabled wc-variation-selection-needed');
        }
    },
    change_nbd_dokan_format: function( e ){
        var type = jQuery(e).val(),
            el_action = jQuery(e).parents('.nbd-dokan-download-wrap').find('a.nbd-dokan-download'),
            href = el_action.attr('data-href');
            el_action.attr('href', href + '&type=' + type);
    },
    change_nbd_download_type: function( e ){
        var type = jQuery(e).val(),
            parent = jQuery(e).parents('.nbd-order-item-download-section'),    
            el_action = parent.find('a.nbd-order-download-file'),
            link = parent.attr('data-href');
        if( type == 'pdf' ) {
            jQuery('#nbd-show-bleed')
            jQuery('.nbd-pdf-options').removeClass('nbd-hide');
        }
        el_action.attr('href', link + '&type=' + type);        
    },
    change_nbd_download_pdf_type: function( ){
        jQuery.each(jQuery('.nbd-order-item-download-section'), function(){
            var _bleed = jQuery('#nbd-show-bleed').is(':checked') ? 'yes' : 'no';
            var _multi_file = jQuery('#nbd-multi-file').is(':checked') ? 'yes' : 'no';
            jQuery('.nbd-pdf-options').addClass('nbd-hide');
            jQuery.each( jQuery('.nbd-order-item-download-section'), function(){
                var link = jQuery(this).find('.nbd-order-download-file').attr('href');
                link += '&multi_file=' + _multi_file + '&bleed=' + _bleed;
                jQuery(this).find('.nbd-order-download-file').attr('href', link);
            })
        });
    }
};
function addParameter(url, parameterName, parameterValue, atStart/*Add param before others*/) {
    var replaceDuplicates = true;
    var urlhash = '';
    if (url.indexOf('#') > 0) {
        var cl = url.indexOf('#');
        urlhash = url.substring(url.indexOf('#'), url.length);
    } else {
        urlhash = '';
        cl = url.length;
    }
    var sourceUrl = url.substring(0, cl);
    var urlParts = sourceUrl.split("?");
    var newQueryString = "";
    if (urlParts.length > 1){
        var parameters = urlParts[1].split("&");
        for (var i = 0; (i < parameters.length); i++)
        {
            var parameterParts = parameters[i].split("=");
            if (!(replaceDuplicates && parameterParts[0] == parameterName))
            {
                if (newQueryString == "")
                    newQueryString = "?";
                else
                    newQueryString += "&";
                newQueryString += parameterParts[0] + "=" + (parameterParts[1] ? parameterParts[1] : '');
            }
        }
    }
    if (newQueryString == "") newQueryString = "?";
    if (atStart) {
        newQueryString = '?' + parameterName + "=" + parameterValue + (newQueryString.length > 1 ? '&' + newQueryString.substring(1) : '');
    } else {
        if (newQueryString !== "" && newQueryString != '?')
            newQueryString += "&";
        newQueryString += parameterName + "=" + (parameterValue ? parameterValue : '');
    }
    return urlParts[0] + newQueryString + urlhash;
};

(function($, document, window) {
    var pluginName = "drystone",
        defaults = {
            item: '.grid-item',
            gutter: 10,
            xs: [576, 1],
            sm: [768, 2],
            md: [992, 2],
            lg: [1200, 3],
            xl: 3,
            onComplete: function() {}
        };
    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            this.buildCache();
            this.registerHandlers();
            this.getValues();
            this.build();
            this.options.onComplete();
        },
        buildCache: function() {
            this.$grid = $(this.element);
            this.$gridItems = this.$grid.children(this.options.item);
        },
        getValues: function() {
            this.gridWidth = this.$grid.width();
            this.numOfColumns = this.getNumOfColumns();
            this.columnWidth = this.getColumnWidth();
        },
        getNumOfColumns: function() {
            this.columns = [];
            var num = 0;
            var width = $(window).width();
            if (width < this.options.xs[0]) {
                num = this.options.xs[1];
            } else if (width < this.options.sm[0]) {
                num = this.options.sm;
            } else if (width < this.options.md[0]) {
                num = this.options.md[1];
            } else if (width < this.options.lg[0]) {
                num = this.options.lg[1];
            } else {
                num = this.options.xl;
            }
            for (let i = 0; i < num; i++) {
                this.columns.push([i, 0]);
            }

            return num;
        },
        getColumnWidth: function() {
            return parseInt((this.gridWidth - this.options.gutter * (this.numOfColumns - 1)) / this.numOfColumns);
        },
        registerHandlers: function() {
            var self = this;
            $(window).resize(function() {
                self.getValues();
                self.build();
            });
        },
        build: function() {
            var self = this;
            var currentColumn;
            self.$gridItems.each(function() {
                var item = $(this);
                item.css('position', 'absolute');
                self.$grid.css('position', 'relative');
                item.css('width', self.columnWidth);
                for (let i = 0; i < self.columns.length; i++) {
                    if (currentColumn == undefined || currentColumn[1] > self.columns[i][1]) {
                        currentColumn = self.columns[i];
                    }
                }
                if (currentColumn[0] == 0) {
                    item.css('left', currentColumn[0] * self.columnWidth);
                } else {
                    item.css('left', currentColumn[0] * self.columnWidth + self.options.gutter * currentColumn[0]);
                }
                item.css('top', currentColumn[1]);
                currentColumn[1] += item.height() + self.options.gutter;
            });
            for (let i = 0; i < self.columns.length; i++) {
                if (currentColumn[1] < self.columns[i][1]) {
                    currentColumn = self.columns[i];
                }
            }
            self.$grid.css('height', currentColumn[1] - this.options.gutter);
            self.$gridItems.css('visibility', 'visible');
        }
    };
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                    new Plugin(this, options));
            }
        });
    };

})(jQuery, document, window);
/*!
 * imagesLoaded PACKAGED v4.1.4
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
!function(e,t){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",t):"object"==typeof module&&module.exports?module.exports=t():e.EvEmitter=t()}("undefined"!=typeof window?window:this,function(){function e(){}var t=e.prototype;return t.on=function(e,t){if(e&&t){var i=this._events=this._events||{},n=i[e]=i[e]||[];return n.indexOf(t)==-1&&n.push(t),this}},t.once=function(e,t){if(e&&t){this.on(e,t);var i=this._onceEvents=this._onceEvents||{},n=i[e]=i[e]||{};return n[t]=!0,this}},t.off=function(e,t){var i=this._events&&this._events[e];if(i&&i.length){var n=i.indexOf(t);return n!=-1&&i.splice(n,1),this}},t.emitEvent=function(e,t){var i=this._events&&this._events[e];if(i&&i.length){i=i.slice(0),t=t||[];for(var n=this._onceEvents&&this._onceEvents[e],o=0;o<i.length;o++){var r=i[o],s=n&&n[r];s&&(this.off(e,r),delete n[r]),r.apply(this,t)}return this}},t.allOff=function(){delete this._events,delete this._onceEvents},e}),function(e,t){"use strict";"function"==typeof define&&define.amd?define(["ev-emitter/ev-emitter"],function(i){return t(e,i)}):"object"==typeof module&&module.exports?module.exports=t(e,require("ev-emitter")):e.imagesLoaded=t(e,e.EvEmitter)}("undefined"!=typeof window?window:this,function(e,t){function i(e,t){for(var i in t)e[i]=t[i];return e}function n(e){if(Array.isArray(e))return e;var t="object"==typeof e&&"number"==typeof e.length;return t?d.call(e):[e]}function o(e,t,r){if(!(this instanceof o))return new o(e,t,r);var s=e;return"string"==typeof e&&(s=document.querySelectorAll(e)),s?(this.elements=n(s),this.options=i({},this.options),"function"==typeof t?r=t:i(this.options,t),r&&this.on("always",r),this.getImages(),h&&(this.jqDeferred=new h.Deferred),void setTimeout(this.check.bind(this))):void a.error("Bad element for imagesLoaded "+(s||e))}function r(e){this.img=e}function s(e,t){this.url=e,this.element=t,this.img=new Image}var h=e.jQuery,a=e.console,d=Array.prototype.slice;o.prototype=Object.create(t.prototype),o.prototype.options={},o.prototype.getImages=function(){this.images=[],this.elements.forEach(this.addElementImages,this)},o.prototype.addElementImages=function(e){"IMG"==e.nodeName&&this.addImage(e),this.options.background===!0&&this.addElementBackgroundImages(e);var t=e.nodeType;if(t&&u[t]){for(var i=e.querySelectorAll("img"),n=0;n<i.length;n++){var o=i[n];this.addImage(o)}if("string"==typeof this.options.background){var r=e.querySelectorAll(this.options.background);for(n=0;n<r.length;n++){var s=r[n];this.addElementBackgroundImages(s)}}}};var u={1:!0,9:!0,11:!0};return o.prototype.addElementBackgroundImages=function(e){var t=getComputedStyle(e);if(t)for(var i=/url\((['"])?(.*?)\1\)/gi,n=i.exec(t.backgroundImage);null!==n;){var o=n&&n[2];o&&this.addBackground(o,e),n=i.exec(t.backgroundImage)}},o.prototype.addImage=function(e){var t=new r(e);this.images.push(t)},o.prototype.addBackground=function(e,t){var i=new s(e,t);this.images.push(i)},o.prototype.check=function(){function e(e,i,n){setTimeout(function(){t.progress(e,i,n)})}var t=this;return this.progressedCount=0,this.hasAnyBroken=!1,this.images.length?void this.images.forEach(function(t){t.once("progress",e),t.check()}):void this.complete()},o.prototype.progress=function(e,t,i){this.progressedCount++,this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded,this.emitEvent("progress",[this,e,t]),this.jqDeferred&&this.jqDeferred.notify&&this.jqDeferred.notify(this,e),this.progressedCount==this.images.length&&this.complete(),this.options.debug&&a&&a.log("progress: "+i,e,t)},o.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";if(this.isComplete=!0,this.emitEvent(e,[this]),this.emitEvent("always",[this]),this.jqDeferred){var t=this.hasAnyBroken?"reject":"resolve";this.jqDeferred[t](this)}},r.prototype=Object.create(t.prototype),r.prototype.check=function(){var e=this.getIsImageComplete();return e?void this.confirm(0!==this.img.naturalWidth,"naturalWidth"):(this.proxyImage=new Image,this.proxyImage.addEventListener("load",this),this.proxyImage.addEventListener("error",this),this.img.addEventListener("load",this),this.img.addEventListener("error",this),void(this.proxyImage.src=this.img.src))},r.prototype.getIsImageComplete=function(){return this.img.complete&&this.img.naturalWidth},r.prototype.confirm=function(e,t){this.isLoaded=e,this.emitEvent("progress",[this,this.img,t])},r.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},r.prototype.onload=function(){this.confirm(!0,"onload"),this.unbindEvents()},r.prototype.onerror=function(){this.confirm(!1,"onerror"),this.unbindEvents()},r.prototype.unbindEvents=function(){this.proxyImage.removeEventListener("load",this),this.proxyImage.removeEventListener("error",this),this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype=Object.create(r.prototype),s.prototype.check=function(){this.img.addEventListener("load",this),this.img.addEventListener("error",this),this.img.src=this.url;var e=this.getIsImageComplete();e&&(this.confirm(0!==this.img.naturalWidth,"naturalWidth"),this.unbindEvents())},s.prototype.unbindEvents=function(){this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype.confirm=function(e,t){this.isLoaded=e,this.emitEvent("progress",[this,this.element,t])},o.makeJQueryPlugin=function(t){t=t||e.jQuery,t&&(h=t,h.fn.imagesLoaded=function(e,t){var i=new o(this,e,t);return i.jqDeferred.promise(h(this))})},o.makeJQueryPlugin(),o});