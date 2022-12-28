<?php


/*** FIELD MODEL */
if ( ! function_exists( 'proto_render_layout_table' ) ) {


    function proto_render_layout_table( array $head , array $body, array $caps = array() ) {


        if ( ! is_caps_valid( $caps ) ) {
            return;
        }

        $head = $head;
        $body = $body;

        echo '<table class="wp-list-table widefat fixed striped table-view-list">';
            echo '<thead>';
                echo '<tr>';
                    echo '<th class="check-column">No.</th>';
                    foreach( $head as $label ) {
                        echo '<th>'. $label .'</th>';
                    }
                echo '</tr>';
            echo '</thead>';
            echo '<tbody id="the-list">';
            foreach( $body as $key => $row ) {
                if ( is_array( $row ) ) {
                    echo '<tr class="">';
                        echo '<td class="check-column">'.$key.'</td>' ;
                        foreach( $row  as $col ) {
                            echo '<td>'.$col.'</td>' ;
                        }
                    echo '</tr>';
                } else {
                    echo '<tr class="">';
                    echo '<td class="check-column">'.$key.'</td>' ;
                    echo '<td>'.$row.'</td>' ;
                    echo '</tr>';
                }
            }
        echo '</table>';
    }

}
