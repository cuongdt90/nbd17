<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<?php 
$limit = $row * $per_row;
$k = 0;
if($des != '') echo "<p>".$des."</p>";
if(count($templates)):
    echo '<ul class="nbdesigner-gallery">';
    foreach ($templates as $temp): 
    $link_template = add_query_arg(array(
        'product_id' => $temp['product_id'],
        'variation_id' => $temp['variation_id'],
        'reference'  =>  $temp['folder']
    ), getUrlPageNBD('create'));         
?>
    <?php if($k % $per_row == 0) echo '<li class="nbdesigner-container">';?>
    <?php if( 0 ): ?>
    <div class="nbdesigner-item nbd-col-<?php echo $per_row; ?>">
        <div class="nbdesigner-con">
            <div class="nbdesigner-top">
                <img src="<?php echo $temp['image']; ?>" class="nbdesigner-img"/>
            </div>
            <div class="nbdesigner-hover">
                <div class="nbdesigner-inner">
                    <a href="<?php echo $link_template; ?>" class="nbdesigner-link" >View design<span>→</span></a>
                </div>
            </div>            
        </div>
    </div>
    <?php elseif( 1 ): ?>
    <div class="nbdesigner-item nbd-col-<?php echo $per_row; ?>">
        <div class="nbd-gallery-item">
            <div class="nbd-gallery-item-inner">
                <a href="<?php echo $link_template; ?>" >
                    <img src="<?php echo $temp['image']; ?>" class="nbdesigner-img"/>
                </a>
            </div>
            <div class="nbd-gallery-item-acction">
                <span class="nbd-gallery-item-name"><?php echo $temp['title']; ?></span>
                <div class="nbd-like-icons">
                    <span class="nbd-like-icon like <?php if(in_array($temp['tid'], $favourite_templates)) echo 'active'; ?>" onclick="updateFavouriteTemplate(this, 'unlike', <?php echo $temp['tid']; ?>)">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <title>like</title>
                            <path fill="#db133b" d="M17.19 4.155c-1.672-1.534-4.383-1.534-6.055 0l-1.135 1.042-1.136-1.042c-1.672-1.534-4.382-1.534-6.054 0-1.881 1.727-1.881 4.52 0 6.246l7.19 6.599 7.19-6.599c1.88-1.726 1.88-4.52 0-6.246z"></path>
                        </svg>                        
                    </span>
                    <span class="nbd-like-icon unlike <?php if(!in_array($temp['tid'], $favourite_templates)) echo 'active'; ?>" onclick="updateFavouriteTemplate(this, 'like', <?php echo $temp['tid']; ?>)">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <title>heart-outlined</title>
                            <path fill="#db133b" d="M17.19 4.156c-1.672-1.535-4.383-1.535-6.055 0l-1.135 1.041-1.136-1.041c-1.672-1.535-4.382-1.535-6.054 0-1.881 1.726-1.881 4.519 0 6.245l7.19 6.599 7.19-6.599c1.88-1.726 1.88-4.52 0-6.245zM16.124 9.375l-6.124 5.715-6.125-5.715c-0.617-0.567-0.856-1.307-0.856-2.094s0.138-1.433 0.756-1.999c0.545-0.501 1.278-0.777 2.063-0.777s1.517 0.476 2.062 0.978l2.1 1.825 2.099-1.826c0.546-0.502 1.278-0.978 2.063-0.978s1.518 0.276 2.063 0.777c0.618 0.566 0.755 1.212 0.755 1.999s-0.238 1.528-0.856 2.095z"></path>
                        </svg>                       
                    </span>
                    <span class="nbd-like-icon loading">
                        <img src="<?php echo NBDESIGNER_PLUGIN_URL.'assets/images/loading.gif' ?>" />
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if($k % $per_row == ($per_row -1)) echo '</li>';?>
    <?php 
    $k ++;
    endforeach;
    echo '</ul>'; ?>
<?php else: ?>    
    <?php _e('No template', 'web-to-print-online-designer'); ?>
<?php endif; ?>
<?php if(($total > $limit) && $pagination): ?>
<?php  
    require_once NBDESIGNER_PLUGIN_DIR . 'includes/class.nbdesigner.pagination.php';
    $paging = new Nbdesigner_Pagination();
    $config = array(
        'current_page'  => isset($page) ? $page : 1, 
        'total_record'  => $total,
        'limit'         => $limit,
        'link_full'     => add_query_arg(array('paged' => '{p}'), $url),
        'link_first'    => $url              
    );	
    $paging->init($config); 
?>
    <div class="tablenav top nbdesigner-pagination-con">
        <div class="tablenav-pages">
            <span class="displaying-num"><?php printf( _n( '%s Template', '%s Templates', $total, 'web-to-print-online-designer'), number_format_i18n( $total ) ); ?>
            <?php echo $paging->html();  ?>
        </div>
    </div>  
<?php endif; ?>
<style>
    .nbd-gallery-item {
        -webkit-box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        -moz-box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        -ms-box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        box-shadow: 0 1px 4px 0 rgba(0,0,0,0.14);
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -ms-transition: all 0.4s;
        transition: all 0.4s;
    }
    .nbd-gallery-item:hover {
        -webkit-box-shadow: 0 3px 10px 0 rgba(75,79,84,.3);
        -moz-box-shadow: 0 3px 10px 0 rgba(75,79,84,.3);
        -ms-box-shadow: 0 3px 10px 0 rgba(75,79,84,.3);
        box-shadow: 0 3px 10px 0 rgba(75,79,84,.3);
    }
    .nbd-gallery-item-inner {
/*        background: #ddd;*/
        overflow: hidden;
    }
    .nbd-gallery-item-inner img {
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -ms-transition: all 0.4s;
        transition: all 0.4s;        
    }
    .nbd-gallery-item-inner:hover img {
        transform: scale(1.1);
    }
    .nbd-gallery-item-acction {
        padding: 10px;
        height: 50px;
        border-top: 1px solid #ddd; 
    }
    .nbd-like-icons {
        width: 30px; 
        height: 30px;
        position: relative;
        display: inline-block;
        float: right;
    }
    .nbd-like-icon {
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        line-height: 30px;
        text-align: center;
        width: 30px; 
        height: 30px;
        display: none; 
        align-items: center;
        justify-content: center;  
        opacity: 0.5;
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        -ms-transition: all 0.4s;
        transition: all 0.4s;        
    }
    .nbd-like-icon:hover {
        -webkit-nimation: heartbeat 1.2s infinite;
        -moz-animation: heartbeat 1.2s infinite;
        animation: heartbeat 1.2s infinite;
        opacity: 1;
    }
    .nbd-gallery-item-name {
        vertical-align: top;
        line-height: 30px;
        width: calc(100% - 50px);
        display: inline-block;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
    .nbd-like-icon.loading {
        display: none;
    }
    .nbd-like-icon.active {
        display: flex;
    }  
    .nbdesigner-gallery {
        margin-bottom: 30px;
    }
    @keyframes heartbeat{
        0% {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        }
        20% {
            -webkit-transform: scale( 1 );
            -moz-transform: scale( 1 );
            transform: scale( 1 );
        }
        40% {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        } 
        60% {
            -webkit-transform: scale( 1 );
            -moz-transform: scale( 1 );
            transform: scale( 1 );
        } 
        80% {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        }
        100%  {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        }
    } 
    @-webkit-keyframes heartbeat{
        0% {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        }
        20% {
            -webkit-transform: scale( 1 );
            -moz-transform: scale( 1 );
            transform: scale( 1 );
        }
        40% {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        } 
        60% {
            -webkit-transform: scale( 1 );
            -moz-transform: scale( 1 );
            transform: scale( 1 );
        } 
        80% {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        }
        100%  {
            -webkit-transform: scale( .75 );
            -moz-transform: scale( .75 );
            transform: scale( .75 );
        }
    }   
    .pagination-links {
        float: right;
    }
    .pagination-links a:last-child {
        margin-right: 0;
    }
</style>   
<script>
    var nonce = "<?php echo wp_create_nonce('nbd_update_favourite_template') ?>"; 
    var updateFavouriteTemplate = function(e, type, template_id){
        var self = jQuery(e),
        parent = self.parent('.nbd-like-icons'),
        tempaltes = localStorage.getItem("nbd_favourite_templates");
        if( tempaltes.indexOf(template_id) > -1 && type == 'like') {
            alert('Template has been added into favourite list!');  
            parent.find('.nbd-like-icon').removeClass('active');
            parent.find('.nbd-like-icon.like').addClass('active'); 
            return;
        }
        var _data = {
            action: 'nbd_update_favorite_template',
            template_id: template_id,
            type: type,
            nonce: nonce
        };
        parent.find('.nbd-like-icon').removeClass('active');
        parent.find('.nbd-like-icon.loading').addClass('active');        
        jQuery.post(woocommerce_params.ajax_url , _data, function(data){
            localStorage.setItem("nbd_favourite_templates", JSON.stringify(data.templates));
            parent.find('.nbd-like-icon.loading').removeClass('active');
            parent.find('.nbd-like-icon.'+type).addClass('active');    
        });
    };
    jQuery( document ).ready(function(){
        var templates = '<?php echo json_encode($favourite_templates); ?>';
        localStorage.setItem("nbd_favourite_templates", templates);
    });
</script>