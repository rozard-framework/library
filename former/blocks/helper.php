<?php


class rozard_former_helper{


    public function data( $data ) {
        
        $result = array();

        foreach( $data as $key => $form ) {

           $unique = $form['filter'];
            
            if ( $form['filter'] === $unique ) {
                
                // forms
                $form_id =  str_slug( $key .'-'. $form['title'] );

              
                $result[ $unique ]['render'][$form_id]['filter']  =  $form['filter'] ;
                $result[ $unique ]['render'][$form_id]['title']   =  $form['title'] ;
                $result[ $unique ]['render'][$form_id]['access']  =  $form['access'] ;
                $result[ $unique ]['render'][$form_id]['datums']  =  $form['datums'] ;
                $result[ $unique ]['render'][$form_id]['context'] =  $form['context'] ;
                $result[ $unique ]['render'][$form_id]['layout']  =  $form['layout'] ;

              
                // section
                foreach( $form['section'] as $section_id => $section ) {

                    // render prepare field
                    $sect_id =  str_slug( $key .'-'. $section_id );

                    $result[$unique]['render'][$form_id]['section'][$sect_id]['title']  =  $section['title'];
                    $result[$unique]['render'][$form_id]['section'][$sect_id]['descs']  =  $section['descs'];
                    $result[$unique]['render'][$form_id]['section'][$sect_id]['icons']  =  $section['icons'];
                    $result[$unique]['render'][$form_id]['section'][$sect_id]['access'] =  $section['access'];
                    $result[$unique]['render'][$form_id]['section'][$sect_id]['event']  =  $section['event'];
                    

                    // unset section
                    unset($form['section'][$section_id] );


                    // fields
                    foreach ( $section['fields'] as $field_id => $field ) {
                    

                        // assign field unique
                        $field_key =  str_slug( $form_id. '-'. $sect_id .'-'. $field_id  );

                        // render prepare field
                        $result[ $unique ]['render'][$form_id]['section'][$sect_id]['fields'][$field_key] = $field;
                        $result[ $unique ]['render'][$form_id]['section'][$sect_id]['fields'][$field_key]['unique'] = $field_key;


                        // saving prepare field
                        $result[ $unique ]['saving'][ $field_key] = $field;
                        $result[ $unique ]['saving'][ $field_key]['unique'] = $field_key;
                    }
                }
            }
        }
        return $result;
    }


    public function pure( $type, $value ) {

    }
}