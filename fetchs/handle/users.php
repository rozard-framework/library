<?php

if ( ! defined( 'ABSPATH' ) ) { exit ; }

if ( ! trait_exists( 'lib_users' ) ) {

    trait lib_users{

        use lib_assist;

        public function invoke_caps( $roles = array(), $caps = array() ) {

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $current_role = get_role( $this->str_slug( $role ) );
                foreach ( $caps as $cap )
                {
                    $current_role->add_cap( $this->str_slug( $cap ) );
                }
            }
        }


        public function revoke_caps( $roles = array(), $caps = array() ) {

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $current_role = get_role( $role );
                foreach ( $caps as $cap )
                {
                    $current_role->remove_cap( $cap );
                }
            }
        }


        public function delete_role( $roles = array() )  {

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $role_slugs = get_role( $role );
                remove_role( $role_slugs );
            }
        }


        public function create_role( $roles = array(), $caps = array() ) {

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $role_slugs = $this->str_keys( $role );
                $roles = get_role( $role_slugs );

                if ( empty( $roles ) )
                {
                    $role_title = to_text( $role_slugs );
                    add_role( $role_slugs , $role_title, $caps );
                }
            }
        }


        public function rename_role( $roles = array() ) {

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $role_slugs = get_role( $role );
                $role_title = $this->str_text(  $role_slugs );
                $role_caps  = $role_slugs->capabilities;
                remove_role($role_slugs );                           // remove role fisrt
                add_role( $role_slugs , $role_title , $role_caps);  // add new role with same capability
            }
        }


        public function delete_caps( $caps = array() ) {
            global $wp_roles;

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( array_keys( $wp_roles->roles ) as $role ) 
            {
                foreach ( $caps as $cap )
                {
                    $wp_roles->remove_cap($role, $cap );
                }
            }
        }


        public function create_caps( $roles = array(), $caps = array() ) {
            
            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $current_role = get_role( $role );
                foreach ( $caps as $cap )
                {
                    $current_role->add_cap( $cap );
                }
            }
        }


        public function invoke_post( $roles = array(), $posts = array() ) {

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'user_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $single = $this->str_keys( $posts );
                $plural = $this->str_plural( $single );

                $current_role = get_role(  $this->str_slug ( $role ) );
                $current_role->add_cap( "edit_{$plural}" ); 
                $current_role->add_cap( "edit_{$plural}" ); 
                $current_role->add_cap( "edit_others_{$plural}" ); 
                $current_role->add_cap( "publish_{$plural}" ); 
                $current_role->add_cap( "read_{$plural}" ); 
                $current_role->add_cap( "read_private_{$plural}" ); 
                $current_role->add_cap( "delete_{$plural}" ); 
                $current_role->add_cap( "delete_{$plural}" );
                $current_role->add_cap( "delete_private_{$plural}" );
                $current_role->add_cap( "delete_others_{$plural}" );
                $current_role->add_cap( "edit_published_{$plural}" );
                $current_role->add_cap( "edit_private_{$plural}" );
                $current_role->add_cap( "delete_published_{$plural}" );
            }
        }


        public function revoke_post( $roles = array(), $posts = array() ) {

            if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'post_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                $single = $this->str_keys( $posts );
                $plural = $this->str_plural($single);

                $current_role = get_role( $this->str_slug( $role ) );
                $current_role->remove_cap( "edit_{$plural}" ); 
                $current_role->remove_cap( "edit_{$plural}" ); 
                $current_role->remove_cap( "edit_others_{$plural}" ); 
                $current_role->remove_cap( "publish_{$plural}" ); 
                $current_role->remove_cap( "read_{$plural}" ); 
                $current_role->remove_cap( "read_private_{$plural}" ); 
                $current_role->remove_cap( "delete_{$plural}" ); 
                $current_role->remove_cap( "delete_{$plural}" );
                $current_role->remove_cap( "delete_private_{$plural}" );
                $current_role->remove_cap( "delete_others_{$plural}" );
                $current_role->remove_cap( "edit_published_{$plural}" );
                $current_role->remove_cap( "edit_private_{$plural}" );
                $current_role->remove_cap( "delete_published_{$plural}" );
            }
        }


        public function invoke_taxonomy( $roles = array(), $taxos = array() ) {

            if ( ! current_user_can( 'manage_options' ) ||  ! current_user_can( 'taxonomy_principal' )  ) {
                return;
            }

            foreach ( $roles as $role )
            {
                if ( $this->get_user_role( $this->str_slug( $role ) ) ) 
                {
                    $current_role = get_role( $this->str_slug( $role ) );
                    foreach ( $taxos as $taxo )
                    {
                        $slugs  = $this->str_plural( $this->str_slug( $taxo ) );
                        $current_role->add_cap( 'manage_'. $slugs );
                        $current_role->add_cap( 'edit_'. $slugs);
                        $current_role->add_cap( 'delete'. $slugs);
                        $current_role->add_cap( 'assign_'. $slugs );
                    }
                }
            }
        }


        public function revoke_taxonomy( $roles = array(), $taxos = array() ) {
            foreach ( $roles as $role )
            {
                if ( $this->get_user_role( $this->str_slug( $role ) ) ) 
                {
                    $current_role = get_role( $this->str_slug( $role ) );
                    foreach ( $taxos as $taxo )
                    {
                        $slugs  = $this->str_plural( $this->str_slug( $taxo ) );
                        $current_role->remove_cap( 'manage_'. $slugs );
                        $current_role->remove_cap( 'edit_'. $slugs );
                        $current_role->remove_cap( 'delete'. $slugs );
                        $current_role->remove_cap( 'assign_'. $slugs );
                    }
                }
            }
        }
    }
}