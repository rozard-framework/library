<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_scheme_objects' ) ) {

    class rozard_scheme_objects{

        public function __construct() {
            $this->hook();
        }


        public function hook() {
            add_action('plugins_loaded', array( $this, 'load' ));
        }


        public function load() {
            
            require_once 'format.php';
            new rozard_scheme_object_post;


            require_once 'taxost.php';
            new rozard_scheme_object_term;

            
            if ( ! is_admin() && uris_has( array( 'edit.php', 'post-new.php' ) ) ) {
                return;
            }

            require_once 'boxest.php';
            new rozard_scheme_object_boxs;
        }
    }
}