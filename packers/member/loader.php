<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists('rozard_packer_users') ) {


    class rozard_packer_users{

        
        public function __construct() {
            $this->hook();
        }


        private function hook() {

            add_filter( 'get_avatar',     array( $this, 'avatar_img' ) , 10, 5 );
            add_filter( 'get_avatar_url', array( $this, 'avatar_url' ) , 10, 3 );
        }


        public function avatar_img( $avatar, $id_or_email, $size, $default, $alt ) {

            $userid =  get_current_user_id();
            $saved  =  get_user_meta( $userid , 'rozard_avatar', true );
            $males  =  images_url() . 'avatar-male.webp';
            $avatar =  ( !empty( $saved ) || $saved =! null ) ? sanitize_url( $males ) : sanitize_url( $saved );


            if ( filter_var( $avatar, FILTER_VALIDATE_URL ) ) {

                return sprintf( '<img src="%s" class="avatar avatar-64 photo" height="64" width="64" loading="lazy" alt="%s" />', 
                                    esc_url( $avatar ), 
                                    esc_attr( $alt ) 
                                );
            }

            return $avatar;
        }


        public function avatar_url( $avatar, $alt ) {

            $userid =  get_current_user_id();
            $saved  =  get_user_meta( $userid, 'rozard_avatar', true );
            $males  =  images_url() . 'avatar-male.webp';
            $avatar =  ( !empty( $saved ) || $saved =! null ) ? sanitize_url( $males ) : sanitize_url( $saved );
            return $avatar;
        }
    }
}