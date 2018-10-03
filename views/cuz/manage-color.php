<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<?php
    $path = NBDESIGNER_DATA_DIR . '/colors.json';
    if (!empty($_POST)) {
        $name = $_POST['nbdesigner_color_name'];
        $hex = $_POST['nbdesigner_color_hex'];
        $cats = isset($_POST['nbdesigner_color_cat']) ? $_POST['nbdesigner_color_cat'] : array(0);
        $id = $_POST['nbdesigner_color_id'];
        $data = [
            'id' => $id,
            'name' => $name,
            'alias' => nbd_alias($name),
            'hex' => $hex,
            'cat' => $cats
        ];
        Nbdesigner_IO::update_json_setting($path, $data, $id);
    }
    $_list_color = Nbdesigner_IO::read_json_setting($path);
    $cat_color = Nbdesigner_IO::read_json_setting(NBDESIGNER_DATA_DIR . '/color_cat.json');
    $current_color_cat_id = 0;
    $current_cat_id = (isset($_GET['cat_id'])) ? $_GET['cat_id'] : '';
    if ($current_cat_id !== '') {
        $list_color = array_filter($_list_color, function ($val) use ($current_cat_id){
            return in_array($current_cat_id, $val->cat) || ($current_cat_id == 0 && sizeof($val->cat) == 0);
        });
    }else{
        $list_color = $_list_color;
    }
    if (is_array($cat_color)) {
        $current_color_cat_id = count($cat_color);
    }
?>

<h1><?php _e('Manage Color', 'web-to-print-online-designer'); ?></h1>
<div class="wrap nbdesigner-container">
    <div class="nbdesigner-content-full">
        <form name="post" action="" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="nbdesigner-content-left postbox">
                <div class="inside">
                    <?php wp_nonce_field('nbd_color', 'nbd_color_nonce'); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row" class="titledesc"><?php echo __("Name", 'web-to-print-online-designer'); ?> </th>
                            <td class="forminp-text">
                                <input type="text" name="nbdesigner_color_name" value=""/><br />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row" class="titledesc"><?php echo __("Hexadecimal", 'web-to-print-online-designer'); ?> </th>
                            <td class="forminp-text">
                                <input type="text" name="nbdesigner_color_hex" value="#fff" class="nbdesigner-option-manager-color"/><br />
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="nbdesigner_color_id" value="<?php echo count($_list_color); ?>"/>
                    <p class="submit">
                        <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save', 'web-to-print-online-designer'); ?>" />
                        <a href="?page=nbdesigner_manager_fonts" class="button-primary" style="<?php $style = (isset($_GET['id'])) ? '' : 'display:none;';echo $style; ?>"><?php _e('Add New', 'web-to-print-online-designer'); ?></a>
                    </p>
                </div>
            </div>
            <div class="nbdesigner-content-side">
                <div class="postbox" style="padding-bottom: 5px;">
                    <h3><?php _e('Color group', 'web-to-print-online-designer'); ?><img src="<?php echo NBDESIGNER_PLUGIN_URL . 'assets/images/loading.gif'; ?>" class="nbdesigner_editcat_loading nbdesigner_loaded" style="margin-left: 15px;"/></h3>
                    <div class="inside">
                        <ul id="nbdesigner_list_color_cats">
                            <?php if(is_array($cat_color) && (count($cat_color) > 0)): ?>
                                <?php foreach($cat_color as $val): ?>
                                    <li id="nbdesigner_cat_color_<?php echo $val->id; ?>" class="nbdesigner_action_delete_color_cat">
                                        <label>
                                            <input value="<?php echo $val->id; ?>" type="checkbox" name="nbdesigner_color_cat[]" <?php if(count($cat_color) > 0 ) if(in_array($val->id, $cat_color)) echo "checked";  ?> />
                                        </label>
                                        <span class="nbdesigner-right nbdesigner-delete-item dashicons dashicons-no-alt" onclick="NBDESIGNADMIN.delete_cat_color(this)"></span>
                                        <span class="dashicons dashicons-edit nbdesigner-right nbdesigner-delete-item" onclick="NBDESIGNADMIN.edit_cat_color(this)"></span>
                                        <a href="<?php echo add_query_arg(array('cat_id' => $val->id), admin_url('admin.php?page=manage_color')); ?>" class="nbdesigner-cat-link"><?php echo $val->name; ?></a>
                                        <input value="<?php echo $val->name; ?>" class="nbdesigner-editcat-name" type="text"/>
                                        <span class="dashicons dashicons-yes nbdesigner-delete-item nbdesigner-editcat-name" onclick="NBDESIGNADMIN.save_cat_color(this)"></span>
                                        <span class="dashicons dashicons-no nbdesigner-delete-item nbdesigner-editcat-name" onclick="NBDESIGNADMIN.remove_action_cat_color(this)"></span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><?php _e('You don\'t have any color group.', 'web-to-print-online-designer'); ?></li>
                            <?php endif; ?>
                        </ul>
                        <input type="hidden" id="nbdesigner_current_color_cat_id" value="<?php echo $current_color_cat_id; ?>"/>
                        <p><a id="nbdesigner_add_color_cat"><?php _e('+ Add new art category', 'web-to-print-online-designer'); ?></a></p>
                        <div id="nbdesigner_color_newcat" class="category-add"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="clear"></div>
    <div class="postbox" id="nbd-list-colors">
        <h3 style="line-height: 20px;"><?php echo __('List color', 'web-to-print-online-designer'); ?>
            <?php if(is_array($cat_color) && (count($cat_color) > 0)): ?>
                <select onchange="if (this.value) window.location.href=this.value+'#nbd-list-colors'">
                    <option value="<?php echo admin_url('admin.php?page=manage_color'); ?>"><?php _e('Select a category', 'web-to-print-online-designer'); ?></option>
                    <?php foreach($cat_color as $cat_index => $val): ?>
                        <option value="<?php echo add_query_arg(array('cat_id' => $val->id), admin_url('admin.php?page=manage_color')) ?>" <?php selected( $cat_index, $current_cat_id ); ?>><?php echo $val->name; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php  endif; ?>
        </h3>
        <div class="nbdesigner-list-fonts inside">
            <div class="nbdesigner-list-arts-container">
                <?php if(is_array($list_color) && (count($list_color) > 0)): ?>
                    <?php foreach($list_color as $val):?>
                        <div class="nbdesigner_color_wrap" style="display: inline-block; margin: 0 5px 10px 0;">
                            <div class="nbdesigner_art_link" style="margin: 0;height: 30px;background-color: <?php echo $val->hex;?>">
                                <span class="nbdesigner_action_delete_color" data-index="<?php echo $val->id; ?>" onclick="NBDESIGNADMIN.delete_color(this)">&times;</span>
                            </div>
                            <p class="nbdesigner_color_name" style="margin: 0; text-align: center"><?php echo $val->name;?></p>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <?php _e('You don\'t have any color.', 'web-to-print-online-designer');?>
                <?php  endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $('.nbdesigner-option-manager-color').wpColorPicker();
            NBDESIGNADMIN.add_color_cat = function (e) {
                var cat_name = $(e).parent().find('.nbdesigner_color_name').val(),
                    cat_id = $('#nbdesigner_current_color_cat_id').val();
                if (cat_name == "") {
                    alert(admin_nbds.nbds_lang.warning_mes_fill_category_name);
                    return;
                }
                $.ajax({
                    url: admin_nbds.url,
                    method: "POST",
                    data: {'action': 'nbdesigner_add_color_group', 'name': cat_name, 'id': cat_id, 'nonce': admin_nbds.nonce},
                    beforeSend: function () {
                        $('#nbdesigner_img_loading').removeClass('nbdesigner_loaded');
                    },
                    complete: function () {
                        $('#nbdesigner_img_loading').addClass('nbdesigner_loaded');
                    }
                }).done(function (data) {
                    if (data.flag == 1) {
                        swal(admin_nbds.nbds_lang.complete, data.mes, "success");
                        var html = '<li id="nbdesigner_cat_color_' + cat_id + '" class="nbdesigner_action_delete_color_cat"><label>';
                        html += '<input value="' + cat_id + '" type="checkbox" name="nbdesigner_color_cat[]" /></label>';
                        html += '<span class="nbdesigner-right nbdesigner-delete-item dashicons dashicons-no-alt" onclick="NBDESIGNADMIN.delete_cat_color(this)"></span>';
                        html += '<span class="dashicons dashicons-edit nbdesigner-right nbdesigner-delete-item" onclick="NBDESIGNADMIN.edit_cat_color(this)"></span>';
                        html += '<a href="?page=manage_color&cat_id='+cat_id+'" class="nbdesigner-cat-link">'+cat_name+'</a>';
                        html += '<input value="'+cat_name+'" class="nbdesigner-editcat-name" type="text"/>';
                        html += '<span class="dashicons dashicons-yes nbdesigner-delete-item nbdesigner-editcat-name" onclick="NBDESIGNADMIN.save_cat_color(this)"></span>';
                        html += '<span class="dashicons dashicons-no nbdesigner-delete-item nbdesigner-editcat-name" onclick="NBDESIGNADMIN.remove_action_cat_color(this)"></span>';
                        html += '</span>';
                        $('#nbdesigner_list_color_cats').append(html);
                        $('#nbdesigner_current_color_cat_id').val(parseInt(cat_id) + 1);
                        $('#nbdesigner_color_newcat').html('');
                    } else if(data){
                        swal({
                            title: "Oops!",
                            text: data.mes,
                            imageUrl: admin_nbds.assets_images + "dinosaur.png"
                        });
                        $('#nbdesigner_color_newcat').html('');
                    }
                    $('#nbdesigner_add_color_cat').show();
                });
            };
            NBDESIGNADMIN.delete_cat_color = function (e) {
                var index = $(e).parent().find('input').val();
                var cat_id = $('#nbdesigner_current_color_cat_id').val();
                swal({
                    title: admin_nbds.nbds_lang.are_you_sure,
                    text: admin_nbds.nbds_lang.warning_mes_delete_category,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function(){
                    var data = {'action': 'nbdesigner_delete_color_group', 'id': index, 'nonce': admin_nbds.nonce};
                    $.ajax({
                        url: admin_nbds.url,
                        method: "POST",
                        data: data,
                        beforeSend: function () {
                            $('#nbdesigner_img_loading').removeClass('nbdesigner_loaded');
                        },
                        complete: function () {
                            $('#nbdesigner_img_loading').addClass('nbdesigner_loaded');
                        }
                    }).done(function (data) {
                        if (data.flag == 1) {
                            swal(admin_nbds.nbds_lang.complete, data.mes, "success");
                            $('#nbdesigner_list_color_cats').find('#nbdesigner_cat_color_' + index).remove();
                            $.each($('#nbdesigner_list_color_cats li label input'), function (key, val) {
                                $(this).val(key);
                            });
                            $('#nbdesigner_current_color_cat_id').val(parseInt(cat_id) - 1);
                            $.each($('.nbdesigner_action_delete_color_cat'), function (key, val) {
                                $(this).attr('id', 'nbdesigner_cat_color_' + key);
                            });
                        }else{
                            swal({
                                title: "Oops!",
                                text: data.mes,
                                imageUrl: admin_nbds.assets_images + "dinosaur.png"
                            });
                        }
                    });
                });
            };
            NBDESIGNADMIN.edit_cat_color = function (e) {
                $(e).parents('#nbdesigner_list_color_cats').find('.nbdesigner-editcat-name').hide();
                $(e).parents('#nbdesigner_list_color_cats').find('.nbdesigner-cat-link').show();
                $(e).parent().find('.nbdesigner-cat-link').hide();
                $(e).parent().find('.nbdesigner-editcat-name').show();
                $(e).parents('#nbdesigner_list_color_cats').find('li').removeClass('active');
                $(e).parent().addClass('active');
            };
            NBDESIGNADMIN.save_cat_color = function (e) {
                var index = $(e).parent().find('input').val(),
                    name = $(e).parent().find('input.nbdesigner-editcat-name').val(),
                    sefl = $(e);
                var data = {'action': 'nbdesigner_add_color_group', 'id': index, 'name': name, 'nonce': admin_nbds.nonce};
                $.ajax({
                    url: admin_nbds.url,
                    method: "POST",
                    data: data,
                    beforeSend: function () {
                        $('.nbdesigner_editcat_loading').removeClass('nbdesigner_loaded');
                    },
                    complete: function () {
                        $('.nbdesigner_editcat_loading').addClass('nbdesigner_loaded');
                    }
                }).done(function (data) {
                    if (data.flag == 1) {
                        swal(admin_nbds.nbds_lang.complete, data.mes, "success");
                        sefl.parent().find('.nbdesigner-cat-link').html(name).show();
                        sefl.parent().find('input.nbdesigner-editcat-name').val(name);
                        sefl.parent().find('.nbdesigner-editcat-name').val(name).hide();
                    }else{
                        swal({
                            title: "Oops!",
                            text: data.mes,
                            imageUrl: admin_nbds.assets_images + "dinosaur.png"
                        });
                        sefl.parent().find('.nbdesigner-cat-link').show();
                        sefl.parent().find('.nbdesigner-editcat-name').val(name).hide();
                    }
                });
                $(e).parents('#nbdesigner_list_color_cats').find('li').removeClass('active');
            };
            NBDESIGNADMIN.remove_action_cat_color = function (e) {
                $(e).parents('#nbdesigner_list_color_cats').find('.nbdesigner-cat-link').show();
                $(e).parents('#nbdesigner_list_color_cats').find('.nbdesigner-editcat-name').hide();
                $(e).parents('#nbdesigner_list_color_cats').find('li').removeClass('active');
                return;
            };
            NBDESIGNADMIN.cancel_add_color_cat = function () {
                $('#nbdesigner_color_newcat').html('');
                $('#nbdesigner_add_color_cat').show();
            };
            NBDESIGNADMIN.delete_color = function (e) {
                var index = $(e).data('index');
                swal({
                    title: admin_nbds.nbds_lang.are_you_sure,
                    text: admin_nbds.nbds_lang.warning_mes_delete_file,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function(){
                    var data = {'action': 'nbdesigner_delete_color', 'id': index, 'nonce': admin_nbds.nonce};
                    $.ajax({
                        url: admin_nbds.url,
                        method: "POST",
                        data: data
                    }).done(function (data) {
                        if (data.flag == 1) {
                            swal(admin_nbds.nbds_lang.complete, data.mes, "success");
                            $(e).closest('.nbdesigner_color_wrap').remove();
                            $.each($('.nbdesigner_action_delete_color'), function (key, val) {
                                var _index = parseInt( $(this).attr('data-index') );
                                if( _index > index ){
                                    $(this).attr('data-index', _index - 1);
                                }
                            });
                        }else{
                            swal({
                                title: "Oops!",
                                text: data.mes,
                                imageUrl: admin_nbds.assets_images + "dinosaur.png"
                            });
                        }
                    });
                });
            };
            $('#nbdesigner_add_color_cat').on('click', function () {
                var html = '<input class="form-required nbdesigner_color_name" type="text" id="nbdesigner_name_color_newcat"><br /><br />';
                html += '<input type="button" id="nbdesigner_save_color_cat" onclick="NBDESIGNADMIN.add_color_cat(this)" value="Add new" class="button-primary">';
                html += '<input type="button" id="nbdesigner_cancel_add_color_cat" style="margin-left: 15px" onclick="NBDESIGNADMIN.cancel_add_color_cat()" value="Cancel" class="button-primary">';
                html += '<img src="' + admin_nbds.url_gif + '" class="nbdesigner_loaded" id="nbdesigner_img_loading" style="margin-left: 15px;"/>';
                $('#nbdesigner_color_newcat').append(html);
                var scroll = $('#nbdesigner_list_color_cats').parent('.inside');
                scroll.animate({ scrollTop: scroll.prop("scrollHeight") }, 'slow');
                $('#nbdesigner_add_color_cat').hide();
            });
            // validation
            $('input[name="Submit"]').on('click', function () {
                var name = $('input[name="nbdesigner_color_name"]').val(),
                    hex = $('input[name="nbdesigner_color_hex"]').val();
                if (name == '' || hex == '') {
                    swal({
                        title: 'Invalid name color or Hexadecimal Color !',
                        type: 'warning',
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    });
                    return false;
                }
            });
        });
    })(jQuery);
</script>