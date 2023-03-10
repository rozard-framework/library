<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! trait_exists( 'rozard_datum_writes' ) ) {


    trait rozard_datum_writes{


        function add_data( $crypto, $path, $data = array() ) {
            $json_data = json_encode($data, JSON_PRETTY_PRINT);
            $json_data = encrypt_string( $json_data, $crypto );
            $documents = fopen($path, 'w');
            fwrite($documents, $json_data);
            fclose($documents);
        }

        function get_cryp( $file, $user_id ) {
            $blog = get_site( get_current_blog_id() );
            $site = sanitize_html_class( $blog->path );
            $user = get_user_by( 'ID', $user_id );
            $path = ABSPATH . 'wp-admin/organel/' . $site . '/private' .'/'. $user->data->user_login .'/'. $file ;

            if ( file_exists( $path ) ) {
                $file = file_get_contents( $path, true);
                return $file;
            } else {
                return null;
            }
        }

        function get_data( $file, $user_id ) {
            $blog = get_site( get_current_blog_id() );
            $site = sanitize_html_class( $blog->path );
            $user = get_user_by( 'ID', $user_id );
            $path = ABSPATH . 'wp-admin/organel/' . $site . '/private' .'/'. $user->data->user_login .'/'. $file ;

            if ( file_exists( $path ) ) {
                $file = file_get_contents( $path, true);
                $file = decrypt_string( $file, $user->data->user_pass );
                $file = json_decode( $file );
                return $file;
            } else {
                return null;
            }
        }
    }
}