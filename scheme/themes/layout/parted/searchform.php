<?php

function theme_search_form_standard() {

    $render = sprintf('<form class="search" method="get" action="%s">
                            <div role="search" class="flex-a">
                            <input class="search-input" type="search" name="s" aria-label="Search site for:" placeholder="%s">
                            <button class="search-submit btn btn-primary" type="submit">%s</button>
                            </div>
                        </form>',
                        esc_url( home_url() ),
                        esc_html( 'To search, type and hit enter.', 'rozard_framework' ),
                        esc_html( 'Search', 'rozard_framework'),
                    );

    printf( $render );
}