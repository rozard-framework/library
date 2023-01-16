<?php


/** DEVELE NOTE : USE BODY CLASS TO CRAETE TEMPLATE PAGE 
 * 
 */


if ( ! class_exists( 'rozard_build_custom_page' ) ) {

    
    class rozard_build_custom_page{

        
        private array  $page;
        private string $mode;


    /** RUNITS */


        public function __construct( array $data ) {
            $this->page = $data; 
            add_action( 'admin_menu', array( $this, 'load' ) );
        }


        public function load() {

            foreach( $this->page as $page ) {
                $this->core( $page );
            }
        }


        private function core( array $page ) {
           

            // datums
            $title = $page['title'];
            $order = $page['orders'];
            $icons = $page['icons'];
            $subas = $page['context'];
            $model = $page['layout'];
            $menu  = $title;
            $caps  = ( ! empty( $page['access'] ) ) ? $page['access'] : 'read';
            $slug  = empty ($page['slugs']) ? str_slug( $title ) : $page['slugs'];
            $view  = empty ($page['slugs']) ? array( $this, 'view' ) : '';


            // register 
            if ( $subas === 'comment' ) {
                add_comments_page( $title, $menu, $caps, $slug, $view,  $order );
            }
            else if ( $subas === 'dashboard' ) {
                add_dashboard_page( $title, $menu, $caps, $slug, $view,  $order );
            }
            else if ( $subas === 'manage' ) {
                add_management_page( $title, $menu, $caps, $slug, $view,  $order );
            }
            else if ( $subas === 'media' ) {
                add_media_page( $title, $menu, $caps, $slug, $view,  $order );
            }
            else if ( $subas === 'setting' ) {
                add_options_page( $title, $menu, $caps, $slug, $view,  $order );
            }
            else if ( $subas === 'theme' ) {
                add_theme_page( $title, $menu, $caps, $slug, $view,  $order );
            }
            else if ( $subas === 'user' ) {
                add_users_page( $title, $menu, $caps, $slug, $view,  $order );
            }
            else if ( $subas !== null && $page['context'] !== 'main' ) {
                add_submenu_page( $subas, $title, $menu, $caps, $slug, $view,  $order );
            } 
            else {
                add_menu_page( $title, $menu, $caps, $slug, $view, $icons, $order );
            }

            // assign mode
            $this->mode = str_slug( $model ) ;
        }



    /** RENDER */


        public function view() {

            global $current_screen;
            $page = $current_screen->id;
            $tops = str_replace( 'toplevel_page_', '', $page );
            $slug = str_replace( 'admin_page_', '', $tops );
            $mode = '';

            // filter and prepare
            foreach( $this->page as $page ) {
                if( str_slug( $page['title'] ) === str_slug( $slug )  ) {
                    $mode = $page['layout'];
                }
            }
  
            echo '<div class="wrap build '. $mode . '">';
                echo '<header>';
                    do_action( "{$slug}_head", $page );
                echo '</header>';
                echo '<main class="row">';
                    echo '<div class="page-left">';
                        do_action( "{$slug}_left", $page );
                    echo '</div>';
                    echo '<div class="page-right">';
                        do_action( "{$slug}_right", $page );
                    echo '</div>';
                    echo '<div class="page-exts">';
                        do_action( "{$slug}_exts", $page );
                    echo '</div>';
                echo '</main>';
                echo '<div class="footer">';
                    do_action( "{$slug}_foot", $page );
                echo '</div>';
            echo '</div>';
        }
    }
}