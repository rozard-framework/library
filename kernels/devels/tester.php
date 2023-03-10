<?php

if ( ! defined( 'ABSPATH' ) || ! defined( 'WPINC' )  ) { exit ; }
if ( ! class_exists('tester_module') ) {



    class tester_module  {

        // use lib_racker;
        // use lib_datums;
        // use lib_fields;  
        // use lib_packer;

        private $test;

        public function __construct( ) {

            // $this->field_tester();
            // $this->metabox_tester();

            // sandbox page
            if ( WP_DEBUG === true ) 
            {
                add_action('network_admin_menu', array( $this, 'register_sandbox' ) );
                add_action('admin_menu', array( $this, 'register_sandbox' ) );
                $this->sandbox_capability();
            }

            if ( rozard_docus === true && WP_DEBUG === true ) 
            {
                add_action('init', array( $this, 'register_documentation' ) );
                add_action('init', array( $this, 'register_docs_taxonomy' ) );
            }
        }


        public function field_tester(){

            
            $native_fields = array(
                'field_button' => array(
                    'type'    => 'button',
                    'label'   => '',
                    'caps'    => array ( 'manage_options' ),
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'value'   => 'Test',
                    'require' => true,
                    'attrib'  => array(
                        
                    ),
                ),
                'field_color' => array(
                    'type'    => 'color',
                    'label'   => 'zaza color',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'zaza checkbox',
                    'error'   => 'zaza checkbox',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'require' => true,
                    ),
                ),
                'field_checkbox' => array(
                    'type'    => 'checkbox',
                    'label'   => 'zaza checkbox',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'zaza checkbox',
                    'error'   => 'zaza checkbox',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'option'  => array(                
                        'label'  => 'Option 1',
                        'value'  => 'option-1',
                    ),
                    'attrib'  => array(

                    ),
                ),
                'field_date' => array(
                    'type'    => 'date',
                    'label'   => 'Field Date',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'test date',
                    'error'   => 'error date',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'placeholder' => 'insert text please',
                        'require' => true,
                    ),
                ),
                'field_datetime' => array(
                    'type'    => 'datetime',
                    'label'   => 'Field Date Time Local',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Test date time local',
                    'error'   => 'error date time local',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'placeholder' => 'insert text please',
                        'require' => true,
                    ),
                ),
                'field_divider' => array(
                    'type'    => 'divider',
                    'label'   => 'Divider',
                    'caps'    => array ( 'manage_options' ),
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => 'test',
                    'attrib'  => array(
                        'require' => true,
                    ),
                ),
                'field_editor' => array(
                    'type'    => 'editor',
                    'label'   => 'Editor',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Editor description',
                    'error'   => 'Editor Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'value'   => '',
                    'require' => true,
                    'attrib'  => array(
                        'wpautop'           => true,
                        'media_buttons'     => true,
                        'default_editor'    => '',
                        'drag_drop_upload'  => false,
                        'textarea_name'     => '',
                        'textarea_rows'     => 20,
                        'tabindex'          => '',
                        'editor_css'        => '',
                        'editor_class'      => '',
                        'teeny'             => false,
                        'tinymce'           => true,
                        'quicktags'         => true,
                    ),
                ),
                'field_email' => array(
                    'type'    => 'email',
                    'label'   => 'Email',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Email description',
                    'error'   => 'Email Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'size'          => '',  
                        'maxlength'     => '', 
                        'minlength'     => '', 
                        'multiple'      => true, 
                        'pattern'       => '', 
                        'placeholder'   => '', 
                        'require'       => true,
                        'readonly'      => false, 
                        'autocomplete'  => true, 
                    ),
                ),
                'field_hidden' => array(
                    'type'    => 'hidden',
                    'label'   => 'Hidden Fields',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Hidden Fields description',
                    'error'   => 'Hidden Fields',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'require' => true,
                    'attrib'  => array(
                        'placeholder' => 'insert text please',
                    ),
                ),
                'field_image' => array(
                    'type'    => 'Image',
                    'label'   => 'Image',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Image description',
                    'error'   => 'Image Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'require' => true,
                    'attrib'  => array(
                        'alt'            => '',  
                        'widht'          => '', 
                        'height'         => '', 
                        'formaction'     => '', 
                        'formenctype'    => '', 
                        'formmethod'     => '', 
                        'formnovalidate' => '', 
                        'formtarget'     => '',
                    ),
                ),
                'field_month' => array(
                    'type'    => 'month',
                    'label'   => 'Month Date',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Month date',
                    'error'   => 'Month error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'step'          => '',
                        'autocomplete'  => true,   
                        'readonly'      => false, 
                        'require'       => true,
                    ),
                ),
                'field_number' => array(
                    'type'    => 'number',
                    'label'   => 'Number',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Number description',
                    'error'   => 'Number Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'autocomplete'  => true, 
                        'readonly'      => false, 
                        'require'       => true,
                    ),
                ),
                'field_password' => array(
                    'type'    => 'password',
                    'label'   => 'Password',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Password description',
                    'error'   => 'Password Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'size'          => '',  
                        'maxlength'     => '', 
                        'minlength'     => '', 
                        'pattern'       => '', 
                        'placeholder'   => '', 
                        'readonly'      => false, 
                        'required'      => true, 
                        'autocomplete'  => true, 
                    ),
                ),
                'field_radio' => array(
                    'type'    => 'radio',
                    'label'   => 'Radio',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Radio desc',
                    'error'   => 'Radio error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'option'  => array(                
                        'label'  => 'Option 1',
                        'value'  => 'option-1',
                    ),
                    'attrib'  => array(
                        'multiple'    => true, 
                        'placeholder' => '', 
                        'required'    => true,
                    ),
                ),
                'field_range' => array(
                    'type'    => 'range',
                    'label'   => 'Range',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Range description',
                    'error'   => 'Range Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'autocomplete'  => false, 
                        'max'           => 100,
                        'min'           => 1,
                        'placeholder'   => '', 
                        'require'       => true,
                        'step'          => 1,
                    ),
                ),
                'field_search' => array(
                    'type'    => 'search',
                    'label'   => 'Search',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Search description',
                    'error'   => 'Search Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'autocomplete' => true, 
                        'maxlength'    => '', 
                        'minlength'    => '', 
                        'pattern'      => '', 
                        'placeholder'  => '', 
                        'required'     => true, 
                        'size'         => '',
                    ),
                ),
                'field_phone' => array(
                    'type'    => 'phone',
                    'label'   => 'Phone',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Phone description',
                    'error'   => 'Phone Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'autocomplete'  => true, 
                        'maxlength'     => '', 
                        'minlength'     => '', 
                        'pattern'       => '"[0-9]{4}-[0-9]{5}"', 
                        'placeholder'   => '"0752-32456"', 
                        'readonly'      => false, 
                        'required'      => true,
                        'size'          => '',  
                    ),
                ),
                'field_switch' => array(
                    'type'    => 'switch',
                    'label'   => 'Switch',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Switch description',
                    'error'   => 'Switch Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(

                    ),
                ),
                'field_text' => array(
                    'type'    => 'text',
                    'label'   => 'Text',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Text description',
                    'error'   => 'Text Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'placeholder' => 'insert text please',
                        'require'     => true,
                    ),
                ),
                'field_textarea' => array(
                    'type'    => 'textarea',
                    'label'   => 'Textarea',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Textarea description',
                    'error'   => 'Textarea Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'autofocus'     => true, 
                        'autocomplete'  => true, 
                        'cols'          =>  '',     // Specifies the visible width of a text area
                        'disabled'      => false,
                        'form'          => '',      // form id
                        'maxlength'     => '', 
                        'name'          => '',      // textarea name 
                        'placeholder'   => '', 
                        'readonly'      => false, 
                        'required'      => true, 
                        'rows'          => '',  
                        'wrap'          => 'hard',  // value : hard :soft
                    ),
                ),
                'field_time' => array(
                    'type'    => 'time',
                    'label'   => 'Time Date',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Time date',
                    'error'   => 'Time error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'autocomplete'  => true,   
                        'step'          => '',
                    ),
                ),
                'field_url' => array(
                    'type'    => 'url',
                    'label'   => 'Url',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Url description',
                    'error'   => 'Url Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'autocomplete'  => true, 
                        'maxlength'     => '', 
                        'minlength'     => '', 
                        'pattern'       => 'https://.*', 
                        'placeholder'   => '', 
                        'readonly'      => false, 
                        'required'      => true, 
                        'size'          => null,  
                    ),
                ),
                'field_week' => array(
                    'type'    => 'week',
                    'label'   => 'Week Date',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Week date',
                    'error'   => 'Week error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'step'          => '',
                        'autocomplete'  => true,   
                        'readonly'      => false, 
                    ),
                ),
            );


            $option_field = array(
                'field_checklist' => array(
                    'type'    => 'checklist',
                    'label'   => 'Checklist',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Checklist Description',
                    'error'   => 'Checklist Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'option'  => array(                
                        'opt_1' => array(
                            'label'   => 'Option 1',
                            'value'   => 'option-1',
                            'require' => true,
                        ),
                        'opt_2' => array(
                            'label'   => 'Option 2',
                            'value'   => 'option-2',
                            'require' => true,
                        ),
                        'opt_3' => array(
                            'label'   => 'Option 3',
                            'value'   => 'option-3',
                            'require' => true,
                        ),
                    ),
                    'attrib'  => array(

                    ),
                ),
                'field_multiple' => array(
                    'type'    => 'multiple',
                    'label'   => 'Multiple Choice',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Multiple Choice desc',
                    'error'   => 'Multiple Choice error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'option'  => array(                
                        'opt_1' => array(
                            'label'   => 'Option 1',
                            'value'   => 'option-1',
                            'checked'     => false,
                        ),
                        'opt_2' => array(
                            'label'   => 'Option 2',
                            'value'   => 'option-2',
                            'checked'     => false,
                        ),
                        'opt_3' => array(
                            'label'   => 'Option 3',
                            'value'   => 'option-3',
                            'checked'     => false,
                        ),
                    ),
                    'attrib'  => array(
                        'multiple'    => true, 
                        'placeholder' => '', 
                        'required'    => true,
                    ),
                ),
                'field_select' => array(
                    'type'    => 'select',
                    'label'   => 'Select',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Select desc',
                    'error'   => 'Select error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'option'  => array(                
                        'opt_1' => 'Options 1',
                        'opt_2' => 'Options 2',
                        'opt_3' => 'Options 3',
                    ),
                    'attrib'  => array(
                        'placeholder'   => '', 
                        'checked'  => true, 
                        'required' => true,
                    ),
                ),
            );


            $object_field = array(
                'field_file' => array(
                    'type'    => 'file',
                    'label'   => 'Files',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Files description',
                    'error'   => 'Files Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'value'   => '',
                    'attrib'  => array(
                        'accept'       => '',       // value reference : https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#unique_file_type_specifiers  
                        'capture'      => true, 
                        'multiple'     => true, 
                    ),
                ),
            );



            $this->register_field(
                'test_1', 
                'table',
                'toplevel_page_rozard-testing-network', 
                array( 'manage_options' ),
                $object_field,  
            ); 
        }


        public function metabox_tester() {

            $post_type = array('post', 'page');
            $boxs_data = array(
                'meta_id'  => 'zaza_metal',
                'title'    => 'Testing Metabox',
                'contexts' => 'normal',
                'priority' => 'default',
            );
            $user_caps = array( 'manage_options' );

            $meta_field = array(
                'field_checklist' => array(
                    'type'    => 'checklist',
                    'label'   => 'Checklist',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Checklist Description',
                    'error'   => 'Checklist Error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'option'  => array(                
                        'opt_1' => array(
                            'label'   => 'Option 1',
                            'value'   => 'option-1',
                            'require' => true,
                        ),
                        'opt_2' => array(
                            'label'   => 'Option 2',
                            'value'   => 'option-2',
                            'require' => true,
                        ),
                        'opt_3' => array(
                            'label'   => 'Option 3',
                            'value'   => 'option-3',
                            'require' => true,
                        ),
                    ),
                    'attrib'  => array(

                    ),
                ),
                'field_multiple' => array(
                    'type'    => 'multiple',
                    'label'   => 'Multiple Choice',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Multiple Choice desc',
                    'error'   => 'Multiple Choice error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'option'  => array(                
                        'opt_1' => array(
                            'label'   => 'Option 1',
                            'value'   => 'option-1',
                            'checked'     => false,
                        ),
                        'opt_2' => array(
                            'label'   => 'Option 2',
                            'value'   => 'option-2',
                            'checked'     => false,
                        ),
                        'opt_3' => array(
                            'label'   => 'Option 3',
                            'value'   => 'option-3',
                            'checked'     => false,
                        ),
                    ),
                    'attrib'  => array(
                        'multiple'    => true, 
                        'placeholder' => '', 
                        'required'    => true,
                    ),
                ),
                'field_select' => array(
                    'type'    => 'select',
                    'label'   => 'Select',
                    'caps'    => array ( 'manage_options' ),
                    'desc'    => 'Select desc',
                    'error'   => 'Select error',
                    'elm-ids' => '',
                    'elm-cls' => '',
                    'elm-wid' => 50,
                    'after'   => '',
                    'before'  => '',
                    'option'  => array(                
                        'opt_1' => 'Options 1',
                        'opt_2' => 'Options 2',
                        'opt_3' => 'Options 3',
                    ),
                    'attrib'  => array(
                        'placeholder'   => '', 
                        'checked'  => true, 
                        'required' => true,
                    ),
                ),
            );

            
            $this->register_field(
                'karim_meta', 
                'block',
                'post', 
                array( 'manage_options' ),
                $meta_field,  
            );

            // register metabox
            $this->packer_metabox( 'karim_meta', $post_type, $boxs_data, $user_caps );
        }


        /** SANDBOX PAGE */
        public function register_sandbox() {

            if ( is_user_logged_in() ) 
            {
                add_menu_page( 'Rozard Devel', 'Rozard Devel', 'rozard_developer' , 'rozard-testing', array( $this, 'renders_sandbox' ), '', 9999 );
            }
        }


        public function renders_sandbox() {
            echo '<div id="wpbody-content">';
                echo '<div class="wrap">';
                    echo '<h3> Rozard Developer Preview </h3>';
                    $this->plain_tester();
                    // $this->render_field('test_1');
                    do_action('rozard_developer_page');
                echo '</div>';
            echo '</div>';
        }

        public function add_header_pdf() {

        }


        public function plain_tester() {


        }


        public function sandbox_capability() {

            $roles = array( 'administrator', 'developer' );


            if ( WP_DEBUG == true ) {
                foreach( $roles as $role )  {
                    $role_object = get_role( $role );
                    if( ! empty( $role_object ) && ! $role_object->has_cap( 'rozard_developer' ) ) 
                    {
                        $role_object->add_cap( 'rozard_developer' );
                    }
                }
            } else {
                foreach( $roles as $role ) {
                    $role_object = get_role( $role );
                    if( !empty( $role_object ) && $role_object->has_cap( 'rozard_developer' ) ) 
                    {
                        $role_object->remove_cap( 'rozard_developer' );
                    }
                }
            }
        }


        /** DOCUMENTATION PAGE */
        public function register_documentation() {
            register_post_type('documentation',
                array(
                    'labels'      => array(
                        'name'          => __( 'Docs', 'rozard' ),
                        'singular_name' => __( 'Docs', 'rozard' ),
                    ),
                    'hierarchical'        => false,
                    'public'              => true,
                    'show_ui'             => true,
                    'show_in_menu'        => true,
                    'show_in_nav_menus'   => true,
                    'show_in_admin_bar'   => true,
                    'menu_position'       => 99999,
                    'can_export'          => true,
                    'has_archive'         => true,
                    'exclude_from_search' => false,
                    'publicly_queryable'  => true,
                    'capability_type'     => 'post',
                    'show_in_rest'        => true,
                    'rewrite'             => array( 'slug' => 'documentation' ), // my custom slug
                )
            );
        }


        public function register_docs_taxonomy() {
           	// Add new taxonomy, make it hierarchical (like categories)
            $labels = array(
                'name'              => _x( 'Modules', 'taxonomy general name', 'textdomain' ),
                'singular_name'     => _x( 'Module', 'taxonomy singular name', 'textdomain' ),
                'search_items'      => __( 'Search Modules', 'textdomain' ),
                'all_items'         => __( 'All Modules', 'textdomain' ),
                'parent_item'       => __( 'Parent Module', 'textdomain' ),
                'parent_item_colon' => __( 'Parent Module:', 'textdomain' ),
                'edit_item'         => __( 'Edit Module', 'textdomain' ),
                'update_item'       => __( 'Update Module', 'textdomain' ),
                'add_new_item'      => __( 'Add New Module', 'textdomain' ),
                'new_item_name'     => __( 'New Module Name', 'textdomain' ),
                'menu_name'         => __( 'Module', 'textdomain' ),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'module' ),
            );

            register_taxonomy( 'module', array( 'documentation' ), $args );
        }
    }
}


/*** DEVELOPMENT END*/
new tester_module;