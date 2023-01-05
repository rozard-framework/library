<?php

declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }


/** USERS SERIES */

    // get current user role 
    function take_role() {

        if ( is_user_logged_in() ) 
        {
            $user  = wp_get_current_user();
            $roles = ( array ) $user->roles;
            $value = ( empty( $roles ) === true ) ? array() : $roles;
            return $value; // This returns an array, for return a single value use 'return $roles[0];'
        } 
    }


/** FILE SYSTEM SERIES */


    // get current file extension
    function take_exts( string $path ) {
        if ( ! is_string( $string ) ) { return; }
        return  pathinfo( $path , PATHINFO_EXTENSION);
    }



/** URI SERIES
 * 
 * @param   $post_type  post type/object
 * @return  array       post status count
*/


    function take_uri() {

        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')  {
            $url = "https://"; 
        }
        else {
            $url = "http://";   
        }  
        $url.= $_SERVER['HTTP_HOST'];    // Append the host(domain name, ip) to the URL. 
        $url.= $_SERVER['REQUEST_URI'];   // Append the requested resource location to the URL   

        if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
            return;
        }
        return $url;  
    }


    function take_uri_query() {
        $url = $_SERVER['REQUEST_URI'];   // Append the requested resource location to the URL 
        $url = sanitize_url( $url );
        return $url;  
    }


    function take_uri_param( $query ) {
        $url_components = parse_url( gets_uri_query() );
        if ( empty ( $url_components['query'] ) ) {
            return;
        }
        parse_str( $url_components['query'], $params );
        if ( array_key_exists( $query, $params )  ) {
            return $params[$query];
        }
        return;
    }



/** POST OBJECT SERIES
 * 
 * @param   $post_type  post type/object
 * @return  array       post status count
*/


    function take_post_stat( string $post_type ) {

        if ( ! is_string( $string ) ) { return; }

        $post_type   = str_slug( $post_type );
        $get_statuta = get_post_stati('' , 'names', '', '' );
        $count_posts = wp_count_posts( $post_type );
        $all_statuta = array();
        foreach ( $get_statuta as $status ) {
            if ( $count_posts ) {
                $all_statuta[$status] = $count_posts->$status;
            }
        }
        return $all_statuta;
    }


    function take_post_taxo( string $post_type ) {
        $taxos  = get_object_taxonomies( $post_type );
        $filter = array( 'post_format', 'wp_theme' );
        $result = array();
        foreach(  $taxos as $taxonomy) {
            if (! in_array( $taxonomy, $filter ) ) {
                $term_data = get_taxonomy(  $taxonomy );
                array_push($result, $term_data );
            }
        }
        return $result;
    }

    
    function take_post_type() {

        global $post, $typenow, $current;
        
        if ($post && $post->post_type)  
        {
            return $post->post_type;
        }
        else if ( $typenow )
        {
            return $typenow;
        } 
        else if ($current && $current->post_type)
        {
            return $current->post_type;
        } 
        else if( isset( $_REQUEST['post_type'] ) ){
            return sanitize_key($_REQUEST['post_type']);
        }
        else
        {
            return null;
        }
    }