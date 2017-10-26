<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header(); ?>
<?php 
    do_action( 'nbd_before_designer_page_content' ); 
    $user_id = intval( $_GET['id'] );
    $user_infos = nbd_get_artist_info($user_id);
    $banner_url = wp_get_attachment_url( $user_infos['nbd_artist_banner'] );
    $current_user_id = get_current_user_id();
?>
<div class="nbd-user-infos">
    <div class="nbd-user-banner">
        <?php if($user_infos['nbd_artist_banner'] != ''): ?>
        <img style="border-radius: 0;" src="<?php echo $banner_url; ?>" alt="<?php echo $user_infos['nbd_artist_name']; ?>" />
        <?php endif; ?>
        <?php if( $current_user_id == $user_id ): ?>
        <a class="nbd-edit-profile" href="<?php echo wc_get_endpoint_url( 'artist-info', $user_id, wc_get_page_permalink( 'myaccount' ) ); ?>" title="<?php _e('Edit profile', 'web-to-print-online-designer'); ?>">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                <title>edit</title>
                <path d="M1.5 32h29c0.827 0 1.5-0.673 1.5-1.5v-29c0-0.827-0.673-1.5-1.5-1.5h-29c-0.827 0-1.5 0.673-1.5 1.5v29c0 0.827 0.673 1.5 1.5 1.5zM1 1.5c0-0.276 0.225-0.5 0.5-0.5h29c0.275 0 0.5 0.224 0.5 0.5v29c0 0.276-0.225 0.5-0.5 0.5h-29c-0.275 0-0.5-0.224-0.5-0.5v-29zM4 28.479c0.048 0 0.096-0.007 0.143-0.021l10-2.979c0.081-0.024 0.154-0.068 0.213-0.127l10.090-10.205c0.023-0.024 0.035-0.053 0.052-0.080l3.658-3.658c0.607-0.607 0.607-1.595 0-2.203l-5.236-5.234c-0.607-0.607-1.595-0.608-2.202 0l-3.739 3.739c-0.024 0.024-0.036 0.054-0.054 0.081l-10.118 10.119c-0.056 0.056-0.098 0.124-0.122 0.199l-3.16 9.715c-0.058 0.177-0.012 0.371 0.117 0.504 0.095 0.097 0.225 0.15 0.358 0.15zM17.359 8.771l1.040 1.040-8.523 8.563-1.727-0.392 9.21-9.211zM10.5 19.165l8.607-8.646 2.434 2.434-8.745 8.547h-2.296v-2.335zM23.385 14.797l-9.246 9.352-0.576-1.999 8.684-8.489 1.138 1.136zM7.493 18.859l2.007 0.456v2.685c0 0.276 0.224 0.5 0.5 0.5h2.624l0.633 2.2-8.487 2.528 2.723-8.369zM21.425 4.679c0.218-0.217 0.572-0.216 0.788 0l5.235 5.235c0.218 0.217 0.218 0.571 0 0.789l-3.372 3.372-6.023-6.023 3.372-3.373z"></path>
            </svg>            
        </a>
        <?php endif; ?>
    </div>   
    <div class="nbd-user-info">
        <img class="nbd-avatar" src="<?php echo get_avatar_url($user_id); ?>" />
        <div class="nbd-designer-info">
            <h1 class="nbd-artist-name"><?php echo $user_infos['nbd_artist_name']; ?></h1>
            <?php if( $user_infos['nbd_artist_address'] != '' ): ?>
            <p class="nbd-artist-add">
                <span>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <title>location</title>
                        <path fill="#0c8ea7" d="M7.969 16c0 0-4.969-7.031-4.969-10.031 0-5.907 4.969-5.969 4.969-5.969s5.031 0.063 5.031 5.938c0 3.093-5.031 10.063-5.031 10.063zM8 3c-1.104 0-2 0.896-2 2s0.896 2 2 2 2-0.896 2-2-0.896-2-2-2z"></path>
                    </svg>
                </span><?php echo $user_infos['nbd_artist_address']; ?>
            </p><br />
            <?php endif; ?>
            <?php if( $user_infos['nbd_artist_phone'] != '' ): ?>
            <p class="nbd-artist-phone">
                <span>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <title>mobile</title>
                        <path fill="#0c8ea7" d="M11 0h-6c-1.104 0-2 0.895-2 2v12c0 1.104 0.896 2 2 2h6c1.104 0 2-0.896 2-2v-12c0-1.105-0.896-2-2-2zM8.25 1.5h1.5c0.137 0 0.25 0.112 0.25 0.25s-0.113 0.25-0.25 0.25h-1.5c-0.138 0-0.25-0.112-0.25-0.25s0.112-0.25 0.25-0.25zM6.5 1c0.276 0 0.5 0.224 0.5 0.5s-0.224 0.5-0.5 0.5-0.5-0.224-0.5-0.5 0.224-0.5 0.5-0.5zM9 14.5c0 0.277-0.223 0.5-0.5 0.5h-1c-0.276 0-0.5-0.223-0.5-0.5v-1c0-0.277 0.224-0.5 0.5-0.5h1c0.277 0 0.5 0.223 0.5 0.5v1zM12 11.5c0 0.277-0.223 0.5-0.5 0.5h-7c-0.276 0-0.5-0.223-0.5-0.5v-8c0-0.276 0.224-0.5 0.5-0.5h7c0.277 0 0.5 0.224 0.5 0.5v8z"></path>
                    </svg>                     
                </span><?php echo $user_infos['nbd_artist_phone']; ?>
            </p>
            <?php endif; ?>
            <p class="nbd-social-list">
                <?php  if( $user_infos['nbd_artist_facebook'] != '' ): ?>
                <a class="nbd-social" href="<?php echo $user_infos['nbd_artist_facebook']; ?>" title="<?php _e('Facebook', 'web-to-print-online-designer'); ?>">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>facebook</title>
                        <path fill="#3b5998" d="M22.675 0h-21.351c-0.732 0-1.325 0.593-1.325 1.325v21.351c0 0.732 0.593 1.325 1.325 1.325h11.495v-9.294h-3.129v-3.621h3.129v-2.674c0-3.099 1.893-4.785 4.659-4.785 1.325 0 2.463 0.096 2.794 0.141v3.24h-1.92c-1.5 0-1.793 0.72-1.793 1.77v2.31h3.585l-0.465 3.63h-3.12v9.284h6.115c0.732 0 1.325-0.593 1.325-1.325v-21.351c0-0.732-0.593-1.325-1.325-1.325z"></path>
                    </svg>
                </a>    
                <?php  endif; ?>
                <?php  if( $user_infos['nbd_artist_google'] != '' ): ?>
                <a class="nbd-social" href="<?php echo $user_infos['nbd_artist_google']; ?>" title="<?php _e('Google', 'web-to-print-online-designer'); ?>">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>google</title>
                        <path fill="#dc4e41" d="M7.635 10.909v2.618h4.335c-0.174 1.125-1.309 3.295-4.331 3.295-2.606 0-4.732-2.16-4.732-4.822s2.123-4.822 4.728-4.822c1.485 0 2.478 0.633 3.045 1.179l2.073-1.995c-1.331-1.245-3.056-1.995-5.115-1.995-4.226-0.002-7.638 3.418-7.638 7.634s3.414 7.635 7.635 7.635c4.41 0 7.332-3.097 7.332-7.461 0-0.501-0.054-0.885-0.12-1.264h-7.212zM24 10.909h-2.183v-2.182h-2.183v2.182h-2.181v2.181h2.182v2.182h2.19v-2.182h2.174z"></path>
                    </svg>
                </a>    
                <?php  endif; ?>       
                <?php  if( $user_infos['nbd_artist_twitter'] != '' ): ?>
                <a class="nbd-social" href="<?php echo $user_infos['nbd_artist_twitter']; ?>" title="<?php _e('Twitter', 'web-to-print-online-designer'); ?>">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>twitter</title>
                        <path fill="#1da1f2" d="M24 4.557c-0.885 0.39-1.83 0.655-2.828 0.776 1.015-0.611 1.797-1.575 2.165-2.724-0.951 0.555-2.006 0.96-3.128 1.185-0.897-0.96-2.175-1.56-3.594-1.56-2.718 0-4.923 2.205-4.923 4.92 0 0.39 0.045 0.765 0.127 1.125-4.092-0.195-7.72-2.16-10.149-5.13-0.426 0.721-0.666 1.561-0.666 2.476 0 1.71 0.87 3.214 2.19 4.098-0.807-0.026-1.567-0.248-2.231-0.615v0.060c0 2.385 1.695 4.377 3.95 4.83-0.414 0.111-0.849 0.171-1.298 0.171-0.315 0-0.615-0.030-0.915-0.087 0.63 1.956 2.445 3.379 4.605 3.42-1.68 1.32-3.81 2.106-6.105 2.106-0.39 0-0.78-0.023-1.17-0.067 2.19 1.395 4.77 2.211 7.56 2.211 9.060 0 14.010-7.5 14.010-13.995 0-0.21 0-0.42-0.015-0.63 0.96-0.69 1.8-1.56 2.46-2.55z"></path>
                    </svg>
                </a>    
                <?php  endif; ?>
                <?php  if( $user_infos['nbd_artist_linkedin'] != '' ): ?>
                <a class="nbd-social" href="<?php echo $user_infos['nbd_artist_linkedin']; ?>" title="<?php _e('Google', 'web-to-print-online-designer'); ?>">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>linkedin</title>
                        <path fill="#0077b5" d="M20.448 20.453h-3.555v-5.569c0-1.329-0.027-3.037-1.851-3.037-1.852 0-2.136 1.446-2.136 2.94v5.667h-3.555v-11.453h3.414v1.56h0.045c0.477-0.9 1.638-1.85 3.37-1.85 3.6 0 4.267 2.37 4.267 5.456v6.282zM5.337 7.433c-1.143 0-2.064-0.926-2.064-2.065 0-1.137 0.921-2.063 2.064-2.063 1.14 0 2.064 0.925 2.064 2.063 0 1.14-0.926 2.065-2.064 2.065zM7.119 20.453h-3.564v-11.453h3.564v11.453zM22.224 0h-20.454c-0.978 0-1.77 0.774-1.77 1.73v20.541c0 0.956 0.792 1.729 1.77 1.729h20.453c0.978 0 1.777-0.774 1.777-1.73v-20.541c0-0.956-0.799-1.73-1.777-1.73z"></path>
                    </svg>
                </a>    
                <?php  endif; ?>  
                <?php  if( $user_infos['nbd_artist_youtube'] != '' ): ?>
                <a class="nbd-social" href="<?php echo $user_infos['nbd_artist_youtube']; ?>" title="<?php _e('Youtube', 'web-to-print-online-designer'); ?>">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>youtube</title>
                        <path fill="#cd201f" d="M0 11.018v1.89c0 1.943 0.24 3.885 0.24 3.885s0.234 1.65 0.954 2.381c0.912 0.956 2.112 0.925 2.646 1.026 1.92 0.184 8.16 0.24 8.16 0.24s5.043-0.006 8.4-0.249c0.471-0.057 1.494-0.060 2.406-1.017 0.72-0.729 0.954-2.382 0.954-2.382s0.24-1.941 0.24-3.885v-1.887c0-1.944-0.24-3.885-0.24-3.885s-0.234-1.653-0.954-2.382c-0.912-0.957-1.935-0.96-2.406-1.017-3.357-0.243-8.4-0.249-8.4-0.249s-6.24 0.054-8.16 0.24c-0.534 0.101-1.734 0.071-2.646 1.026-0.72 0.731-0.954 2.381-0.954 2.381s-0.24 1.944-0.24 3.885zM9.522 15.112v-6.742l6.484 3.382-6.48 3.36z"></path>
                    </svg>
                </a>    
                <?php  endif; ?>
                <?php  if( $user_infos['nbd_artist_instagram'] != '' ): ?>
                <a class="nbd-social" href="<?php echo $user_infos['nbd_artist_instagram']; ?>" title="<?php _e('Instagram', 'web-to-print-online-designer'); ?>">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>instagram</title>
                        <path fill="#e4405f" d="M12 0c-3.259 0-3.668 0.015-4.947 0.072-1.278 0.060-2.148 0.261-2.913 0.558-0.789 0.306-1.459 0.717-2.126 1.385-0.667 0.666-1.080 1.335-1.385 2.125-0.297 0.765-0.5 1.635-0.558 2.913-0.060 1.279-0.072 1.688-0.072 4.947s0.015 3.668 0.072 4.947c0.060 1.278 0.261 2.149 0.558 2.913 0.306 0.789 0.717 1.46 1.385 2.126 0.666 0.667 1.335 1.080 2.126 1.384 0.765 0.297 1.635 0.5 2.913 0.558 1.279 0.060 1.688 0.072 4.947 0.072s3.668-0.015 4.947-0.072c1.278-0.060 2.149-0.261 2.913-0.558 0.789-0.306 1.46-0.717 2.126-1.384 0.667-0.666 1.080-1.335 1.384-2.126 0.297-0.765 0.5-1.635 0.558-2.913 0.060-1.279 0.072-1.688 0.072-4.947s-0.015-3.668-0.072-4.947c-0.060-1.278-0.261-2.149-0.558-2.913-0.306-0.789-0.717-1.459-1.384-2.126-0.666-0.667-1.335-1.080-2.126-1.385-0.765-0.297-1.635-0.5-2.913-0.558-1.279-0.060-1.688-0.072-4.947-0.072zM12 2.16c3.204 0 3.585 0.015 4.849 0.072 1.17 0.054 1.805 0.249 2.227 0.414 0.561 0.218 0.96 0.477 1.38 0.897s0.679 0.819 0.897 1.38c0.165 0.423 0.36 1.058 0.414 2.228 0.057 1.266 0.071 1.646 0.071 4.849s-0.015 3.585-0.075 4.849c-0.060 1.17-0.255 1.805-0.42 2.227-0.225 0.561-0.48 0.96-0.9 1.38s-0.825 0.679-1.38 0.897c-0.42 0.165-1.065 0.36-2.235 0.414-1.275 0.057-1.65 0.071-4.86 0.071s-3.585-0.015-4.86-0.075c-1.17-0.060-1.815-0.255-2.235-0.42-0.57-0.225-0.96-0.48-1.38-0.9s-0.69-0.825-0.9-1.38c-0.165-0.42-0.36-1.065-0.42-2.235-0.045-1.26-0.060-1.65-0.060-4.845s0.015-3.585 0.060-4.86c0.060-1.17 0.255-1.815 0.42-2.235 0.21-0.57 0.48-0.96 0.9-1.38s0.81-0.69 1.38-0.9c0.42-0.165 1.050-0.36 2.22-0.42 1.275-0.045 1.65-0.060 4.86-0.060zM12 5.838c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.791-4-4s1.791-4 4-4c2.21 0 4 1.791 4 4s-1.791 4-4 4zM19.845 5.595c0 0.795-0.645 1.44-1.44 1.44s-1.44-0.645-1.44-1.44 0.645-1.44 1.44-1.44 1.44 0.645 1.44 1.44z"></path>
                    </svg>
                </a>    
                <?php  endif; ?>         
                <?php  if( $user_infos['nbd_artist_flickr'] != '' ): ?>
                <a class="nbd-social" href="<?php echo $user_infos['nbd_artist_flickr']; ?>" title="<?php _e('Flickr', 'web-to-print-online-designer'); ?>">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>flickr</title>
                        <path fill="#0063dc" d="M0 12c0 3.075 2.493 5.565 5.565 5.565 3.075 0 5.569-2.49 5.569-5.565s-2.494-5.565-5.569-5.565c-3.071 0-5.565 2.49-5.565 5.565zM12.866 12c0 3.075 2.493 5.565 5.568 5.565 3.062 0 5.567-2.49 5.567-5.565s-2.493-5.565-5.565-5.565c-3.075 0-5.57 2.49-5.57 5.565z"></path>
                    </svg>
                </a>    
                <?php  endif; ?>                   
            </p>
        </div>
    </div>
    <div class="nbd-description">
        <p class="nbd-about-title"><?php _e('About the designer', 'web-to-print-online-designer'); ?></p>
        <p><?php echo $user_infos['nbd_artist_description']; ?></p>
    </div>
</div>
<div class="nbd-list-designs">
    <?php 
        $row = apply_filters('nbd_artist_designs_row', 5);
        $per_row = intval( apply_filters('nbd_artist_designs_per_row', 4) );
        $des = '';
        $pagination = true;
        $url = add_query_arg(array('id' => $user_id), getUrlPageNBD('designer'));
        $page = (get_query_var('paged')) ? get_query_var('paged') : 1; 
        $templates = My_Design_Endpoint::nbdesigner_get_templates_by_page($page, $row, $per_row, false, false, $user_id);
        $favourite_templates = My_Design_Endpoint::get_favourite_templates();
        $total = My_Design_Endpoint::count_total_template( false, $user_id );
        include_once('gallery.php');
    ?>
</div>
<?php 
    do_action( 'nbd_after_designer_page_content' ); 
    get_footer();