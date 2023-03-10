<?php


class builder_object_term{


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

        $this->hook();
        unset( $data );
    }


    private function hook() {
        add_action('init', array( $this, 'main' ) );
    }



    public function main() {


        if ( ! empty( $this->create ) ) {
            $this->create();
        }

        if ( ! empty( $this->change ) ) {
            $this->change();
        }

        if ( ! empty( $this->remove ) ) {
            $this->remove();
        }

    }



/***  CREATE */

    private function create() {

        foreach( $this->create as $term ) {
            $named  =  str_keys( $term['name'] );
            $setup  =  $term['hook'];
            $proto  =  $this->proto( $term );
            register_taxonomy( $named , $setup , $proto );
        }

        return;
    }


    private function proto( array $data ) {


        // title
        $single  =  str_text( $data['name'] );
        $plural  =  str_plural( $single );


        // attrib
        $slug  =  str_keys( $data['name'] );
        $desc  =  ( ! empty( $data['desc'] ) ) ? pure_text( $data['desc'] ) : $single .' format. ' ;

        
        // labels
        $label  =  $this->label( $single, $plural );

        
        // hirarchy
        $level  =  ( empty( $data['level'] ) || $data['level'] !== true  ) ? false : true ;


        // default
        $built  =  ( empty( $data['built'] )) ? '' : $data['built'] ;


        // arguments
        if ( $data['mode'] === 'system' ) {

            // operate as system module 
            $proto = array(
                'labels'                => $label,
                'show_ui'               => false,
                'rewrite'               => array( 'slug' => $slug ),
                'query_var'             => false,
                'hierarchical'          => $level,
                'show_in_rest'          => false,
                'show_admin_column'     => false,
                'default_term'          => $built,
                'update_count_callback' => '_update_post_term_count',
            );
        }
        else if( $data['mode'] === 'manage' ){

            // operate as backend module
            $proto = array(
                'labels'                => $label,
                'show_ui'               => true,
                'rewrite'               => array( 'slug' => $slug ),
                'query_var'             => true,
                'hierarchical'          => $level,
                'show_in_rest'          => false,
                'show_admin_column'     => false,
                'default_term'          => $built,
                'update_count_callback' => '_update_post_term_count',
            );
        }
        else {

            // operate as public module
            $proto = array(
                'labels'                => $label,
                'show_ui'               => true,
                'rewrite'               => array( 'slug' => $slug ),
                'query_var'             => true,
                'hierarchical'          => $level,
                'show_in_rest'          => true,
                'show_admin_column'     => true,
                'default_term'          => $built,
                'update_count_callback' => '_update_post_term_count',
            );
        }
          
        return $proto;
    }


    private function label( string $single, string $plural ) {
        
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


/***  CHANGE */

    private function change() {
    }

    
/***  REMOVE */


    private function remove() {

        foreach( $this->remove as $term ) {
            $taxonomy = $term['slug'];
            foreach( $term['hook'] as $object_type ) {
                unregister_taxonomy_for_object_type( $taxonomy, $object_type );
            }
        }
    }

/***  HELPER */

   
}