<?php


if ( ! class_exists( 'builder_object_bars' ) ) {

    class builder_object_bars{


        use rozard_builder_helper;


    /***  DATUMS  */


        private array $create;
        private array $change;
        private array $remove;

        
    
    /***  RUNITS  */    


        public function __construct( array $data ) {
            
            if ( ! empty( $data ) && is_array( $data ) && is_admin() ) {
                $this->load( $data );
            }
            return;
        }
    
    
        private function load( array $data ) {
    
            $datums = $this->data_modes( $data );
            $this->create = $datums[0];
            $this->change = $datums[1];
            $this->remove = $datums[2];

            unset( $data );
            add_action('admin_bar_menu', array( $this, 'main' ), 99 );
        }
    
    
        public function main( $bar ) {
                
            if ( ! empty( $this->create ) ) {
                $this->create( $bar );
            }
            if ( ! empty( $this->change ) ) {
                $this->change( $bar );
            }
            if ( ! empty( $this->remove ) ) {
                $this->remove( $bar );
            }
        }

    
    
    /***  CREATE  */

        private function create( $bar ) {
          
            foreach( $this->create as $menu ) {
            
                if ( empty( $menu['name'] ) && ! usr_can( $menu['caps'] ) ) {
                    continue;
                }

                $proto = array(
                    'id'     => str_keys( $menu['name'] ),
                    'title'  => str_text( $menu['name'] ),
                    'parent' => ( empty( $menu['hook'] ) ) ? '' : str_slug( $menu['hook'] ),
                    'group'  => false,
                    'href'   => esc_url( admin_url( $menu['slug'] ) ),
                    'meta'   => array(),
                );
                $bar->add_menu( $proto );
            }
        }



    /***  CHANGE  */


        private function change( $bar ) {
                
            foreach( $this->change as $menu ) {

            }
        }



    /***  REMOVE  */
        
        private function remove( $bar ) {
            foreach( $this->remove as $menu ) {
                $bar->remove_menu( $menu['slug'] );
            }
        }
    }
}