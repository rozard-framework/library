<?php 


declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_base_scheme' ) ) {

    class rozard_base_scheme{


        public function __construct() {

        }

        private function aset() {

        }

        private function path() {

        }

        private function info() {
            
        }
    }
}




/*** ROZARD SCHEME */


    function get_cores() {
        $based = (object) array(
            'master' => array(
                'datums' => dirname( rozard , 1) . '/rozard-datums' ,
                'packer' => dirname( rozard , 1) . '/rozard-module' ,
                'themes' => ABSPATH .'wp-admin/themes/',
                'admins' => ABSPATH .'wp-admin/extend/',
                'helper' => ABSPATH .'wp-admin/extend/helper/',
                'public' => ABSPATH .'wp-content/extend/',
            ),
            'credit' => array(
                'developer' => array(
                    'name' => 'Al Muhdil Karim',
                    'blog' => 'https://almuhdilkarim.com/',
                ),
                'company' => array(
                    'name'    => 'Lektor Media Utama',
                    'webs'    => 'https://lectore.com',
                    'logo'    =>  content_url() . '/extend/images/main-logo.webp',
                    'address' => 'Tokopedia Tower 22nd Floor Unit F, JL. Prof. DR. Satrio KAV. 11, Jakarta, ID',
                ),
                'statement' => array(
                    'naming' => 'Rozard ',
                    'models' => 'Information Management System',
                    'credit' => 'Al Muhdil Karim &#169 2019 - '. date('Y'),
                    'legals' => 'All other trademarks and copyrights are the property of their respective owners. All rights reserved.',
                ),
            ),
        );
        return $based;
    }



    function library_url() {
        $link = get_site_url( get_main_site_id() ) . '/wp-admin/library/';
        return $link;
    }


    function images_url() {
        $link = library_url() . 'images/';
        return $link;
    }

