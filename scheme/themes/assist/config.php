<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }

if ( ! class_exists( 'rozard_theme_config' ) ) {

    class rozard_theme_config{


        // module
        use rozard_former_field;


        public function __construct() {
            $this->data();
        }


        private function data() {
          

            $this->hook();
        }



        private function hook() {
            add_action( 'customize_register', array( $this, 'init' ) );
        }


        public function init( $craft ) {
           
            // register basic model
            require_once 'model.php';

            global $themes;
            $configs = $themes['config'];

 
            foreach( $configs as $panel ) {

                if ( ! usr_can( $panel['caps'] ) ) {
                    continue;
                }

                $panid  =  str_keys( $panel['keys'] );
                $title  =  str_text( $panel['name'] );
                $descr  =  str_text( $panel['desc'] );
                $prior  =  absint( $panel['sort'] );
                $argue  =  array(
                                'title'       => __(  $title, 'rozard_framework' ),
                                'priority'    =>  $prior,
                                'description' => __( $descr, 'rozard_framework'), 
                            );
               
    
                // register config panel
                $craft->add_panel( $panid, $argue );
    
              
                // register config section
                $this->form( $panel, $craft );
            }
        }

        
        private function form( $panel, $craft ) {

            global $former;


            if ( ! isset( $former[$panel['form']] ) && empty( $former[$panel['form']] ) || ! is_array( $former[$panel['form']] ) ) {
                return;
            }

            $group  =  $former[$panel['form']] ;
            $saved  =  $group['data'];
            $prior  =  absint( $panel['sort'] );
            $panid  =  str_keys( $panel['keys'] );


            foreach( $group['form'] as $seckey => $section ) {

                $title  =  str_text( $section['name'] );
                $descr  =  str_text( $section['desc'] );
                $prior  =  absint( $prior );
                $panel  =  str_keys( $panid  );
                $secid  =  str_keys( $seckey );
                $saved  =  str_keys( $saved  );
                $forms  =  array(
                            'title'       => __( $title, 'rozard_framework' ),
                            'priority'    => $prior,
                            'panel'       => $panel,
                            'description' => __( $descr, 'rozard_framework' ),
                            'type'        => $saved,
                        );


                $craft->add_section( $secid, $forms );

                foreach( $section['field'] as $field ) {

                    $field['secid'] =  $secid;
                    $field['saved'] =  $saved;                    

                    $this->item( $field, $craft );
                }
            } 
        }
        

        private function item( $field, $craft ) {


            if ( ! usr_can( $field['keys'] ) ) {
                return;
            }


            $label =  esc_html( $field['name'] );
            $secid =  $field['secid'];
            $save  =  $field['saved'];
            $keys  =  str_keys( $field['keys'] );
            $data  =  $secid.'['.$keys.']';
            $caps  =  str_keys( $field['caps'] );
            $type  =  str_keys( $field['type'] );
           


            $setting = array(
                'default'           => '',
                'capability'        => 'edit_theme_options',
                'type'              => 'option',
                'sanitize_callback' => $this->pure_calls( $type ),
            );


            $control = array(
                'label'      => __( $label , 'rozard_framework'),
                'section'    => $secid ,
                'settings'   => $data,
                'type'       => $type,
            );


            $craft->add_setting( $data , $setting );  
            $craft->add_control( str_keys( $secid .'_'. $keys ), $control );
        } 
    }
    new rozard_theme_config;
}