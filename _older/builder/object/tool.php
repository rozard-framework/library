<?php


class builder_object_tool{


    use rozard_builder_helper;
    

/***  DATUMS */


    private array $create;
    private array $change;
    private array $remove;


/***  RUNITS */

    public function __construct( array $data ) {

        if ( ! empty( $data ) && is_array( $data ) ) {
            $this->load( $data );
        }

        return;
    }


    private function load( array $data ) {

    }


    private function hook() {

    }



/*** CREATE */

    public function create() {

    }



/*** CHANGE */

    public function change() {
            
    }


/*** REMOVE */


    public function remove() {
                
    }
}