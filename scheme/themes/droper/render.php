<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_theme_classic_structure' ) ) {

    class rozard_theme_classic_structure{

        private $data;


        public function __construct() {
            add_action( 'widgets_init', array( $this, 'data' ) );
        }


        public function data() {

            $this->data = apply_filters( 'register_scheme', array() );

            if ( empty( $this->data['theme']['master']['models'] ) ) {
                return;
            }

            if ( $this->data['theme']['master']['models'] === 'classic' ) {
                $this->init();
            }
        }


        public function init() {
            $this->hook();
            $this->conf();
        }


        private function hook() {

            register_sidebar( 
                array(
                    'name'          => esc_html__( 'Header', 'rozard_framework' ),
                    'id'            => 'rozard-classic-header',
                    'description'   => 'Themes header layout section',
                    'before_widget' => '',
                    'after_widget'  => '',
                ) 
            );


            register_sidebar( 
                array(
                    'name'          => esc_html__( 'Footer', 'rozard_framework' ),
                    'id'            => 'rozard-classic-footer',
                    'description'   => 'Themes Footer layout section',
                    'before_widget' => '',
                    'after_widget'  => '',
                ) 
            );


            register_sidebar( 
                array(
                    'name'          => esc_html__( 'Frontpage', 'rozard_framework' ),
                    'id'            => 'rozard-classic-frontpage',
                    'description'   => '',
                    'before_widget' => '<section id="%1$s" class="section my-5 p-3">',
                    'after_widget'  => '</section>',
                ) 
            );
        }


        private function conf() {

            // heading config
            require_once 'control/header.php';
            register_widget( 'rozard_classic_header' );


            // footer config
            require_once 'control/footer.php';
            register_widget( 'rozard_classic_footer' );
        }
    }

    new rozard_theme_classic_structure;
}