<?php

if ( ! class_exists( 'builder_object_conf' ) ) {

    class builder_object_conf {


    /***  TRAITS  */

        use rozard_builder_helper;



    /***  DATUMS  */

        // filters
        private array $create;
        private array $change;
        private array $remove;

        // modular
        private array $netopt = array( 'setting.php' );
        private array $defopt = array( 'general', 'writing', 'reading', 'discussion', 'media', 'permalink', 'privacy' );


    /***  RUNITS */

        public function __construct( array $data ) {


            // data validation
            if ( empty( $data ) || ! is_array( $data ) )  {
                return;
            }


            // uris validation
            if ( ! uris_has( array( 'settings', 'options', 'admin.php' ) ) ) {
                return;
            }


            // load module data
            $this->load( $data );
            return;
        }


        private function load( array $data ) {

            $datums = $this->data_modes( $data );
            $this->create = $datums[0];
            $this->change = $datums[1];
            $this->remove = $datums[2];

            $this->hook( $data );
            unset( $data );
        }


        private function hook( $data ) {

            if ( ! empty( $data ) ) {

                // create option
                if ( is_multisite() && is_network_admin() ) {
                    add_action( 'network_admin_menu', array( $this, 'menu' ) );
                }
                else {
                    add_action( 'admin_menu', array( $this, 'menu' ) );
                }

                // register menu
                add_filter( 'manages_menu', array( $this, 'regs' ) );
            } 

            return;
        }


        public function regs( $menu ) {

            foreach( $this->create as $key => $item ) {
                if ( in_array( $item['slug'], $this->defopt ) || in_array( $item['slug'], $this->netopt ) ) {
                    continue;
                }

                $item['slug'] = 'options-'. $item['slug']; 
                $menu[$key] = $item;
            }

            return $menu;
        }


        public function menu() {

            if ( ! empty( $this->create ) ) {
                foreach( $this->create as $option ) {
                    $this->create( $option );
                }
            }

            if ( ! empty( $this->change ) ) {
                
            }

            if ( ! empty( $this->remove ) ) {
                
            }
        }


    /***  CREATE */

        private function create( array $option ) {

            // nets level
            if ( is_network_admin() && in_array( $option['slug'], $this->netopt )  ){
                $this->create_form( $option['field'] );
            } 
            else if ( is_network_admin() ){
                $this->create_page( $option );
            }

            // site level
            if ( ! is_network_admin() && in_array( $option['slug'], $this->defopt )  ){
                $this->create_form( $option['field'] );
            } 
            else if ( ! is_network_admin() ){
                $this->create_page( $option );
            }
        }



        private function create_page( array $option ) {

            $title = $option['name'];
            $menu  = $option['name'];
            $caps  = $option['caps'];
            $slug  = 'options-' . $option['slug'];
            $call  = array( $this, 'render_page' );
            $order = $option['order'];

            add_options_page( $title, $menu, $caps, $slug, $call, $order );
        }


        public function render_page() {

        }


        private function create_form( string $field_id ) {

        }


    /***  CHANGE */

        private function change() {
                
        }


    /***  REMOVE */

        private function remove() {
                    
        }


    /***  LAYOUT */

        private function option_menu() {

        }

        private function option_head() {
            
        }

        private function option_side() {
            
        }



    /***  HELPER */

        private function helper() {

        }

    }
}


/**
 * reference
 * https://rudrastyh.com/wordpress-multisite/options-pages.html
 */
