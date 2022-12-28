<?php

if ( ! class_exists('metabox') ) {


    class metabox extends cores {

        // method
        protected $fields;

        // data
        protected $metabox;


        public function __construct() {

            $this->fields = new fields;

        }


        public function create( $data = array() ) {

            $this->metabox = $data;

            add_action( 'admin_menu', [$this, 'register' ], 2000 );
            add_action( 'save_post', [ $this, 'save_data' ] ); 

        }


        public function register() {

            $datas = $this->metabox;

            foreach ( $datas as $data ) 
            {
                // validation data
                if ( function_exists( 'get_current_screen ') ) {
                    $get_screen = get_current_screen()->id;   // current screen id
                    $set_screen = $data['access']['screen'];  // field screen data
                }
                $set_links  = $data['access']['links'];   // field uri data 
                $set_caps   = $data['access']['caps'];    // field uri data 


                // level 1 - validate render using screen method
                if ( function_exists( 'get_current_screen ') ) {
                    if ( ! empty( $set_screen ) && ( $get_screen !== null  && $set_screen !== $get_screen ) ) {
                        // var_dump( $this->cores['label'] .' blocked at screen validation'); // debug
                        continue;
                    }
                }

                // level 2 - validate render using uri method
                if ( ! empty( $set_links ) && $this->is_admin_uri( $set_links ) === false ) {
                    // var_dump( $this->cores['label'] .' blocked at uri validation');    // debug
                    continue;
                }

                // level 3 - validate render using user capability method
                if ( ! empty( $set_caps ) && current_user_can( $set_caps ) === false ) {
                    // var_dump( $this->cores['label'] .' blocked at caps validation');   // debug
                    continue;
                }

                // register metabox
                $unique   = $data['cores']['id'];             // metabox ID
                $title    = $data['cores']['title'];          // metabox title
                $post     = $data['cores']['post'];           // metabox assigned post type
                $caps     = $data['access']['caps'];          // metabox capabilities 
                $position = $data['cores']['position'];       // metabox position  (normal, side, advanced)
                $priority = $data['cores']['priority'];       // metabox priority (default, low, high, core)

                add_meta_box( $unique, $title,  [ $this, 'edit_data'], $post, $position, $priority, $data['fields'] );
            }
        }


        public function edit_data( $post, $field ) {

                // init and assign value for custom field 
                $fields = $field['args'];


                // metabox nonce declarations
                wp_nonce_field( basename( __FILE__ ), 'rozard_metabox_nonce' );
    
                
                // check field is empty            
                if ( empty( $fields ) || $fields ==-null  ){
                    return;
                }
               
                // reasign value
                foreach ( $fields as &$field ) 
                {
                    $post_meta =  get_post_meta( $post->ID, $field['cores']['keys'], true ) ?? null ;
                    $field['cores']['value'] = $post_meta;
                }

                // render field
                $this->fields->create( $fields );
        }


        public function save_data( $post_id ) {


            // nonce check
            if ( !isset( $_POST['rozard_metabox_nonce'] ) || !wp_verify_nonce( $_POST['rozard_metabox_nonce'], basename( __FILE__ ) ) ){
                return;
            }

            // return if autosave
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            // check user capabilities
           
           
            // save metabox value
            $data = $this->metabox;

            foreach ( $data as $section ) 
            {
                if ( empty( $section['fields'] ) || $section['fields'] === null  ) {
                    continue;
                }

                foreach( $section['fields'] as $field ) 
                {
                    $value = $_POST[ $field['cores']['keys'] ]  ;

                    if ( isset( $value ) )
                    {
                        update_post_meta( $post_id, $field['cores']['keys'], $value );
                    }
                    else
                    {
                        delete_post_meta( $post_id, $field['cores']['keys'] );
                    }
                }
            }
        }
    }
}

/*
// taxonomy field method
                    if ( $field['type'] === 'taxo'  ) 
                    {
                        $taxonomy_slug   = $field['option']['taxonomy'];
                        $get_term_object = wp_get_object_terms( $post_id, $taxonomy_slug , array( 'fields' => 'ids' ) );
                        
                        if ( isset( $_POST[ $field['keys'] ] ) ) 
                        {
                            wp_set_post_terms( $post_id, $_POST[ $field['keys'] ], $taxonomy_slug, false );
                        } 
                        else 
                        {
                            wp_remove_object_terms(  $post_id, $get_term_object, $taxonomy_slug );
                        }
                    }
 * 
 * 
 */