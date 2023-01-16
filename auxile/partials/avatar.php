<?php


/** PROFILE SECTIONS */



function rozard_custom_avatar_img( $avatar, $id_or_email, $size, $default, $alt ) {
        
    /*
    //If is email, try and find user ID
    if ( ! is_numeric( $id_or_email ) && is_email( $id_or_email ) ) {
        $user = get_user_by( 'email', $id_or_email ); 
        if ( $user ) { 
            $id_or_email = $user->ID;
        }
    }

    //if not user ID, return
    if ( ! is_numeric( $id_or_email ) ) {
        return;
    } */

    //Find URL of saved avatar in user meta
    $saved  = get_user_meta( $id_or_email, 'rozard_avatar', true );
    $males  = get_cores()->assets['images']['public']['link']. 'avatar-male.webp';
    $avatar = ( !empty( $saved ) || $saved =! null ) ? sanitize_url( $males ) : sanitize_url( $saved );

    //check if it is a URL and return saved image
    if ( filter_var( $avatar, FILTER_VALIDATE_URL ) ) {
        return sprintf( '<img src="%s" class="avatar avatar-64 photo" height="64" width="64" loading="lazy" alt="%s" />', esc_url( $avatar ), esc_attr( $alt ) );
    }
    return $avatar;
}
add_filter( 'get_avatar', 'rozard_custom_avatar_img' , 1, 5 );


function rozard_custom_avatar_url( $url, $id_or_email, $args ) {
    /*
    //If is email, try and find user ID
    if ( ! is_numeric( $id_or_email ) && is_email( $id_or_email ) ) {
        $user  =  get_user_by( 'email', $id_or_email );
        if ( $user ) {
            $id_or_email = $user->ID;
        }
    }

    //if not user ID, return
    if ( ! is_numeric( $id_or_email ) ) {
        return;
    } */

    //Find URL of saved avatar in user meta
    $saved = get_user_meta( $id_or_email, 'rozard_avatar', true );
    $males = get_cores()->assets['images']['public']['link']. 'avatar-male.webp';
    $avatar = ( !empty( $saved ) || $saved =! null ) ? sanitize_url( $males ) : sanitize_url( $saved );
    return $avatar;
}
add_filter( 'get_avatar_url', 'rozard_custom_avatar_url' , 1, 3 );


