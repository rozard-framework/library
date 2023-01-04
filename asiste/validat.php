<?php


declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }



// general validator helper
function general_validator( array $data, string $validator ) {

    $authentication = array();
    foreach ( $data as $access_object ) 
    {
        $status = ( $access_object ===  $validator || $access_object ===  'global' ) ? 'granted' : 'denied'; 
        array_push( $authentication, $status );
    }
    $status = ( in_array( 'granted' , $authentication ) ) ? true : false;  
    return $status;
}
    

// role existing validator
function is_role_exist( array $role ) {

    if ( is_user_logged_in() && empty( $role ) === false ) 
    {
        $value = $GLOBALS['wp_roles']->is_role( $role );
        return $value;
    } 
    return array();
}


// uri validator
function is_uri_valid( string $uri ) {

    if ( str_contains( esc_url( $_SERVER["REQUEST_URI"] ), $uri ) && is_string( $uri ) )  {
        return true;
    }
    else if ( ! is_string( $uri ) ) {
        return false;
    }
    else {
        return false;
    }
}

// uri query validator
function uri_has( string $query ) {
    if ( str_contains( gets_uri(), $query ) ) {
        return true;
    }
    return false;
}


// file extension and existing validator
function is_file_valid( string $path, array $extensions ) {

    $validator   = array();
    $exten_temps = array();
    $target_ext  = pathinfo( $path, PATHINFO_EXTENSION);


    // path validator
    if ( file_exists( $path ) === true ) 
    {
        array_push( $validator, 'valid' );
    } 
    else 
    {
        array_push( $validator, 'invalid' );
        devnote( 'debug', $path . ' file not exist' );
    }

    // extension validator
    if ( ( ! empty( $extensions ) ) ) {

        foreach( $extensions as $extension )  {
            if ( $target_ext === $extension ) {
                array_push( $exten_temps, 'valid' );
            } else {
                array_push( $exten_temps, 'invalid' );
                devnote( 'array', 'File extension is not match, current file extension is "' . $extension .'" and target file extension is "' . $target_ext .'"');
            }
        }

        if ( in_array( 'valid',  $exten_temps ) ) {
            array_push( $validator, 'valid' );
        } 
    }

    $status = ( in_array( 'invalid',  $validator ) ) ? false : true ;
    return $status;
}


// screen id validator  
function is_screen_valid( array $data ) {

    if ( function_exists( 'get_current_screen' ) && empty( $data ) === false ) 
    {
        $current_screen = get_current_screen()->id;    // current screen id
        $status = general_validator( $data, $current_screen );
        return  $status ;
    }
    return null;
}


// admin uri validator 
function is_link_valid( array $data ) {

    if (  empty( $data ) === false ) 
    {
        $current_links = get_page_link();  // current admin page uri
        $status = general_validator( $data, $current_links );
        return $status;
    }
    return null;
}


// user capabilies validator
function is_caps( array $data ) {

    if ( function_exists( 'current_user_can') && empty( $data ) === false ) 
    {
        $authentication = array();
        foreach ( $data as $caps_validator ) 
        {
            $status = ( current_user_can( $caps_validator ) === true ) ? 'granted' : 'denied'; 
            array_push( $authentication, $status );
        }
        $status = ( in_array( 'granted' , $authentication ) ) ? true : false;  
        return $status;
    }
    return null;
}


// current post type validator 
function is_post_valid( array $data ) {

    if (  empty( $data ) === false ) 
    {
        $current_format = get_post_type();
        general_validator( $data, $current_format );
        return true;
    }
    return null;
}


// user role validator
function is_role_valid( array $data ) {

    if ( trait_exists( 'lib_getter' ) && empty( $data ) === false ) 
    {
        $authentication = array();
        foreach ( $data as $access_roles ) 
        {
            $users_roles = get_user_role();
            $role_access = ( in_array( $access_roles , $users_roles ) ) ? 'granted' : 'denied'; 
            array_push( $authentication, $role_access );
        }
        $status = ( in_array( 'granted' , $authentication ) ) ? true : false;  
        return $status;
    }
}


// array contains
function is_array_contains( string $string , array $array ) {

    if ( ! is_array( $array ) ) {
        if ( WP_DEBUG === true ) { der('This value its not a array'); }
        return;
    } 
        
    if ( ! is_string( $string ) ) {
        if ( WP_DEBUG === true ) { der('This value its not a string'); }
        return;
    } 
   
    $result = '';
    foreach ( $array as $key => $data ) {
        if ( str_contains( $string, $data) === true  )  {
            $result = true;
            break;
        } 
        else {
            continue;
        } 
    }
    return ( empty( $result) ) ? false : $result;
}