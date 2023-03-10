<?php

if ( ! class_exists( 'builder_object_assets' ) ){


    class builder_object_assets{


        use rozard_builder_helper;


    /***  DATUMS  */


        private array $create;
        private array $change;
        private array $remove;

            
    
    /***  RUNITS  */     


        public function __construct( array $data ) {

            if ( ! empty( $data ) && is_array( $data ) ) {
                $this->load( $data );
            }
        }

        
        private function load( array $data ) {

            $datums = $this->data_modes( $data );
            $this->create = $datums[0];
            $this->change = $datums[1];
            $this->remove = $datums[2];

            unset( $data );
            $this->hook();
        }


        private function hook() {

            if ( ! empty( $this->create ) ) {
                add_action( 'admin_enqueue_scripts', array( $this, 'make' ) );
                add_filter( 'script_loader_tag',     array( $this, 'mods' ), 10, 3);
            }
        }


        public function make( $page ) {

            foreach( $this->create as $script ) {

                if ( empty ( $script['slug'] ) && ! usr_can( $script['caps'] ) ) {
                    continue;
                }

                if ( $script['type'] === 'css' && ( $script['slug'] === $page || $script['slug'] === 'admin' ) ) {
                   
                    wp_enqueue_style( $script['name'], $script['link'], false, rozard_version, 'all' );
                    continue;
                }
                
                if ( $script['type'] === 'jsx' && ( $script['slug'] === $page || $script['slug'] === 'admin' ) ) {

                    wp_enqueue_script( $script['name'], $script['link'], false, rozard_version, true  );
                    continue;
                }
            }
        }


        public function mods( $tag, $handle, $src ) {

            foreach( $this->create as $script ) {

                if ( $script['type'] === 'jsx' && $script['name'] === $handle && usr_can( $script['caps'] ) ) {

                    $tag = '<script type="module" src="' . esc_url($src) . '" defer></script>';
                }
            }
            
            return $tag;
        }
    }
}