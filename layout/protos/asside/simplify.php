<?php

declare(strict_types=1);
if ( ! defined( 'ABSPATH' ) ){ exit; }
if ( ! class_exists('proto_asside_simplify') ){

    class proto_asside_simplify{

        use lib_string;

        public function __construct( string $prefix ) {

            $slug = $this->str_keys( $prefix );

            echo '<asside class="sidebar simplify">';
                echo '<div class="heading">';
                    do_action( $slug .'_sidebar_heading' );
                echo '</div>';
                echo '<div id="sidenav-'.$slug.'" class="sidenav">';
                    do_action( $slug .'_sidebar_sidenav' );
                echo '</div>';
                echo '<div id="sidetab-'.$slug.'" class="sidetab">';
                    do_action( $slug .'_sidebar_section' );
                echo '</div>';
            echo '</asside>';
        }

    }
}
