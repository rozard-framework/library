<?php


declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }


/** SINGLE SERIES  */


    function sanitize_keyid( string $datum ) {
        $data = preg_replace('([^0-9])', '', (string)$datum);
        return (string)$data;
    }


    function sanitize_number( string $datum ) {
        $int = preg_replace('([^0-9])', '', $datum);
        $int = (int)$int;
        return $int;
    }

    

/** ARRAY SERIES  */

    // normal array
    function sanitize_array_keys( array $datum ) {
    
        if ( ! is_array( $string ) ) { return; }

        $sanitized = array();
        foreach( $datum as $keys => $data ) {
            $sanitized_data = str_keys( $data );
            $sanitized[$keys] = $sanitized_data;
        }
        return $sanitized;
    }

    // arrow array
    function sanitize_arrays( array $datum ) {
        
        if ( ! is_array( $string ) ) { return; }

        $sanitized = array();
        foreach( $datum as $keys => $data ) {
            $sanitized_keys = sanitize_keyid( $keys );
            $sanitized_data = str_text( $data );
            $sanitized[$sanitized_keys] = $sanitized_data;
        }
        return $sanitized;
    }


    function sanitize_arrays_keys( array $datum ) {

        if ( ! is_array( $string ) ) { return; }

        $sanitized = array();
        foreach( $datum as $keys => $data ) {
            $sanitized_keys = str_keys( $keys );
            $sanitized_data = str_keys( $data );
            $sanitized[$sanitized_keys] = $sanitized_data;
        }
        return $sanitized;
    }


    function sanitize_arrays_slug( array $datum ) {

        if ( ! is_array( $string ) ) { return; }

        $sanitized = array();
        foreach( $datum as $keys => $data ) {
            $sanitized_keys = str_slug( $keys );
            $sanitized_data = str_slug( $data );
            $sanitized[$sanitized_keys] = $sanitized_data;
        }
        return $sanitized;
    }


    function sanitize_arrays_text( array $datum ) {

        if ( ! is_array( $string ) ) { return; }

        $sanitized = array();
        foreach( $datum as $keys => $data ) {
            $sanitized_keys = str_text( $keys );
            $sanitized_data = str_text( $data );
            $sanitized[$sanitized_keys] = $sanitized_data;
        }
        return $sanitized;
    }


/** URI SERIES  */

