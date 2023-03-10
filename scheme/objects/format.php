<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_scheme_object_post' ) ) {


    class rozard_scheme_object_post{


        private $raws;


        public function __construct() {
            $this->data();
        }


        public function data(){
            
            $this->data = apply_filters( 'register_scheme', array() );

            if ( ! isset( $this->data['object']['post'] ) ) {
                return;
            }

            $this->hook();
        }


        public function hook() {
            add_action( 'init',                      array( $this, 'make' ), 10 );
            add_action( 'admin_menu',                array( $this, 'menu' ), 10 );
            add_filter( 'body_class',                array( $this, 'body' ), 10 );
            add_filter( 'excerpt_more',              array( $this, 'more' ), 10 );
            add_filter( 'excerpt_length',            array( $this, 'leed' ), 10 );
            add_action( 'after_setup_theme',         array( $this, 'mods' ), 10 );
            add_filter( 'use_block_editor_for_post', array( $this, 'edit' ), 10, 2);
        }


        public function body( $body ) {

            foreach( $this->data['object']['post'] as $post ) {
            
                $slug = str_slug( $post['keys'] );

                if ( is_singular( $slug ) || is_post_type_archive( $slug ) ) {
                    $body .= ' rozard-' .$slug .' ' ;
                }
            }


            if ( is_admin() || is_network_admin() ) {
                $body .= ' net-insg';
                $body .= ' wp-build';
                $body .= ' no-title';
            }
            
            return $body;
        }


        public function make() {

            foreach( $this->data['object']['post'] as $post ) {

                $named = str_slug( $post['node'] .'-'. $post['keys'] );
                $model = $this->make_data( $post );
                register_post_type( $named, $model );
            }
        }


        private function make_data( $post ) {
         
            // title
            $post['single'] = str_text( $post['name'] );
            $post['plural'] = str_plural( $post['single'] );
       

            // attrib
            $post['name']  =  str_text( $post['name'] );
            $post['slug']  =  str_slug( $post['name'] );
            $post['desc']  =  ( ! empty( $post['desc'] ) ) ? pure_text( $post['desc'] ) : $single .' format. ' ;


            // labels
            $post['label'] = $this->make_info( $post );

            // icons
            $post['icon'] = ( ! empty( $post['icon'] ) ) ? str_slug( $post['icon'] ) : 'dashicons-edit' ;

       
            // support
            $mods  = array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' );
            $post['modul'] = ( ! empty( $post['modul'] ) ) ? $post['modul'] : $mods;


            // capability 
            $caps  = ( ! empty( $post['caps'] ) ) ? $post['caps'] : 'post';
            $post['caps'] = $caps;


            // hirarchy
            $hirarchy = ( empty( $post['level'] ) || $post['level'] !== true  ) ? false : true ;
            $post['hirarchy'] = $hirarchy;


            // register
            if ( $post['mode'] === 'app' ) {

                $result = $this->make_apps( $post );
            }
            else if ( $post['mode'] === 'sys' ) {

                $result = $this->make_syst( $post );
            }
            else if ( $post['mode'] === 'web' ) {

                $result = $this->make_webs( $post );
            }

            return $result;

        }
        

        private function make_info( $post ) {

            $single = str_text( $post['single'] );
            $plural = str_text( $post['plural'] );
            $groups = ucwords( str_text( $post['node'] ) );

            $labels = array(
                'name'                     => __( $plural, 'rozard_framework' ),
                'singular_name'            => __( $single, 'rozard_framework' ),
                'add_new'                  => __( 'Add New', 'rozard_framework' ),
                'add_new_item'             => __( 'Add New '. $single, 'rozard_framework' ),
                'edit_item'                => __( 'Edit '. $single, 'rozard_framework' ),
                'new_item'                 => __( 'New '. $single, 'rozard_framework' ),
                'view_item'                => __( 'View '. $single, 'rozard_framework' ),
                'view_items'               => __( 'View '. $plural, 'rozard_framework' ),
                'search_items'             => __( 'Search '. $plural, 'rozard_framework' ),
                'not_found'                => __( 'No '. $plural .' found.', 'rozard_framework' ),
                'not_found_in_trash'       => __( 'No '. $plural. ' found in Trash.', 'rozard_framework' ),
                'parent_item_colon'        => __( 'Parent '. $plural .':', 'rozard_framework' ),
                'all_items'                => __( 'Container' , 'rozard_framework' ),
                'attributes'               => __( $single .' Attributes', 'rozard_framework' ),
                'insert_into_item'         => __( 'Insert into '. $single, 'rozard_framework' ),
                'uploaded_to_this_item'    => __( 'Uploaded to this '. $single, 'rozard_framework' ),
                'featured_image'           => __( 'Featured Image', 'rozard_framework' ),
                'set_featured_image'       => __( 'Set featured', 'rozard_framework' ),
                'remove_featured_image'    => __( 'Remove featured', 'rozard_framework' ),
                'use_featured_image'       => __( 'Use as featured', 'rozard_framework' ),
                'menu_name'                => __( $groups, 'rozard_framework' ),
                'filter_items_list'        => __( 'Filter '. $single .' list', 'rozard_framework' ),
                'filter_by_date'           => __( 'Filter by date', 'rozard_framework' ),
                'items_list_navigation'    => __( $plural .'list navigation', 'rozard_framework' ),
                'items_list'               => __( $plural .' list', 'rozard_framework' ),
                'item_published'           => __( $single .' published.', 'rozard_framework' ),
                'item_published_privately' => __( $single .' published privately.', 'rozard_framework' ),
                'item_reverted_to_draft'   => __( $single .' reverted to draft.', 'rozard_framework' ),
                'item_scheduled'           => __( $single .' scheduled.', 'rozard_framework' ),
                'item_updated'             => __( $single .' updated.', 'rozard_framework' ),
                'item_link'                => __( $single .' Link', 'rozard_framework' ),
                'item_link_description'    => __( 'A link to an '. $single .'.', 'rozard_framework' ),
            );

            return $labels;
        }


        private function make_apps( $post ) {

            $name = $post['name'];
            $icon = $post['icon'];
            $desc = $post['desc'];
            $slug = $post['slug'];
            $labs = $post['label'];
            $mods = $post['modul'];
            $levl = $post['hirarchy'];
            $caps = $post['caps'];
            $navs = ( $post['type'] === 'single' ) ? false : $post['menu'] ;


            // arguments for manage mode a.k.a backend
            $result = array(
                'label'                 => __( $name , 'rozard_framework' ),
                'description'           => __( $desc , 'rozard_framework' ),
                'labels'                => $labs,
                'public'                => true,
                'hierarchical'          => $levl,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'show_ui'               => true,
                'show_in_menu'          => $navs,
                'show_in_nav_menus'     => true,
                'show_in_admin_bar'     => false,
                'show_in_rest'          => false,
                'menu_position'         => 4,
                'menu_icon'             => $icon,
                'capability_type'       => $caps,
                'capabilities'          => array(),
                'supports'              => $mods,
                'taxonomies'            => array(),
                'has_archive'           => true,
                'rewrite'               => array( 'slug' => $slug ),
                'query_var'             => true,
                'can_export'            => false,
                'delete_with_user'      => false,
                'template'              => array(),
                'template_lock'         => false,
            );

            return $result;
            
        }


        private function make_syst( $post ) {

            $name = $post['name'];
            $icon = $post['icon'];
            $desc = $post['desc'];
            $slug = $post['slug'];
            $labs = $post['label'];
            $mods = $post['modul'];
            $levl = $post['hirarchy'];
            $caps = $post['caps'];
            $navs = ( $post['node'] === 'website' ) ? false : $post['menu'] ;


            $result = array(
                'label'                 => __( $name , 'rozard_framework' ),
                'description'           => __( $desc , 'rozard_framework' ),
                'labels'                => $labs,
                'hierarchical'          => $levl,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'public'                => false,
                'show_ui'               => false,
                'show_in_rest'          => $navs,
                'show_in_menu'          => true,
                'show_in_nav_menus'     => false,
                'show_in_admin_bar'     => false,
                'menu_position'         => 4,
                'menu_icon'             => $icon,
                'capability_type'       => $caps,
                'capabilities'          => array(),
                'supports'              => $mods,
                'taxonomies'            => array(),
                'has_archive'           => true,
                'rewrite'               => array( 'slug' => 'event' ),
                'query_var'             => true,
                'can_export'            => true,
                'delete_with_user'      => false,
                'template'              => array(),
                'template_lock'         => false,
            );

            return $result;
        }


        private function make_webs( $post ) {
            
            $name = $post['name'];
            $icon = $post['icon'];
            $desc = $post['desc'];
            $slug = $post['slug'];
            $labs = $post['label'];
            $mods = $post['modul'];
            $levl = $post['hirarchy'];
            $caps = $post['caps'];
            $navs = ( $post['node'] === 'website' ) ? false : $post['menu'] ;


            // arguments for public mode
            $result = array(

                'label'                 => __( $name , 'rozard_framework' ),
                'description'           => __( $desc , 'rozard_framework' ),
                'labels'                => $labs,
                'hierarchical'          => $levl,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'public'                => true,
                'show_ui'               => true,
                'show_in_rest'          => true,
                'show_in_menu'          => $navs,
                'show_in_nav_menus'     => true,
                'show_in_admin_bar'     => true,
                'menu_position'         => 4,
                'menu_icon'             => $icon,
                'capability_type'       => $caps,
                'capabilities'          => array(),
                'supports'              => $mods,
                'taxonomies'            => array(),
                'has_archive'           => true,
                'rewrite'               => array( 'slug' =>  $slug ),
                'query_var'             => true,
                'can_export'            => true,
                'delete_with_user'      => true,
                'template'              => array(),
                'template_lock'         => false,
            );

            return $result;
        }


        public function mods() {

            foreach( $this->data['object']['post'] as $post ) {
        
                $slug = str_slug( $post['keys'] );

                if ( is_singular( $slug ) || is_post_type_archive( $slug ) ) {

                    add_theme_support( 'post-formats', $post['format'] );
                }
            }
        }


        public function more( $more ) {

            foreach( $this->data['object']['post'] as $post ) {
            
                $slug = str_slug( $post['keys'] );

                if ( is_singular( $slug ) || is_post_type_archive( $slug ) ) {

                    if ( empty( $post['more'] ) ) {
                        return null;
                    }
                    else {
                        return wp_kses_post( $post['more'] );
                    }
                }
            }
          
            return $more;
        }


        public function leed( $long  ) {

            foreach( $this->data['object']['post'] as $post ) {
            
                $slug = str_slug( $post['keys'] );

                if ( is_singular( $slug ) || is_post_type_archive( $slug ) ) {
                    return $post['leed'];
                }
            }
          
            return $long;
        }


        public function menu() {

            foreach( $this->data['object']['post'] as $post ) {

                $slug = str_slug( $post['node'] .'-'. $post['keys'] );
                remove_submenu_page( 'edit.php?post_type='.  $slug  , 'post-new.php?post_type='. $slug  );

                // comment metabox
                if ( ! in_array( 'comment', $post['modul'] ) ) {
                    remove_meta_box( 'commentstatusdiv' , $slug , 'normal' );
                    remove_meta_box( 'commentsdiv' , $slug , 'normal' );
                }
            }
        }


        public function edit( $use_block_editor, $post ) {

            foreach( $this->data['object']['post'] as $data ) {

                $named = str_slug( $data['node'] .'-'. $data['keys'] );

                if ( $named === $post->post_type && $data['edit'] === 'classic' ) {
                    return false;
                }
            }

            return $use_block_editor;
        }
    }
}