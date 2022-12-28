<?php

declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) || ! defined( 'rozard_form' )  ){ exit; }

if ( ! function_exists( 'rozard_field_saving ' ) ) {


    /** INITIALIZE */
        function rozard_field_saving( string $id, string $mode, array $access, array $filter, array $field ) {

            if ( empty( $id ) ) {
                der( 'Render field error, field id is empty');
                return;
            }

            if ( empty( $mode ) ) {
                dev( 'Render field mode used "block", due empty mode.' );
                return;
            }

            if ( ! is_caps_valid( $access ) ) {
                dev( 'Render field aborted, current user need higgher access level.' );
                return;
            }

            if ( ! is_screen_valid( $filter ) ) {
                dev( 'Render field aborted, this page its not a target render for field with id ' . $id . '.' );
                return;
            }

            if ( empty( $fields ) ) {
                dev( 'Render field aborted, Data field object is empty at field id ' . $id . '.' );
                return;
            }
        }


    /** SAVING METHOD */
}