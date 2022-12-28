<?php

declare(strict_types=1);
if( ! defined('ABSPATH') ){exit;}
if( ! trait_exists( 'lib_bricks' ) ) {

    trait lib_bricks{

        use lib_valids;
        use lib_cleans;
        private $layouts_depends;


    /** PREPARE ASSETS */

        public function register_bricks( $types = array() ){
            $layouts = $this->sanitize_array_keys( $types );
            $this->layouts_depends = $types;
            add_action('admin_enqueue_scripts', array( $this, 'bricks_depends' ), 150);
        }


        public function bricks_depends() {

            foreach( $this->layouts_depends as $type ) {

                if( isset( $_SESSION[$type] ) ){
                   continue;
                }
                
                if ( str_contains( $type, 'card' ) ) {
                    $prefix = 'card';
                } 
                else if ( str_contains( $type, 'menu' ) ) {
                    $prefix = 'menu';
                }
                else if ( str_contains( $type, 'head' ) ) {
                    $prefix = 'head';
                }

                else if ( str_contains( $type, 'tabs' ) ) {
                    $prefix = 'tabs';
                }

                else if ( str_contains( $type, 'button' ) ) {
                    $prefix = 'button';
                }

                else if ( str_contains( $type, 'action-core' ) ) {
                    $prefix = 'action-core';
                }

 
                $baseds = get_auxil('based');
                $handle = 'bricks-' . $this->str_slug($type);
                $styles = $baseds->corest['styles']['url'] . 'module/bricks/'. $prefix .'.css';
                $jsxmod = $baseds->corest['jsxmod']['url'] . 'module/bricks/'. $prefix .'.js';
                $file_styles = $baseds->corest['styles']['dir'] . 'module/bricks/'. $prefix .'.css';
                $file_jsxmod = $baseds->corest['jsxmod']['dir'] . 'module/bricks/'. $prefix .'.js';


                if ( file_exists( $file_styles ) ) {
                   
                    wp_enqueue_style(  $handle , $styles , array(), rozard_version, 'all' );
                }

                if ( file_exists( $file_jsxmod ) ) {
                    
                    wp_enqueue_script(  $handle , $jsxmod , array(), rozard_version, true );
                }
               

                $_SESSION[$type] = 1; // set session id to prevent duplicate proccess
            }
        }



    /** RENDER LAYOUT */

        public function render_head_simplify( $img_url, string $title, string $tagline ) {
            require_once __DIR__ . '/head/simplify.php';
            $render = new proto_head_simplify( $img_url, $title, $tagline );
            return $render;
        }

    /** RENDER ACTION */
        public function brick_core_post_action( $post_types = array() ) {
            require_once __DIR__ . '/action/core-post.php';
            new brick_core_post_action( $post_types );
        }

        public function brick_core_term_action( $taxonomies = array() ) {
            require_once __DIR__ . '/action/core-term.php';
            new brick_action_core_term;
        }
        
    /** RENDER SIDEBAR */

        public function render_asside_simplify( string $prefix ) {
            require_once __DIR__ . '/asside/simplify.php';
            new proto_asside_simplify( $prefix  );
        }

    /** RENDER CARD  */
        public function render_card_simplify( $count, string $title, string $tagline, string $url, $action ) {
            require_once __DIR__ . '/card/simplify.php';
            $render = new proto_card_simplify( $count, $title, $tagline, $url, $action );
            return $render;
        }

        public function render_card_sidecard( string $icon, string $title, string $count ) {
            require_once __DIR__ . '/card/sidecard.php';
            $render = new proto_card_sidecard( $icon, $title, $count );
            return $render;
        }


    /** RENDER BUTTON  */
        public function render_btn_simplify( string $icon, string $title, string $href, string $target, $attribute = array()  ) {
            require_once __DIR__ . '/button/simplify.php';
            $render = new proto_btn_simplify( $icon, $title, $href, $target, $attribute );
            return $render;
        }

        public function render_menu_alpha( string $title, string $link ) {
            require_once __DIR__ . '/menu/alpha.php';
            $render = new proto_menu_alpha( $title, $link );
            return $render;
        }



    /** TAB MODULE */

        public function render_tab_actions( string $parent, $action = array() ) {
            require_once __DIR__ . '/tabs/actions.php';
            new proto_tab_actions(  $parent, $action );
        }

        public function render_tab_content( string $parent, $action = array() ) {
            require_once __DIR__ . '/tabs/content.php';
            new proto_tab_content(  $parent, $action );
        }
    
    /** TABLE MODULE */
        public function render_core_table( $head = array(), $body = array(), $caps = array() ) {
            require_once __DIR__ . '/core/table.php';
            new proto_core_table(  $head, $body, $caps );
        }
    }
}