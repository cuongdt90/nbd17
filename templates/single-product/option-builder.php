<?php if (!defined('ABSPATH')) exit; ?>
<style>
    /* tipTip */
    #tiptip_holder {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 99999;
    }
    #tiptip_holder.tip_top {
        padding-bottom: 5px;
    }
    #tiptip_holder.tip_bottom {
        padding-top: 5px;
    }
    #tiptip_holder.tip_right {
        padding-left: 5px;
    }
    #tiptip_holder.tip_left {
        padding-right: 5px;
    }
    #tiptip_content {
        font-size: 11px;
        color: #fff;
        text-shadow: 0 0 2px #000;
        padding: 4px 8px;
        border: 1px solid rgba(255,255,255,0.25);
        background-color: rgb(25,25,25);
        background-color: rgba(25,25,25,0.92);
        background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(transparent), to(#000));
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        box-shadow: 0 0 3px #555;
        -webkit-box-shadow: 0 0 3px #555;
        -moz-box-shadow: 0 0 3px #555;
    }
    #tiptip_arrow, #tiptip_arrow_inner {
        position: absolute;
        border-color: transparent;
        border-style: solid;
        border-width: 6px;
        height: 0;
        width: 0;
    }
    #tiptip_holder.tip_top #tiptip_arrow {
        border-top-color: #fff;
        border-top-color: rgba(255,255,255,0.35);
    }
    #tiptip_holder.tip_bottom #tiptip_arrow {
        border-bottom-color: #fff;
        border-bottom-color: rgba(255,255,255,0.35);
    }
    #tiptip_holder.tip_right #tiptip_arrow {
        border-right-color: #fff;
        border-right-color: rgba(255,255,255,0.35);
    }
    #tiptip_holder.tip_left #tiptip_arrow {
        border-left-color: #fff;
        border-left-color: rgba(255,255,255,0.35);
    }
    #tiptip_holder.tip_top #tiptip_arrow_inner {
        margin-top: -7px;
        margin-left: -6px;
        border-top-color: rgb(25,25,25);
        border-top-color: rgba(25,25,25,0.92);
    }
    #tiptip_holder.tip_bottom #tiptip_arrow_inner {
        margin-top: -5px;
        margin-left: -6px;
        border-bottom-color: rgb(25,25,25);
        border-bottom-color: rgba(25,25,25,0.92);
    }
    #tiptip_holder.tip_right #tiptip_arrow_inner {
        margin-top: -6px;
        margin-left: -5px;
        border-right-color: rgb(25,25,25);
        border-right-color: rgba(25,25,25,0.92);
    }
    #tiptip_holder.tip_left #tiptip_arrow_inner {
        margin-top: -6px;
        margin-left: -7px;
        border-left-color: rgb(25,25,25);
        border-left-color: rgba(25,25,25,0.92);
    }
    @media screen and (-webkit-min-device-pixel-ratio:0) {	
        #tiptip_content {
            padding: 4px 8px 5px 8px;
            background-color: rgba(45,45,45,0.88);
        }
        #tiptip_holder.tip_bottom #tiptip_arrow_inner { 
            border-bottom-color: rgba(45,45,45,0.88);
        }
        #tiptip_holder.tip_top #tiptip_arrow_inner { 
            border-top-color: rgba(20,20,20,0.92);
        }
    }
    .nbd-help-tip {
        vertical-align: middle;
        cursor: help;
        margin: -2px -24px 0 5px;
        line-height: 1;
        color: #fff;
        background: #333333;
        border-radius: 50%;
        display: inline-block;
        font-size: 10px;
        font-style: normal;
        height: 12px;
        position: relative;
        width: 12px;  
    }
    .nbd-help-tip::after {
        font-family: Dashicons;
        speak: none;
        font-weight: 400;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        text-indent: 0px;
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        text-align: center;
        content: "?";
        cursor: help;
        font-variant: normal;
        margin: 0px;
    }
    /* End tipTip */ 
    /* md-radio */
    @keyframes ripple {
        0% {
            box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0);
        }
        50% {
            box-shadow: 0px 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        100% {
            box-shadow: 0px 0px 0px 15px rgba(0, 0, 0, 0);
        }
    }    
    @-webkit-keyframes ripple {
        0% {
            box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0);
        }
        50% {
            box-shadow: 0px 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        100% {
            box-shadow: 0px 0px 0px 15px rgba(0, 0, 0, 0);
        }
    } 
    .nbd-radio input[type="radio"]:checked + label:before {
        border-color: #0c8ea7;
        animation: ripple 0.2s linear forwards;
    }
    .nbd-radio input[type="radio"]:checked + label:after {
        transform: scale(1);
    }
    .nbd-radio label {
        display: inline-block;
        height: 20px;
        position: relative;
        padding: 0 30px;
        margin-bottom: 0;
        cursor: pointer;
        line-height: 20px;
    }
    .nbd-radio label:before, .nbd-radio label:after {
        position: absolute;
        content: '';
        border-radius: 50%;
        transition: all .3s ease;
        transition-property: transform, border-color;
        box-sizing: border-box;
    }
    .nbd-radio label:before {
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(0, 0, 0, 0.54);
    }
    .nbd-radio label:after {
        top: 5px;
        left: 5px;
        width: 10px;
        height: 10px;
        transform: scale(0);
        background: #0c8ea7;
    }    
    /* end. nbd-radio */
    .nbd-option-wrapper {
        margin-bottom: 1.1em;
    }
    .nbd-option-field {
        -webkit-box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        -moz-box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        -ms-box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        border-radius: 4px;
        background-color: #fff;
        margin-bottom: 1.1em;
        border: 1px solid #ddd;
    }
    .nbd-option-field select,
    .nbd-option-field input[type="text"]{
        min-width: 150px;
    }
    .nbd-field-header {
        padding: 10px;
        background: #f2f2f2;
        color: #0c8ea7;
        font-weight: bold;
    }
    .nbd-field-header label {
        font-weight: bold;
    }
    .nbd-field-content {
        padding: 10px;
    }    
    .nbd-option-wrapper label {
        cursor: pointer;
        margin: 0 !important;
        margin-right: 5px !important;
    }
    .nbd-swatch {
        width: 36px;
        height: 36px;
        display: inline-block;
        border-radius: 50%; 
        cursor: pointer;
        border: 2px solid #fff;
    }
    .nbd-option-wrapper input[type="radio"] {
        display: none;
    }
    .nbd-swatch-wrap input[type="radio"]:checked + label {
        border: 2px solid rgba(221, 51, 51,0.5);
    }
    .nbd-dropdown {
        border: 1px solid #EEE;
        height: 40px;
        padding: 3px 40px 3px 8px;
        background-color: transparent;
        line-height: 100%;
        outline: 0;
        background-image: url(<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/arrow.png'; ?>);
        background-position: right;
        background-repeat: no-repeat;
        position: relative;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;        
    }
    .nbd-swatch-wrap .nbd-field-content{
        font-size: 0;
    }
</style>
<div class="nbd-option-wrapper">
<?php
$html_field = '';
foreach($options["fields"] as $field){
    if( $field['general']['data_type'] == 'i' ){
        $tempalte = '/options-builder/input.php';
    }else{
        switch($field['appearance']['display_type']){
            case 's':
                $tempalte = '/options-builder/swatch.php';
                break;
            case 'r':
                $tempalte = '/options-builder/radio.php';
                break;
            default:
                $tempalte = '/options-builder/dropdown.php';
                break;            
        }
    }
    include($tempalte);
}
?>
    <p><?php _e('Options: ', 'web-to-print-online-designer'); ?> <span id="nbd-option-total"></span></p>
</div>
<script type="text/javascript">
    (function($){
        $.fn.tipTip = function(options) {
                var defaults = {
                        activation: "hover",
                        keepAlive: false,
                        maxWidth: "200px",
                        edgeOffset: 3,
                        defaultPosition: "bottom",
                        delay: 400,
                        fadeIn: 200,
                        fadeOut: 200,
                        attribute: "title",
                        content: false, // HTML or String to fill TipTIp with
                        enter: function(){},
                        exit: function(){}
                };
                var opts = $.extend(defaults, options);

                // Setup tip tip elements and render them to the DOM
                if($("#tiptip_holder").length <= 0){
                        var tiptip_holder = $('<div id="tiptip_holder" style="max-width:'+ opts.maxWidth +';"></div>');
                        var tiptip_content = $('<div id="tiptip_content"></div>');
                        var tiptip_arrow = $('<div id="tiptip_arrow"></div>');
                        $("body").append(tiptip_holder.html(tiptip_content).prepend(tiptip_arrow.html('<div id="tiptip_arrow_inner"></div>')));
                } else {
                        var tiptip_holder = $("#tiptip_holder");
                        var tiptip_content = $("#tiptip_content");
                        var tiptip_arrow = $("#tiptip_arrow");
                }

                return this.each(function(){
                        var org_elem = $(this);
                        if(opts.content){
                                var org_title = opts.content;
                        } else {
                                var org_title = org_elem.attr(opts.attribute);
                        }
                        if(org_title != ""){
                                if(!opts.content){
                                        org_elem.removeAttr(opts.attribute); //remove original Attribute
                                }
                                var timeout = false;

                                if(opts.activation == "hover"){
                                        org_elem.hover(function(){
                                                active_tiptip();
                                        }, function(){
                                                if(!opts.keepAlive){
                                                        deactive_tiptip();
                                                }
                                        });
                                        if(opts.keepAlive){
                                                tiptip_holder.hover(function(){}, function(){
                                                        deactive_tiptip();
                                                });
                                        }
                                } else if(opts.activation == "focus"){
                                        org_elem.focus(function(){
                                                active_tiptip();
                                        }).blur(function(){
                                                deactive_tiptip();
                                        });
                                } else if(opts.activation == "click"){
                                        org_elem.click(function(){
                                                active_tiptip();
                                                return false;
                                        }).hover(function(){},function(){
                                                if(!opts.keepAlive){
                                                        deactive_tiptip();
                                                }
                                        });
                                        if(opts.keepAlive){
                                                tiptip_holder.hover(function(){}, function(){
                                                        deactive_tiptip();
                                                });
                                        }
                                }

                                function active_tiptip(){
                                        opts.enter.call(this);
                                        tiptip_content.html(org_title);
                                        tiptip_holder.hide().removeAttr("class").css("margin","0");
                                        tiptip_arrow.removeAttr("style");

                                        var top = parseInt(org_elem.offset()['top']);
                                        var left = parseInt(org_elem.offset()['left']);
                                        var org_width = parseInt(org_elem.outerWidth());
                                        var org_height = parseInt(org_elem.outerHeight());
                                        var tip_w = tiptip_holder.outerWidth();
                                        var tip_h = tiptip_holder.outerHeight();
                                        var w_compare = Math.round((org_width - tip_w) / 2);
                                        var h_compare = Math.round((org_height - tip_h) / 2);
                                        var marg_left = Math.round(left + w_compare);
                                        var marg_top = Math.round(top + org_height + opts.edgeOffset);
                                        var t_class = "";
                                        var arrow_top = "";
                                        var arrow_left = Math.round(tip_w - 12) / 2;

                    if(opts.defaultPosition == "bottom"){
                        t_class = "_bottom";
                        } else if(opts.defaultPosition == "top"){
                                t_class = "_top";
                        } else if(opts.defaultPosition == "left"){
                                t_class = "_left";
                        } else if(opts.defaultPosition == "right"){
                                t_class = "_right";
                        }

                                        var right_compare = (w_compare + left) < parseInt($(window).scrollLeft());
                                        var left_compare = (tip_w + left) > parseInt($(window).width());

                                        if((right_compare && w_compare < 0) || (t_class == "_right" && !left_compare) || (t_class == "_left" && left < (tip_w + opts.edgeOffset + 5))){
                                                t_class = "_right";
                                                arrow_top = Math.round(tip_h - 13) / 2;
                                                arrow_left = -12;
                                                marg_left = Math.round(left + org_width + opts.edgeOffset);
                                                marg_top = Math.round(top + h_compare);
                                        } else if((left_compare && w_compare < 0) || (t_class == "_left" && !right_compare)){
                                                t_class = "_left";
                                                arrow_top = Math.round(tip_h - 13) / 2;
                                                arrow_left =  Math.round(tip_w);
                                                marg_left = Math.round(left - (tip_w + opts.edgeOffset + 5));
                                                marg_top = Math.round(top + h_compare);
                                        }

                                        var top_compare = (top + org_height + opts.edgeOffset + tip_h + 8) > parseInt($(window).height() + $(window).scrollTop());
                                        var bottom_compare = ((top + org_height) - (opts.edgeOffset + tip_h + 8)) < 0;

                                        if(top_compare || (t_class == "_bottom" && top_compare) || (t_class == "_top" && !bottom_compare)){
                                                if(t_class == "_top" || t_class == "_bottom"){
                                                        t_class = "_top";
                                                } else {
                                                        t_class = t_class+"_top";
                                                }
                                                arrow_top = tip_h;
                                                marg_top = Math.round(top - (tip_h + 5 + opts.edgeOffset));
                                        } else if(bottom_compare | (t_class == "_top" && bottom_compare) || (t_class == "_bottom" && !top_compare)){
                                                if(t_class == "_top" || t_class == "_bottom") {
                                t_class = "_bottom";
                            } else {
                                t_class = t_class + "_bottom";
                            }
                            arrow_top = -12;
                            marg_top = Math.round(top + org_height + opts.edgeOffset);
                        }

                        if (t_class == "_right_top" || t_class == "_left_top") {
                            marg_top = marg_top + 5;
                        } else if (t_class == "_right_bottom" || t_class == "_left_bottom") {
                            marg_top = marg_top - 5;
                        }
                        if (t_class == "_left_top" || t_class == "_left_bottom") {
                            marg_left = marg_left + 5;
                        }
                        tiptip_arrow.css({"margin-left": arrow_left + "px", "margin-top": arrow_top + "px"});
                        tiptip_holder.css({"margin-left": marg_left + "px", "margin-top": marg_top + "px"}).attr("class", "tip" + t_class);

                        if (timeout) {
                            clearTimeout(timeout);
                        }
                        timeout = setTimeout(function () {
                            tiptip_holder.stop(true, true).fadeIn(opts.fadeIn);
                        }, opts.delay);
                    }

                    function deactive_tiptip() {
                        opts.exit.call(this);
                        if (timeout) {
                            clearTimeout(timeout);
                        }
                        tiptip_holder.fadeOut(opts.fadeOut);
                    }
                }
            });
        }
    })(jQuery);  
    var tiptip_args = {
        'attribute': 'data-tip',
        'fadeIn': 50,
        'fadeOut': 50,
        'delay': 200,
        defaultPosition: "top"
    };
    jQuery('.nbd-help-tip').tipTip( tiptip_args );
    var nbd_form_option = {
        option: <?php echo json_encode($options["fields"]); ?>,
        init: function(){
            
        },
        onchange: function(){
            
        },
        validate: function(){
            
        },
        calculate_price: function(){
            console.log(23);
        }
    };
    jQuery('.variations_form').on('woocommerce_variation_has_changed', function(){
        nbd_form_option.calculate_price();
    });
</script>