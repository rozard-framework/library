<?php

if ( ! class_exists('terms') ) {

    class terms extends cores{

        // method
        protected $fields;
        protected $metabox;

        // term property
        protected $keyid;
        protected $terms;
        


        // field property
        protected $field;


        public function init() {

          $this->fields  = new fields;
          $this->metabox = new metabox;

        }



        public function add( $data = array() ) {
         
            $this->terms = $data;
            add_action('init', array( $this, 'register' ) , 99, 1 );
                
        } 



        public function register() {

            foreach( $this->terms as $term ) {

                // slugs
                $slugs  = $this->str_keys( $term['cores']['name']);

                // base data
                $single = $term['cores']['name'];
                $plural = $this->str_plural( $single );
                
                // prefix
                $single_prefix = $this->str_keys( $slugs );
                $plural_prefix = $this->str_keys( $plural ) ;

                $labels = array(
                    'name'              => _x( $plural, 'taxonomy general name' ),
                    'singular_name'     => _x( $single, 'taxonomy singular name' ),
                    'search_items'      => __( 'Search '. $plural ),
                    'all_items'         => __( 'All '. $plural ),
                    'parent_item'       => __( 'Parent '. $single ),
                    'parent_item_colon' => __( 'Parent '.  $single ),
                    'edit_item'         => __( 'Edit '.  $single ),
                    'update_item'       => __( 'Update '.  $single ),
                    'add_new_item'      => __( 'Add New '.  $single ),
                    'new_item_name'     => __( 'New '.  $single .' Name' ),
                    'menu_name'         => __(  $single ),
                );
        
                $user_arg = array();


                $core_arg = array(
                    'labels'            => $labels,
                    'description'       => '',
                    'public'            => true,
                    'hierarchical'      => $term['cores']['hierarchy'], // make it hierarchical (like categories)
                    'show_ui'           => true,
                    'show_in_menu'      => $term['cores']['menu'],
                    'show_in_nav_menus' => true,
                    'show_admin_column' => $term['cores']['column'],
                    'show_in_rest'      => $term['cores']['rest'],
                    'rewrite'           => [ 'slug' => $slugs ],
                    'default_term'      => [],
                );

                // $args =  array_merge( $core_arg, $user_arg );


                // assign taxonomy to post
                register_taxonomy( $slugs , $term['cores']['post'] , $core_arg );

                // register builtin terms
                // $this->builtin( $term );
            }



        }


        // create builtin terms and fields
        private function builtin( $term ) {



            $taxonomy_name = $this->str_keys( $term['cores']['name']);
            $builtin_terms = $term['extras']['builtin'];
            $builtin_field = $term['extras']['fields'];



            // field method
            if ( ! empty( $builtin_field ) ||  $builtin_field !== null ){
                $term_field = [
                    'taxonomy' => $taxonomy_name,
                    'fields'   => $builtin_field,
                ];
                $this->fields( $term_field );
            }

        }

        public function fields( $data = array()  ) {

            $this->field   = $data['fields'];
            $taxonomy_name = $this->str_keys( $data['taxonomy'] );

            // field init
            add_action( $taxonomy_name  .'_add_form_fields', [ $this, 'field_add'], 10, 2 );
            add_action( $taxonomy_name  .'_edit_form_fields', [ $this, 'field_edit'], 10, 2 );
            add_action( 'created_'. $taxonomy_name  , [ $this, 'field_save' ] );
            add_action( 'edited_'. $taxonomy_name  , [ $this, 'field_save' ] );
        }


        public function field_add( $taxonomy ) {

            // nonce declarations
            wp_nonce_field( basename( __FILE__ ), 'rozard_terms_nonce' );

            // render field
            $this->fields->create( $this->field );

        }


        public function field_edit( $term, $taxonomy ) {

            // declare fields
            $edit_field = $this->field;

            
            // nonce declarations
            wp_nonce_field( basename( __FILE__ ), 'rozard_terms_nonce' );


            // prepare field data
            foreach ( $edit_field as $key => &$field ) 
            {
                // get field value
                $get_term_meta = get_term_meta( $term->term_id, $field['cores']['keys'], true  );
                $field['cores']['value'] = $get_term_meta;
               
                // render field as table 
                $field['display']['render'] = 'table'; 
            }


            // render field
            $this->fields->create( $edit_field );
        }


        public function field_save( $term_id ) {

            // declare fields
            $save_field = $this->field;


            // nonce check
            if ( !isset( $_POST['rozard_terms_nonce'] ) || !wp_verify_nonce( $_POST['rozard_terms_nonce'], basename( __FILE__ ) ) ){
                return false;
            }


            // save value to database
            foreach ( $save_field as $field ) 
            {
                $set_term_meta = $this->sanitize_field( $field['type'], $_POST[ $field['cores']['keys'] ] );
                update_term_meta( $term_id, $field['cores']['keys'], $set_term_meta );
            }
       }
    }
}

$rozard_term = new terms;
$rozard_term->init();


// function new_term ( $data ) {

   // $rozard_term = new terms;
   // $rozard_term->add( $data );
// }

