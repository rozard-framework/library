<?php

/*** POST MODULE */

if ( ! class_exists( 'format' ) ) {

    class format extends cores{


        protected $formats;


        public function create( $formats = array() ) {

            $this->formats = $formats ;
            add_action('init', [$this, 'register' ], 99, 1);
          
        }

        public function register() {
           
            $format = $this->formats ;

            // slugs
            $slugs  = $this->str_keys( $format['cores']['name']);

            
            // base data
            $single = $format['cores']['name'];
            $plural = $this->str_plural( $single );
            
            // prefix
            $single_prefix = $this->str_keys( $slugs );
            $plural_prefix = $this->str_keys( $plural ) ;


            $labels = array(
                'name'                  => _x( $plural, 'rozard' ),
                'singular_name'         => _x( $single, 'rozard' ),
                'menu_name'             => _x( $single, 'rozard' ),
                'name_admin_bar'        => _x( $single, 'rozard' ),
                'add_new'               => __( 'Add New', 'rozard' ),
                'add_new_item'          => __( 'Add New'. $single, 'rozard' ),
                'new_item'              => __( 'New ' .$single, 'rozard' ),
                'edit_item'             => __( 'Edit '. $single, 'rozard' ),
                'view_item'             => __( 'View'. $single, 'rozard' ),
                'all_items'             => __(  $single, 'rozard' ),
                'search_items'          => __( 'Search '. $plural, 'rozard' ),
                'parent_item_colon'     => __( 'Parent '. $plural.':', 'rozard' ),
                'not_found'             => __( 'No '. $plural.' found.', 'rozard' ),
                'not_found_in_trash'    => __( 'No '. $plural.' found in Trash.', 'rozard' ),
                'featured_image'        => _x(  $single. ' Cover Image', 'rozard' ),
                'set_featured_image'    => _x( 'Set cover image', 'rozard' ),
                'remove_featured_image' => _x( 'Remove cover image', 'rozard' ),
                'use_featured_image'    => _x( 'Use as cover image', 'rozard' ),
                'archives'              => _x( $single. ' archives', 'rozard' ),
                'insert_into_item'      => _x( 'Insert into '. $single, 'rozard' ),
                'uploaded_to_this_item' => _x( 'Uploaded to this '.$single, 'rozard' ),
                'filter_items_list'     => _x( 'Filter '. $single .' list', 'rozard' ),
                'items_list_navigation' => _x( $plural. ' list navigation', 'rozard' ),
                'items_list'            => _x( $plural. ' list', 'rozard' ),
            );
        
            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => $format['cores']['model'],
                'show_in_admin_bar'  => $format['cores']['admin_bar'],
                'query_var'          => true,
                'rewrite'            => array( 'slug' => $slugs ),
                'show_in_rest'       => $format['cores']['rest_api'] ?? false,
                'has_archive'        => true,
                'hierarchical'       => $format['cores']['hierarchy'],
                'menu_position'      => $format['cores']['position'], 
                'menu_icon'			 => $format['cores']['icons'] ?: 'dashicons-welcome-add-page',
                'supports'           => $format['cores']['supports'] ?? array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'  ),
                'taxonomies'         => $format['cores']['taxonomy'],
                // 'capability_type'    => 'read',
                // 'map_meta_cap'       => true,
            );

        
            // register new for new custom post type
            register_post_type( $slugs , $args );

        }
    }

    new format;
}





// wp upload based on file type and user
// https://wordpress.stackexchange.com/questions/175782/how-to-set-custom-upload-directory-per-user-after-moving-content-directory
// https://gist.github.com/blainerobison/e802658da007e6e806b1


if ( ! class_exists( 'mozard_upload' ) )
{
    class mozard_upload{

    }
}


function karim_custom_upload( $upload ) {

    $file_type = array();

    // Get file type
    if( ! empty( $_POST['name'] ) ) :

        $custom_directory = '';
        $file_type = wp_check_filetype( $_POST['name'] );
        $file_ext  = ( $file_type['ext'] ) ? $file_type['ext'] : '';

        // set directory based on file type
        if( in_array( strtolower( $file_ext ), array( 'jpg', 'jpeg', 'png', 'gif', 'webp' ) ) ) :

            // Images
            $custom_directory = '/image';

        elseif( in_array( strtolower( $file_ext ), array( 'mp3', 'ogg', 'wav') ) ) :

            // Audio
            // remove music cover art on upload progress
            add_filter('upload_mimes', 'remove_audio_cover_art_upload', 1, 1);
            $custom_directory = '/audio';

        elseif( in_array( strtolower( $file_ext ), array( 'pdf', 'doc', 'docx') ) ) :

            // Document
            $custom_directory = '/document';

        else:

            // Misc
            $custom_directory = '/misc';

        endif;

        // update directory
        if( $custom_directory ) :

            global $current_user;

            // remove default subdir (year/month)
            $upload['path']    = str_replace( $upload['subdir'], '', $upload['path'] );
            $upload['url']     = str_replace( $upload['subdir'], '', $upload['url'] );

            // update paths
            $upload['subdir']  = '/' . $current_user->display_name . $custom_directory .'/'. date("Y") .'/'.date('F');
            $upload['path']   .= '/' . $current_user->display_name . $custom_directory .'/'. date("Y") .'/'.date('F');
            $upload['url']    .= '/' . $current_user->display_name . $custom_directory .'/'. date("Y") .'/'.date('F');

        endif;

    endif;

    return $upload;

}


/**
 * Add custom directory filter
 * 'karim_custom_upload'
 */
function karim_pre_upload( $file ) 
{
    add_filter( 'upload_dir', 'karim_custom_upload' );
    return $file;
}
// add_filter( 'wp_handle_upload_prefilter', 'karim_pre_upload', 0 );

/**
 * Remove custom directory filter
 * 'karim_custom_upload'
 */
function karim_post_upload( $fileinfo ) 
{
    remove_filter( 'upload_dir', 'karim_custom_upload' );
    return $fileinfo;
}
// add_filter( 'wp_handle_upload', 'karim_post_upload', 0 );
