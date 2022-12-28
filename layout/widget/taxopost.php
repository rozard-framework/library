<?php

declare(strict_types=1);
if ( ! defined('ABSPATH') ){exit;}
if ( ! class_exists('widget_taxopost') ) {
    
    class widget_taxopost{

        use lib_arrays;
        use lib_getter;

        public function __construct( string $caps ) {

            if ( ! current_user_can( sanitize_key( $caps ) ) ) {
                return;
            }

            global $wp;
            global $post_type; 
            $taxonomies = $this->get_post_taxo( $post_type );
            $query_uris = $this->array_base_url_query( $wp->query_vars);

            // validate post have taxonomy
            if( empty( $taxonomies ) ) {return;};


            echo '<div class="card widget taxopost">';
                echo '<div class="header flex-a">';
                    echo '<i class="las la-folder-open"></i>';
                    echo '<h3> Metafil </h3>' ;
                echo '</div>';

                foreach( $taxonomies as $taxonomy ) {

                    $name = $taxonomy->name;
                    $terms = get_terms( array(
                        'taxonomy' =>   $name,
                        'hide_empty' => true,
                    ));

                    if ( empty( $terms) || ! current_user_can( $taxonomy->cap->assign_terms ) ) {
                        continue;
                    }

                    echo '<div id="section-'. esc_attr( $taxonomy->name ) .'" class="section">';
                        echo '<div class="panelist flex-a">';
                            echo '<h5 class="title">'. esc_html( $taxonomy->label ) .'</h5>';

                            if ( current_user_can( $taxonomy->cap->manage_terms ) ) {
                                
                                echo '<a href="'. esc_url( admin_url('/edit-tags.php?taxonomy=' . esc_attr( $taxonomy->name) ) ).'"><i class="las la-sliders-h"></i></a>';
                            }

                            echo '<div href="test" class="droping" data-target="tax-post-widget-'. esc_attr( $taxonomy->name ) .'">';
                                echo '<i class="las la-plus-circle"></i>';
                                echo '<i class="las la-minus-circle"></i>';
                            echo '</div>';
                        echo '</div>';
                        echo '<ul id="tax-post-widget-'. esc_attr( $taxonomy->name ) .'" class="listing">';
                            foreach( $terms as $term ) {

                                if ( $taxonomy->name !== 'category'  ) {
                                    $url_query = esc_url( admin_url('/edit.php?' ) . $query_uris . '&'.esc_attr( $taxonomy->name ) .'='. $term->slug ) ;
                                } else {
                                    $url_query = esc_url( admin_url('/edit.php?' ) . $query_uris . '&cat='. esc_attr( $term->term_id ) );
                                }

                                echo '<li class="item">';
                                    echo '<a class="action" href="'. esc_url( $url_query ) .'">';
                                    echo esc_html( $term->name );
                                    echo '</a>';
                                echo '</li>';
                            }
                        echo '</ul>';
                    echo '</div>'; 
                }
            echo '</div>';
        }
    }
}