<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_theme_loader' ) ) {

    class rozard_theme_loader{


        // schemes
        private $data; 


        // component
        private $aset; 


        
        public function __construct() {
           $this->hook();
        }


        public function hook() {
            add_action( 'after_setup_theme', array( $this, 'init' ) );
            add_action( 'get_header',        array( $this, 'view' ) );
        }


        public function init() {
            $this->data();
            $this->load();
            $this->mods();
        }


        public function load() {
            require_once  'assist/helper.php';
            require_once  'assist/config.php';
            require_once  'assist/operat.php';
        }


        public function data() {

            define( 'rozard_frontend', rozard . 'scheme/themes/layout/'  );
            $data = apply_filters( 'register_scheme', array() );

            if ( isset( $data['themes'] ) ) {
                global $themes;
                $themes = $data['themes'];
            }


            if ( isset( $data['plugin'] ) ) {
                global $plugin;
                $plugin = $data['plugin'];
            }
        }


        public function mods() {
            $this->suport();
            $this->navist();

        }



    /**  SUPPORT */
  
        public function suport() {
            add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
            add_theme_support( 'menus' );
            add_theme_support( 'title-tag' );
            add_theme_support( 'custom-logo' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'featured-content' );
            add_theme_support( 'widgets' );
            add_theme_support( 'widgets-block-editor' );
        }
        

    /**  MENUS */

        public function navist() {
            
            global $themes;

            if ( isset( $themes['structure']['menu'] ) ) {

                foreach( $themes['structure']['menu'] as $group ) {

                    foreach ( $group as $name => $value ) {

                        if ( $value === true ) {

                            $keys = str_keys( $name );
                            $name = str_text( $name );
                            register_nav_menu( $keys ,__(  $name ));
                        }  
                    }
                }
            }
        }



    /**  MODEL */

        public function view() {

            global $themes;

            if ( ! isset( $themes['structure']['bootups'] ) ) {
                return;
            }


            $model = $themes['structure']['bootups']['model'];


            if ( $model === 'droper' ) {
               require_once 'droper/render.php';
            }

            if ( $model === 'blocks' ) {
                require_once 'blocks/render.php';
            }

            if ( $model === 'static' ) {
                require_once 'layout/render.php';
                new rozard_theme_render;
            }
        }
    }
}