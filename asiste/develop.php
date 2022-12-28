<?php

declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }


/** DEVELOPMENT NOTICE */

function dev( $message ) {
    if ( WP_DEBUG === false || ! class_exists( 'QM' ) ||  ( ! current_user_can('manage_options') || ! current_user_can('rozard_developer') )  ) 
    {
        unset( $message );
        return;
    } else {
        do_action( 'qm/debug',  $message  );
    }
}

function der( $message ) {
    if ( WP_DEBUG === false || ! class_exists( 'QM' ) ||  ( ! current_user_can('manage_options') || ! current_user_can('rozard_developer') )  ) 
    {
        unset( $message );
        return;
    } else {
        do_action( 'qm/error',  $message  );
    }
}

function dei( $message ) {
    if ( WP_DEBUG === false || ! class_exists( 'QM' ) ||  ( ! current_user_can('manage_options') || ! current_user_can('rozard_developer') )  ) 
    {
        unset( $message );
        return;
    } else {
        do_action( 'qm/info',  $message  );
    }
}

function den( $message ) {
    if ( WP_DEBUG === false || ! class_exists( 'QM' ) ||  ( ! current_user_can('manage_options') || ! current_user_can('rozard_developer') )  ) 
    {
        unset( $message );
        return;
    } else {
        do_action( 'qm/notice',  $message  );
    }
}

function dew( $message ) {
    if ( WP_DEBUG === false || ! class_exists( 'QM' ) ||  ( ! current_user_can('manage_options') || ! current_user_can('rozard_developer') )  ) 
    {
        unset( $message );
        return;
    } else {
        do_action( 'qm/warning',  $message  );
    }
}

function dee( $message ) {
    if ( WP_DEBUG === false || ! class_exists( 'QM' ) ||  ( ! current_user_can('manage_options') || ! current_user_can('rozard_developer') )  ) 
    {
        unset( $message );
        return;
    } else {
        do_action( 'qm/emergency',  $message  );
    }
}

