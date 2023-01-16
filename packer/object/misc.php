<?php


if ( ! class_exists( 'rozard_build_miscellaneous' ) ) {

    class rozard_build_miscellaneous{


        private array $body;


        public function __construct( array $data ) {
            $this->bios( $data );
        }


        private function bios( array $data ) {

            // body class data
            foreach( $data as $kind ) {
                if ( $kind['context'] === 'body-class'  ) {
                    $this->body[] = $kind;
                }
            }

            $this->hook() ;
        }


        private function hook() {
            add_filter( 'admin_body_class', array( $this, 'body' ) );
        }


        public function body( $classes  ) {

            foreach( $this->body as $page ) {
                if ( ! uris_has( $page['filter'] ) ) {
                    continue;
                }
                $classes .= $page['layout'];
            }
            return $classes;
        }
    }
}