<?php


declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }


/** SINGLE SERIES  */


    // integrer sanitize
    function pure_int( int $datum ) {
        $int = preg_replace('([^0-9])', '', $datum);
        $int = intval( $int );
        $int = absint( $int );
        return $int;
    }


    // key sanitize
    function pure_key( string $datum ) {
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_key( $datum );
        return $datum;
    }


    // slug sanitize
    function pure_slug( string $datum  ) {
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_html_class( $datum );
        return $datum;
    }


    // text field sanitize
    function pure_text( string $datum ) {
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_text_field( $datum );
        return $datum;
    }


    // email sanitize
    function pure_mail( string $datum ) {
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_email( $datum );
        return $datum;
    }


    // filename sanitize
    function pure_file( string $datum ) {
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_file_name( $datum );
        return $datum;
    }


    // color hex sanitize
    function pure_hex( string $datum ) {
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_hex_color( $datum );
        return $datum;
    }
   

    // mime type sanitize
    function pure_mime( string $datum ) {
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_mime_type( $datum );
        return $datum;
    }


    // textarea sanitize
    function pure_texa( string $datum ){
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_textarea_field( $datum );
        return $datum;
    }


    // title sanitize
    function pure_title( string $datum ){
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_title_for_query( $datum );
        return $datum;
    }


    // url sanitize
    function pure_url( string $datum ){
        if ( ! is_string( $datum ) ) { return; }
        $datum = sanitize_url( $datum );
        return $datum;
    }

    

/** ARRAY SERIES  */

    // sanitize normal array return as clean string
    function pure_array( array $datum ) {
    
        if ( ! is_array( $datum ) ) { return; }

        $sanitized = array();
        foreach( $datum as $keys => $data ) {
            $sanitized_data   = pure_slug( $data );
            $sanitized[$keys] = $sanitized_data;
        }
        return $sanitized;
    }


    // arrow array
    function pure_arrays( array $datum ) {
        
        if ( ! is_array( $string ) ) { return; }

        $sanitized = array();
        foreach( $datum as $keys => $data ) {
            $sanitized_keys = pure_slug( $keys );
            $sanitized_data = str_text( $data );
            $sanitized[$sanitized_keys] = $sanitized_data;
        }
        return $sanitized;
    }



/** DANGER SERIES  */