<?php


if ( ! class_exists( 'rozard_former' ) ) {

    class rozard_former{


    /** DATUMS */

        
        private array $form;



    /** RUNITS */


        public function __construct() {
            $this->bios();
        }


        private function bios() {

            // define constanta
            define( 'rozard_former', __DIR__ . '/' );
            define( 'former_blocks', rozard_former . 'blocks/' );
            define( 'former_object', rozard_former . 'object/' );

            // assitance module
            require_once rozard . 'auxile/_init.php';

            // load field module
            require_once former_blocks . 'helper.php';
            require_once former_blocks . 'fields.php';

            $this->boot();
        }
    

        private function boot() {


            $help = array();
            $libs = array( 'upload.php', 'media-new.php', 'admin-ajax' );
            $mbox = array( 'post-new.php', 'post.php', 'admin-ajax' );
            $sign = array( 'wp-signup.php' );
            $site = array( 'site-info.php', 'site-settings.php' );
            $conf = array( 'options', 'admin-ajax' );
            $page = array( 'admin.php', '?page=', 'admin-ajax' );
            $term = array( 'term.php', 'edit-tags.php', 'admin-ajax' );
            $user = array( 'profile.php', 'user-edit.php', 'admin-ajax' );


            if ( has_filter( 'add_form' ) ) {
              

                $form = apply_filters( 'add_form', $help );


                if ( ! empty( $form['media'] ) && uris_has( $libs ) ) {
                    $this->form = $this->data( $form['media'] );
                    add_action( 'admin_init', array( $this, 'libs') );
                }


                else if ( ! empty( $form['metabox'] ) && uris_has( $mbox ) ) {
                    $this->form = $this->data( $form['metabox'] );
                    add_action( 'current_screen', array( $this, 'mbox') );
                }


                else if ( ! empty( $form['signup'] ) && uris_has( $sign ) ) {
                    $this->form = $this->data( $form['signup'] );
                    add_action( 'init', array( $this, 'sign') );
                }
                

                else if ( ! empty( $form['site'] ) && uris_has( $site ) )  {
                    $this->form = $this->data( $form['site'] );
                    add_action( 'admin_init', array( $this, 'site') );
                }


                else if ( ! empty( $form['config'] ) && uris_has( $conf ) ) {
                    $this->form = $this->data( $form['config'] );
                    add_action( 'admin_init', array( $this, 'conf') );
                }


                else if ( ! empty( $form['page'] ) && uris_has( $page ) )  {
                    $this->form = $this->data( $form['page'] );
                    $this->boot();
                }


                else if ( ! empty( $form['term'] ) && uris_has( $term ) )  {
                    $this->form = $this->data( $form['term'] );
                    add_action( 'admin_init', array( $this, 'term') );
                }


                else if ( ! empty ( $form['user'] ) && uris_has( $user ) ) {
                    $this->form = $this->data( $form['user'] );
                    add_action( 'admin_init', array( $this, 'user') );
                }
            } 
        }


        private function data( $data ) {
        
            $result = array();
    
            foreach( $data as $key => $form ) {
    
                $unique = $form['filter'];
                
                if ( $form['filter'] === $unique ) {
                    
                    // forms
                    $form_id =  str_slug( $key );
    
                  
                    $result[ $unique ]['render'][$form_id]['filter']  =  $form['filter'] ;
                    $result[ $unique ]['render'][$form_id]['title']   =  $form['title'] ;
                    $result[ $unique ]['render'][$form_id]['access']  =  $form['access'] ;
                    $result[ $unique ]['render'][$form_id]['datums']  =  $form['datums'] ;
                    $result[ $unique ]['render'][$form_id]['context'] =  $form['context'] ;
                    $result[ $unique ]['render'][$form_id]['layout']  =  $form['layout'] ;
    
                  
                    // section
                    foreach( $form['section'] as $key => $section ) {
    
                        // render prepare field
                        $sect_id =  str_slug( $key );
    
                        $result[$unique]['render'][$form_id]['section'][$sect_id]['name']   =  $section['name'];
                        $result[$unique]['render'][$form_id]['section'][$sect_id]['descs']  =  $section['descs'];
                        $result[$unique]['render'][$form_id]['section'][$sect_id]['icons']  =  $section['icons'];
                        $result[$unique]['render'][$form_id]['section'][$sect_id]['access'] =  $section['access'];
                        $result[$unique]['render'][$form_id]['section'][$sect_id]['event']  =  $section['event'];
                        
    
                        // unset section
                        unset($form['section'][$key] );
    
    
                        // fields
                        foreach ( $section['fields'] as $field_id => $field ) {
    
                            // assign field unique - add underscore to hide this meta from default custom field
    
                            $field_key = str_slug( $form_id.'-'.$field_id );
    
                            // render prepare field
                            $result[ $unique ]['render'][$form_id]['section'][$sect_id]['fields'][$field_key] = $field;
                            $result[ $unique ]['render'][$form_id]['section'][$sect_id]['fields'][$field_key]['unique'] = $field_key;
    
    
                            // saving prepare field
                            $result[ $unique ]['saving'][ $field_key] = $field;
                            $result[ $unique ]['saving'][ $field_key]['unique'] = $field_key;
                        }
                    }
                }
            }
            return $result;
        }



    /** METHOD */


        // media
        public function libs() {
            require_once former_object . 'libs.php';
            if ( ! empty( $this->data )) {
                new rozard_former_media( $this->data );
            }
        }


        // metabox
        public function mbox( $screen ) {
            require_once former_object . 'mbox.php';
            if ( ! empty( $this->form[ $screen->post_type ] ) ) {
                new rozard_former_metabox( $this->form[ $screen->post_type ] );
            }
        }


        // term
        public function term() {
            require_once former_object . 'term.php';
            foreach( $this->form as $key => $form ) {
                new rozard_former_taxonomy( $key, $form );
            }
        }


        // site
        public function site() {
            require_once former_object . 'site.php';
            foreach( $this->form as $key => $form ) {
                new rozard_former_sites( $form );
            }
        }

      
        // user
        public function user() {
            require_once former_object . 'user.php';
            foreach( $this->form as $key => $form ) {
                new rozard_former_user( $form );
            }
        }


        // sign
        public function sign() {
            require_once former_object . 'sign.php';
            foreach( $this->form as $key => $form ) {
                new rozard_former_signup( $form );
            }
        }


        // conf
        public function conf() {
            require_once former_object . 'conf.php';
            foreach( $this->form as $key => $form ) {
                new rozard_former_config( $form );
            }
        }
    }
    add_action('plugins_loaded', function(){ new rozard_former; } );
}