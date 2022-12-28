<?php

/*** FIELD MODEL */


if ( ! trait_exists( 'tpl_fields' ) ) {

    trait tpl_fields {

        // master
        protected $data = array();

        // models
        protected $cores;
        protected $access;
        protected $render;
        protected $extras;
        protected $native = array( 'color', 'date', 'datetime', 'datetime-local', 'email', 'file', 'hidden', 'month', 'number', 'password', 'range', 'tel', 'text', 'time', 'url', 'week'  ) ;

        
        public function fields( $data = array() ) {

            if ( empty( $data ) === false &&  $data !== null  ) {
                foreach( $data as $model ) {
                    array_push( $this->data, $model);
                }
            }

            $this->render(); 
        }



        // method - group rendering selection 
        private function render() {

           
            $access_filter = $this->access_validator( 'field', $this->data );

            foreach ( $this->data as $field ) {

                // master data preparation

                $this->cores  = $field['cores'];
                $this->access = $field['access'];
                $this->render = $field['render'];
                $this->extras = $field['extras'];


                // validation field before render
                if ( in_array( $field['cores']['unique'],  $access_filter )  ) {
                    
                    // begin render field
                    $callback = 'mode_'. $field['cores']['mode'];   
                    call_user_func( array( $this, $callback ), '' );
                }
            }
        }


        // render - field as table
        private function mode_table() {

            $id     = $this->cores['unique'];
            $label  = $this->cores['label'] ?: null;
            $desc   = $this->cores['desc'] ?: null;
            $error  = $this->cores['error'] ?? null;
            $type   = $this->cores['type'];
            $method = ( in_array( $type , $this->native ) ) ? 'native' : $type;

            echo '<tr class="field '. esc_attr( $type ) .' '. $this->str_slug($id) .' table">';
                echo '<th scope="row">';
                    echo '<label class="form-label" for="'. esc_attr( $id ) .'">'. esc_html( $label ) .'</label>';
                echo '</th>';
                echo '<td>';
                    call_user_func( array( $this, $method ), '' );

                    if ( $desc !== null ) {
                        echo '<p class="description">'. esc_html( $desc ) .'</p>';
                    } 
    
                    if ( $error !== null ) {
                        echo '<p class="form-input-hint error '. $this->str_slug($id) .'">'. esc_html( $error ) .'</p>';
                    }   
                
                echo '</td>';
            echo '</tr>';
        }


        // render - field as block
        private function mode_normal() {

            $id     = $this->cores['unique'];
            $desc   = $this->cores['desc'] ?? null;
            $error  = $this->cores['error'] ?? null;
            $type   = $this->cores['type'];
            $method = ( in_array( $type , $this->native ) ) ? 'native' : $type;

            echo '<div class="field '. esc_attr( $type ) .' '. $this->str_slug($id) .' block">';

                call_user_func( array( $this, $method ), '' );
            
                if ( $desc !== null ) {
                    echo '<p class="description">'. esc_html( $desc ) .'</p>';
                } 

                if ( $error !== null ) {
                    echo '<p class="form-input-hint error '. $this->str_slug($id) .'">'. esc_html( $error ) .'</p>';
                }   
                
            echo '</div>';
        }


        // render -  field native template 
        private function native() {

            $id     = $this->cores['unique'];
            $type   = $this->cores['type'];
            $value  = $this->default_value();
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['label'] ?: null;
            $getatr = $this->extras['attribute'] ?? [];
            $setatr = $this->array_string( $getatr , 'html-attr' ) ;  
            $before = $this->render['before'] ?? null;  
            $after  = $this->render['after'] ?? null;  
   
           
            if ( $label !== null  ) {
                echo '<label class="form-label  flex-a" for="'. esc_attr( $id ) .'"><i class="label-icon '. $icons .'"></i> '. esc_html( $label ) .'</label>';
            }
            echo '<fieldset class="form-group">';
                if ( ! empty( $before ) ) { echo '<div class="extra before">'. esc_html( $before ).'</div>'; } // render before field element
                echo '<input  type="'. esc_attr( $type ).'" id="'. esc_attr( $id ).'" class="form-input" name="'. esc_attr( $id ).'"  value="'. $value .'" '.$setatr.' />';
                if ( ! empty( $after ) ) { echo '<div class="extra after">'. esc_html( $after ).'</div>'; }   // render after field element
            echo '</fieldset>';
        }


        // render -  field button template 
        private function button() {
            $id     = $this->cores['unique'];
            $type   = $this->cores['type'];
            $value  = $this->cores['label'];
            $class  = $this->render['class'] ?? null;
            $getatr = $this->extras['attribute'] ?? [];
            $attr   = $this->array_string( $getatr , 'html-attr' ) ;  
   
            echo '<input  type="'. esc_attr( $type ).'" id="'. esc_attr( $id ).'" class="form-input '. $class .'" name="'. esc_attr( $id ).'"  value="'. $value .'" '.$attr.' />';

        }


        // render - field image template 
        private function image() {
            $id     = $this->cores['unique'];
            $type   = $this->cores['type'];
            $value  = $this->cores['value'];
            $class  = $this->render['class'] ?? null;
            $getatr = $this->extras['attribute'] ?? [];
            $attr   = $this->array_string( $getatr , 'html-attr' ) ;  
   
            echo '<input  type="'. esc_attr( $type ).'" id="'. esc_attr( $id ).'" class="form-input '. $class .'" name="'. esc_attr( $id ).'"  src="'. $value .'" '.$attr.' />';
        }


        // render - field checkbox template 
        private function checkbox() {

            $id     = $this->cores['unique'];
            $value  = $this->default_value();
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['label'] ?: null;
            $class  = $this->render['class'] ?? null;
            $option = $this->render['option'];  
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;  
            $before = $this->render['before'] ?? null;  
            $after  = $this->render['after'] ?? null;  
           
            echo '<label class="form-label"><i class="label-icon '. $icons .'"></i> '. esc_html($label) .'</label>';
            foreach( $option as $key => $title ) 
            {
                echo '<label class="form-checkbox '. esc_attr( $class ) .'">';
                    echo '<input type="checkbox" id="'. esc_attr( $key ) .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $key ) .'" '. $attr .' '. checked( $key, $value, false ) .'>';
                    echo '<i class="form-icon"></i>'. esc_html( $title );
                echo '</label>';
            }
        }


        // render - field wp data cores template 
        private function cores() {
            
            $id     = $this->cores['unique'];
            $value  = $this->default_value();
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['label'] ?: null;
            $class  = $this->render['class'] ?? null;
            $option = $this->render['option'];  
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;  


            if ( $this->extras['attribute']['data-scope'] === 'post' ) {

                $query = [
                    'caps'   => $this->access['caps'],
                    'method' => 'find-post',
                    'query'  => $this->extras['post'],
                ];
                $query = $this->encrypt( json_encode( $query ) );

            }
            else if ( $this->extras['attribute']['data-scope'] === 'term' ) {

                $query = [
                    'caps'   => $this->access['caps'],
                    'method' => 'find-term',
                    'query'  => $this->extras['term'],
                ];
                $query = $this->encrypt( json_encode( $query ) );

            }
            else if ( $this->extras['attribute']['data-scope'] === 'user' ) {

                $query = [
                    'caps'   => $this->access['caps'],
                    'method' => 'find-user',
                    'query'  => '',
                ];
                $query = $this->encrypt( json_encode( $query ) );
            }

            
            echo '<label class="form-label flex-a"><i class="label-icon '. $icons .'"></i> '. esc_html($label) .'</label>';
            echo '<fieldset class="form-group cores '.$class.'">';
                echo '<div id="choosen"></div>';
                echo '<input type="hidden" class="value" id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $value ) .'">';
                echo '<input type="text" id="search-cores" name="search-cores" data-model="'. $query .'" value="" '. $attr .' >';
                echo '<div class="overlay">';
                    echo '<ul class="options shadow"></ul>';
                echo '</div>';
            echo '<fieldset class="form-group">';
        }
        

        // render - field wp editor template
        private function editor() {
           
            $id    = $this->cores['unique'];
            $value = $this->cores['value'];
            $label = $this->cores['label'] ?: null;
            $icons = $this->cores['icons'] ?? null;
            $class = $this->render['class'];

            echo '<fieldset class="form-group '. $class .'">';
                echo '<label class="form-label " for="'. esc_attr( $id ) .'"><i class="label-icon '. $icons .'"></i> '. esc_html( $label ) .'</label>';
                wp_editor( $value , $id , $this->extras['attribute'] );
            echo '</fieldset>';
        }


        // render - field radio template 
        private function radio() {

            $id     = $this->cores['unique'];
            $value  = $this->default_value();
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['label'] ?: null;
            $class  = $this->cores['class'] ?? null;
            $option = $this->render['option'];  
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;  


            echo '<label class="form-label " for="'. esc_attr( $id ) .'"><i class="label-icon '. $icons .'"></i> '. esc_html( $label ) .'</label>';
            foreach( $option as $key => $title ) 
            {
                echo '<label class="form-radio '. $class .'">';
                    echo '<input type="radio" id="'. esc_attr( $key ) .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $key ) .'" '. checked( $key, $value, false ) .'>';
                    echo '<i class="form-icon"></i>'. esc_html( $title );
                echo '</label>';
            }
        }


        // render - field section template 
        private function divider() {

            $id     = $this->cores['unique'];
            $value  = $this->cores['info'];
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['title'] ?: null;
            $class  = $this->cores['class'] ?? null;
            $option = $this->render['option'];  

            echo '<div class="divider '. esc_attr( $class ) .'">';
                echo '<h1>'. esc_html( $label ) .'</h1>';
                echo '<p>'.  esc_html( $value ) .'</p>';
            echo '</div>';

        }


        // render - field search template 
        private function search() {

            // based data 
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;
            $button = ( empty( $this->display['after'] ) ) ? 'hide' : null;
          

            // query data 
            if ( $this->cores['scope'] === 'internal'  ) 
            {
                $caps  = [ 'caps' => $this->access['caps'] ];
                $merge = array_merge( $this->render['option']['internal'] , $caps);
                $query = $this->encrypt( json_encode( $merge ) );
            }
            else if ( $this->cores['scope'] === 'external'  ) 
            {
                $query  = $this->render['option']['external'] ;
            }

         
            echo '<div class="input-group">';
                if ( ! empty( $this->display['icons']  ) ) {
                    echo '<span class="input-group-addon"><i class="'.  $this->display['icons'] .'"></i></span>';
                }
                echo '<input type="text" class="form-input" data-model="'.$query .'" value="" '.$attr.'">';
                if ( ! empty( $this->display['after']  ) ) {
                    echo '<button class="btn search-btn btn-primary input-group-btn">'. $this->display['after'] .'</button>';
                }
            echo '</div>';
        }


        // render - field select template 
        private function select() {

            $id     = $this->cores['unique'];
            $value  = $this->default_value();
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['label'] ?: null;
            $option = $this->render['option'];  
            $class  = $this->cores['class'] ?? null;
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;  
            $before = $this->render['before'] ?? null;  
            $after  = $this->render['after'] ?? null;  
            
            echo '<label class="form-label " for="'. esc_attr( $id ) .'"><i class="label-icon '. $icons .'"></i> '. esc_html( $label ) .'</label>';
            echo '<fieldset class="form-group">';
                if ( ! empty( $before ) ) { echo '<div class="extra before">'. esc_html( $before ).'</div>'; } // render before field element
                echo '<select id="'. esc_attr( $id ) .'" name="'. esc_attr( $id ) .'"  class="action form-select '. $class .'" '.$attr.'  >';
                foreach( $option as $key => $title ) 
                {
                    echo ' <option value="'. esc_attr( $key ) .'" '. selected( esc_attr( $key ) , esc_attr( $value ), false ) .'>'.esc_html( sanitize_html_class( $title ) ).'</option>';
                }
                if ( ! empty( $after ) ) { echo '<div class="extra after">'. esc_html( $after ).'</div>'; }   // render after field element
                echo '</select>';
            echo '</fieldset">';
        }


        // render -  field submit template 
        private function submit() {
            $id     = $this->cores['unique'];
            $type   = $this->cores['type'];
            $value  = $this->cores['label'];
            $class  = $this->render['class'] ?? null;
            $getatr = $this->extras['attribute'] ?? [];
            $attr   = $this->array_string( $getatr , 'html-attr' ) ;  
    
            echo '<input  type="'. esc_attr( $type ).'" id="'. esc_attr( $id ).'" class="form-input '. $class .'" name="'. esc_attr( $id ).'"  value="'. $value .'" '.$attr.' />';
        }
        

        // render - field search template 
        private function switch() {

            $id     = $this->cores['unique'];
            $value  = $this->default_value();
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['label'] ?: null;
            $option = $this->render['option'];  
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;  
            $before = $this->render['before'] ?? null;  
            $after  = $this->render['after'] ?? null;  

            echo '<label class="form-label " for="'. esc_attr( $id ) .'"><i class="label-icon '. $icons .'"></i> '. esc_html( $label ) .'</label>';
            foreach( $option as $key => $title ) 
            {
                echo '<label class="form-switch">';
                    echo '<input type="checkbox" id="'. esc_attr( $key ) .'" name="'. esc_attr( $id ) .'" value="'. esc_attr( $key ) .'" '. checked( $key, $value, false ) .'>';
                    echo '<i class="form-icon"></i>'. esc_html( $title );
                echo '</label>';
            }
        }


        // render - field textarea template
        private function textarea() {

            $id     = $this->cores['unique'];
            $value  = $this->default_value();
            $icons  = $this->cores['icons'] ?? null;
            $label  = $this->cores['label'] ?: null;
            $class  = $this->cores['class'] ?? null;
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;  
            $before = $this->render['class'] ?? null;  
            $after  = $this->render['after'] ?? null;

            echo '<fieldset class="form-group">';
                echo '<label class="form-label " for="'. esc_attr( $id ) .'"><i class="label-icon '. esc_attr( $icons ) .'"></i> '. esc_html( $label ) .'</label>';
                echo '<textarea class="form-input '. esc_attr( $class ) .'" id="'. esc_attr( $id ).'" name="'. esc_attr( $id ).'"  '.$attr.'>'. esc_html( $value ) .'</textarea>';
            echo '</fieldset>';
        }


        // render - field upload template 
        private function upload() {

            $id     = $this->cores['unique'];
            $value  = $this->default_value();
            $label  = $this->cores['label'] ?: null;
            $attr   = $this->array_string( $this->extras['attribute'], 'html-attr' ) ;  
            $before = $this->render['before'] ?? null;  
            $after  = $this->render['after'] ?? null;
            $hide   = ( ! empty( $value ) ) ?: 'hide';


            // wp media load
            wp_enqueue_media();

            echo '
            <div class="tile tile-centered">
                <div class="tile-icon">
                    <div class="avatar avatar-lg tile-icon-box bg-error">
                        <i class="ti-package centered"></i>
                        <i class="avatar-presence bg-warning"></i>
                    </div>
                </div>
                <div class="tile-content">
                    <label for="'. esc_attr( $id ) .'" class="tile-title">'.  $label .'</label><br>
                    <input type="hidden" id="'. $id .'" name="'. $id .'" class="value" value="'. $value .'" '.$attr.'>
                    <small class="tile-subtitle text-gray">14MB · Public · 1 Jan, 2017</small>
                </div>
                <div class="tile-action">
                    <button class="btn btn-link '. $hide .'  preview" data-url="'. $value .'">
                    <i class="ti-more-alt"></i>
                    </button>
                </div>
            </div>  
            <div class="action">
                <button class="btn btn-sm upload">Upload</button>
                <button class="btn btn-sm remove '. $hide .'">Remove</button>
            </div>';
        }

        // sanitize field
        public function sanitize_field( $type, $value ) {

            $url  = [ 'file', 'url', 'upload' ];
            $key  = [ 'checkbox', 'radio', 'hidden', 'number', 'range', 'select' ];
            $text = [ 'email', 'tel', 'text', 'color', 'select', 'user', 'post', 'taxo' ];
            $date = [ 'date', 'datetime-local', 'month', 'time', 'week' ];
    
            if ( in_array( $type, $url )  ) 
            {
                $sanitize = sanitize_url( $value );
                return $sanitize;
            }
            else if ( in_array(  $type, $key ) )
            {
                $sanitize = sanitize_key(  $value );
                return $sanitize;
            }
            else if ( in_array(  $type, $text ) )
            {
                $sanitize = sanitize_text_field( $value );
                return $sanitize;
            }
            else if ( in_array(  $type, $date ) )
            {
                return $value;
            }
        }
        
        
        // method - set default field value when value is empty  
        private function default_value() {

            $type  = $this->cores['type'];
            $value = $this->cores['value'] ?? null;

            // default value method
            if ( $type === 'color' && ( empty( $value ) ||  $value === null  ) )
            {
                $value = '#000000';
            }
            else if ( $type === 'date' && ( empty( $value ) ||  $value === null  )  )
            {
                $value = current_time('Y-m-d');
            }
            else if ( $type === 'datetime-local' && ( empty( $value ) ||  $value === null  ) )
            {
                $date = current_time('Y-m-d');
                $time = current_time('h:m:s');
                $value = $date.'T'.$time;
            }
            else if ( $type === 'month' && ( empty( $value ) ||  $value === null  ) )
            {
                $value = current_time('Y-m');
            }
            else if ( $type === 'week' && ( empty( $value ) ||  $value === null  ) )
            {
                $date  = current_time('Y-m-d');
                $week  = date('W', strtotime($date));
                $value = current_time('Y').'-W'.$week;
            }
            else if ( $type === 'time' && ( empty( $value ) ||  $value === null  ) )
            {
                $value = current_time('h:m:s');
            }
            else
            {
                $value = esc_attr(  $value );
            }

            return $value;
        }
    }
}