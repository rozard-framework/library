<?php


if ( ! class_exists( 'rozard_core_object_remover' ) ) {
    class rozard_core_object_remover{


    /** DATUMS */

        private array $asst = array();
        private array $cols = array();
        private array $dbox = array();
        private array $head = array();
        private array $help = array();
        private array $menu = array();
        private array $page = array();
        private array $scrn = array();
        private array $term = array();
       

    /** RUNITS */

        public function __construct( array $data ) {

            $this->load( $data );
        }

        private function load( array $data ) {

            if ( ! empty ( $data['cols'] )  ) {
                $this->cols_hook( $data['cols'] );
            }

            if ( ! empty ( $data['dbox'] ) && ( uris_has( array( 'index.php' )) )) {
                $this->dbox = $data['dbox'];
                add_action('wp_dashboard_setup', array( $this, 'dbox' ), 99 );
            }

            if ( ! empty ( $data['head'] )  ) {
                $this->head = $data['head'];
                add_action( 'admin_bar_menu', array( $this, 'head'), 99 );
            }

            if ( ! empty( $data['help'] ) ) {
                $this->scrn = $data['help'];
                add_action( 'admin_head', array( $this, 'schl'), 99 );
            }

            if ( ! empty ( $data['menu'] )  ) {
                $this->menu = $data['menu'];
                add_action('admin_menu', array( $this, 'menu' ), 99 );
            }

            if ( ! empty ( $data['script'] )  ) {
                $this->asst = $data['script'];
                add_action( 'admin_enqueue_scripts',  array( $this, 'asst' ), 99);
            }

            if ( ! empty ( $data['term'] )  ) {
                $this->term = $data['term'];
                add_action( 'init', array( $this, 'term' ), 99 );
            }
        }


    /** METHOD */

        // asset
        function asst() {
            foreach( $this->asst as $script ) {
                if ( $script['context'] == 'css' ) {
                    wp_dequeue_style( $script['handler'] );
                    wp_deregister_style( $script['handler'] );
                }
                else {
                    wp_dequeue_script( $script['handler'] );
                    wp_deregister_script( $script['handler'] );
                }
            }
        }
        

        // term
        function term() {
            foreach( $this->term as $term ) {
                unregister_taxonomy_for_object_type( $term['slug'], $term['context'] );
            }
        }


        // headbar
        function head( $admin_bar ) {
            foreach( $this->head as $bar ) {
                $admin_bar->remove_menu( $bar['slug'] );
            }
        }


        // screen option and contextual help
        function schl() {

            $screen = get_current_screen();
            foreach( $this->scrn as $item ) {

                if ( $item['context'] === 'help' ) {
                    $screen->remove_help_tab( $item['unique'] );
                }
                else if ( $item['context'] === 'option' ) {
                    $screen->remove_option( $item['unique'] );
                }
            }
        } 


        // column
        function cols_hook( array $datums ) {

            foreach( $datums as $data ) {
                $context    = $data['handler'];
                $this->cols = $data['context'];
                add_action( "manage_{$context}_columns" , array( $this, 'cols' ), 99);
            }
        }


        function cols( $columns ) {
            $filter = $this->cols;
            foreach( $filter as $col ) {
                unset( $columns[ $col ] );
            };
            unset( $filter );
            return $columns;
        }


        // admin menu
        function menu() {
            
            foreach( $this->menu as $menu ) {
                if ( empty( $menu['slugs'] ) ) {
                    continue;
                }
                else if ( empty( $menu['parent'] ) ) {
                    foreach( $menu['slugs'] as $slug ) {
                        remove_menu_page( $slug );
                    }
                }
                else {
                    $parent = $menu['parent'];
                    foreach( $menu['slugs'] as $slug ) {
                        remove_submenu_page( $menu['parent'], $slug );
                    }
                }
            }
        }


        // dashboard metabox
        function dbox() {
            
            global $wp_meta_boxes;

            
            // prepare filtered metabox id 
            $remover = array();
            foreach( $this->dbox as $box) {
                $remover[] = $box['unique'];
            }

            // metabox remover
            foreach( $wp_meta_boxes["dashboard"] as $position => $core ){
                foreach( $core["core"] as $widget_id => $widget_info ){
                    if ( in_array( $widget_id, $remover ) ) {
                        remove_meta_box( $widget_id, 'dashboard', $position );
                    }
                }
            }
        }


    /** HELPER */


    }
}