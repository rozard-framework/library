<?php


class rozard_module_mboxes extends rozard{

    private array  $data;


    public function __construct( array $data ) {
        $this->data = $data;
        $this->hook( $data );
    }


    private function hook() {
        add_action( 'admin_menu',         array( $this, 'make' ));
        add_action( 'network_admin_menu', array( $this, 'make' ));
    }


    public function make() {

        // edit method
        $mbox = $this->data;

     
        if ( ! usr_can( $mbox['caps'] ) ) {
            return;
        }


        $keys = $mbox['keys'];   // unique id
        $name = $mbox['name'];   // label            
        $node = $mbox['page'];   // screen id     | attached page 
        $part = $mbox['part'];   // show context  | attached element on screen
        $sort = $mbox['sort'];   // prority       | high |  core | default | low
        $args = array(
            'keys' => $keys,
            'load' => $mbox['load'],
        );

        add_meta_box( $keys, $name, array( $this, 'view' ), $node, $part, $sort, $args );
    }


    public function view( $args, $parse ) {

        $mods = $parse['args']['load'];
        $keys = $parse['args']['keys'];

       
        foreach( $mods as $key => $orders ) {

            foreach( $orders as $type => $data ) {

                if ( $type === 'former' ) {
                    $create = new rozard_module_form;
                    $create->view( $data );
                }
            }
        }
    }
}