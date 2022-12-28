<?php


/*** TOOLKIT PAGES */

if ( ! class_exists( 'tools' ) ) {


    class tools extends cores{

        protected $menus;
        protected $pages;

        public function __construct( $data ) {

            $this->menus = $data;
           
            // register to tools page
            add_action( 'tool_box', [$this, 'toolkit_menu' ] );
            add_action( 'admin_menu', [$this, 'import_menus' ] );

        }


        public function toolkit_menu() {

            foreach( $this->menus as $menu ) {

                $title  = $menu['title'];
                $slugs  = $menu['slugs'];
                $icon   = $menu['icon'];
                $caps   = $menu['caps'] ?: 'manage_options';
                $desc   = $menu['desc'];
                $links  = admin_url('admin.php?import='.$slugs );
                $action = $menu['action'];
             
    
                if ( ! current_user_can( $caps ) ) 
                {
                    return false;
                }
    
            
                echo '<div class="card">';
                    echo '<h2 class="title">'. $title .'</h2>';
                    echo '<p>'. $desc .' </p>';
                    echo '<p>';
    
                        // main action
                        if (  $menu['module'] === true ) 
                        {
                            echo '<a class="button" href="'.$links.'">Open</a>';
                        }
                       
                        // additional action
                        foreach ( $action as $name => $url  )
                        {
                            echo '<a class="button" href="'.$url.'">'. $this->str_text( $name ) . '</a>';
                        }
                    echo '</p>';
                echo '</div>';
            }
          
        }


        public function import_menus() {

            foreach( $this->menus as $menu ) {

                $title  = $menu['title'];
                $slugs  = $menu['slugs'];
                $icon   = $menu['icon'];
                $caps   = $menu['caps'] ?: 'manage_options';
                $desc   = $menu['desc'];
                $action = $menu['action'];

                if ( ! current_user_can( $caps ) ) 
                {
                    return false;
                }
                
                // register importer menus
                register_importer(  $slugs ,  $title ,  $desc , [$this, 'import_pages'] , 'dispatch' ) ;
            }
        }


        public function import_pages() {

            foreach( $this->menus as $menu ) {
                    
                $title  = $menu['title'];
                $slugs  = $menu['slugs'];

                echo '<div class="wrap toolkit '. $slugs  .'">';
                    echo '<section id="header">';
                        echo '<div id="title">';
                            echo '<h1 class="wp-heading-inline">'. $title .'</h1>';
                        echo '</div>';
                    echo '</section>';
                    echo '<section id="content" class="container">';
                        echo '<div class="columns">';
                            $hook = $this->str_keys( $menu['slugs'] ). '_hook';
                            do_action( $hook );
                            if ( developer_mode === true )
                            {
                                echo 'hook : '. $hook;
                            }
                        echo '</div>';
                    echo '</section>';
                echo '</div>';
            }
        }
    }
}