<?php

trait rozard_builder_helper {
    

/***  DATUMS  */

    public function data_modes( array $datum ) {

        $create = array();
        $change = array();
        $remove = array();

        foreach( $datum as $data ) {

            if ( ! empty( $data['caps'] ) && ! usr_can( $data['caps'] )  ) {
                continue;
            }
            else if ( $data['mode'] === 'create' ) {
                $create[] = $data; 
            }
            else if ( $data['mode'] === 'change' ) {
                $change[] = $data; 
            }
            else if ( $data['mode'] === 'remove' ) {
                $remove[] = $data; 
            }
        }

        $result = array( $create, $change, $remove );
        return $result;
    }

  
    public function data_nodes( array $datums ) {

        $result = array();

        foreach( $datums as $data ) {
            
        }

        return $result;
    }



    public function data_field( array $datums ) {
        
        $result = array(); 
        $master = apply_filters( 'register_scheme', [] );

        foreach( $datums as $data ) {
            $data = $data['field'];
            if ( ! empty( $master['fields'][$data] ) ) {
                $nodes = $master['fields'][$data];
                foreach( $nodes[ 'group' ] as $key => $group ) {
                    $result[$key] = $group;
                }
            }
        }

        return $result;
    }


/***  FILTER  */

    // field by scope param
    public function field_by_scope( array $datums, string $scope ) {

        $result = array(); 
        $master = apply_filters( 'register_scheme', [] );

        foreach( $datums as $nodes ) {

            if ( $nodes['scope'] !== $scope ) {
                continue;
            }

            $data = $nodes['field'];

            if ( ! empty( $master['fields'][$data] ) ) {
                $nodes = $master['fields'][$data];
                foreach( $nodes[ 'group' ] as $key => $group ) {
                    $result[$key] = $group;
                }
            }
        }

        return $result;
    }


    // field by hook param
    public function field_by_hook( array $datums, string $hook ) {

        $result = array(); 
        $master = apply_filters( 'register_scheme', [] );

        foreach( $datums as $nodes ) {

            if ( $nodes['hook'] !== $hook ) {
                continue;
            }

            $data = $nodes['field'];

            if ( ! empty( $master['fields'][$data] ) ) {
                $nodes = $master['fields'][$data];
                foreach( $nodes[ 'group' ] as $key => $group ) {
                    $result[$key] = $group;
                }
            }
        }

        return $result;
    }


    public function field_by_param( array $datums, string $filter, string $param ) {

        $result = array(); 
        $master = apply_filters( 'register_scheme', [] );

      
        foreach( $datums as $nodes ) {

            if ( $nodes[$filter] !== $param ) {
                continue;
            }

            $data = $nodes['field'];

            if ( ! empty( $master['fields'][$data] ) ) {
                $nodes = $master['fields'][$data];
                foreach( $nodes[ 'group' ] as $key => $group ) {
                    $result[$key] = $group;
                }
            }
        }
       
        return $result;
    }


/***  VALIDS  */


    public function user_check( $datums ) {

    }



/***  MODULE  */


    public function field_module() {

        // traits custom field
        require_once  builder_former . 'fielders/divider.php';
        require_once  builder_former . 'fielders/editor.php';
        require_once  builder_former . 'fielders/search.php';
        require_once  builder_former . 'fielders/switch.php';
        require_once  builder_former . 'fielders/textarea.php';
        require_once  builder_former . 'fielders/upload.php';

        // custom field loader
        require_once  builder_former . 'fielders/_loader.php';
    }
} 
