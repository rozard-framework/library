<?php


class builder_object_post{


    use rozard_builder_helper;


/***  DATUMS */

    
    private array $create;
    private array $change;
    private array $remove;


/***  RUNITS */


    public function __construct( array $data ) {
        
        if ( ! empty( $data ) && is_array( $data ) ) {
           $this->load( $data );
        }

        return;
    }


    private function load( array $data ) {

        $datums = $this->data_modes( $data );
        $this->create = $datums[0];
        $this->change = $datums[1];
        $this->remove = $datums[2];

        $this->main();
    }


    private function main() {
        add_action('init', array( $this, 'create' ) );
    }



/***  CREATE */


    public function create() {

        foreach( $this->create as $post ) {
            $named = str_keys( $post['name'] );
            $proto = $this->proto( $post );
            register_post_type( $named, $proto );
        }

        return;
    }


    private function proto( array $data ) {


        // title
        $single = str_text( $data['name'] );
        $plural = str_plural( $single );
        

        // attrib
        $slug  =  str_keys( $data['name'] );
        $desc  =  ( ! empty( $data['desc'] ) ) ? pure_text( $data['desc'] ) : $single .' format. ' ;


        // labels
        $label = $this->label( $single, $plural );


        // support
        $mods  = array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' );
        $modul = ( ! empty( $data['modul'] ) ) ? $data['modul'] : $mods;


        // capability 
        $caps  = ( ! empty( $data['caps'] ) ) ? $data['caps'] : 'post';


        // hirarchy
        $level = ( empty( $data['level'] ) || $data['level'] !== true  ) ? false : true ;


        // arguments
        if ( $data['mode'] === 'system' ) {

            // arguments for system mode
            $proto = array(
                'label'               => __( $slug , 'rozard_framework' ),
                'description'         => __( $desc , 'rozard_framework' ),
                'labels'              => $label,
                'supports'            => $modul,
                'taxonomies'          => array(),
                'hierarchical'        => $level,
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
                'capability_type'     => $caps,
                'query_var'           => false,
                'show_in_rest'        => false,
            );
        }
        else if ( $data['mode'] === 'manage' ) {
            
            // arguments for manage mode a.k.a backend
            $proto = array(
                'label'               => __( $slug , 'rozard_framework' ),
                'description'         => __( $desc , 'rozard_framework' ),
                'labels'              => $label,
                'supports'            => $modul,
                'taxonomies'          => array(),
                'hierarchical'        => $level,
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
                'capability_type'     => $caps,
                'show_in_rest'        => false,
            );
        }
        else {
            
            // arguments for public mode
            $proto = array(
                'label'               => __( $slug , 'rozard_framework' ),
                'description'         => __( $desc , 'rozard_framework' ),
                'labels'              => $label,
                'supports'            => $modul,
                'taxonomies'          => array(),
                'hierarchical'        => $level,
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
                'capability_type'     => $caps,
                'show_in_rest'        => false,
            );
        }

        return $proto;
    }


    private function label( string $single, string $plural ) {

        // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( $plural, 'Post Type General Name', 'rozard_framework' ),
            'singular_name'       => _x( $single, 'Post Type Singular Name', 'rozard_framework' ),
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


/***  CHANGE */


    public function change() {

    }


/***  REMOVE */

    public function remove() {
            
    }
}