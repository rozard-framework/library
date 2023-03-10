<?php

if ( ! defined( 'ABSPATH' ) || ! defined( 'WPINC' )  ) { exit ; }

/*** AJAX REQUES HANDLER */
if ( ! trait_exists( 'cores_ajaxs' ) ) { 

    trait cores_ajaxs {

        protected $scope;
        protected $query;
        protected $method;
       

        public function ajaxs() {
            add_action( 'wp_ajax_cores', array( $this, 'cores' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'localize' ) );
        }


        public function cores() {
            
            if ( isset( $_POST ) ) { 
             
                // extract data
                if ( $_POST['crypter'] == true ) {
                    $model = base64_decode( $_POST['model'] );
                    $model = $this->decrypt( $model );
                    $model = json_decode(stripslashes( $model ), true);
                } else {
                    $model = base64_decode( $_POST['model'] );
                }


                // prepare model
                $nonce = $_POST['token'];
                $query = [
                    'value' =>  $_POST['value'],
                    'query' =>  $model['query'],
                ];
                $method = $this->str_keys( $model['method'] );
           
               
                // level 1 - nonce validation 
                if ( ! wp_verify_nonce( $nonce, 'yuzardi-nonce' ) ) {
                    echo json_encode( 'error-1 Invalid Access or Ilegal access' );
                    die();
                }

                // level 2 - capabilities validation
                if ( ! current_user_can( $model['caps'] ) === false || ! current_user_can( 'manage_options' )  ) {
                    echo json_encode( 'error-2 Your need higher level access to access this data' );
                    die();
                }


                // begin operation
                call_user_func( array( $this,  $method ),  $query  );
            }
            die();
        }

      
        // METHOD
        private function data_create( $args ) {

        }


        private function data_reader( $args ) {
           
        }


        private function data_insert( $args ) {
           
        }

        private function data_update( $args ) {
           
        }

        private function data_delete( $args ) {
            
        }


        private function find_post( $args ) {

            // post handler method
            $value  = $args['value'];
            $result = [];

            // start querying post
            query_posts( $args['query'] );
           
            if( have_posts() ) : while( have_posts() ): the_post();

                // search param
                $postid   = get_the_ID();
                $target_0 = strtolower( $value );
                $params_1 = strtolower( get_the_title( $postid ) );
                $params_2 = strtolower( get_post_meta( $postid ) );

                if ( str_contains( $params_1 , $target_0) || str_contains( $params_2 , $target_0) ) 
                {
                    $data = $this->post_model(  $postid );
                    array_push( $result, $data  ); 
                }

            endwhile; endif;

            $this->sent_data( $result );

        }


        private function list_post( $args ) {
           
        }


        private function find_user( $args ) {
           

            $users  = get_users( array( 'fields' => array( 'display_name', 'ID',  'user_login', 'user_nicename', 'user_email' ) ) );
            $result = array();

            foreach( $users as $user ) {

                $target_0 = strtolower( sanitize_key( $args['value'] ) );
                $params_1 = strtolower($user->user_login);
                $params_2 = strtolower($user->display_name);
               
                if ( str_contains( $params_1 , $target_0) || str_contains( $params_2 , $target_0) ) { 

                    $data = $this->user_model($user->ID);

                    // register data
                    array_push( $result, $data );
                }
            }

            $this->sent_data( $result );
        }


        private function list_user( $args ) {
            
        }


        private function find_term( $args ) {

            // term handler method
            $value  = $args['value'];
            $terms  = get_terms( $args['query'] );
            $result = [];

            foreach( $terms as $term ) 
            {
                $target_0 = strtolower( $value );
                $params_1 = strtolower($term->name);
                $params_2 = strtolower($term->slug);
            
                if ( str_contains( $params_1 , $target_0) || str_contains( $params_2 , $target_0)  ) { 

                    $data = $this->term_model( $term->term_id );
                    array_push( $result, $data ); 
                }
            }
            $this->sent_data( $result );
        }


        private function list_term( $args ) {
           
        }


        // MODELING
        function post_model( $postid ) {
            
            // object
            $title   = get_the_title( $postid );
            $metas   = get_post_meta( $postid );
            $format  = get_post_type( $postid );

            // action
            $create  = get_the_time('Y-m-d', $postid); 
            $trash   = htmlspecialchars_decode( get_delete_post_link( $postid ) );
            $purge   = htmlspecialchars_decode( get_delete_post_link( $postid, '', true ) );
            $restore = htmlspecialchars_decode( wp_nonce_url( 'post.php?post='. $postid .'&action=untrash', "untrash-post_$postid" ));

            // author 
            $authid  = get_post_field( 'post_author', $postid );
            $author  = get_the_author_meta( 'display_name', $authid );

            // model
            $model = [ $postid, $title, $author, $format,  $create, $trash, $purge, $restore, $metas  ];
            return $model;


        }


        function term_model( $termid ) {

            $term = get_term( $termid );

            $data = [
                $term_ids  = $term->term_id,
                $term_name = $term->name,
                $term_meta = $term->meta,
            ];

            return $data;
        }


        function user_model( $userid ) {

            $user    = get_user_by( 'ID', $userid );
            $avatar  = get_avatar_url( $user->id );
            $data = [
                $user->id,
                $user->display_name,
                $avatar,
                $user->user_login,
                $user->user_nicename,
                $user->user_email,
                $user->display_name,
            ];

            return $data;
        }


        // HELPER
        private function sent_data( $data ) {

            $result = ( empty( $data ) ) ? 'empty-data' : $data;
            echo json_encode( $result );
            die();
        }


        public function localize() {

            $cores_localize = array(
                'id'     => wp_create_nonce('yuzardi-nonce'),
                'url'    => admin_url('admin-ajax.php'),
                'method' => 'cores',
                'crypto' => true,
            );
            wp_localize_script( 'admin-script', 'rofecth', $cores_localize );
        }
    }
}