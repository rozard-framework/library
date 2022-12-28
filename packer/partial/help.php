<?php


/** HELPER METHOD */

if ( ! class_exists( 'helper' ) ) {

    class helper extends cores{


        use driver_devels;


        protected $screen;
        
        // hooks
        protected $hooks;

        // display
        protected $context = array();
        protected $footers;


        // key unique id
        protected $context_keys = array();
        protected $footers_keys = array();


        /** HELPER METHOD */
        public function __construct( $datas = array() ) {

            foreach ( $datas as $data ) {

                $unique = $data['cores']['unique'];

                if ( $data['cores']['render'] === 'context' && ! in_array( $unique, $this->context_keys)  ) 
                {
                    array_push( $this->context_keys, $unique );
                    array_push( $this->context, $data );
                   
                }
                else if ( $data['cores']['render'] === 'footer'  && ! in_array( $unique, $this->footers_keys) )
                {
                    array_push( $this->footers_keys, $unique );
                    array_push( $this->footer, $data );
                }
            }

            // hooks init
            add_action( 'admin_head', array( $this, 'context_render' ) );
            add_action( 'admin_footer_text',  array( $this, 'footer_render' ) );
        }



        /** RENDER HELPER DISPLAY */
        public function context_render() {

            // get allowed context context 
            $context_validate = $this->is_rendered( 'helper', $this->context );

            foreach( $this->context as $context ) {

                //validate allowed context
                if ( in_array( $context['access']['keyman'], $context_validate ) ) {

                    $screen   = get_current_screen();
                    $unique   = $context['cores']['unique'];
                    $title    = $context['cores']['title'];
                    $method   = $context['cores']['method'];
                    $callback = $context['content']['callback'] ;
    
                    if ( $method === 'callback' &&  $callback !== null  ) 
                    {
                        $screen->add_help_tab( array( 'id'	=> $unique, 'title'	=> __( $title), 'content'=> null, 'callback' => $callback, ));
                     }
                    else
                    {
                        $content  = $this->content( $method , $context['content'] );
                        $screen->add_help_tab( array( 'id' => $unique, 'title' => __( $title), 'content' => $content, 'callback' => false, ));
                    }
                }
                else
                {
                    $this->notice('error', 'error',  $context['cores']['title'] );
                }
            }
        }

        /*
        public function helper_render() {
            echo  $this->hooks;
            do_action( $this->hooks );
        }*/


        public function footer_render() {

            // remove default footer
            remove_filter( 'update_footer', 'core_update_footer' );

            // render new footer layout
            echo '<div id="rozard-footer">';
              
            echo '</div>';
        }


        private function content( $method, $content ) {

            $method = 'content_'. $method;
            $content = call_user_func( array( $this, $method ), $content );
            return $content;

        }

      
        // helper using native html mode
        private function content_plain( $content ) {

            $plain_content = $content['plain'];
            return $plain_content;
        }


        // helper using hooks and callback
        private function content_hooks( $content ) {
           
            $this->hooks = $content['hooks'];
            return null ;
        }


        // helper using custom post mode
        private function content_post( $content ) {
            $post    =  get_post( $content );
            $title   =  '<h1>'. $post->post_title .'</h1>';
            $content =  $post->post_content;
            $value   =  $title . $content;

            return $value;
        }

        // helper using external api mode
        private function content_api( $content ) {
            $value_content = $content['api'];
            return $value_content;
        }
    }
}



/** HELPER DEFAULT */
if ( ! class_exists( 'rozard_helper' ) ) {

    class rozard_helper {


        public function __construct() {
            $this->context_display();
            $this->context_manages();
        }

        private function context_display() {

            /** WITHOUT CALLBACK */
            $screen_option = [
                'rozard_screen_option' => [
                    'cores' => [
                        'render'   => 'context',           // Display on footer or context value : footer | context
                        'unique'   => 'rozard_screen',
                        'title'    => 'Display',
                        'method'   => 'plain'              // api | post | plain || callback
                    ],
                    'access'  => [
                        'keyman'   => 'test',              // unique key for rendering validator 
                        'caps'     => [],                  // capablitiy for access this form : default 'manage_options'
                        'links'    => [],                  // admin page uri  
                        'post'     => [],                  // admin page uri  
                        'screen'   => [],                  // admin page screen
                        'roles'    => [],                  // admin page screen
                    ],
                    'content' => [
                        'api' => [
                            'url'   => '',                 // api endpoint url
                            'type'  => '',                 
                            'token' => '',                  
                        ],
                        'post'     => 1,                   // insert post id
                        'plain'    => '<div id="main-screen-panel" class="panel"></div>',                   // html or text
                        'callback' => null,                // callback function name
                    ],
                ],
            ];
            new helper( $screen_option );
        }


        private function context_manages() {

            /** WITHOUT CALLBACK */
            $screen_admins = [
                'rozard_screen_option' => [
                    'cores' => [
                        'render'   => 'context',           // Display on footer or context value : footer | context
                        'unique'   => 'rozard_admins',
                        'title'    => 'Manage',
                        'method'   => 'callback'              // api | post | plain || callback
                    ],
                    'access'  => [
                        'keyman'   => 'admin_option',              // unique key for rendering validator 
                        'caps'     => ['manage_options', 'manage_rozard'],                  // capablitiy for access this form : default 'manage_options'
                        'links'    => [],                  // admin page uri  
                        'post'     => [],                  // admin page uri  
                        'screen'   => [],                  // admin page screen
                        'roles'    => [],                  // admin page screen
                    ],
                    'content' => [
                        'api' => [
                            'url'   => '',                 // api endpoint url
                            'type'  => '',                 
                            'token' => '',                  
                        ],
                        'post'     => 1,                   // insert post id
                        'plain'    => '',                   // html or text
                        'callback' => array( $this, 'render_option_context'),                // callback function name
                    ],
                ],
            ];
            new helper( $screen_admins );
        }


        function render_option_context() {

            global $submenu;
            global $wp_admin_bar;
            $setting = $submenu['options-general.php'];
            $manages = array();
            $get_man = array_merge( $submenu['plugins.php'], $submenu['themes.php'], $submenu['upload.php'], $submenu['users.php'], $submenu['tools.php'] );
            $fil_man = array('plugin-install.php', 'site-editor.php', 'media-new.php', 'user-new.php', 'profile.php', 'import.php', 'export.php', 'site-health.php', 'export-personal-data.php', 'erase-personal-data.php');
            foreach( $get_man as $menu ) 
            {
                if ( current_user_can( $menu[1] ) && ! in_array( $menu[2], $fil_man ) ) 
                {
                    array_push( $manages,  $menu);
                }
            }

            /** TEMPLATE RENDER */
            echo  '<div class="panel context">';
            echo     '<div class="panel-header d-flex">';
            echo         '<div class="panel-nav">';
            echo            '<ul class="tab tab-block">';
            echo             '<li class="tab-item active" data-target="admin-module" data-parent="context-admin">';
            echo                 '<a id="devel-hooks-action" href="#"><i class="las la-tools"></i>Module</a>';
            echo             '</li>';
            echo             '<li  class="tab-item" data-target="admin-setting" data-parent="context-admin" >';
            echo                 '<a id="devel-notif-action" href="#"><i class="las la-sliders-h"></i>Setting</a>';
            echo             '</li>';
            echo            '</ul>';
            echo         '</div>';
            echo         '<div>';
            echo              '<div class="panel-title h5 mt-10">Management</div>';
            echo              '<div class="panel-subtitle">Application Control Panel</div>';
            echo         '</div>';
            echo        '<figure class="avatar avatar-lg"><img src="'.rzd_url .'assets/image/backend/manage-option.png" alt="Avatar"></figure>';
            echo     '</div>';
            echo     '<div class="panel-body context-admin">';
            echo         '<div id="admin-module" class="tab-content active">';
                            $this->render_option_menu( $manages );
            echo         '</div>';
            echo         '<div id="admin-setting" class="tab-content">';
                            $this->render_option_menu(    $setting );
            echo         '</div>';
            echo     '</div>';
            echo     '<div class="panel-footer">';
            echo         '<!-- buttons or inputs -->';
            echo     '</div>';
            echo  '</div>';
        }


        private function render_option_menu( $menus ) {

            foreach( $menus as $menu ) {

                if ( current_user_can( $menu[1] ) ) {
    
                    $titles = $this->render_option_title( $menu[2], $menu[0]  );
                    $unique = str_replace( '/', ' ', $menu[2] );
                    echo '<div id="'. $unique .'" class="item">';
                        echo '<a href="'. $menu[2] .'">';
                            echo '<p>'.  $titles.'</p>';
                        echo '</a>';
                    echo '</div>';
                }
            }
        }


        private function render_option_title( $page, $current_title ) {

            if ( $page === 'plugins.php' ) {
                $title = 'Plugins';
            } 
            else if ( $page === 'users.php' ) {
                $title = 'Members';
            }
            else if ( $page === 'themes.php' ) {
                $title = 'Themes';
            }
            else if ( $page === 'tools.php' ) {
                $title = 'Toolkit';
            }
            else {
                $title = $current_title;
            }

            return $title;
        }
    }
    new rozard_helper;
}



/** ADMINT DEFAULT */