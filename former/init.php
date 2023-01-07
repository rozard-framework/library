<?php


if ( ! class_exists( 'rozard_form' ) ) {

    class rozard_form{


    /** DATUMS */


        private $data;
        private $libs;
        private $meta;
        private $regs;
        private $rdbs;
        private $sets;
        private $term;
        private $user;
     
        

    /** RUNITS */


        public function __construct() {
            $this->defs();
        }


        private function defs() {

            // define constanta
            define( 'rozard_former', __DIR__ . '/' );
            define( 'former_blocks', rozard_former . 'blocks/' );
            define( 'former_object', rozard_former . 'object/' );
            define( 'former_render', rozard_former . 'render/' );


            // load field module
            require_once former_blocks . 'helper.php';
            require_once former_render . 'render.php';

            $this->bios();
        }
    
    

    /** METHOD */
    

        private function bios() {
          

            $prep = new rozard_former_helper;

            if ( has_filter( 'build_form' ) ) {

                $help = array();
                $form = apply_filters( 'build_form', $help );


                if ( ! empty ( $form['core'] )  ) {
                    $this->rdbs = $form['core'];
                }

                if ( ! empty ( $form['media'] )  ) {
                    $this->libs = $prep->data( $form['media'] );
                }

                if ( ! empty ( $form['metabox'] ) && ( uris_has( array( 'post-new.php', 'post.php', 'admin-ajax.php' )) ) ) {
                    $this->meta = $prep->data( $form['metabox'] );
                }

                if ( ! empty ( $form['signup'] )  ) {
                    $this->regs = $form['signup'];
                }

                if ( ! empty ( $form['option'] )  ) {
                    $this->sets = $form['option'];
                }

                if ( ! empty ( $form['term'] ) && ( uris_has( array( 'term.php', 'edit-tags.php', 'admin-ajax.php' )) ) ) {
                    $this->term = $prep->data( $form['term'] );
                }

                if ( ! empty ( $form['user'] )  ) {
                    $this->user = $form['user'];
                }

                $this->boot();
                return;
            } 
        }


        private function boot() {

            if ( ! empty ( $this->term ) ) {
                add_action( 'admin_init', array( $this, 'term') );
            }

            if ( ! empty ( $this->meta ) ) {
                add_action( 'current_screen', array( $this, 'meta') );
            }


            if ( ! empty ( $this->libs ) ) {
                add_action( 'admin_init', array( $this, 'libs') );
            }
         
        }



    /** OBJECT */


        public function libs() {
            require_once former_object . 'media.php';
            new rozard_former_media( $this->libs['media'] );
        }


        public function meta( $screen ) {
            require_once former_object . 'metabox.php';
            new rozard_former_metabox( $this->meta[ $screen->post_type ] );
        }


        public function term() {
            require_once former_object . 'term.php';

       
         
            foreach( $this->term as $key => $form ) {
                new rozard_former_taxonomy( $key, $form );
            }
        }
    }

    add_action('init', function(){ new rozard_form; }, 20 );
}