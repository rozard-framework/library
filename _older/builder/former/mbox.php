<?php


if ( ! class_exists( 'builder_object_mbox' ) ) {

    class builder_object_mbox{


        use rozard_builder_helper;
        

    /***  DATUMS  */


        private array $create;
        private array $change;
        private array $remove;

   
    
    /***  RUNITS  */    


        public function __construct( array $data ) {
           
            $filter = array( 'index.php', 'post-new.php', 'post.php', 'admin-ajax' );

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
            $this->hook();
        }


        private function hook() {

            
            if ( isset( $this->create ) ) {

                // field module
                $this->field_module();

                // hooks module
                add_action( '_admin_menu',  array( $this, 'main' ) );
                add_action( 'save_post',    array( $this, 'saving_post' ), 10, 2 );
            }
        }

  
        public function main() {

            if ( ! empty( $this->create ) ) {
                $this->create();
            }
    
            if ( ! empty( $this->change ) ) {
                $this->change();
            }
    
            if ( ! empty( $this->remove ) ) {
                $this->remove();
            }
        }
    
    
    
    /***  CREATE  */


        public function create() {
    
            foreach( $this->create as $mbox ) {
    
                // unpack
                $title   = $mbox['name'];
                $scope   = $mbox['scope'];
                $unique  = str_keys( $mbox['name'] );
                $render  = array( $this, 'render' );
                $screen  = $mbox['hook'];
                $context = $mbox['order'];
                $parsing = array(
                    'scope'  => $scope,
                    'field'  => $mbox['field'],
                    'unique' => $unique,
                );

                // create
                add_meta_box( $unique, $title , $render , $screen, $context, 'high', $parsing );
            }
        }


        // render
        public function render( $post, $data ) {

            // unpack
            $master = apply_filters( 'build_builder', [] );
            $unique = str_keys( $data['args']['unique'] );
            $field  = str_keys( $data['args']['field'] );
            

            // before
            do_action( "{$unique}_heads" );


            // fields
            if ( ! empty( $master['fields'][$field] ) ) {

                $nodes = $master['fields'][$field];
                foreach( $nodes['group'] as $key => &$field ) {
                    $nodes['group'][$key]['value'] = get_post_meta( $post->ID, $field['keys'], true );
                }

                $build_field = new rozard_builder_field;
                $build_field->view_form( $nodes );
            }


            // after
            do_action( "{$unique}_after" );


            // logic
            do_action( "{$unique}_logic" );
        }


        // saving
        public function saving_post( $post_id, $post ) {


            $master = apply_filters( 'build_builder', [] );
            $format = $post->post_type; 


            foreach( $this->create as $mbox ) {
 
                if ( ! in_array( $format, $mbox['hook'] ) ) {
                    continue;
                }

                $register = $mbox['field'];

                if ( ! empty( $master['fields'][$register] ) ) {
                    
                    $fields = $master['fields'][$register];

                    foreach( $fields['group'] as $field ) {
                        
                        $unique = $field['keys'];
                        
                        if ( isset( $_POST[ $unique ] ) ) {
                            update_post_meta( $post_id, $unique , $_POST[ $unique  ] );
                        } else {
                            delete_post_meta( $post_id, $unique );
                        }
                    }
                }
            }
        }




    /***  CHANGE  */


        private function change() {
            
            foreach( $this->change as $mbox ) {
    
            }
        }


        

    /***  REMOVE  */
        
        public function remove() {
            foreach( $this->remove as $mbox ) {
                remove_meta_box( $mbox['slug'], $mbox['hook'], $mbox['order'] );
            }
        }
    }
}