<?php


if ( ! class_exists( 'builder_object_menu' ) ) {

    class builder_object_menu{

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
            add_action('admin_menu', array( $this, 'main' ));
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


        private function create() {
    
            foreach( $this->create as $menu ) {
    
                if ( empty( $menu['slug'] ) && ! usr_can( $menu['caps'] ) ) {
                    continue;
                }
    
                $title =  str_text( $menu['name'] );
                $menus =  $title;
                $caps  =  ( empty( $menu['caps'] ) ) ? 'read' : str_keys( $menu['caps'] );
                $slugs =  ( empty( $menu['slug'] ) ) ? str_keys( $title ) : pure_url( $menu['slug'] );
                $icons =  $menu['icon'];
                $order =  absint( $menu['order'] );
                $hooks =  esc_url( $menu['hook'] );
    
    
                if ( empty( $parent ) ) {
                    add_menu_page( $title, $menus, $caps, $slugs, '', $icons, $order );
                }
                else {
                    add_submenu_page( $hooks, $title, $menus, $caps, $slugs, '', $order );
                }
            }
        }


    /***  CHANGE  */


        private function change() {
            
            foreach( $this->change as $menu ) {
    
            }
        }


    /***  REMOVE  */
        
        private function remove() {
            
            foreach( $this->remove as $menu ) {
    
                if ( empty( $menu['slug'] ) ) {
                    continue;
                }
                else if ( empty( $menu['hook'] ) ) {
                    remove_menu_page( $menu['slug'] );
                }
                else {
                    remove_submenu_page( $menu['hook'], $menu['slug'] );
                }
            }
        }
    }
}

