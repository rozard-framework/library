<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


if ( ! class_exists( 'rozard_scheme_scripts' ) ) {

    class rozard_scheme_scripts{


        private $raws;


        public function __construct() {
           $this->init();
        }


        private function init() {

            if ( is_multisite() ) {
                
                define( 'vendor_css', get_site_url( get_main_site_id() ) . '/wp-admin/library/scheme/scripter/styles/' );
                define( 'vendor_jsx', get_site_url( get_main_site_id() ) . '/wp-admin/library/scheme/scripter/script/' );
            }
            else {

                define( 'vendor_css', get_site_url() . '/wp-admin/library/scheme/scripter/styles/' );
                define( 'vendor_jsx', get_site_url() . '/wp-admin/library/scheme/scripter/script/' );
            }
            
            $this->based();
            $this->preps();
        }


    /*** BASED  */

        private function based() {
           $this->based_css();
           $this->based_jsx();
        }


        public function based_css() {


            // FRONT
            $this->raws['front']['head']['css'][] = array(
                'name'  => 'theme-css',
                'file'  => vendor_css . 'rozard/theme.css',
                'deps'  => array(),
                'vers' => rozard_version,
                'args'   => 'all',
            );


            $this->raws['front']['head']['css'][] = array(
                'name'  =>  'aos-css',
                'file'  =>  vendor_css . 'aos/aos.min.css',
                'deps'  =>  array(),
                'vers'  =>  2,
                'args'  =>  'all',
            );


            $this->raws['front']['head']['css'][] = array(
                'name'  => 'icons-css',
                'file'  => vendor_css . 'line-awsome/css/line-awesome.min.css',
                'deps'  => array(),
                'vers' => rozard_version,
                'args'   => 'all',
            );




            // BACK
            $this->raws['back']['head']['css'][] = array(
                'name'  =>  'aos-css',
                'file'  =>  vendor_css . 'aos/aos.min.css',
                'deps'  =>  array(),
                'vers'  =>  2,
                'args'  =>  'all',
            );
          

            $this->raws['back']['head']['css'][] = array(
                'name'  => 'icons-css',
                'file'  => vendor_css . 'line-awsome/css/line-awesome.min.css',
                'deps'  => array(),
                'vers' => rozard_version,
                'args'   => 'all',
            );


            $this->raws['back']['head']['css'][] = array(
                'name'  =>  'admin-css',
                'file'  =>  vendor_css . 'rozard/admin.css',
                'deps'  =>  array(),
                'vers'  =>  rozard_version,
                'args'  => 'all',
            );
        }


        public function based_jsx() {
            
            // FRONT
            $this->raws['front']['head']['jsx'][] = array(
                'name'  =>  'aos-jsx',
                'file'  =>  vendor_jsx . 'aos/aos.js',
                'deps'  =>  array(),
                'vers'  =>  2,
                'args'  =>  true,
            );

            $this->raws['front']['head']['jsx'][] = array(
                'name'  =>  'theme-jsx',
                'file'  =>  vendor_jsx . 'rozard/theme.js',
                'deps'  =>  array(),
                'vers'  =>  rozard_version,
                'args'  =>  true,
            );


            // BACK
            $this->raws['back']['head']['jsx'][] = array(
                'name'  =>  'aos-jsx',
                'file'  =>  vendor_jsx . 'aos/aos.js',
                'deps'  =>  array(),
                'vers'  =>  2,
                'args'  =>  false,
            );

            $this->raws['back']['head']['jsx'][] = array(
                'name'  =>  'admin-jsx',
                'file'  =>  vendor_jsx . 'rozard/admin.js',
                'deps'  =>  array( 'aos-jsx' ),
                'vers'  =>  rozard_version,
                'args'  =>  true,
            );
        }


    /*** PREPS  */


        private function preps() {
            add_action('init', array( $this, 'preps_data' ));
        } 


        public function preps_data() {

            
            $scheme = apply_filters( 'register_scheme', array() );
           
       
            if ( isset( $scheme['script']['front'] ) ) {

                foreach( $scheme['script']['front'] as $type => $data ) {

                    if ( $data['node'] === 'plugin' ) {

                        $path =  get_site_url( get_main_site_id() ) .'/wp-content/plugins/' . $data['base'] .'/assets' .'/';
                    }
                    else {

                        $path = get_template_directory_uri() . '/assets' .'/'  ;
                    }

                    if ( $data['type'] === 'css' ) {
                        $data['file'] =  $path . $data['file'] .'.css';
                    }

                    if ( $data['type'] === 'jsx' ) {
                        $data['file'] =  $path . $data['file'] .'.js';
                    }

                    $this->raws['front'][$data['hook']][$data['type']][] = $data;
                }
            }

               
            if ( isset( $scheme['vendor']['front'] ) ) {
                foreach( $scheme['vendor']['front'] as $data ) {
                    $this->vendor[$data['type']][$data['name']]['caps'] = $data['caps'];
                    $this->vendor[$data['type']][$data['name']]['load'] = $data['load'];
                    $this->raws['front'][$data['hook']][$data['type']][] = $this->vendor[$data['type']][$data['name']];
                }
            }

            
            if ( isset( $scheme['script']['back'] ) ) {

                foreach( $scheme['script']['back'] as $data ) {

                    if ( ! usr_can( $data['caps'] ) ) {
                        continue;
                    }

                    if ( $data['node'] === 'plugin' ) {

                        $path =  get_site_url( get_main_site_id() ) .'/wp-content/plugins/' . $data['base'] .'/assets' .'/';
                    }
                    else {

                        $path = get_template_directory_uri() . '/assets' .'/'  ;
                    }
                   
                    if ( $data['type'] === 'css' ) {
                        $data['file'] =  $path . $data['file'] .'.css';
                    }

                    if ( $data['type'] === 'jsx' ) {
                        $data['file'] =  $path . $data['file'] .'.js';
                    }

                    $this->raws['back'][$data['hook']][$data['type']][] = $data;
                }
            }

            
            if ( isset( $scheme['vendor']['back'] ) ) {
                foreach( $scheme['vendor']['front'] as $data ) {
                    $this->vendor[$data['type']][$data['name']]['caps'] = $data['caps'];
                    $this->vendor[$data['type']][$data['name']]['load'] = $data['load'];
                    $this->raws['back'][$data['hook']][$data['type']][] = $this->vendor[$data['type']][$data['name']];
                }
            }


            $this->preps_hook();
        }


        public function preps_hook() {
            $this->theme();
            $this->admin();
        }


    /*** THEME  */

        private function theme() {
            add_action( 'wp_enqueue_scripts', array( $this, 'theme_head' ) );
            add_action( 'get_footer',         array( $this, 'theme_foot' ) );
        }



        public function theme_head() {


            if ( ! isset( $this->raws['front']['head'] ) ) {
                return;
            }
           
            $this->register( $this->raws['front']['head'] );
        }


        public function theme_foot() {

            if ( ! isset( $this->raws['front']['foot'] ) ) {
                return;
            }
           
            $this->register( $this->raws['front']['foot'] );  
        }


        public function theme_mods() {

        }

        

    /*** ADMIN  */


        private function admin() {
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_head' ) );  
            add_filter( 'script_loader_tag',     array( $this, 'admin_mods' ), 10, 3);
        }


        public function admin_head() {

            if ( ! isset( $this->raws['back']['head'] ) ) {
                return;
            }
           
            $this->register( $this->raws['back']['head'] );  
        }


        public function admin_foot() {
            // echo 
        }


        public function admin_mods( $tag, $handle, $src ) {

            
            if ( 'admin-jsx' === $handle ) {
                $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
            }

            return $tag;
        }


    /*** METHOD  */


        private function register( $data ) {


            foreach( $data['css'] as $type => $script ) {

                $handle  =  $script['name'];
                $source  =  $script['file'];
                $depend  =  $script['deps'];
                $version =  $script['vers'];
                $media   =  $script['args'];

                wp_enqueue_style(  $handle, $source, $depend, $version, $media );
            }


            foreach( $data['jsx'] as $type => $script ) {
            
                $handle  =  $script['name'];
                $source  =  $script['file'];
                $depend  =  $script['deps'];
                $version =  $script['vers'];
                $footer  =  $script['args'];

                wp_enqueue_script(  $handle, $source, $depend, $version, $footer );
            }
        }
    }
}