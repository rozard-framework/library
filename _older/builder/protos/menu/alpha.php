<?php

declare(strict_types=1);
if( ! defined('ABSPATH') ){exit;}
if ( ! class_exists('proto_menu_alpha') ) {

    class proto_menu_alpha{
        
        
        use lib_string;


        private $render;


        public function __construct( $title, $link ) {
            $this->render( $title, $link );
            add_action('admin_assets', array( $this, 'assets' ));
        }


        public function assets() {

            if(!isset($_SESSION['asset_load'])){
                $_SESSION['asset_load'] = 1;
                $get = get_info('cores');
                $css = $get->styles['url'] . 'corest/layout/menu/';
                $jsx = $get->script['url'] . 'corest/layout/menu/';
                wp_enqueue_style( 'proto-menu-alpha', $css . 'alpha.css', array(), roz_ver, 'all' );
            }
            
        }


        public function render( $title, $link ) {
            $title  = sanitize_title( $title );
            $prefix = substr( $title, 0, 1 );
            $render = '';

            $render .='<li class="list side-alpha">';
                $render .='<a class="wraping flex-a" href="'.esc_url( $link ).'">';
                    $render .='<h2>'. esc_html( $prefix ) .'</h2>';
                    $render .='<p>'. esc_html( $title ) .'</p>';
                $render .='</a>';
            $render .='</li>';
            $this->render = $render;
        }


        public function __toString() {
            return $this->render;
        }
    }
}