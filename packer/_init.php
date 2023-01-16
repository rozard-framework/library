<?php


if ( ! class_exists( 'rozard_object_builer' ) ) {

    class rozard_object_builer{

    
    /** DATUMS */
      

    /** RUNITS */
    
        public function __construct() {
            $this->defs();
        }
    
    
        private function defs() {
    
            // define constanta
            define( 'rozard_packer', __DIR__ . '/' );
            define( 'packer_helper', rozard_packer . 'helper/' );
            define( 'packer_object', rozard_packer . 'object/' );
            define( 'packer_widget', rozard_packer . 'widget/' );
           


            // initialize hook
            $this->dreg();
            $this->regs();
        }
    

    /** REMOVE */
    
        private function dreg() {
         
            if ( has_filter( 'clean_object' ) ) {

                $helper = array();
                $remove = apply_filters( 'clean_object', $helper );

                if ( ! empty( $remove )  && is_admin() ) {
                    require_once packer_helper . 'remover.php';
                    new rozard_core_object_remover( $remove );
                }

                return;
            }
        }



    /** CREATE */


        private function regs() {

            if ( has_filter( 'build_object' ) ) {
    
                $helper = array();
                $builds = apply_filters( 'build_object', $helper );

                
                if ( ! empty ( $builds['page'] )  ) {
                    require_once packer_object . 'page.php';
                    new rozard_build_custom_page( $builds['page'] );
                }

                if ( ! empty ( $builds['post'] )  ) {
                    require_once packer_object . 'post.php';
                    new rozard_build_custom_post( $builds['post'] );
                }

                if ( ! empty ( $builds['term'] )  ) {
                    require_once packer_object . 'term.php';
                    new rozard_build_custom_term( $builds['term'] );
                }

                if ( ! empty ( $builds['tool'] )  ) {
                    require_once packer_object . 'tool.php';
                    new rozard_build_custom_tool( $builds['tool'] );
                }


                if ( ! empty ( $builds['misc'] )  ) {
                    require_once packer_object . 'misc.php';
                    new rozard_build_miscellaneous( $builds['misc'] );
                }
    
                return;
            }
        }
    }
    add_action('init', function(){ new rozard_object_builer; }, 20 );
}