<?php

if ( ! class_exists( 'rozard_rebase_appmode' ) ) {

    class rozard_rebase_appmode{


        public function __construct() {
            $this->defs();
        }


        private function defs() {

            $this->deps();
        }


        private function deps() {

            require_once  rozard . 'packer/_init.php';
            $this->load();
        }


        private function load() {

            // filter
            add_filter( 'clean_object', array( $this, 'dreg' ) );
            add_filter( 'build_object', array( $this, 'regs' ) );
        }


        public function dreg( $object ) {

            $object['menu'][] = array(
                'parent' => '',
                'slugs'  => array( 'edit.php', 'edit.php?post_type=page' ),
                'events' => array( 'all' ),
            );

            return $object;
        }


        public function regs( $object ) {

            $object['page']['website_main'] = array(
                'title'    => 'Publish',
                'icons'    => '',               //  
                'slugs'    => 'edit.php',       // using slug to register default link, left blank for page custom
                'operate'  => 'sites',          // network || sites
                'context'  => 'main',           // main('parent menu'), themes, options dll
                'orders'   => 87,               //  
                'layout'   => 'left-nav',       // normal, left-nav, right-nav, head-nav, foot-nav, scratch
                'access'   => 'appmode_options',
                'extras'   => array( 'appmode_options' ),
            );
            

            $object['page']['website_page'] = array(
                'title'    => 'Static',
                'icons'    => '',               //  
                'slugs'    => 'edit.php?post_type=page',        //  network || sites
                'operate'  => 'manage',         //  network || sites
                'context'  => 'edit.php',       //  main('parent menu'), themes, options dll
                'layout'   => 'left-nav',       // normal, left-nav, right-nav, head-nav, foot-nav, scratch
                'access'   => 'read',
                'extras'   => array(),
                'orders'   => 1,               //  
            );

            return $object;
        }


    /** OPTIONS */


    
    /** RENDER */

        
        private function view() {
            add_action( 'publish_head',  array( $this, 'head' ) );
            add_action( 'publish_left',  array( $this, 'left' ) );
            add_action( 'publish_right', array( $this, 'right' ) );
            add_action( 'publish_foot',  array( $this, 'foot' ) );
        }


        public function head(){
           echo 'head';
        }

        
        public function left(){
            echo 'left';
        }

        
        public function right(){
            echo 'right';
        }


        public function foot(){
            echo 'foot';
        }
    }
    add_action( 'init', function(){ new rozard_rebase_appmode; } );
}