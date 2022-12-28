<?php

declare( strict_types=1 );
if( ! defined('ABSPATH') ){exit;}

if( ! class_exists('brick_action_core_term') ) {

    class brick_action_core_term{
        
        use lib_string;
        use lib_cleans;

        public function __construct( $taxonomies = array() ) {
            $taxonomies = $this->sanitize_array_keys($taxonomies);
            $taxonomy   = ( empty( $taxonomies ) ) ? get_current_screen()->taxonomy : $taxonomies ;
            $hookers    = sanitize_key( $taxonomy ) .'_row_actions';
            add_filter( $hookers , array( $this, 'render' ) , 10 , 2 );
        }


        public function render( $actions, $term ) {
            $title   =  $term->name;
            $taxos   =  $term->taxonomy;
            $term_id =  $term->term_id;
            $delete  =  wp_nonce_url( "edit-tags.php?action=delete&amp;taxonomy=$taxos&amp;tag_ID=$term_id", 'delete-tag_' . $term_id );
            
            if ( ! empty(  $actions['delete']  ) && current_user_can( 'delete_term', $term->term_id ) ) {
                $actions['delete'] = '<a href="'. esc_url(  $delete  ) .'" class="delete-tag aria-button-if-js" aria-label="Delete '. esc_attr( $title ).' to the Trash"><i class="las la-trash"></i></a>';
            }

            if ( current_user_can( 'edit_term', $term->term_id ) ) {
                // $actions['view']   = '<a href="'. esc_url( get_term_link( $term ) ) .'" rel="bookmark" aria-label="View '. esc_attr( $title ).' "><i class="las la-external-link-alt"></i></a>';
                unset(  $actions['inline hide-if-no-js'] );
                unset(  $actions['edit'] );
                unset(  $actions['view'] );
            }
            return $actions;
        }
    }
}