<?php

declare(strict_types=1);
if ( ! defined('ABSPATH') ){exit;}
if ( ! class_exists('proto_tab_content') ) {
    
    class proto_tab_actions{

        public function __construct( string $parent, $targets = array() ) {
            $parent = sanitize_html_class( $parent );
            echo '<ul class="tab-actions flex-a">';
            foreach( $targets as $keys => $item ) {

                if ( ! current_user_can( $item['caps'] ) ) {
                    return;
                }

                $target = sanitize_html_class( $keys );
                $icons  = sanitize_text_field( $item['icons'] );
                $title  = sanitize_text_field( $item['title'] );
                echo '<li class="tab-action flex-a" data-parent="'. esc_attr(  $parent ) .'"  data-target="'. esc_attr( $target ) .'">';
                    echo '<i class="'.  esc_attr( $icons ) .'"></i>';
                    echo '<p class="title">'. esc_html( $title ) .'</p>';
                echo '</li>';
            }
            echo '</ul>';
        }
    }
}