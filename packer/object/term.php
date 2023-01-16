<?php


if ( ! class_exists( 'rozard_build_custom_term' ) ) {
    
    
    class rozard_build_custom_term{


    /** RUNITS */


        public function __construct( array $data ) {
            $this->load( $data );
        }
    
    
        private function load( $data ) {
           
            foreach( $data as $term ) {

                // main method 
                $this->core( $term );

                // add antoher method here
            }
        }



    /** METHOD */


        // core method
        private function core( array $term ) {

            // slugs
            $slug   = str_keys( $term['label'] );

            // builds
            $build  = $this->core_arg( $term );

            // object
            $object = $term['context'];
        
            // register taxonomy
            register_taxonomy( $slug , $object , $build );
        }


        private function core_arg( array $term ) {

            // slugs
            $slug   = str_keys( $term['label'] );

            // labels
            $label = $this->core_lab( $term );

            // hirarchy
            $hirarchy = ( empty( $term['order'] ) || $term['order'] !== true  ) ? false : true ;

            // default term
            $defaults = ( ! empty( $term['extras'] ) && ! empty( $term['extras']['default'] )) ? $term['extras']['default'] : '' ;


            // arguments
            if ( $term['operate'] === 'system' ) {

                // operate as system module 
                $args = array(
                    'labels'                => $label,
                    'show_ui'               => false,
                    'rewrite'               => array( 'slug' => $slug ),
                    'query_var'             => false,
                    'hierarchical'          => $hirarchy,
                    'show_in_rest'          => false,
                    'show_admin_column'     => false,
                    'default_term'          => $defaults,
                    'update_count_callback' => '_update_post_term_count',
                );
            }
            else if( $term['operate'] === 'manage' ){

                // operate as backend module
                $args = array(
                    'labels'                => $label,
                    'show_ui'               => true,
                    'rewrite'               => array( 'slug' => $slug ),
                    'query_var'             => true,
                    'hierarchical'          => $hirarchy,
                    'show_in_rest'          => false,
                    'show_admin_column'     => false,
                    'default_term'          => $defaults,
                    'update_count_callback' => '_update_post_term_count',
                );
            }
            else {

                // operate as public module
                $args = array(
                    'labels'                => $label,
                    'show_ui'               => true,
                    'rewrite'               => array( 'slug' => $slug ),
                    'query_var'             => true,
                    'hierarchical'          => $hirarchy,
                    'show_in_rest'          => true,
                    'show_admin_column'     => true,
                    'default_term'          => $defaults,
                    'update_count_callback' => '_update_post_term_count',
                );
            }
              
            return $args;
        }


        private function core_lab( array $term ) {
            
            $single = str_text( $term['label'] );
            $plural = str_plural( $term['label'] );

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
    }
}