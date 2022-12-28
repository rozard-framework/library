<?php

declare(strict_types=1);
if ( ! defined('ABSPATH') ){exit;}
if ( ! class_exists('widget_poststat') ) {
    
    class widget_poststat{

        
        use lib_string;


        public function __construct( string $caps, string $scope, $post_types = array(), $status = array()) {

            if ( ! current_user_can( $caps ) || ! is_admin() ) {
                return;
            }
            $this->scope_method( $post_types, $status, $scope );
        }
    
    
    /** SCOPE METHOD */ 

        public function scope_method( $post_types, $status, $scope ) {
           
            $callback = $scope. '_status';
            if ( $scope === 'global' || $scope === 'user' ) {
                if ( empty( $post_types )  ) {
                    global $post_type; 
                    $types = $post_type;
                    call_user_func( array( $this, $callback ), $types, $status );
                } 
                else {
                    foreach( $post_types as $post_type ) {
                        $types = sanitize_html_class( $post_type );
                        call_user_func( array( $this, $callback ), $types, $status );
                    }
                }
            } 
            else {
                der( '"proto_widget_poststat" class doesn have scope'. $scope );
            }
        }

    
    /** GLOBAL STATUS */ 

        public function global_status( $post_type, $status ) {

            foreach( $status as $state ) {
                if ( $state === 'all' ) {
                    $getpost = wp_count_posts( $post_type );
                    foreach( $getpost as $type => $item ) {
                        $this->render( $type, $item );
                    }
                } 
                else {
                    $getpost = wp_count_posts( $post_type );
                    $counted = $getpost->$state;
                    $this->render( $state, $counted );
                }
            }
        }


    /** USER STATUS */
    
        public function user_status( $post_types, $status ) {

            foreach( $status as $state ) {

                if (  $state === 'publish' ) {
                    $publish = $this->user_counting( $post_types, 'publish' );
                    $this->render( 'publish' , $publish );
                }
                else if (  $state === 'draft' ) {
                    $draft = $this->user_counting( $post_types, 'draft' );
                    $this->render( 'draft' , $draft );
                }
                else if (  $state === 'future' ) {
                    $future = $this->user_counting( $post_types, 'future' );
                    $this->render( 'future' , $future );
                }
                else if (  $state === 'pending' ) {
                    $pending = $this->user_counting( $post_types, 'pending' );
                    $this->render( 'pending' , $future );
                }
                else if (  $state === 'all' ) {
                    $publish = $this->user_counting( $post_types, 'publish' );
                    $draft   = $this->user_counting( $post_types, 'draft' );
                    $future  = $this->user_counting( $post_types, 'future' );
                    $pending = $this->user_counting( $post_types, 'pending' );
    
                    $this->render( 'publish' , $publish );
                    $this->render( 'draft' , $draft );
                    $this->render( 'future' , $future );
                    $this->render( 'pending' , $future );
                }
                else {
                    der( 'proto_widget_poststat class at user_status function doestn have ' .$state. ' status.' );
                }
            }
        }


        private function user_counting( $post_types, $status ) {
            $args = array(
                'post_type'   => $post_types ,
                'post_author' => get_current_user_id(),
                'post_status' => array( $status )    
            );
            $query = new WP_Query( $args );
            $count = count( $query->get_posts() );
            return  $count;
        }

    
    /** RENDER STATUS */

        public function render( $title, $counted ) {

            $icon = 'las la-chart-pie';

            echo '<div class="card sidecard">';
                echo '<i class="'. esc_attr( $icon ) . '"></i>';
                echo '<div class="info">';
                    echo '<h4> '. esc_html( $this->str_text( $title ) )  .'</h4>';
                    echo '<h1 class="counter"> '. esc_html(  $counted ) .'</h1>';
                echo '</div>';
            echo '</div>';
        }
    }
}