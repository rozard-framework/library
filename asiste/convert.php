<?php


declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }

/** STRING SERIES */

    // string to plural
    function str_plural( string $string ) {

        if ( ! is_string( $string ) ) { return; }


        $last = $string[strlen( $string ) - 1];
        if( $last == 'y' ) {                     // convert y to ies
            $cut = substr( $string, 0, -1 );   
            $plural = $cut . 'ies';
        }
        else if( $last == 's' ) {                // convert s to s
            $cut = substr( $string, 0, -1 );
            $plural = $string . 's';           
        }
        else {                                   // just attach an s
            $plural = $string . 's';
        }
        $plural = sanitize_text_field( $plural );
        return $plural;
    }


    // string to text
    function str_text( string $string ) {

        if ( ! is_string( $string ) ) { return; }

        $string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
        return  $string;
    }


    // string to keys
    function str_keys( string $string ) {

        if ( ! is_string( $string ) ) { return; }

        $string = preg_replace('/[^A-Za-z0-9]/', '_', $string);
        $string = strtolower( $string );
        $string = sanitize_key( $string );
        return $string;
    }


    // string to slug
    function str_slug( string $string ) {

        if ( ! is_string( $string ) ) { return; }

        $string = preg_replace('/[^A-Za-z0-9]/', '-', $string);
        $string = strtolower($string);
        $string = sanitize_html_class( $string );
        return $string;
    }


    // string to filename
    function str_file( string $string ) {

        if ( ! is_string( $string ) ) { return; }

        $string = preg_replace('/[^A-Za-z0-9 .\-]/', '', $string);
        $string = strtolower( str_replace( ' ', '-', $string ) );
        return $string;
    }


/** ARRAYS SERIES */

    // array to html element
    function array_html( array $datum ) {
        
        if ( ! is_array( $string ) ) { return; }

        array_walk($datum, function(&$value, $key) {
            $value = '<span class="key">'. sanitize_key( $key ) .'</span><span class="delimit">:</span><span class="value">'. sanitize_text_field( $value ).'</span>';
        });
        $result = implode(' ', $datum);
        return $result; 
    }


    // array to html attribute
    function array_attr( array $datum ) {

        if ( ! is_array( $datum ) ) { return; }

        array_walk($datum, function(&$value, $key) {
            if ( empty( $value ) || $value === false ) {
                $value = null;
            }
            else if ( $value === true ) {
                $value = $key;
            }
            else {
                $value = sanitize_key( $key ) .'="'. sanitize_text_field( $value ) .'"';
            }
        });
        $result = implode(' ', $datum);
        return $result; 
    }


    // array to url query arguments
    function array_url_query( array $datum ) {

        if ( ! is_array( $string ) ) { return; }

        $whitelist = array('m', 'paged', 'order', 'orderby', 'post_type', 'posts_per_page', 'post_status', 'perm');

        // filter exclude data
        foreach( $datum as $key => $data ) {
            if ( ! in_array( $key, $whitelist ) ) {
                unset($datum[$key]);
            }
        }

        // render to uri
        array_walk($datum, function(&$value, $key) {
            
            if ( ! empty( $value )  ) {
                $value = '&'.sanitize_key( $key ) .'='. sanitize_html_class( $value );
            } 
        });
        $result = implode('', $datum);
        return $result; 
    }


/** URI SERIES */

    // remove protocol and sitename
    function uri_to_path( string $uri ) {

        if ( filter_var( $uri, FILTER_VALIDATE_URL ) ) {
            $path = rtrim( ABSPATH, '/' ) . str_replace( get_site_url() , '',$uri );
        } else {
            $path = rtrim( ABSPATH, '/' ) . $uri;
        }

        if ( file_exists(  $path ) ) {
            return $path;
        } else {
            return false;
        }
    }

    function path_to_uri( string $data ) {
        if ( is_admin() ) {
            $uri = strstr($data, 'wp-admin');
        }
		$uri = get_site_url(). '/' .$uri;
		return $uri;
	}