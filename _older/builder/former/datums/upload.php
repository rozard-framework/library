<?php




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
