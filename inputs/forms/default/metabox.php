<?php


declare(strict_types=1);
if ( ! defined('ABSPATH') || ! defined('WP_LIBRARY')  || ! defined( 'rozard' ) ){ exit; }
if ( ! class_exists( 'input_form_metabox' ) ) {



/** METHOD SECTION */

    class input_form_metabox{

        private $formed;
        private $unique;
        private $titles;
        private $filter;
        private $access;
        private $fields;
        private $contex;


        public function __construct( array $formed, array $fields  ) {

            $this->formed = $formed;
            $this->fields = $fields;
            $this->unique = sanitize_key( $formed['keys'] );
            $this->titles = sanitize_text_field( $formed['title'] );
            $this->filter = $formed['filter'];
            $this->access = $formed['caps'];
            $this->contex = sanitize_key( $formed['context'] );
            

            // render metabox
            add_action( 'add_meta_boxes', array( $this, 'register_metabox' ), 99 );
            add_action( 'save_post',      array( $this, 'savings_metaboxs' ), 99, 2);
        }


        public function register_metabox( $post_type ) {

            add_meta_box(
                $this->unique,
				__( $this->titles , 'rozard-engine' ),
				array( $this, 'render_metaboxes' ),
                $this->filter,
                $this->contex,
				null,
			);
        }


        public function render_metaboxes( $post ) {
            render_field( $this->unique, 'metabox' , $this->access, $this->filter, $this->fields );
        }


        
        public function savings_metaboxs( $post_id, $post ) {


        }
    }
}