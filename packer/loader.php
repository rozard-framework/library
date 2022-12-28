<?php


declare(strict_types=1);
if ( ! defined( 'ABSPATH' ) || ! defined( 'rozard' ) ){ exit; }
if ( ! trait_exists( 'lib_packer' ) ) {

    trait lib_packer{

        // use lib_packer_metabox;

        public function packer_metabox(  $render_fields, $post_type = array(), $boxs_data = array(), $user_caps = array() ) {
           // $this->packer_created_metabox(  $render_fields, $post_type,  $boxs_data, $user_caps );
        }
    }
}