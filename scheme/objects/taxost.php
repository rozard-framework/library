<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_scheme_object_term' ) ) {


    class rozard_scheme_object_term{


        use rozard_former_field;


        public function __construct() {
            $this->data();
        }


        public function data(){

            $this->data = apply_filters( 'register_scheme', array() );

            if ( ! isset( $this->data['object']['term'] ) ) {
                return;
            }

            $this->hook();
        }


        public function hook() {
            add_action( 'init',  array( $this, 'make' ), 99 );
            add_action( 'init',  array( $this, 'form' ), 100 );
        }


    /** MAKE */

        public function make() {

            foreach( $this->data['object']['term'] as $term ) {

                $named  =  str_keys( $term['keys'] );
                $setup  =  $term['hook'];
                $proto  =  $this->make_data( $term );
                register_taxonomy( $named , $setup , $proto );
            }
        }


        public function make_data( $term ) {

            // title
            $term['single'] = str_text( $term['name'] );
            $term['plural'] = str_plural( $term['single'] );


            // attrib
            $term['name']  =  str_text( $term['name'] );
            $term['slug']  =  str_slug( $term['keys'] );
            $term['desc']  =  ( ! empty( $term['desc'] ) ) ? pure_text( $term['desc'] ) : $single .' format. ' ;

            
            // labels
            $term['label'] = $this->make_info( $term );

        
            // hirarchy
            $hirarchy = ( empty( $term['level'] ) || $term['level'] !== true  ) ? false : true ;
            $term['hirarchy'] = $hirarchy;


            // register
            if ( $term['mode'] === 'app' ) {

                $result = $this->make_apps( $term );
            }
            else if ( $term['mode'] === 'sys' ) {

                $result = $this->make_syst( $term );
            }
            else if ( $term['mode'] === 'web' ) {

                $result = $this->make_webs( $term );
            }
    

            return $result;
        }


        public function make_info( $term ) {
            

            $single = $term['single'];
            $plural = $term['plural'];


            $labels = array(
                'name'                       => _x(  $plural, 'taxonomy general name' ),
                'singular_name'              => _x(  $single, 'taxonomy singular name' ),
                'search_items'               =>  __( $single .' Topics' ),
                'popular_items'              => __( 'Popular '. $plural ),
                'name_field_description'     => '',   
                'slug_field_description'     => '',   
                'filter_by_item'             => '',  
                'all_items'                  => __( 'All '. $plural ),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __( 'Edit '. $single ), 
                'update_item'                => __( 'Update '. $single ),
                'add_new_item'               => __( 'Add New '. $single ),
                'new_item_name'              => __( 'New '. $single .' Name' ),
                'separate_items_with_commas' => __( 'Separate '. $plural .' with commas' ),
                'add_or_remove_items'        => __( 'Add or remove '. $single ),
                'choose_from_most_used'      => __( 'Most used '. $plural ),
                'menu_name'                  => __( $plural ),
            );
    
            return $labels;
        }


        public function make_apps( $term ) {
            
            $name = $term['name'];
            $slug = $term['slug'];
            $labs = $term['label'];
            $buil = $term['built'];
            $levl = $term['hirarchy'];

            $result = array(
                        'labels'                => $labs,
                        'show_ui'               => true,
                        'rewrite'               => array( 'slug' => $slug ),
                        'query_var'             => true,
                        'public'                => true,
                        'show_ui'               => true,
                        'show_in_menu'          => false,
                        'show_in_rest'          => false,
                        'show_admin_column'     => false,
                        'hierarchical'          => $levl,
                        'default_term'          => $buil,
                        'update_count_callback' => '_update_post_term_count',
                    );

            return $result;
        }


        public function make_syst( $term ) {

            $name = $term['name'];
            $slug = $term['slug'];
            $labs = $term['label'];
            $buil = $term['built'];
            $levl = $term['hirarchy'];
            
            $result = array(
                        'labels'                => $labs,
                        'show_ui'               => false,
                        'rewrite'               => array( 'slug' => $slug ),
                        'query_var'             => false,
                        'public'                => true,
                        'show_ui'               => true,
                        'show_in_rest'          => false,
                        'show_in_menu'          => false,
                        'show_admin_column'     => false,
                        'hierarchical'          => $levl,
                        'default_term'          => $buil,
                        'update_count_callback' => '_update_post_term_count',
                    );

            return $result;
        }


        public function make_webs( $term ) {

            $name = $term['name'];
            $slug = $term['slug'];
            $labs = $term['label'];
            $buil = $term['built'];
            $levl = $term['hirarchy'];
            
            $result = array(
                        'labels'                => $labs,
                        'show_ui'               => true,
                        'rewrite'               => array( 'slug' => $slug ),
                        'query_var'             => true,
                        'public'                => true,
                        'show_ui'               => true,
                        'show_in_menu'          => false,
                        'show_in_rest'          => true,
                        'show_admin_column'     => false,
                        'hierarchical'          => $levl,
                        'default_term'          => $buil,
                        'update_count_callback' => '_update_post_term_count',
                    );

            return $result;
        }


    /** FORM */

    
        public function form() {

            if ( ! uris_has( array( 'edit-tags', 'admin-ajax' ) ) || empty( $_REQUEST['taxonomy'] ) ) {
                return;
            }

            // term form data
            $this->raws['form'] = $this->form_data();
            $hook = pure_text( $_REQUEST['taxonomy'] );

            // term form init
            add_action( $hook .'_add_form_fields',  array( $this, 'form_make' ) );
            add_action( $hook .'_edit_form_fields', array( $this, 'form_edit' ), 10, 2 );
            add_action( 'created_'. $hook,          array( $this, 'form_save' ), 10, 2 );
            add_action( 'edited_'. $hook,           array( $this, 'form_save' ), 10, 2 );
        }


        private function form_data() {

            $result = array();
            $filter = pure_text( $_REQUEST['taxonomy'] );

            foreach( $this->data['object']['term'] as $term ) {


                // validate data
                if ( empty( $term['form'] ) || $term['keys'] !== $filter ) {
                    continue;
                }
                
                if ( ! isset( $this->data['former'][$term['form']] ) || ! is_array( $this->data['former'][$term['form']] ) ) {
                    return;                
                }

                // validate caps
                if ( ! usr_can( $this->data['former'][$term['form']]['caps'] )  ) {
                    return;
                }


                // extracts form
                $form  = $this->data['former'][$term['form']];
                $name  = str_keys( $term['keys'] );


                foreach( $form['form'] as $key => $group ) {

                    $groupid = str_keys( $key );

                    foreach( $group['field'] as &$field ) {

                        $field['keys'] = str_keys( $groupid .'_'. $field['keys'] );
                        $field['taxo'] = str_keys( $name );
                        $result[] = $field;
                    }
                }
            }
       

            return $result;
        }


        public function form_make( $taxonomy ) {

            if ( ! isset( $this->raws['form'] ) ) {
                return;
            }


            foreach( $this->raws['form'] as $field ) {

                if ( $field['taxo'] !==  $taxonomy ) {
                    continue;
                }

                $field['value'] =  '';
                $render = $this->get_field( $field, 'single ');

                printf( '<div class="form-field %s">
                            <label for="%s">%s</label>
                            %s
                        </div>', 
                        esc_attr( $field['keys'] ),
                        esc_attr( $field['keys'] ), 
                        esc_html( $field['name'] ),
                        $render
                    );
            }
        }


        public function form_edit( $term, $taxonomy ) {
            
            $form = $this->raws['form'];

            foreach( $form as $field ) {

                if (  $field['taxo'] !==  $taxonomy ) {
                    continue;
                }

                $values = get_term_meta( $term->term_id, $field['keys'] , true );
                $field['value'] = ( ! empty( $values ) ) ? $values : '';
                $render = $this->get_field( $field, 'single ');

                printf( '<tr class="form-field">
                            <th class="row"><label for="%s">%s</label></th>
                            <td>%s</td>
                        </tr>',
                        esc_attr( $field['keys'] ), 
                        esc_html( $field['name'] ),
                        $render 
                    );
            }
        }


        public function form_save( $term_id, $tt_id ) {

            foreach( $this->raws['form'] as $field ) {

                if ( $field['taxo'] !== $_POST['taxonomy'] ) {
                    continue;
                }

                $unique = $field['keys'];
               
                if ( isset( $_POST[ $unique ] ) ) {

                    $values =  $this->pure_field( $field['type'], $_POST[ $unique ] ) ;
                    update_term_meta( $term_id, $unique, $values );
                }
                else {

                    delete_term_meta( $term_id, $unique );
                } 
            }
        }
    }
}