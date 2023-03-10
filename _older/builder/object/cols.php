<?php


if ( ! class_exists( 'builder_object_cols' ) ) {

    class builder_object_cols{

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

            $this->hook( $data );
            unset( $data );
        }


        private function hook( array $data ) {

            foreach( $data as $item ) {

                $context = $item['hook'];
                add_action( "manage_{$context}_columns" , array( $this, 'main' ) );
            }
        }
    

        public function main( $columns ) {
    
            if ( ! empty( $this->create ) ) {
                $columns = $this->create( $columns );
            }
    
            if ( ! empty( $this->change ) ) {
                $columns = $this->change( $columns );
            }
    
            if ( ! empty( $this->remove ) ) {
                $columns = $this->remove( $columns );
            }

            return $columns;
        }
    
    
    
    /***  CREATE  */


        private function create( $columns ) {
    
            foreach( $this->create as $cols ) {
    
                
            }

            return $columns;
        }


    /***  CHANGE  */


        private function change( $columns ) {
            
            foreach( $this->change as $cols ) {
    
            }

            return $columns;
        }


    /***  REMOVE  */
        
        private function remove( $columns ) {

            foreach( $this->remove as $cols ) {

                if ( ! empty( $cols['scope'] ) && ! uri_has( $cols['scope'] ) ) {
                    continue;
                }
                unset( $columns[ $cols['order'] ] );
            }

            return $columns;
        }
    }
}

