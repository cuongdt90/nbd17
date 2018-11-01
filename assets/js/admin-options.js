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
angular.module('optionApp', []).controller('optionCtrl', function( $scope, $timeout, pmFieldFilter, bulkFieldFilter ) {
    /* init parameters */
    $scope.showPreview = false;
    $scope.previewWide = false;
    /* end init parameters */
    /* quantity */
    $scope.validate_quantity_break = function(){
        
    };
    $scope.excludeField = function(actual, expected){
        var _field = null;
        angular.forEach($scope.options.fields, function(field){
            if( field.id == actual ) _field = field;
        });
        if( _field.nbd_type == 'page' ) return false;
        return actual != expected;
    };
    $scope.add_price_break = function(){
        var last =  $scope.options.quantity_breaks.length > 0 ? $scope.options.quantity_breaks[$scope.options.quantity_breaks.length - 1].val : 0; 
        $scope.options.quantity_breaks.push({ val: last + 1 });
    };
    $scope.remove_price_break = function( index ){
        if( $scope.options.quantity_breaks.length == 1 ) return;
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
            if( angular.isDefined($scope.nbd_options[type]) && $scope.nbd_options[type] == 1 ){
                alert(nbd_options.nbd_options_lang.option_exist);
                return;
            }else{
                $scope.nbd_options[type] = 1;
            }
            field.nbd_type = type;
            field.nbd_template = 'nbd.' + type;
            field.general.title.value = nbd_options.nbd_options_lang[type];
            switch(type){
                case 'dpi': 
                    field.general.input_option.value.min = 72;
                    field.general.input_option.value.max = 600;
                    field.general.data_type.value = 'i';
                    field.general.data_type.hidden = true;
                    field.general.input_type.value = 'n';
                    field.general.input_type.hidden = true;
                    field.general.description.value = nbd_options.nbd_options_lang.dpi_description;
                    break;
                case 'page': 
                    field.general.data_type.value = 'i';
                    //field.general.data_type.hidden = true;
                    field.general.input_type.value = 'n';
                    field.general.input_type.hidden = true;
                    field.general.price_type.value = 'c';
                    field.general.price_type.hidden = true;
                    field.general.page_display = '1';
                    field.general.exclude_page = '0';
                    field.general.attributes.options[1] = {};
                    //field.general.attributes.options[2] = {};
                    angular.copy(field.general.attributes.options[0], field.general.attributes.options[1]); 
                    //angular.copy(field.general.attributes.options[0], field.general.attributes.options[2]); 
                    field.general.attributes.options[0].name = nbd_options.nbd_options_lang.front;
                    field.general.attributes.options[1].name = nbd_options.nbd_options_lang.back;
                    //field.general.attributes.options[2].name = nbd_options.nbd_options_lang.both;
                    //field.general.attributes.add_att = false;
                    //field.general.attributes.remove_att = false;
                    break;
                case 'color':
                    field.general.data_type.value = 'm';
                    field.general.data_type.hidden = true;
                    field.general.attributes.bg_type = 'i';
                    field.general.attributes.number_of_sides = 4;
                    angular.forEach(field.general.attributes.options, function(op){
                        op.bg_image = [];
                        op.bg_image_url = [];
                    });
                    break;
                case 'orientation':
                    field.general.data_type.value = 'm';
                    field.general.data_type.hidden = true;
                    field.general.attributes.options[1] = {};
                    angular.copy(field.general.attributes.options[0], field.general.attributes.options[1]); 
                    field.general.attributes.options[0].name = nbd_options.nbd_options_lang.vertical;
                    field.general.attributes.options[1].name = nbd_options.nbd_options_lang.horizontal;
                    //field.general.attributes.add_att = false;
                    //field.general.attributes.remove_att = false;
                    break;
                case 'area':
                    field.general.data_type.value = 'm';
                    field.general.data_type.hidden = true;
                    field.general.attributes.options[1] = {};
                    angular.copy(field.general.attributes.options[0], field.general.attributes.options[1]); 
                    field.general.attributes.options[0].name = nbd_options.nbd_options_lang.rectangle;
                    field.general.attributes.options[1].name = nbd_options.nbd_options_lang.ellipse;
                    field.general.attributes.add_att = false;
                    field.general.attributes.remove_att = false;
                    break;
                case 'size':
                    field.general.data_type.value = 'm';
                    field.general.data_type.hidden = true;
                    field.general.attributes.same_size = 'y';
                    break;
                case 'dimension':
                    field.general.data_type.value = 'i';
                    field.general.data_type.hidden = true;
                    field.general.input_type.value = 't';
                    field.general.input_type.hidden = true;
                    field.general.mesure = 'n';
                    field.general.mesure_range = [];
                    break;
            }
        }
        $scope.options.fields.push( field );
        $timeout(function(){
            jQuery('html,body').animate({
                scrollTop: jQuery("#" + field['id']).offset().top
            }, 'slow');            
        });
        $scope.initfieldValue();
    };
    $scope.add_measurement_range = function(fieldIndex){
        $scope.options['fields'][fieldIndex].general.mesure_range.push([]);
    };
    $scope.delete_measurement_ranges = function(fieldIndex, $event){
        var mesure_range = $scope.options['fields'][fieldIndex].general.mesure_range;
        if( mesure_range.length ){
            var need_delete = [];
            angular.forEach(mesure_range, function(mr, mr_index){
                if( mr[3] ){
                    need_delete.push(mr_index);
                };
            });
            for (var i = need_delete.length -1; i >= 0; i--) mesure_range.splice(need_delete[i],1);
        }
        angular.element($event.currentTarget).parents('table.nbo-measure-range').find('input.nbo-measure-range-select-all').prop('checked', false);
    };
    $scope.select_all_measurement_range = function(fieldIndex, $event){
        var mesure_range = $scope.options['fields'][fieldIndex].general.mesure_range;
        var el = angular.element($event.target),
        check = el.prop('checked') ? true : false;
        if( mesure_range.length ){
            angular.forEach(mesure_range, function(mr, mr_index){
                mr[3] = check;
            });
        }
    };
    $scope.copy_field = function( index ){
        if(angular.isDefined($scope.options.fields[index].nbd_type)){
            alert(nbd_options.nbd_options_lang.can_not_copy);
            return;
        }
        var field = {};
        angular.copy($scope.options.fields[index], field);
        var d = new Date();
        field['id'] = 'f' + d.getTime();
        field['general']['title']['value'] = field['general']['title']['value'] + ' - Copy';
        $scope.options.fields.push( field );
        $scope.initfieldValue();
    };
    $scope.delete_field = function(index){
        var con = confirm(nbd_options.nbd_options_lang.want_to_delete);
        if( con ){
            var field = $scope.options.fields[index];
            if( angular.isDefined(field.nbd_type) ){
                $scope.nbd_options[field.nbd_type] = 0;
            }
            $scope.options.fields.splice(index, 1);
            $scope.initfieldValue();
        }
    }; 
    $scope.sort_field= function(field_index, direction){
        var dest_index = field_index - 1;
        if( direction == 'up' ){
            if( field_index == 0 ) return;
        }else{
            if( field_index == ( $scope.options.fields.length - 1 ) ) return;
            dest_index = field_index + 1;
        }
        var temp_field = {};
        angular.copy($scope.options.fields[field_index], temp_field);
        angular.copy($scope.options.fields[dest_index ], $scope.options.fields[field_index ]);
        angular.copy(temp_field, $scope.options.fields[dest_index ]);
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
            if( angular.isDefined(field.nbd_type) ){
                $scope.nbd_options[field.nbd_type] = 1;
                switch(field.nbd_type){
                    case 'dpi': 
                        field.general.data_type.hidden = true;
                        field.general.input_type.hidden = true;
                        break;
                    case 'page': 
                        field.general.input_type.hidden = true;
                        field.general.price_type.hidden = true;
                        if( field.general.data_type.value == 'i' ){
                            field.general.attributes.options[1] = {};
                            field.general.attributes.options[2] = {};
                            angular.copy(field.general.attributes.options[0], field.general.attributes.options[1]); 
                            //angular.copy(field.general.attributes.options[0], field.general.attributes.options[2]); 
                            field.general.attributes.options[0].name = nbd_options.nbd_options_lang.front;
                            field.general.attributes.options[1].name = nbd_options.nbd_options_lang.back;
                            //field.general.attributes.options[2].name = nbd_options.nbd_options_lang.both;
                        }
                        //field.general.attributes.add_att = false;
                        //field.general.attributes.remove_att = false;
                        break;
                    case 'color':
                        field.general.data_type.hidden = true;
                        if( field.general.attributes.options.bg_type == 'c' ){
                            angular.forEach(field.general.attributes.options, function(op){
                                op.bg_image = [];
                                op.bg_image_url = [];
                            });
                        }
                        break;
                    case 'orientation':
                        field.general.data_type.hidden = true;
                        field.general.attributes.add_att = false;
                        field.general.attributes.remove_att = false;
                        break;
                    case 'area':
                        field.general.data_type.hidden = true;
                        field.general.attributes.add_att = false;
                        field.general.attributes.remove_att = false;
                        break;
                    case 'size':
                        field.general.data_type.hidden = true;
                        break;
                    case 'dimension':
                        field.general.data_type.hidden = true;
                        field.general.input_type.hidden = true;
                        break;
                }
            }
        });
    };
    $scope.init = function( fields ){
        $scope.nbd_options = {};
        $scope.options = NBDOPTIONS;
        if( angular.isDefined(fields) ){
            $scope.options.fields = fields;
            if ($scope.$root.$$phase !== "$apply" && $scope.$root.$$phase !== "$digest") $scope.$apply(); 
        }
        $scope.option_values = [];
        angular.forEach($scope.options.fields, function(field, key){
            field.isExpand = false;
        });
        $scope.initfieldValue();
        $scope.options.pm_ver = $scope.options.pm_ver ? $scope.options.pm_ver : [];
        $scope.options.pm_hoz = $scope.options.pm_hoz ? $scope.options.pm_hoz : [];
        $scope.$watchCollection('options.fields', function(newVal, oldVal){
            $scope.availablePmHozFileds = pmFieldFilter($scope.options.fields, $scope.options.pm_ver);
            $scope.availablePmVerFileds = pmFieldFilter($scope.options.fields, $scope.options.pm_hoz);
            $scope.availableBulkFileds = bulkFieldFilter($scope.options.fields);
        }, true);
        $scope.$watchCollection('options.pm_ver', function(newVal, oldVal){
            $scope.availablePmHozFileds = pmFieldFilter($scope.options.fields, $scope.options.pm_ver);
        }, true);    
        $scope.$watchCollection('options.pm_hoz', function(newVal, oldVal){
            $scope.availablePmVerFileds = pmFieldFilter($scope.options.fields, $scope.options.pm_hoz);
        }, true);         
    };
    $scope.export = function(){
        var filename = 'options.json',
        options = JSON.stringify( $scope.options.fields, function(name, val){
            if( name == '$$hashKey' ){
                return undefined;
            }else{
                return val;
            }
        });
        var a = document.createElement('a');
        a.setAttribute('href', 'data:text/plain;charset=utf-u,'+ options);
        a.setAttribute('download', filename);
        a.click();
    };
    $scope.import = function(){
        var input = document.createElement('input');
        input.type = 'file';
        input.accept = 'text/json|application/json';
        input.style.display = 'none';
        input.addEventListener('change', onChange.bind(input), false);
        document.body.appendChild(input);
        input.click();
        function onChange(){
            if (this.files.length > 0) {
                var file = this.files[0],
                reader = new FileReader();
                reader.onload = function(event){
                    if (event.target.readyState === 2) {
                        var result = JSON.parse(reader.result);
                        $scope.init(result);
                        destroy();
                    }
                };
                reader.readAsText(file);                
            }            
        }
        function destroy() {
            input.removeEventListener('change', onChange.bind(input), false);
            document.body.removeChild(input);
        }        
    };
    $scope.debug = function(){
        console.log($scope.options);
    };
    $scope.check_depend = function( fields, data ){
        if( angular.isDefined(data.hidden) ) return false;
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
        if( angular.isDefined( $scope.options['fields'][fieldIndex]['general'][key].remove_att ) ){
            alert(nbd_options.nbd_options_lang.can_not_remove_att);
            return;
        }
        $scope.options['fields'][fieldIndex]['general'][key]['options'].splice($index, 1);
    };
    $scope.sort_attribute = function(fieldIndex, opIndex, direction){
        var options = $scope.options['fields'][fieldIndex]['general']['attributes']['options'];
        var dest_index = opIndex - 1;
        if( direction == 'up' ){
            if( opIndex == 0 ) return;
        }else{
            if( opIndex == ( options.length - 1 ) ) return;
            dest_index = opIndex + 1;
        }
        var temp_op = {};
        angular.copy(options[opIndex], temp_op);
        angular.copy(options[dest_index ], options[opIndex]);
        angular.copy(temp_op, options[dest_index]);
        $scope.initfieldValue();
    };
    $scope.seleted_attribute = function(fieldIndex, key, $index){
        angular.forEach($scope.options['fields'][fieldIndex]['general'][key]['options'], function(field, _key){
            $scope.options['fields'][fieldIndex]['general'][key]['options'][_key]['selected'] = 0;
        });
        $scope.options['fields'][fieldIndex]['general'][key]['options'][$index]['selected'] = 1;
        $scope.initfieldValue();
    };
    $scope.add_attribute = function(fieldIndex, key){
        if( angular.isDefined( $scope.options['fields'][fieldIndex]['general'][key].add_att ) ){
            alert(nbd_options.nbd_options_lang.can_not_add_att);
            return;
        }
        $scope.options['fields'][fieldIndex]['general'][key]['options'].push(
            {
                name: nbd_options.nbd_options_lang.attribute_name,
                price: [],
                selected: 0,
                preview_type:  'i',
                image:  0,
                image_url:  '',
                color:  '#ffffff',
                bg_image: [],
                bg_image_url: []
            }
        );
    };
    $scope.set_attribute_image = function(fieldIndex, $index, type, type_url, $bg_index){
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
            if( angular.isDefined($bg_index) ){
                $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index][type][$bg_index] = attachment.id;
            }else{
                $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index][type] = attachment.id;
            }
            var url = attachment.url;
            if( angular.isDefined(attachment.sizes) && angular.isDefined(attachment.sizes.thumbnail) ){
                url = attachment.sizes.thumbnail.url;
            }
            if( angular.isDefined($bg_index) ){
                $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index][type_url][$bg_index] = url;
            }else{
                $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index][type_url] = url;
            }
            if ($scope.$root.$$phase !== "$apply" && $scope.$root.$$phase !== "$digest") $scope.$apply();
        });
        file_frame.open(); 
    };
    $scope.remove_attribute_image= function(fieldIndex, $index, type, type_url){
        $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index][type] = 0;
        $scope.options['fields'][fieldIndex]['general']['attributes']['options'][$index][type_url] = '';
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
}).directive('convertToNumber', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(val) {
                return val != null ? parseInt(val, 10) : null;
            });
            ngModel.$formatters.push(function(val) {
                return val != null ? '' + val : null;
            });
        }
    };    
}).directive( 'nbdColorPicker', function() {
    return {
        restrict: 'A',
        scope: {
            value: '=nbdColorPicker'
        },
        link: function( scope, element ) {
            function init(){
                jQuery(element).val(scope.value);
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
            };
            scope.$watch('value', function(newValue, oldValue) {
                if (newValue != oldValue){
                    jQuery(element).wpColorPicker('color', newValue);
                }
            }, true);
            init();
        }
    };
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
    };
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
    };
}).filter('range', function() {
    return function (input, total) {
        total = parseInt(total);
        for (var i = 0; i < total; i++) {
            input.push(i);
        }
        return input;
    };
}).filter('pmField', function(){
    return function(fields, usedFields){
        var filtered_fileds = [];
        angular.forEach(fields, function(field, field_index){
            if( usedFields.indexOf(''+field_index) < 0 && field.general.data_type.value == 'm' && field.general.enabled.value == 'y' && field.general.attributes.options.length > 0 && field.conditional.enable == 'n' ){
                var _field = {};
                angular.copy(field, _field);
                _field.field_index = field_index;
                filtered_fileds.push(_field);
            }
        });
        return filtered_fileds;
    }
}).filter('bulkField', function(){
    return function(fields){
        var filtered_fileds = [];
        angular.forEach(fields, function(field, field_index){
            var exclude = ['dpi', 'page', 'orientation', 'area', 'dimension'];
            var check_od = true;
            if( angular.isDefined(field.nbd_type) && exclude.indexOf(field.nbd_type) > -1 ){
                check_od = false;
            }
            if( check_od && field.general.data_type.value == 'm' && field.general.enabled.value == 'y' && field.general.attributes.options.length > 0 && field.conditional.enable == 'n' ){
                var _field = {};
                angular.copy(field, _field);
                _field.field_index = field_index;
                filtered_fileds.push(_field);
            }
        });
        return filtered_fileds;
    }
});
jQuery( document ).ready(function($){
    $(".nbo-dates input:not(.hasDatepicker)").datepicker({
        defaultDate: "",
        dateFormat: "yy-mm-dd",
        numberOfMonths: 1,
        showButtonPanel: true,
        showOn: "button",
        buttonImage: nbd_options.calendar_image,
        buttonImageOnly: true,
        onSelect: function (selectedDate) {
            var option = $(this).is('.date_from') ? "minDate" : "maxDate";
            var instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            var dates = $(this).parents('.nbo-dates').find('input');
            dates.not(this).datepicker("option", option, date);
        }
   });
    $('.nbo-toggle-nav').on('click', function(){
        $('.nbo-toggle').removeClass('active');
        if( $(this).is(':checked') ){
            $($(this).data('toggle')).addClass('active');
        }
    });
});