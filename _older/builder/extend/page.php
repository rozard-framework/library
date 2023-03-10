<?php


class builder_extend_page {


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

        $datums = $this->data_modes( $data );
        $this->create = $datums[0];
        $this->change = $datums[1];
        $this->remove = $datums[2];

        $this->hook();
        unset( $data );
    }


    private function hook() {
        add_action('admin_menu', array( $this, 'create' ) );
    }


    
/***  CREATE */


    public function create() {

        foreach( $this->create as $page ) {

  
            $title  =  str_text( $page['name'] );
            $menus  =  $title;
            $caps   =  ( empty( $page['caps'] ) ) ? 'read' : $page['caps'];
            $slug   =  ( empty( $page['slug'] ) ) ? str_keys( $title ) : pure_url( $page['slug'] );
            $calls  =  array( $this, 'render' );
            $icons  =  $page['icon'];
            $order  =  $page['order'];
   

            switch ( $page['hook'] ) {
                case '':
                    add_menu_page( $title, $menus, $caps, $slug, $calls, $icons, $order );
                    break;
                case null:
                    add_menu_page( $title, $menus, $caps, $slug, $calls, $icons, $order );
                    break;
                case 'comment':
                    add_comments_page( $title, $menus, $caps, $slug, $calls,  $order );
                    break;
                case 'dashboard':
                    add_dashboard_page( $title, $menus, $caps, $slug, $calls, $order );
                    break;
                case 'management':
                    add_management_page( $title, $menus, $caps, $slug, $calls, $order );
                    break;
                case 'media':
                    add_media_page( $title, $menu, $menus, $slug, $calls, $order );
                    break;
                case 'setting':
                    add_options_page( $title, $menu, $menus, $slug, $calls, $order );
                    break;
                case 'theme':
                    add_theme_page( $title, $menu, $menus, $slug, $calls, $order );
                    break;
                case 'user':
                    add_users_page( $title, $menu, $menus, $slug, $calls, $order );
                    break;
                default:
                    $parent = pure_url( $page['parent'] );
                    add_submenu_page( $parent, $title, $menus, $caps, $slug, $calls, $order );
            }
        }
    }


    public function render() {

        $paged = get_current_screen()->id;
        $paged = str_replace( 'toplevel_page_', '', $paged );
        $paged = str_replace( 'admin_page_', '', $paged );



        foreach( $this->create as $page ) {
          
            $slug = ( empty( $page['slug'] ) ) ? str_keys( $page['name'] ) : pure_url( $page['slug'] );

            if ( $paged === $slug ) {
                $this->layout( str_keys( $slug ), str_slug( $page['model'] ) );
            }
        }
    }


    private function layout( string $slug, string $mode ) {

        $slug = esc_attr( pure_slug( $slug ) );
        $mode = esc_attr( pure_key( $mode) );

        echo '<div class="wrap build '. esc_attr( $mode ) . '">';
            echo '<header>';
                do_action( "{$slug}_head" );
            echo '</header>';
            echo '<main class="row">';
                echo '<div class="page-left">';
                    do_action( "{$slug}_left" );
                echo '</div>';
                echo '<div class="page-right">';
                    do_action( "{$slug}_right" );
                echo '</div>';
                echo '<div class="page-side">';
                    do_action( "{$slug}_side" );
                echo '</div>';
            echo '</main>';
            echo '<div class="footer">';
                do_action( "{$slug}_foot" );
            echo '</div>';
        echo '</div>';
    }


/***  CHANGE */


    


/***  REMOVE */


/***  HELPER */
}
