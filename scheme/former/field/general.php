<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! trait_exists( 'rozard_former_field' ) ) {
    

    trait rozard_former_field {


        private $allowed = array( 'checkbox', 'color', 'date', 'datetime', 'editor', 'html', 'email', 'hidden', 'image', 'month', 'number',  'password',  'phone', 'post', 'radio',  'range', 'search', 'select', 'switch', 'term', 'text', 'textarea', 'time', 'upload', 'url', 'user', 'week');


    /***  GETTER */

        public function field_conf( $field ) {


            if ( ! is_admin() || ! uris_has( array( 'options', 'admin-ajax' ) )  ) {
                return;
            }


            if ( ! usr_can( 'manage_options' ) || ! usr_can( $field['caps'] ) ) {
                return;
            }


            // filter editor field, its not supported for option page
            if ( $field['type'] === 'editor' ) {
               return;
            }


            // props
            $keyid  =  $field['keys'];
            $slugs  =  $field['slug'];
            $secid  =  $field['secid'];
            $calls  =  array( $this, 'config' ) ;
            $title  =  str_text( $field['name'] );
            $parse  =  array( 
                'label_for' => $keyid,
                'field'     => $field, 
            );

            add_settings_field( $keyid, $title, $calls, $slugs, $secid, $parse );
        }


        public function field_libs() {
        }


        public function set_field( $data, $mode = '' ) {
            $render = $this->main_take( $data, $mode );
            printf( $render );
        }


        public function get_field( $data, $mode = '' ) {
            
           
            if ( $mode === 'group' ) {
                $render = $this->group( $data );
            }
            else {
                $render = $this->render( $data );
             }
 
            return $render ;
        }


        public function pure_calls( $type ) {

            if ( ! in_array( $type, $this->allowed )  ) {
                $result = '';
            }
            else if ( $type === 'checkbox' ) {
                $result = 'pure_text';
            }
            else if ( $type === 'color' ) {
                $result = 'pure_hex';
            }
            else if ( $type === 'date' ) {
                $result = 'pure_date';
            }
            else if ( $type === 'datetime' ) {
                $result = 'pure_datetime';
            }
            else if ( $type === 'editor' ) {
                $result = 'wp_kses_post';
            }
            else if ( $type === 'email' ) {
                $result = 'pure_mail';
            }
            else if ( $type === 'hidden' ) {
                $result = 'pure_text';
            }
            else if ( $type === 'number' ) {
                $result = 'pure_text';
            }
            else if ( $type === 'image' ) {
                $result = 'pure_url';
            }
            else if ( $type === 'month' ) {
                $result = 'pure_date';
            }
            else if ( $type === 'phone' ) {
                $result = 'pure_phone';
            }
            else if ( $type === 'radio' ) {
                $result = 'absint';
            }
            else if ( $type === 'range' ) {
                $result = 'intval';
            }
            else if ( $type === 'switch' ) {
                $result = 'pure_text';
            }
            else if ( $type === 'text' ) {
                $result = 'pure_text';
            }
            else if ( $type === 'textarea' ) {
                $result = 'pure_texa';
            }
            else if ( $type === 'time' ) {
                $result = 'pure_time';
            }
            else if ( $type === 'url' ) {
                $result = 'pure_url';
            }
            else if ( $type === 'week' ) {
                $result = 'pure_week';
            }
            else {
                $result = 'pure_text';
            }

            return $result;
        }
    
    
        public function pure_field( $type, $value ) {
            

            if ( ! in_array( $type, $this->allowed ) ) {
                $result = '';
            }
            else if ( $value === null ) {
                $result = '';
            }
            else if ( empty( $value ) ) {
                $result = '';
            }
            else if ( $type === 'checkbox' ) {
                $result = pure_text( $value );
            }
            else if ( $type === 'color' ) {
                $result = pure_hex( $value );
            }
            else if ( $type === 'date' ) {
                $result = pure_date( $value );
            }
            else if ( $type === 'datetime' ) {
                $result = pure_datetime( $value );
            }
            else if ( $type === 'editor' ) {
                $result = wp_kses_post( $value );
            }
            else if ( $type === 'email' ) {
                $result = pure_mail( $value );
            }
            else if ( $type === 'hidden' ) {
                $result = pure_text( $value );
            }
            else if ( $type === 'number' ) {
                $result = pure_text( $value );
            }
            else if ( $type === 'image' ) {
                $result = pure_url( $value );
            }
            else if ( $type === 'month' ) {
                $result = pure_date( $value );
            }
            else if ( $type === 'password' ) {
                $result = $value;
            }
            else if ( $type === 'phone' ) {
                $result = pure_phone( $value );
            }
            else if ( $type === 'radio' ) {
                $result = absint( $value );
            }
            else if ( $type === 'range' ) {
                $result = intval( $value );
            }
            else if ( $type === 'switch' ) {
                $result = pure_text( $value );
            }
            else if ( $type === 'text' ) {
                $result = pure_text( $value );
            }
            else if ( $type === 'textarea' ) {
                $result = pure_texa( $value );
            }
            else if ( $type === 'time' ) {
                $result = pure_time( $value );
            }
            else if ( $type === 'url' ) {
                $result = pure_url( $value );
            }
            else if ( $type === 'week' ) {
                $result = pure_week( $value );
            }
            else {
                $result = '';
            }

            return $result;
        }



    /***  RENDER */

        
        // render config field
        public function config( array $fields ) {
            $calls = 'field_' . $fields['field']['type'];
            $field = call_user_func( array( $this, $calls ) , $fields['field']);
            printf( $field );
        }


        // render group field
        private function group( array $group ) {

            $render = '';

            $render .= sprintf( '<table class="form-table" role="presentation"><tbody>');

            foreach( $group as $field ) {

                $render .= sprintf( '<tr class="row" style="width:%s;float:left;">',
                                esc_attr( $field['width'] . '%'),
                            );

                $render .= sprintf( '<th><label for="%s"> %s </label></th>', 
                                esc_attr( $field['keys'] ),
                                esc_attr( $field['name'] )
                            );
                $render .= sprintf( '<td>' );
                $render .= $this->render( $field );
                $render .= sprintf( '</td>' );
                $render .= sprintf( '</tr>' );
            }

            $render .= sprintf( '</tbody></table>' );

            return $render;
        }


        // render single field
        private function render( array $field ) {


            
            // validate field type
            if ( ! in_array( $field['type'], $this->allowed ) ) {
                return;
            }
         

            // validate field caps
            if ( ! usr_can( $field['caps'] ) ) {
                dev( 'Your access level doest not meet information minimum grade.' );
                return;
            }


            // info
            $format = $field['type'];
            $unique = $field['keys'];
            $value  = ( isset( $field['value'] )) ? $field['value'] : '';

            

            // id
            if ( isset( $field['attr']['id'] ) ) {
                $keysid = $field['attr']['id'];
            } else {
                $keysid = $unique;
            }


            // name
            if ( isset( $field['attr']['name'] ) ) {
                $nameid = $field['attr']['name'];
            } else {
                $nameid = $unique;
            }


            // rendering
            $calls = str_keys( 'field_' . $format );
            $skels = call_user_func( array( $this, $calls ) , $field );

            return $skels;
        }



    /***  FIELDS */

   
        public function field_checkbox( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];


            $fields = sprintf( '<input type="checkbox" id="%s" name="%s" value="1" %s/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                checked( 1, $value, false),
                            );

            return $fields;
        }


        public function field_color( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];


            $fields = sprintf( '<input type="color" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return $fields;
        }


        public function field_date( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="date" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return $fields;
        }


        public function field_datetime( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="datetime-local" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return $fields;
        }


        public function field_editor( array $field ) {
            
            
            if ( uris_has( array( 'sites', 'site-', 'settings', 'options', 'term.php', 'edit-tags' ) )  ) {
                return '';
            } 


            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '%s', wp_editor( $value, $names ) );

            return $fields;
        }


        public function field_html( array $field ) {
            $fields = sprintf( '%s', wp_kses_post(  $field['value'] ) );
            return $fields;
        }


        private function field_email( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="email" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return $fields;
        }


        public function field_hidden( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="hidden" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return  $fields;
        }


        public function field_image( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="image" id="%s" name="%s" src="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_url( $value ), 
                            );

            return  $fields;
        }


        public function field_month( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="month" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return  $fields;

     
            return $fields;
        }


        public function field_number( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="number" id="%s" name="%s" value="%s" />', 
                            esc_attr( $keyid ), 
                            esc_attr( $names ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_password( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="password" id="%s" name="%s" value="%s" />', 
                            esc_attr( $keyid ), 
                            esc_attr( $names ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_phone( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="tel" id="%s" name="%s" value="%s" />', 
                            esc_attr( $keyid ), 
                            esc_attr( $names ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }

        /** Not ready yet */
        public function field_post( array $field ) {

            $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%s" />', 
                            esc_attr( $format ), 
                            esc_attr( $keysid ), 
                            esc_attr( $nameid ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_radio( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];


            $fields = sprintf( '<input type="radio" id="%s" name="%s" value="1" %s/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                checked( 1, $value, false),
                            );

            return $fields;
        }


        public function field_range( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="range" id="%s" name="%s" value="%s" />', 
                            esc_attr( $keyid ), 
                            esc_attr( $names ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        /** Not ready yet */
        public function field_search( array $field ) {
            
            $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%s" />', 
                            esc_attr( $format ), 
                            esc_attr( $keysid ), 
                            esc_attr( $nameid ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_select( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];
            $lists = '';



            foreach ( $field['list'] as $keys => $option ) {

                $lists .=  sprintf( '<option value="%s" %s>%s</option>',
                                    esc_attr( $keys ),
                                    selected( $keyid, $value, false ),
                                    esc_html( $option ),
                                );
            }

            $fields = sprintf( '<select name="%s" id="%s">%s</select>',
                                esc_attr( $names ), 
                                esc_attr( $keyid ), 
                                $lists, 
                            );


            return $fields;
        }


        public function field_switch( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];


            $fields = sprintf( '<label class="toggle">
                                    <input class="toggle-checkbox" type="checkbox" name="%s" id="%s" value="%s" %s>
                                    <div class="toggle-switch"></div><span class="toggle-label">%s</span>
                                </label>',
                                esc_attr( $names ), 
                                esc_attr( $keyid ), 
                                esc_attr( $keyid ), 
                                checked( $keyid, $value, false),
                                'test',
                            );


            return $fields;
        }


        /** Not ready yet */
        public function field_term( array $field ) {

            $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%s" />', 
                            esc_attr( $format ), 
                            esc_attr( $keysid ), 
                            esc_attr( $nameid ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_text( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="text" id="%s" name="%s" value="%s" />', 
                            esc_attr( $keyid ), 
                            esc_attr( $names ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_textarea( array $field ) {
            
            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<textarea id="%s" name="%s" >%s</textarea>', 
                            esc_attr( $keyid ), 
                            esc_attr( $names ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_time( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="time" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return $fields;
        }


        /** Not ready yet */
        public function field_upload( array $field ) {
            
            $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%s" />', 
                            esc_attr( $format ), 
                            esc_attr( $keysid ), 
                            esc_attr( $nameid ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_url( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="url" id="%s" name="%s" value="%s" />', 
                            esc_attr( $keyid ), 
                            esc_attr( $names ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        /** Not ready yet */
        public function field_user( array $field ) {

            $fields = sprintf( '<input type="%s" id="%s" name="%s" value="%s" />', 
                            esc_attr( $format ), 
                            esc_attr( $keysid ), 
                            esc_attr( $nameid ), 
                            esc_attr( $value  ),
                        );

            return $fields;
        }


        public function field_week( array $field ) {

            $keyid = $this->get_keysid( $field );
            $names = $this->get_nameid( $field );
            $value = $field['value'];

            $fields = sprintf( '<input type="week" id="%s" name="%s" value="%s"/>', 
                                esc_attr( $keyid ), 
                                esc_attr( $names ), 
                                esc_attr( $value ), 
                            );

            return $fields;
        }


    /***  HELPER */

        private function get_keysid( array $field ) {

            // id
            if ( isset( $field['attr']['id'] ) ) {
                $keysid = $field['attr']['id'];
            } else {
                $keysid = sanitize_html_class( str_slug( $field['keys'] )  );
            }

            return $keysid;
        }


        private function get_nameid( array $field ) {
            
            // name
            if ( isset( $field['attr']['name'] ) ) {
                $nameid = $field['attr']['name'];
            } else {
                $nameid = $field['keys'];
            }

            return $nameid;
        }
    

    /***  VALUES */


        private function get_data_user(){

        }

        private function get_data_post(){
            
        }

        private function get_data_conf(){
            
        }


        private function get_data_site(){
            
        }

        private function get_data_term(){
            
        }


        private function get_data_dbms(){

        }



    /***  SAVING */

        private function save_data_user(){

        }

        private function save_data_post(){
            
        }

        private function save_data_conf(){
            
        }


        private function save_data_site(){
            
        }

        private function save_data_term(){
            
        }


        private function save_data_dbms(){

        }

    /***  CRYPTO */

        private function text_encrypt() {

        }


        private function text_decrypt() {

        }


        private function file_encrypt() {

        }


        private function file_decrypt() {

        }
    }
}
