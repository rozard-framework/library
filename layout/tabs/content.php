<?php

declare(strict_types=1);
if( ! defined('ABSPATH') ){exit;}
if ( ! class_exists('proto_tab_content') ) {

    class proto_tab_content{

        use lib_string;

        public function __construct( string $parent, $targets = array() ) {

            echo '<div id="'. $parent .'">';
                foreach( $targets as $key => $item ) {

                    if ( ! current_user_can( $item['caps'] ) ) {
                        continue;
                    }

                    $active = '';
                    $class  = $this->str_slug( $key);
                    $calls  = $this->str_keys( $parent. '_' .  $key);

                    if ( ! isset( $_SESSION['first_run'] ) ){
                        $_SESSION['first_run'] = 1;
                        $active = 'active';
                    }

                    echo '<div id="'. esc_attr( $class ) .'" class="tab-content '. esc_attr( $active ) .'">';
                        do_action( $calls );
                    echo '</div>';
                };
            echo '</div>';
        }
    }
}