<?php

declare(strict_types=1);
if( ! defined('ABSPATH') ){exit;}

if ( ! function_exists( 'render_table' ) ) {

    function render_table( array $head, array $body, array $caps ) {
        require_once __DIR__ . '/protos/core/table.php';
        proto_render_layout_table(  $head, $body, $caps );
    }
}