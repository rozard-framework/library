<?php


if ( ! class_exists( 'builder_object_help' ) ) {

    class builder_object_help{


        use rozard_builder_helper;

    /***  DATUMS  */


        private array $create;
        private array $change;
        private array $remove;
    
    
    /***  RUNITS  */    


        public function __construct( array $data ) {
           
            if ( ! empty( $data ) &&  is_array( $data ) && is_admin() ) {
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
            add_action( 'admin_head' , array( $this, 'main' ) );
        }


        public function main(  ) {
    
            $help = get_current_screen();

            if ( ! empty( $this->create ) ) {
                $this->create( $help );
            }
    
            if ( ! empty( $this->change ) ) {
                $this->change( $help );
            }
    
            if ( ! empty( $this->remove ) ) {
                $this->remove( $help );
            }
        }
    
    
    
    /***  CREATE  */


        private function create( $help ) {
    
            foreach( $this->create as $menu ) {
    
                
            }
        }


    /***  CHANGE  */


        private function change( $help ) {
            
            foreach( $this->change as $menu ) {
    
            }
        }


    /***  REMOVE  */
        
        private function remove( $help ) {

            foreach( $this->remove as $menu ) {

                if ( $menu['scope'] === 'help' ) {
                    $help->remove_help_tab( $menu['order'] );
                }
                
                if ( $menu['scope'] === 'option' ) {
                    $screen->remove_option( $item['unique'] );
                }
            }
        }
    }
}