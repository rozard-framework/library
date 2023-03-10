<?php


/**
 *  ROZARD CONFIGURATION MASTER CLASS
 *   
 */


if ( ! class_exists( 'rozard_scheme_config' ) ) {


    class rozard_scheme_config{


    /***  DATA */
    
        // module
        use rozard_former_field;


        // property
        private $form;
        private $conf;
        private $page;
        private $save;
        private $them;
        private $user;


        // filter
        private $node = array( 'general', 'reading', 'discussion', 'media', 'profile', 'permalink', 'privacy' );
        private $core = array( 'settings' );



    /***  INIT  */

        public function __construct() {
            add_action('plugins_loaded', array( $this, 'load' ));
        }
 

        public function load() {
            
            if ( is_multisite()  ) {
                $this->load_core();
                $this->load_node();
            } 
            else {
                $this->load_node();
            }
        }


        private function load_core() {

            if ( ! is_network_admin() || ! uris_has( array( 'sites', 'settings', 'site-', 'edit.php', 'admin-ajax' ) ) ) {
                return;
            }

            $this->core();
        }


        private function load_node() {

            if (  ! uris_has( array( 'options', 'profile', 'admin-post.php', 'admin-ajax' ) )  ) {
                return;
            }
            
            $this->node();
        }


        
    /***  LOAD  */


        private function data_page( array $data, array $filter ) {


            foreach( $data as  $page ) {

                // populate form
                $this->form[][$page['keys']] = $page['form'];


                // populate page
                if ( in_array( $page['keys'], $filter ) ) {
                    continue;
                }

                if ( ! usr_can( $page['caps'] ) ) {
                    continue;
                }


                $this->page[] = $page;
            }
        }


        private function data_site( array $data, array $filter ) {


            foreach( $data as $page ) {

                // populate form
                $this->form[][$page['keys']] = $page['form'];


                // populate page
                if ( in_array( $page['keys'], $filter ) ) {
                    continue;
                }

                if ( ! usr_can( $page['caps'] ) ) {
                    continue;
                }

                $this->site[] = $page;
            }
        }


        private function data_conf( array $scheme ) {

            foreach ( $this->form as $divs ) {

                foreach ( $divs as $name => $data ) {

                    $setting = $name;

                    // validate data
                    if ( ! isset( $scheme['former'][$data] ) || empty( $scheme['former'][$data] ) && ! is_array( $scheme['former'][$data] ) ) {
                        return;                
                    }
    
                    // validate caps
                    if ( ! usr_can( $scheme['former'][$data]['caps'] )  ) {
                        return;
                    }

                    // extracts data
                    $form = $scheme['former'][$data];
                    $form['name'] = $setting;
    
              
                    // load and extract form data
                    foreach( $form['form'] as $key =>  &$group ) {
    
    
                        // validate form capabilities
                        if ( ! empty( $group['caps'] ) && ! usr_can( $group['caps'] ) ) {
                            return;
                        }
    
                        $group['slug'] = $form['name'];
                        $group['keys'] = $key;
                        $group_id      = $key;
           
                    
                        foreach ( $group['field'] as $key => &$field ) {
        
    
                            // validate field capabilities
                            if ( ! empty( $field['caps'] ) && ! usr_can( $field['caps'] ) ) {
                                continue;
                            }
                                 
   
                            // setup original field key reference
                            $this->save[$field['keys']] = $field['type'];

    
                            // setup spesific config  field attribute
                            $field['attr']['id']  =  str_slug( $field['keys'] );
                            $field['keys']        =  str_keys( $form['name'] ).'['. str_keys( $group_id ).']'.'['. str_keys( $field['keys'] ).']';
                            $field['slug']        =  $form['name'];
                            $field['secid']       =  str_keys( $group_id );
                        }
                    }

                    // assign value to property
                    $this->conf[] = $form;
                }
            }
        }



    /***  NODE  */


        private function node() {
            $this->node_data();
            $this->node_hook();
            $this->node_user();
        }


        private function node_data() {

            $raws = apply_filters( 'register_scheme', array() );

            if ( ! uris_has( array( 'options', 'admin-ajax' ) )  ) {
                return;
            }

            if ( empty( $raws['config']['node'] ) ) {
                return '';
            }

            $data = $raws['config']['node'];
            
            $this->data_page( $data, $this->node );
            $this->data_conf( $raws );
        }


        private function node_hook() {

            if ( ! uris_has( array( 'options', 'admin-ajax' ) )  ) {
                return;
            }

            add_action('admin_init', array( $this, 'node_conf' ) );
            add_action('admin_menu', array( $this, 'node_page' ) );

        }


        // options conf
        public function node_conf() {

            if ( empty( $this->conf ) ) {
                return;
            }


            if ( take_uri_param('page') !== null  ) {
                $filter = array( str_replace( 'options-' , '' , take_uri_param('page') ) );
            }
            else {
                $filter = $this->node ;
            }

            foreach( $this->conf as $data ) {

                register_setting( $data['name'], $data['name'],  array($this, 'node_conf_pure')  );

                $this->node_conf_form( $data['form'], $filter );
            }
        }


        public function node_conf_form( $data, $filter ) {

            $count = 0;

            foreach( $data as $key => $groups ) {


                if ( ! usr_can( $groups['caps'] ) ) {
                    continue;
                }


                $secid = $groups['keys'];
                $title = $groups['name']; 
                $descr = $groups['desc']; 
                $slugs = $groups['slug']; 
                $class = ( $count === 0 ) ? 'active' : '' ;
                $count++;


                if ( in_array( $slugs, $this->node ) || in_array( $slugs, $this->core )  ) {

                    $prevs = sprintf( '<section id="%s" class="tabs-content active">', 
                                    $secid,
                                );
                }
                else {

                    $prevs = sprintf( '<section id="%s" class="tabs-content %s">', 
                                    $secid,
                                    $class,
                                );

                }
              

                $argus = array(
                    'before_section' => $prevs,
                    'after_section'  => '</section>',
                    'section_class'  => $descr,
                );
                
                
                add_settings_section( $secid, $title, '', $slugs, $argus  );

                $this->node_conf_item( $groups['field'], $filter );
            }
        }


        public function node_conf_item( $data, $filter ) {

            if ( empty( $data ) ) {
                return;
            }

            foreach( $data as $field ) {

                if ( ! usr_can( $field['caps'] ) || ! in_array(  $field['slug'] , $filter ) ) {
                    continue;
                }

                // assign field value
                $option = ( ! empty( get_option( $field['slug'] ) ) ) ? get_option( $field['slug'] ) : '' ;
                $groups = $field['secid'];
                $fields = str_keys( $field['attr']['id'] );

                if ( ! empty( $option[$groups][$fields] ) ) {
                    $field['value'] = $option[$groups][$fields];
                } 

                $this->field_conf( $field );
            }
        }


        public function node_conf_pure( $data ) {

            foreach( $data as &$input ) {

                foreach( $input as $key => &$field ) {

                    if ( array_key_exists( $key, $this->save )  ) {
                       
                        $types  =  $this->save[$key];
                        $value  =  $field;
                        $field  =  $this->pure_field( $types, $value );
                    }
                }
            }

            return $data;
        }


        // options page
        public function node_page() {
         
            if ( empty( $this->page ) ) {
                return;
            }

            foreach( $this->page as $page ) {

                $calls  =  array( $this, 'node_page_view' );
                $title  =  str_text( $page['name'] );
                $slugs  =  str_slug( 'options-' . $page['keys'] );
                $capab  =  ( $page['caps'] ) ? str_keys( $page['caps'] ) : 'manage_options' ;
                $prior  =  absint( $page['sort'] );


                add_options_page( $title, $title, $capab, $slugs, $calls, $prior );
            }
        }


        public function node_page_view() {

            foreach( $this->page as $page ) {

                
                if ( in_array( $page['keys'], $this->page ) || ucwords( $page['keys'] ) !==  get_admin_page_title() )  {
                    continue;
                }


                $slug  =  str_slug( $page['keys'] );
                $mode  =  ( $page['menu'] === 'head' ) ? 'menu-head' : 'menu-side' ;
                $head  = sprintf('<h1>%s</h1>', get_admin_page_title());


                printf( '<div class="wrap rozard-setting">%s<form method="post" action="options.php">', 
                            $head 
                        );

                        settings_fields( $slug );
                        $this->node_page_menu( $slug );
                        submit_button();  

                printf( '</form></div>' );
            }
        }


        public function node_page_menu( $page ) {


            global $wp_settings_sections, $wp_settings_fields;


            if ( ! isset( $wp_settings_sections[ $page ] ) ) {
                return;
            }


            // config navigate
            $menus = '';
            $count = 0;
            foreach ( (array) $wp_settings_sections[ $page ] as $key => $section ) {

                $class = (  $count === 0 ) ? 'active' : '';

                $menus .= sprintf( '<div class="tabs-action %s" data-target="%s">%s</div>',  
                                    esc_attr( $class ), 
                                    esc_attr( $section['id'] ), 
                                    esc_html( $section['title'] ) 
                                );
                $count++;
            }
            printf( '<nav class="tabs-menu">%s</nav>',  wp_kses_post( $menus ) );


            // config contents
            foreach ( (array) $wp_settings_sections[ $page ] as $section ) {


                if ( '' !== $section['before_section'] ) {
                    print( wp_kses_post( $section['before_section'] ) ) ;
                }
        

                if ( $section['title'] ) {

                    printf( '<h2 class="mt-5">%s</h2><p class="mb-3">%s</p>',
                                esc_html( $section['title'] ),
                                esc_html( $section['section_class'] ),
                            );
                }
        

                if ( $section['callback'] ) {
                    call_user_func( $section['callback'], $section );
                }
        

                if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
                    continue;
                }


                printf( '<table class="form-table" role="presentation">' );
                    do_settings_fields( $page, $section['id'] );
                printf( '</table>' );

        
                if ( '' !== $section['after_section'] ) {
                    print( wp_kses_post( $section['after_section'] ) ) ;
                }
            }
        }


        public function node_page_side( $page ) {

            dev(  $this->conf );

            foreach ( $this->conf as $field ) {
               
            }
   
        }



        // profile conf
        private function node_user() {

            if ( uris_has( array( 'profile', 'admin-post',  'admin-ajax') )) {
                add_action( 'init',                 array( $this, 'node_user_data' ), 99 );
                add_action( 'admin_menu',           array( $this, 'node_user_make' ), 99 );
                add_action( 'admin_post_user_save', array( $this, 'node_user_save' ), 99 );
            }
        }


        public function node_user_data() {

            $scheme =  apply_filters( 'register_scheme', array() );

            
            if ( empty( $scheme['config']['profile'] ) ) {
                return;
            }


            $profil =  $scheme['config']['profile'];
            $this->user['core'] = $profil;

            foreach( $this->user['core'] as $data ) {

                $formid = $data['form'];

                if ( ! isset( $scheme['former'][$formid] ) && empty( $scheme['former'][$formid] ) || ! is_array( $scheme['former'][$formid] ) ) {
                    return;
                }

                $formers = $scheme['former'][$formid];
                $setting = $data['keys'];

                foreach( $formers['form'] as $gid => $form ) {
               
                    $group_id  = $gid;

                    foreach ( $form['field'] as &$field ) {

                        $user_id = get_current_user_id();
                        $fiel_id = str_keys( $setting .'_'. $group_id .''. $field['keys'] );
                        $field['keys'] = $fiel_id;
                        $getvals = get_user_meta( $user_id, $fiel_id, true );

                
                        // assigned field value to field attribute
                        if ( ! empty(  $getvals ) ) {

                            $field['value'] =  $getvals;
                            
                        } 
                        else {

                            $field['value'] =  '';
                        }
                        

                        $field['setup']       =  $setting;
                        $this->user['form'][] =  $field;
                    } 
                } 
            }
        }


        public function node_user_make() {

            if ( empty(  $this->user['core'] ) ) {
                return;
            }

            foreach( $this->user['core'] as $page ) {

                $calls  =  array( $this, 'node_user_view' );
                $title  =  str_text( $page['name'] );
                $slugs  =  str_slug( 'profile-' . $page['keys'] );
                $capab  =  ( $page['caps'] ) ? str_keys( $page['caps'] ) : 'list_users' ;
                $prior  =  absint( $page['sort'] );

                add_users_page( $title, $title, $capab, $slugs, $calls, $prior );
            }
        }


        public function node_user_view() {

            
            foreach( $this->user['core'] as $user ) {

                if ( in_array( $user['keys'], $this->node ) || $user['name'] !==  get_admin_page_title() )  {
                    continue;
                }


                $conf = str_keys( $user['keys'] );
                $form = $this->node_user_form( $conf );

                $head = sprintf('<h1>%s</h1>', get_admin_page_title());

                printf( '<div class="wrap">%s%s</div>',
                    $head,
                    $form
                );
            }
        }


        public function node_user_save() {


            // Nonce security check
            check_admin_referer( 'rozard-nonce' ); 


            if ( isset( $_POST ) ) {

                foreach( $this->user['form'] as $field ){

                    $unique = $field['keys'];
                    $userid = $_POST['user'] ;


                    if ( isset( $_POST[ $unique ] ) ) {

                        $value  =  $this->pure_field( $field['type'], $_POST[ $unique ] ) ; 
                        update_user_meta( $userid, $unique, $value );
                    }
                    else {

                        delete_user_meta( $userid, $unique );
                    }
                }
            }

           
            $page = pure_slug( $_POST[ 'page' ] );
            $conf = $_POST[ 'name' ];
            

            $redirected  =  array(
                                'page'    => $page,
                                'updated' => 'true'
                            );

            $sitesbased  =  admin_url( 'users.php' );

            wp_safe_redirect( add_query_arg( $redirected, $sitesbased ) );
            exit;
        }


        public function node_user_form( $conf ) {


            $conf  =  str_keys( $conf );
            $page  =  str_slug( 'profile-'. $conf );
            $item  =  $this->node_user_item( $conf );
            $args  =  add_query_arg( 'action', 'user_save', 'admin-post.php' );

            $form  =  sprintf(  '<form method="post" action="%s">
                                    %s
                                    <input type="hidden" name="page" value="%s" />
                                    <input type="hidden" name="name" value="%s" />
                                    <input type="hidden" name="user" value="%u" />
                                    <table class="form-table">%s</table>
                                    %s
                                </form>', 
                                $args,
                                wp_nonce_field( 'rozard-nonce', '_wpnonce', true , false ),
                                $page,
                                $conf,
                                get_current_user_id(),
                                $item,  
                                get_submit_button(),
                            );

            return $form;
        }


        private function node_user_item( $conf ) {

            $result  = '';
           
            foreach( $this->user['form'] as $field ) {


                if ( $field['setup'] !== $conf ) {
                    continue;
                }

                $result .= sprintf( '<tr>
                                        <th scope="row"><label for="some_field">%s</label></th>
                                        <td>%s</td>
                                    </tr>',
                                    esc_html( $field['name'] ),
                                    $this->get_field( $field, 'single ')
                                ); 
            }

            return $result;
        }


        private function node_user_pure( $data ) {

            $result = $data;

            foreach ( $result as &$groups ) {

                foreach( $groups as $key => &$field ) {

                    if ( array_key_exists( $key, $this->save )  ) {
                       
                        $types  =  $this->save[$key];
                        $value  =  $field;
                        $field  =  $this->pure_field( $types, $value );
                    }
                }
            }

            return  $result;
        }




    /***  SITE  */


        private function core() {
            
            if ( uris_has(array( 'sites', 'site-', 'edit.php', 'admin-ajax' )  ) ) {
                // $this->core_site();
            }

            if ( uris_has(array( 'settings', 'edit.php', 'admin-ajax' )  ) ) {
                // $this->core_conf();
            }
        }


        // multisite site conf 
        private function core_site() {
           $this->site_data();
        }


        private function site_data() {

            $raws = apply_filters( 'register_scheme', array() );
            $data = $raws['config']['node'];
            
            $this->data_site( $data, $this->node );
            $this->data_conf( $raws );
            $this->site_hook();
        } 


        private function site_hook() {
            add_filter( 'network_edit_site_nav_links',  array( $this, 'site_menu' ) );
            add_action( 'network_admin_menu',           array( $this, 'site_page' ) );
            add_action( 'network_admin_edit_site_save', array( $this, 'site_save' ) );
        } 


        public function site_menu( $menu ) {

            foreach( $this->site as $site ) {

                if ( ! usr_can( $site['caps'] ) ) {
                    return;
                }

                $slug = str_slug( 'site-' . $site['keys'] );
                $name = str_text( $site['name'] );
                $caps = str_keys( $site['caps'] );

                $menu[  $slug  ] = array(
                    'label' => $name,
                    'url' => add_query_arg( 'page',  $slug , 'sites.php' ), 
                    'cap' => $caps
                );
            }
          
            return $menu;
        }


        public function site_page() {

            foreach( $this->site as $page ) {

                $calls  =  array( $this, 'site_view' );
                $title  =  str_text( $page['name'] );
                $slugs  =  str_slug( 'site-' . $page['keys'] );
                $capab  =  ( $page['caps'] ) ? str_keys( $page['caps'] ) : 'manage_options' ;
                $prior  =  absint( $page['sort'] );
    
                    
                if ( is_network_admin() && usr_can( $capab ) ) {
                    add_submenu_page( 'sites.php', $title, $title, $capab, $slugs, $calls, $prior );
                }
            }
        }


        public function site_save() {


            check_admin_referer( 'rozard-nonce' ); // Nonce security check


            $keys = absint( $_POST[ 'id' ] );
            $page = pure_slug( $_POST[ 'page' ] );
            $conf = pure_slug( $_POST[ 'name' ] );
            $data = $this->site_pure( $_POST[ $conf ] );


            update_blog_option( $keys, $conf, $data );


            $redirected  =  array(
                'page'    => $page,
                'id'      => $keys,
                'updated' => 'true'
            );

            $sitesbased =  network_admin_url( 'sites.php' );


            wp_safe_redirect( add_query_arg(  $redirected, $sitesbased ) );
            exit;
        }


        public function site_view() {

            // do not worry about that, we will check it too
            $keys  =  absint( $_REQUEST[ 'id' ] );
            $site  =  get_site( $keys );
            $page  =  $_REQUEST[ 'page' ] ;
            $conf  =  str_replace( 'site-', '',  $page );


            $head  =  sprintf( '<h1 id="edit-site"> Edit Site : %s </h1>
                                <p class="edit-site-actions">
                                    <a href="%s">Visit</a> | <a href="%s">Dashboard</a>
                                </p>',
                                esc_html( $site->blogname ),
                                esc_url( get_home_url(  $keys, '/' ) ),
                                esc_url( get_admin_url( $keys ) )
                            );


            $menu  =  network_edit_site_nav(
                        array(
                            'blog_id'  => $keys,
                            'selected' => $page // current tab
                        )
                    );

            
            $form  = $this->site_form( $site, $conf, $page,  $keys );


            printf( '<div class="wrap">%s%s%s</div>',
                        $head,
                        $menu,
                        $form
                    );
        }


        private function site_form( $site, $conf, $page, $keys ) {

            $item  =  $this->site_item( $conf, $keys );
            $form  =  sprintf(  '<form method="post" action="edit.php?action=site_save">
                                %s
                                <input type="hidden" name="id"   value="%s" />
                                <input type="hidden" name="page" value="%s" />
                                <input type="hidden" name="name" value="%s" />
                                <table class="form-table">
                                %s
                                </table>
                                %s
                            </form>',
                            wp_nonce_field( 'rozard-nonce' , '_wpnonce', true , false ),
                            $keys,
                            $page,
                            $conf,
                            $item,  
                            get_submit_button(),
                        );

            return $form;
        }


        private function site_item( $conf, $keys ) {

            $items  = '';
           
            foreach( $this->conf as $data ) {

                if ( $data['name'] !== $conf ) {
                    continue;
                }

                foreach( $data['form'] as $setting => $form ) {
               
                    foreach ( $form['field'] as $field ) {

                        // assign field value
                        $option = ( ! empty( get_blog_option( $keys, $conf ) ) ) ? get_blog_option( $keys, $conf ) : '' ;
                        $groups = $field['secid'];
                        $fields = str_keys( $field['attr']['id'] );

                        if ( ! empty( $option[$groups][$fields] ) ) {
                            $field['value'] = $option[$groups][$fields];
                        } 


                        $items .= sprintf( '<tr>
                                                <th scope="row"><label for="some_field">%s</label></th>
                                                <td>%s</td>
                                            </tr>',
                                            esc_html( $field['name'] ),
                                            $this->get_field( $field, 'single ')
                                        );
                    }
                } 
            }
            return $items;
        }


        private function site_pure( $data ) {

            $result = $data;

            foreach ( $result as &$groups ) {

                foreach( $groups as $key => &$field ) {

                    if ( array_key_exists( $key, $this->save )  ) {
                       
                        $types  =  $this->save[$key];
                        $value  =  $field;
                        $field  =  $this->pure_field( $types, $value );
                    }
                }
            }

            return  $result;
        }

       
        // multisite setting page 
        private function core_conf() {
            $this->conf_data();
        }


        private function conf_data() {

            $raws = apply_filters( 'register_scheme', array() );
            $data = $raws['config']['core'];
            
            $this->data_page( $data, $this->core );
            $this->data_conf( $raws );
            $this->conf_hook();
        }


        private function conf_hook() {
            add_action( 'network_admin_menu',           array( $this, 'conf_page' ) );
            add_action( 'network_admin_edit_core_save', array( $this, 'conf_save' ) );
        }


        public function conf_page() {

        
            foreach( $this->page as $page ) {

                $calls  =  array( $this, 'conf_view' );
                $title  =  str_text( $page['name'] );
                $slugs  =  str_slug( 'setting-' . $page['keys'] );
                $capab  =  str_keys( $page['caps'] ) ;
                $prior  =  absint( $page['sort'] );

                add_submenu_page( 'settings.php' , $title, $title, $capab, $slugs, $calls, $prior );
            }
        }


        public function conf_save() {

            check_admin_referer( 'rozard-nonce' ); // Nonce security check

            $page = pure_slug( $_POST[ 'page' ] );
            $conf = pure_slug( $_POST[ 'name' ] );
            $data = $this->conf_pure( $_POST[ $conf ] );


            update_site_option( $conf, $data );


            $redirected  =  array(
                'page'    => $page,
                'updated' => 'true'
            );

            $sitesbased  =  network_admin_url( 'settings.php' );

            wp_safe_redirect( add_query_arg( $redirected, $sitesbased ) );
            exit;
        }


        public function conf_view() {

            foreach( $this->page as $page ) {

                if ( in_array( $page['keys'], $this->core ) || ucwords( $page['keys'] ) !==  get_admin_page_title() )  {
                    continue;
                }

                $conf = str_keys( $page['keys'] );
                
                $form = $this->conf_form( $conf );
                $head = sprintf('<h1>%s</h1>', get_admin_page_title());

                printf( '<div class="wrap">%s%s</div>',
                    $head,
                    $form
                );
            }
        }


        private function conf_form( $conf ) {

            $conf  =  str_keys( $conf );
            $page  =  str_slug( 'settings-'. $conf );
            $item  =  $this->conf_item( $conf );
            $args  =  add_query_arg( 'action', 'core_save', 'edit.php' );

            $form  =  sprintf(  '<form method="post" action="%s">
                                    %s
                                    <input type="hidden" name="page" value="%s" />
                                    <input type="hidden" name="name" value="%s" />
                                    <table class="form-table">%s</table>
                                    %s
                                </form>', 
                                $args,
                                wp_nonce_field( 'rozard-nonce', '_wpnonce', true , false ),
                                $page,
                                $conf,
                                $item,  
                                get_submit_button(),
                            );

            return $form;
        }


        private function conf_item( $conf ) {

            $items  = '';
           
            foreach( $this->conf as $data ) {


                if ( $data['name'] !== $conf ) {
                    continue;
                }

                $setting = $data['name'];
                $optvals = ( ! empty( get_site_option( $setting  ) ) ) ? get_site_option( $setting  ) : '' ;

                foreach( $data['form'] as $gid => $form ) {
               
                    $group_id  = $gid;

                    foreach ( $form['field'] as &$field ) {

                        
                        // assigned field value to field attribute
                        $fid = str_keys( $field['attr']['id'] );
                        if ( ! empty( $optvals[$gid][$fid] ) ) {
                            $field['value'] = $optvals[$gid][$fid];
                        } 

                        $items .= sprintf( '<tr>
                                                <th scope="row"><label for="some_field">%s</label></th>
                                                <td>%s</td>
                                            </tr>',
                                            esc_html( $field['name'] ),
                                            $this->get_field( $field, 'single ')
                                        );
                    }
                } 
            }

            return $items;
        }


        private function conf_pure( $data ) {

            $result = $data;

            foreach ( $result as &$groups ) {

                foreach( $groups as $key => &$field ) {

                    if ( array_key_exists( $key, $this->save )  ) {
                       
                        $types  =  $this->save[$key];
                        $value  =  $field;
                        $field  =  $this->pure_field( $types, $value );
                    }
                }
            }

            return  $result;
        }
    }

    new rozard_scheme_config;
}


/**
 *  Reference
 *  https://rudrastyh.com/wordpress-multisite/custom-tabs-with-options.html
 *  https://rudrastyh.com/wordpress/creating-options-pages.html#show-notice
 *  https://rudrastyh.com/wordpress-multisite/options-pages.html
 *  https://marioyepes.com/create-a-wordpress-multisite-settings-page/
 * 
 *  // user custom form
 *  https://developer.wordpress.org/reference/hooks/admin_post_action/
 */