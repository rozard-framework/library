<?php


if ( ! class_exists( 'rozard_build_custom_post' ) ) {
    class rozard_build_custom_post{


    /** RUNITS */

        public function __construct( array $data ) {
            $this->load( $data );
        }
    
    
        private function load( $data ) {
           
            foreach( $data as $post ) {

                // main method 
                $this->core( $post );

                // add antoher method here
            }
        }
    
    
    /** METHOD */
    

        // core method
        private function core( $post ) {
    
            // slug
            $slug = str_keys( $post['label'] );
    
        
    
            // builds
            $build = $this->core_arg( $post );
    
    
            register_post_type( $slug, $build );
        }


        private function core_arg( array $post ) {
    

            $single = str_text( $post['label'] );
            $slug   = str_keys( $post['label'] );
    

            // labels
            $label = $this->core_lab( $post );
            

            // description
            $desc =  ( ! empty( $post['descr'] ) ) ? pure_text( $post['descr'] ) : $single .' format. ' ;
    
    
            // support
            $default_support  = array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' );
            $support = ( ! empty( $post['feature'] ) ) ? $post['feature'] : $default_support;
    
   
            // capability 
            $capability = ( ! empty( $post['access'] ) ) ? $post['access'] : 'post';
    
    
            // hirarchy
            $hirarchy = ( empty( $post['order'] ) || $post['order'] !== true  ) ? false : true ;
    
    
            // arguments
            if ( $post['operate'] === 'system' ) {
    
                // arguments for system mode
                $args = array(
                    'label'               => __( $slug , 'rozard_framework' ),
                    'description'         => __( $desc , 'rozard_framework' ),
                    'labels'              => $label,
                    'supports'            => $support,
                    'taxonomies'          => array(),
                    'hierarchical'        => $hirarchy,
                    'public'              => false,
                    'show_ui'             => false,
                    'show_in_menu'        => true,
                    'show_in_nav_menus'   => false,
                    'show_in_admin_bar'   => false,
                    'menu_position'       => 5,
                    'can_export'          => false,
                    'has_archive'         => false,
                    'exclude_from_search' => true,
                    'publicly_queryable'  => false,
                    'capability_type'     => $capability,
                    'query_var'           => false,
                    'show_in_rest'        => false,
                );
            }
            else if ( $post['operate'] === 'manage' ) {
                
                // arguments for manage mode a.k.a backend

                $args = array(
                    'label'               => __( $slug , 'rozard_framework' ),
                    'description'         => __( $desc , 'rozard_framework' ),
                    'labels'              => $label,
                    'supports'            => $support,
                    'taxonomies'          => array(),
                    'hierarchical'        => $hirarchy,
                    'public'              => false,
                    'show_ui'             => true,
                    'show_in_menu'        => true,
                    'show_in_nav_menus'   => true,
                    'show_in_admin_bar'   => false,
                    'menu_position'       => 5,
                    'can_export'          => true,
                    'has_archive'         => true,
                    'exclude_from_search' => false,
                    'publicly_queryable'  => false,
                    'capability_type'     => $capability,
                    'show_in_rest'        => false,
                );
            }
            else {
                
                // arguments for public mode
    
                $args = array(
                    'label'               => __( $slug , 'rozard_framework' ),
                    'description'         => __( $desc , 'rozard_framework' ),
                    'labels'              => $label,
                    'supports'            => $support,
                    'taxonomies'          => array(),
                    'hierarchical'        => $hirarchy,
                    'public'              => true,
                    'show_ui'             => true,
                    'show_in_menu'        => true,
                    'show_in_nav_menus'   => true,
                    'show_in_admin_bar'   => true,
                    'menu_position'       => 5,
                    'can_export'          => true,
                    'has_archive'         => true,
                    'exclude_from_search' => false,
                    'publicly_queryable'  => true,
                    'capability_type'     => $capability,
                    'show_in_rest'        => false,
                );
            }
    
            return  $args;
        }
    
    
        private function core_lab( array $post ) {
    
    
            $single = str_text( $post['label'] );
            $plural = str_plural( $post['label'] );
    
    
            // Set UI labels for Custom Post Type
            $labels = array(
                'name'                => _x( $plural, 'Post Type General Name', 'rozard_framework' ),
                'singular_name'       => _x( 'Movie', 'Post Type Singular Name', 'rozard_framework' ),
                'menu_name'           => __( $plural, 'rozard_framework' ),
                'parent_item_colon'   => __( 'Parent '. $plural, 'rozard_framework' ),
                'all_items'           => __( 'All '. $plural, 'rozard_framework' ),
                'view_item'           => __( 'View '. $single, 'rozard_framework' ),
                'add_new_item'        => __( 'Add New '. $single, 'rozard_framework' ),
                'add_new'             => __( 'Add New', 'rozard_framework' ),
                'edit_item'           => __( 'Edit '. $single, 'rozard_framework' ),
                'update_item'         => __( 'Update '. $single, 'rozard_framework' ),
                'search_items'        => __( 'Search '. $single, 'rozard_framework' ),
                'not_found'           => __( 'Not Found', 'rozard_framework' ),
                'not_found_in_trash'  => __( 'Not found in bin', 'rozard_framework' ),
            );
    
            return $labels;
        }
    

        // add antoher method here
    }
}

