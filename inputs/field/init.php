<?php

declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) || ! defined( 'rozard_form' )  ){ exit; }
if ( ! function_exists( 'render_field') || ! function_exists( 'saving_field') || ! function_exists('register_field') ) {


    /** RENDER FIELD */

        function render_field( string $id, string $mode, array $access, array $filter, array $field ) {
            require_once __DIR__ . '/render.php';
            rozard_field_render( $id, $mode, $access, $filter, $field );
        }


    /** RENDER FIELD */

        function saving_field( string $id, string $mode, array $access, array $filter, array $field ) {
            require_once __DIR__ . 'saving.php';
            rozard_field_saving( $id, $mode, $access, $filter, $field );
        }
}