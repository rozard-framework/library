<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_theme_script') ) {

    class rozard_theme_script{


        private $asset;


        public function __construct() {
           $this->init();
        }


        public function init() {
            $this->data();
            $this->hook();
        }


        private function data() {
            $this->data_vendor();
            $this->data_script();
        }


        private function data_vendor() {

            global $themes;
            $vendor = apply_filters( 'register_vendor', array() );


            // default
            $this->asset['head']['css'][] = $vendor['css']['rothem'];
            $this->asset['head']['jsx'][] = $vendor['jsx']['rothem'];

            if ( isset( $themes['vendor'] ) && has_filter( 'register_vendor' ) ) {

              
                foreach( $themes['vendor'] as $import ) {

                    if ( ! isset( $vendor[$import['type']][$import['name']] ) ) {
                        continue;
                    }

                    $this->asset[$import['node']][$import['type']][] = $vendor[$import['type']][$import['name']];
                }
            }
        }


        private function data_script() {

            global $themes, $plugin;


            if ( isset( $themes['script'] ) ) {

                $path = get_template_directory_uri();

                foreach( $themes['script'] as $script ) {

                    if ( $script['type'] === 'css' ) {
                        $script['file'] =  $path . '/assets/styles/' . $script['file'] .'.'. $script['type'];
                    }

                    if ( $script['type'] === 'jsx' ) {
                        $script['file'] =  $path . '/assets/script/' . $script['file'] .'.js';
                    }

                    $this->asset[$script['node']][$script['type']][] = $script;
                }
            }


            if ( isset( $plugin['script'] ) ) {

                foreach( $plugin['script'] as $plug ) {


                    if ( $plug['part'] !== 'front'  ) {
                        continue;
                    }


                    $pather = plugin_dir_url( $plug['name'] ) . $plug['name'] .'/assets' .'/';
                   

                    if ( $plug['type'] === 'css' ) {

                        $plug['file'] =  $pather . $plug['file'] .'.css';
                    }


                    if ( $plug['type'] === 'jsx' ) {

                        $plug['file'] =  $pather . $plug['file'] .'.js';
                    }

                    $this->asset[$plug['node']][$plug['type']][] = $plug;
                }
            }
        }


        private function hook() {
            add_action( 'wp_enqueue_scripts', array( $this, 'head' ) );
            add_action( 'get_footer',         array( $this, 'foot' ) );
        }


        public function head() {

            if ( ! empty( $this->asset['head'] ) ) {
                $this->load( $this->asset['head'] );
            }
        }


        public function foot() {
            
            if ( ! empty( $this->asset['foot'] ) ) {
                $this->load( $this->asset['foot'] );
            }
        }


        public function load( $data ) {
            

            foreach( $data as $key => $group ) {

                if ( $key === 'css' ) {

                    foreach( $group as $aset ) {

                        $handle  =  $aset['name'];
                        $source  =  $aset['file'];
                        $depend  =  $aset['deps'];
                        $version =  $aset['vers'];
                        $media   =  $aset['args'];
    
                        wp_enqueue_style(  $handle, $source, $depend, $version, $media );
                    }
                }
                else if ( $key === 'jsx' ) {
                    
                    foreach( $group as $aset ) {

                        $handle  =  $aset['name'];
                        $source  =  $aset['file'];
                        $depend  =  $aset['deps'];
                        $version =  $aset['vers'];
                        $footer  =  $aset['args'];
    
                        wp_enqueue_script(  $handle, $source, $depend, $version, $footer );
                   }
                }
            }
        }
    }
    new rozard_theme_script;
}