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
						if(t_class == "_top" || t_class == "_bottom"){
							t_class = "_bottom";
						} else {
							t_class = t_class+"_bottom";
						}
						arrow_top = -12;
						marg_top = Math.round(top + org_height + opts.edgeOffset);
					}

					if(t_class == "_right_top" || t_class == "_left_top"){
						marg_top = marg_top + 5;
					} else if(t_class == "_right_bottom" || t_class == "_left_bottom"){
						marg_top = marg_top - 5;
					}
					if(t_class == "_left_top" || t_class == "_left_bottom"){
						marg_left = marg_left + 5;
					}
					tiptip_arrow.css({"margin-left": arrow_left+"px", "margin-top": arrow_top+"px"});
					tiptip_holder.css({"margin-left": marg_left+"px", "margin-top": marg_top+"px"}).attr("class","tip"+t_class);

					if (timeout){ clearTimeout(timeout); }
					timeout = setTimeout(function(){ tiptip_holder.stop(true,true).fadeIn(opts.fadeIn); }, opts.delay);
				}

				function deactive_tiptip(){
					opts.exit.call(this);
					if (timeout){ clearTimeout(timeout); }
					tiptip_holder.fadeOut(opts.fadeOut);
				}
			}
		});
	}
})(jQuery);
var AD_NBD_OPTIONS = {
    render_price_matrix: function(){
        
    }
};
angular.module('optionApp', []).controller('optionCtrl', function( $scope, $timeout ) {
    /* init parameters */
    $scope.showPreview = true;
    $scope.previewWide = false;
    /* end init parameters */
    /* quantity */
    $scope.validate_quantity_break = function(){
        
    };
    $scope.add_price_break = function(){
        var last =  $scope.options.quantity_breaks.length > 0 ? $scope.options.quantity_breaks[$scope.options.quantity_breaks.length - 1].val : 0; 
        $scope.options.quantity_breaks.push({ val: last + 1 });
    };
    $scope.remove_price_break = function( index ){
        $scope.options.quantity_breaks.splice(index, 1);
    };    
    /* end. quantity */
    $scope.add_field = function(type){
        var field = {};
        angular.copy(NBDOPTION_FIELD, field);
        var d = new Date();
        field['id'] = 'f' + d.getTime();
        field.isExpand = true;
        if( angular.isDefined( type ) ){
            field.is_nbd = 1;
            field.nbd_template = 'nbd.' + type;
            field.general.title.value = nbd_options.nbd_options_lang[type];
        }
        $scope.options.fields.push( field );
        $scope.initfieldValue();
    };
    $scope.copy_field = function( index ){
        var field = {};
        angular.copy($scope.options.fields[index], field);
        var d = new Date();
        field['id'] = 'f' + d.getTime();
        field['general']['title']['value'] = field['general']['title']['value'] + ' - Copy';
        $scope.options.fields.push( field );
        $scope.initfieldValue();
    };
    $scope.delete_field = function(index){
        $scope.options.fields.splice(index, 1);
        $scope.initfieldValue();
    }; 
    $scope.toggleExpandField =  function(index, $event){
        $scope.options.fields[index].isExpand = !$scope.options.fields[index].isExpand;
        var parent = jQuery($event.target).parents('.nbd-field-wrap');
        $timeout(function() {
            jQuery('html,body').animate({ scrollTop: parent.offset().top - 50}, 200);
        }, 0);
    }; 
    $scope.initfieldValue = function(){
        angular.forEach($scope.options.fields, function(field, key){
            $scope.option_values[key] = angular.isDefined($scope.option_values[key]) ? $scope.option_values[key] : '';
            if(field.general.data_type.value == 'i'){
                $scope.option_values[key] = '';
            }else{
                if( field.general.attributes.options.length == 0 ){
                    $scope.option_values[key] = '';
                }else{
                    $scope.option_values[key] = 0;
                    angular.forEach(field.general.attributes.options, function(op, k){
                        if( op.selected ) $scope.option_values[key] = k;
                    });
                }
            }            
        });
    };
    $scope.init = function(){
        $scope.options = NBDOPTIONS;
        $scope.option_values = [];
        angular.forEach($scope.options.fields, function(field, key){
            field.isExpand = false;
        });
        $scope.initfieldValue();
    };
    $scope.debug = function(){
        console.log($scope.options);
    };
    $scope.check_depend = function( fields, data ){
        if( angular.isUndefined(data.depend) ) return true;
        var check = [], total_check = true;
        angular.forEach(data.depend, function(f, _key){
            check[_key] = f.operator == '=' ? false : true;
            angular.forEach(fields, function(field, key){
                if( key == f.field && field.value == f.value ){
                    check[_key] = f.operator == '=' ? true : false;
                }
            });
        });
        angular.forEach(check, function(c, k){
            total_check = total_check && c;
        });
        return total_check;
    };
    $scope.check_option_depend = function(fieldIndex, depend){
        if( angular.isUndefined(depend) ) return true;
        if( depend.operator  == '=' ){
            if($scope.options['fields'][fieldIndex]['general'][depend.field].value == depend.value) return true;
        }else{
            if($scope.options['fields'][fieldIndex]['general'][depend.field].value != depend.value) return true;
        }
        return false;
    };
    $scope.remove_attribute = function(fieldIndex, key, $index){
        $scope.options['fields'][fieldIndex]['general'][key]['options'].splice($index, 1);
    };
    $scope.seleted_attribute = function(fieldIndex, key, $index){
        angular.forEach($scope.options['fields'][fieldIndex]['general'][key]['options'], function(field, _key){
            $scope.options['fields'][fieldIndex]['general'][key]['options'][_key]['selected'] = 0;
        });
        $scope.options['fields'][fieldIndex]['general'][key]['options'][$index]['selected'] = 1;
        $scope.initfieldValue();
    };
    $scope.add_attribute = function(fieldIndex, key){
        $scope.options['fields'][fieldIndex]['general'][key]['options'].push(
            {
                name: '',
                price: [],
                selected: 0,
                preview_type:  'i',
                image:  0,
                image_url:  '',
                color:  '#ffffff'                
            }
        );
    };
    $scope.set_attribute_image = function(fieldIndex, $index){
        var file_frame;
        if ( file_frame ) {
            file_frame.open();
            return;
        };
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            library: {
                    type: [ 'image' ]
            },
            multiple: false
        });
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index].image = attachment.id;
            var url = attachment.url;
            if( angular.isDefined(attachment.sizes) && angular.isDefined(attachment.sizes.thumbnail) ){
                url = attachment.sizes.thumbnail.url;
            }
            $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index].image_url = url;
            if ($scope.$root.$$phase !== "$apply" && $scope.$root.$$phase !== "$digest") $scope.$apply();
        });
        file_frame.open(); 
    };
    $scope.remove_attribute_image= function(fieldIndex, $index){
        $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index].image = 0;
        $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index].image_url = '';
    }; 
    $scope.add_condition = function(fieldIndex){
        $scope.options['fields'][fieldIndex]['conditional'].depend.push({
            id:  '',
            operator:  'i',
            val:  ''            
        });
    };
    $scope.delete_condition = function(fieldIndex, cdIndex){
        if( $scope.options['fields'][fieldIndex]['conditional'].depend.length == 1 ) return;
        $scope.options['fields'][fieldIndex]['conditional'].depend.splice(cdIndex, 1);
    };
    $scope.update_price_type = function(fieldIndex){
        if( $scope.options['fields'][fieldIndex]['general'].data_type.value == 'm' && $scope.options['fields'][fieldIndex]['general'].price_type.value == 'c' ){
            $scope.options['fields'][fieldIndex]['general'].price_type.value = 'f';
        }
    };
    $scope.check_option_visible = function(fieldIndex){
        if( $scope.options['fields'][fieldIndex]['conditional'].enable == 'n' ) return true;
        if( angular.isUndefined( $scope.options['fields'][fieldIndex]['conditional'].depend ) ) return true;
        if( $scope.options['fields'][fieldIndex]['conditional'].depend.length == 0 ) return true;
        var show = $scope.options['fields'][fieldIndex]['conditional']['show'],
        logic = $scope.options['fields'][fieldIndex]['conditional']['logic'],
        check = [];
        var total_check = logic == 'a' ? true : false;
        function get_field(fieldId){
            var field = null;
            angular.forEach($scope.options['fields'], function(_field, key){
                if( _field.id == fieldId){
                    field = _field;
                    field.index = key;
                }
            });
            return field;
        };
        angular.forEach($scope.options['fields'][fieldIndex]['conditional'].depend, function(con, _key){
            if( con.id != '' ){
                var field = get_field(con.id);
                switch(con.operator){
                    case 'i':
                        check[_key] = $scope.option_values[field.index] == con.val ? true : false;
                        break;
                    case 'n':
                        check[_key] = $scope.option_values[field.index] != con.val ? true : false;
                        break;  
                    case 'e':
                        check[_key] = $scope.option_values[field.index] == '' ? true : false;
                        break;
                    case 'ne':
                        check[_key] = $scope.option_values[field.index] != '' ? true : false;
                        break;                     
                }
            }else{
                check[_key] = true;
            }
        });
        angular.forEach(check, function(c, k){
            total_check = logic == 'a' ? (total_check && c) : (total_check || c);
        });
        return show == 'y' ? total_check : !total_check;
    };
    $scope.init();
}).directive('stringToNumber', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(value) {
                return '' + value;
            });
            ngModel.$formatters.push(function(value) {
                return parseFloat(value);
            });
        }
    };
}).directive( 'nbdColorPicker', function() {
    return {
        restrict: 'A',
        link: function( scope, element ) {
            jQuery(element).wpColorPicker({
                change: function (evt, ui) {
                    var $input = jQuery(this);
                    setTimeout(function () {
                        if ($input.wpColorPicker('color') !== $input.data('tempcolor')) {
                            $input.change().data('tempcolor', $input.wpColorPicker('color'));
                            $input.val($input.wpColorPicker('color'));
                        }
                    }, 10);
                }
            });
        }
    }
}).directive( 'nbdTab', function($timeout) {
    return {
        restrict: 'A',
        link: function( scope, element ) {
            $timeout(function() {
                jQuery.each( jQuery(element).find('.nbd-field-tab'), function(){
                    jQuery(this).on('click', function(){
                        var target = jQuery(this).data('target');
                        jQuery(this).parents('.nbd-field-wrap').find('.nbd-field-content').removeClass('active');
                        jQuery(this).parent('ul').find('li').removeClass('active');
                        jQuery(this).parents('.nbd-field-wrap').find('.'+target).addClass('active');
                        jQuery(this).addClass('active');      
                    });
                });
            });
        }
    }
}).directive( 'nbdTip', function($timeout) {
    return {
        restrict: 'E',
        scope: {
            dataTip: '@tip'
        },
        template: '<span class="woocommerce-help-tip" data-tip="{{dataTip}}" ></span>',
        link: function( scope, element, attrs ) {
            var tiptip_args = {
                'attribute': 'data-tip',
                'fadeIn': 50,
                'fadeOut': 50,
                'delay': 200
            };
            $timeout(function() {
                jQuery(element).find('.woocommerce-help-tip').tipTip( tiptip_args );
            }, 0);
        }
    }
});
jQuery( document ).ready(function($){
   
});