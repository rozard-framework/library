<?php


if ( ! defined('ABSPATH') ){exit;};
if ( ! trait_exists('lib_widget') ) {

    trait lib_widget{

        use lib_valids;
        use lib_cleans;
        private $widget_depends;


        public function register_widget( $types = array() ){
            $layouts = $this->sanitize_array_keys( $types );
            $this->widget_depends = $types;
            add_action('admin_enqueue_scripts', array( $this, 'widget_depends' ), 150);
        }


        public function widget_depends() {

            foreach( $this->widget_depends as $type ) {

                if( isset( $_SESSION[$type] ) ){
                   continue;
                }
                
                else if ( str_contains( $type, 'taxopost' ) ) {
                    $prefix = 'taxopost';
                }

                $baseds = get_auxil('based');
                $handle = 'module-' . $this->str_slug($type);
                $styles = $baseds->corest['styles']['url'] . 'module/widget/'. $prefix .'.css';
                $jsxmod = $baseds->corest['jsxmod']['url'] . 'module/widget/'. $prefix .'.js';
                $file_styles = $baseds->corest['styles']['dir'] . 'module/widget/'. $prefix .'.css';
                $file_jsxmod = $baseds->corest['jsxmod']['dir'] . 'module/widget/'. $prefix .'.js';


                if ( file_exists( $file_styles ) ) {
                   
                    wp_enqueue_style(  $handle , $styles , array(), roz_ver, 'all' );
                }

                if ( file_exists( $file_jsxmod ) ) {
                    
                    wp_enqueue_script(  $handle , $jsxmod , array(), roz_ver, true );
                }
               

                $_SESSION[$type] = 1; // set session id to prevent duplicate proccess
            }
        }
        

        /** WIDGET SERIES  */


        /** SHOW CURRENT POST TAXONOMY  */

            public function widget_taxopost( string $caps ) {
                require_once __DIR__ . '/taxopost.php';
                new widget_taxopost( $caps );
            }

        /** SHOW CURRENT POST STATUS 
         *  
         *  @param caps       string | minimum capability
         *  @param post_type  array  | post object, if leave blank,  default value is current object attached
         *  @param status     string | spesific current post status, ex : publish. fill "all" to show all status
         *  @param scope      string | "global" or "user"
         * 
         */

            public function widget_poststat( string $caps, string $scope, $post_type = array(), $status = array() ) {
                require_once __DIR__ . '/poststat.php';
                new widget_poststat( $caps, $scope, $post_type, $status  );
            }

    }
}
