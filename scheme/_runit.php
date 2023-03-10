<?php


/**  ROZARD SCHEME
*/

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_scheme' ) ) {


    class rozard_scheme{


        public function __construct() {
            $this->hook();
        }


        public function hook() {
            $this->former();
            $this->script();
            $this->object();
            $this->admins();
            $this->themes();
        }


        public function script() {
            require_once 'scripter/loader.php';
            new rozard_scheme_scripts;
        }


        public function former() {
            require_once 'former/loader.php';
            new rozard_scheme_former;
        }


        public function object() {
            require_once 'objects/loader.php';
            new rozard_scheme_objects;
        }


        public function admins() {
            require_once 'admins/loader.php';
            new rozard_scheme_admins;
        }


        public function themes() {
            require_once 'themes/loader.php'; 
            new rozard_theme_loader;
        }
    }
}