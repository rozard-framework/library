<?php

declare( strict_types=1 );
if( ! defined('ABSPATH') ){exit;}

if( ! class_exists('brick_core_post_action') ) {

    class brick_core_post_action{
        
        use lib_string;
        use lib_cleans;

        public function __construct( $post_types = array() ) {
          
            if ( is_array( $post_types ) &&  ! empty( $post_types )) {
                foreach(  $post_types as $type ) {
                    add_filter( $type .'_row_actions' , array( $this, 'render' ) , 10 , 2 );
                };
            } 
            else if ( empty( $post_types ) ) {
                $screen = get_current_screen();
                add_filter( $screen->post_type .'_row_actions' , array( $this, 'render' ) , 10 , 2 );
            }
        }



        public function render( $actions, $post ) {
           
            $title   = $post->title;
            $post_id = $post->ID;
            $post_ob = get_post_type_object( $post->post_type );
            $trashs  = get_delete_post_link( $post->ID );
            $untrash = wp_nonce_url( admin_url( sprintf( $post_ob->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-post_' . $post->ID );
            $preview = get_preview_post_link( $post );
            if ( current_user_can( 'edit_post', $post->ID ) && 'trash' !== $post->post_status ) {
                $actions['view']  = '<a href="'. esc_url( $preview ) .'" rel="bookmark" aria-label="View '. esc_attr( $title ).' "><i class="las la-external-link-alt"></i></a>';
                unset(  $actions['inline hide-if-no-js'] );
                unset(  $actions['edit'] );
            }
            if ( current_user_can( 'delete_post', $post->ID ) ) {
                if ( 'trash' === $post->post_status ) {
                    $actions['untrash'] = '<a href="'. esc_url( $untrash ) .'" class="submitdelete" aria-label="Restore '. esc_attr( $title ).' from the trash"><i class="las la-undo-alt"></i></a>';;
                }  
                elseif ( EMPTY_TRASH_DAYS ) {
                    $actions['trash'] = '<a href="'. esc_url( $trashs ) .'" class="submitdelete" aria-label="Move '. esc_attr( $title ).' to the trash"><i class="las la-trash"></i></a>';
                }

                if ( 'trash' === $post->post_status || ! EMPTY_TRASH_DAYS ) {
                    $actions['delete'] =  '<a href="'. esc_url( get_delete_post_link( $post_id, '', true ) ) .'" class="submitdelete" aria-label="Delete '. esc_attr( $title ).' permanently"><i class="las la-eraser"></i></a>';;
                }
            }
            return $actions;
        }
    }
}