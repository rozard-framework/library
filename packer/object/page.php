<?php

if ( ! class_exists( 'pages' ) ) {

    class pages extends cores{


        protected $page;

        public function __construct( $data = array() ) {

            $this->page = $data;
            add_action( 'admin_menu', array($this, 'build_method' ) );
        
        }


        public function build_method() {

            $page = $this->page;

            $build_mode = $page['cores']['mode'] ;
            $page_title = $page['cores']['title'];
            $menu_title = $page['cores']['menu'];
            $capability = $page['access']['caps'] ?: 'manage_options';
            $menu_slug  = $page['cores']['slug'];
            $callback   = array( $this, 'page_method' );
            $icon_url   = $page['cores']['icon'];
            $position   = $page['cores']['position'];
            $parent     = $page['cores']['parent'] ?: null ;

            if (  $build_mode === 'modular' && $parent === null ) 
            {
                add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback, $icon_url, $position );
            }
            else if ( $build_mode === 'modular' && $parent !== null )
            {
                add_menu_page( $parent, $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }    
            else if (  $build_mode === 'setting' )
            {
                add_options_page( $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }
            else if ( $build_mode === 'manage' ) 
            {
                add_management_page( $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }
            else if ( $build_mode === 'user' ) 
            {
                add_users_page( $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }
            else if ( $build_mode === 'theme' ) 
            {
                add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }
            else if ( $build_mode === 'comment' ) 
            {
                add_comments_page( $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }
            else if ( $build_mode === 'media' ) 
            {
                add_media_page( $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }
            else if ( $build_mode === 'dashboard' ) 
            {
                add_dashboard_page( $page_title, $menu_title, $capability, $menu_slug, $callback,  $position );
            }
        }


        public function page_method() {

            echo '<div class="wrap">';
                echo '<div class="container">';
                    echo '<div class="columns">';
                        $callback = $this->str_keys($this->page['cores']['model']);
                        call_user_func( array( $this, $callback), '');
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        
        }


        /** LAYOUT */

        private function head_nav() {
           
            echo '<div class="outsider column col-xs-12 col-12">';
                echo '<div class="header">';
                    call_user_func( array( $this, 'render_pageheader'), '');
                echo '</div>';
                echo '<div class="navigation">';
                    call_user_func( array( $this, 'render_navigation'), '');
                echo '</div>';
            echo '</div>';
            echo '<div class="container column col-xs-12 col-12">';
                echo '<div class="content">';
                    call_user_func( array( $this, 'render_containers'), '');
                echo '</div>';
            echo '</div>';    
        }


        private function right_nav(){

            echo '<div class="container column col-xs-12 col-lg-8 col-9">';
                echo '<div class="header">';
                    call_user_func( array( $this, 'render_pageheader'), '');
                echo '</div>';
                echo '<div class="content">';
                    all_user_func( array( $this, 'render_containers'), '');
                echo '</div>';
            echo '</div>'; 
            echo '<div class="outsider column col-xs-12 col-lg-4 col-3">';
                echo '<div class="navigation">';
                    call_user_func( array( $this, 'render_navigation'), '');
                echo '</div>';
            echo '</div>';

        }

        private function left_nav() {

            echo '<div class="outsider column col-xs-12  col-lg-4 col-3">';
                echo '<div class="navigation">';
                    call_user_func( array( $this, 'render_navigation'), '');
                echo '</div>';
            echo '</div>';
            echo '<div class="container column col-xs-12  col-lg-8 col-9">';
                echo '<div class="header">';
                    call_user_func( array( $this, 'render_pageheader'), '');
                echo '</div>';
                echo '<div class="content">';
                    call_user_func( array( $this, 'render_containers'), '');
                echo '</div>';
             echo '</div>'; 
        }

     

        /** RENDER */
        private function render_pageheader() {

            $page =  $this->page;

            $header = array(
                'layout' => $page['render']['header']['layout'],          // value : default | minimize
                'title'  => get_admin_page_title(),
                'icons'  => $page['render']['header']['icons'],
                'descs'  => $page['render']['header']['descs'],
            );
            new heading( $header );
        }


        private function render_navigation() { 

            $menus = $this->page['section'];
            
            
            foreach( $menus as $menu ) 
            {
                new tabs();
                echo $menu['panel']['title'];
            }


        }
        
        private function render_containers() { 

        }

        
        /** PARTIAL */
       
    }
}