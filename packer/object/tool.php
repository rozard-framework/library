<?php

if ( ! class_exists( 'rozard_build_custom_tool' ) ) {
    
    
    class rozard_build_custom_tool{


        private array $menu;
        private array $page;


        public function __construct( array $data ) {
            $this->load( $data );
        }

        private function load( array $data ){

            $this->data = $data;
            add_action( 'tool_box',   array( $this, 'tool' ) );
            add_action( 'admin_menu', array( $this, 'menu' ) );
        }


        public function tool() {


            foreach( $this->data as $tool ) {
               
                $title = $tool['title'];
                $descr = $tool['descr'];
                $links = '';

                // create action
                foreach ( $tool['extras'] as $link => $title ) {

                    $links .=   sprintf( '<a href="%s" class="button button-primary">%s</a>', 
                                    esc_attr( $link ), esc_html( $title ) 
                                );
                }
                
                // render card 
                printf(
                    '<div class="card">
                        <h2 class="title">%s</h2>
                        <p>%s</p>
                        <div class ="action">%s</div>
                    </div>', 
                    esc_html( $title ), esc_html( $descr ), $links,
                );
            }
        }

        
        public function menu() {
            
            foreach( $this->data as $tool ) {

                $title  = $tool['title'];
                $descr  = $tool['descr'];
                $slugs  = str_slug( $title );

                // register menus
                register_importer(  $slugs ,  $title ,  $descr , array( $this, 'view' ) , 'dispatch' ) ;
            }
        }


        public function view() {

            foreach( $this->data as $tool ) {

                $title  = $tool['title'];
                $descr  = $tool['descr'];
                $slugs  = str_slug( $title );

                echo $title;
            }
        }
    }
}