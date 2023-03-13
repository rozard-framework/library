<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists('rozard_kernel_probe_column') ) {


    class rozard_kernel_probe_column{

        public function __construct() {
            $this->hook();
        }


        private function hook() {
            $this->post();
            $this->feed();
            $this->user();
            $this->site();
        }


        private function post() {
            add_filter( 'manage_post_posts_columns', array( $this, 'col_post' ) );
            add_filter( 'admin_init',                array( $this, 'com_post' ) );
        }


        public function com_post() {

            $post_types = get_post_types();
            foreach ($post_types as $post_type) {
                if(post_type_supports($post_type,'comments')) {
                    remove_post_type_support($post_type,'comments');
                    remove_post_type_support($post_type,'trackbacks');
                }
            }
        }


        public function col_post( $columns ) {
            unset( $columns['tags'], $columns['categories'], $columns['comments']);
            return $columns;
        }


        private function feed() {
            add_filter( 'manage_edit-comments_columns', array( $this, 'col_feed' ) );
        }

        
        public function col_feed( $columns ) {
            unset( $columns['date']);
            return $columns;
        }


        private function user() {
            add_filter( 'manage_users_columns',              array( $this, 'col_user' ) );
            add_filter( 'manage_site-users-network_columns', array( $this, 'col_user' ) );
            add_filter( 'manage_users-network_columns',     array( $this, 'col_user' ) );
        }


        public function col_user( $columns ) {

            if ( isset( $columns['posts'] ) ) {
                unset( $columns['posts'] );
            }

            if ( isset( $columns['role'] ) ) {
                unset( $columns['role'] );
            }

            if ( isset( $columns['registered'] ) ) {
                unset( $columns['registered'] );
            }

            if ( isset( $columns['blogs'] ) ) {
                unset( $columns['blogs'] );
            }

            unset(  $columns['email'], $columns['name'] );

            return $columns;
        }


        private function site() {
            add_filter( 'manage_sites-network_columns', array( $this, 'col_site' ) );
        }


        public function col_site( $columns ) {
            unset( $columns['lastupdated'], $columns['registered'] );
            return $columns;
        }
    }
}