<?php

declare(strict_types=1);
if ( ! defined('ABPSATH') || ! defined( 'rozard' ) ){ exit; }


function theme_logo() {

	$logo_ids  =  get_theme_mod( 'custom_logo' );
	$get_logo  =  wp_get_attachment_image_src( $logo_ids , 'full' );


	if ( has_custom_logo() ) {

		$resultat = sprintf( '<a class="brand flex" href="%s"><img class="logo" src="%s" alt="%s"></a>',
						esc_url( home_url() ),
						esc_url( $get_logo[0] ),
						esc_attr( get_bloginfo( 'name' ) ),
					);

	} 
	else {

		$resultat  =  sprintf( '<h1>%s</h1>', get_bloginfo('name') );
	} 


	return $resultat;
}


function theme_brand_general() {


	$info    = get_option( 'brand_info' );
	$contact = get_option( 'brand_contact' );
	$social  = get_option( 'brand_social' );


	// inform
	$nm  = ( ! empty( $info['nm'] ) ) ? $info['nm'] : '';
	$of  = ( ! empty( $info['of'] ) ) ? $info['of'] : '';
	$cp  = ( ! empty( $info['cp'] ) ) ? $info['cp'] : '';



	// contact
	$tl  = ( ! empty( $contact['tl'] ) ) ? $contact['tl'] : '';
	$ml  = ( ! empty( $contact['ml'] ) ) ? $contact['ml'] : '';
	$fx  = ( ! empty( $contact['fx'] ) ) ? $contact['fx'] : '';
	$wa  = ( ! empty( $contact['wa'] ) ) ? $contact['wa'] : '';


	$rtl  = ( ! empty( $tl ) ) ? '<div class="flex-a"><i class="dashicons dashicons-phone mr-2 my-3"></i>'. esc_html( $tl ) .' </div>' : '';
	$rml  = ( ! empty( $ml ) ) ? '<div class="flex-a"><i class="dashicons dashicons-email mr-2 my-3"></i>'. esc_html( $ml ) .' </div>' : '';
	$rfx  = ( ! empty( $fx ) ) ? '<div class="flex-a"><i class="dashicons dashicons-printer mr-2 my-3"></i>'. esc_html( $fx ) .' </div>' : '';
	$rwa  = ( ! empty( $wa ) ) ? '<div class="flex-a"><i class="dashicons dashicons-whatsapp mr-2 my-3"></i>'. esc_html( $wa ) .' </div>' : '';


	


	// logo
	$logo = theme_logo();


	$info = sprintf( '<div class="company">
						<p class="item address  my-5">%s</p>
						<p class="item compro  ">%s</p>
					 </div>',
					 esc_html( $of ),
					 esc_html( $cp ),
				);


	$cont = sprintf( '<div class="contact">
						<div class="item  flex-a">%s</div>
						<div class="item  flex-a">%s</div>
						<div class="item  flex-a">%s</div>
						<div class="item  flex-a">%s</div>
					 </div>',
					wp_kses_post( $rtl ),
					wp_kses_post( $rml ),
					wp_kses_post( $rfx ),
					wp_kses_post( $rwa ),
				);

	$sosm = sprintf( '<ul class="social ls-none flex-a">
							%s
							%s
							%s
							%s
							%s
	   				  </ul>',
						wp_kses_post( $rfb ),
						wp_kses_post( $rig ),
						wp_kses_post( $rlk ),
						wp_kses_post( $ryt ),
						wp_kses_post( $rtw ),
					);


	printf( '<div class="brand card">
				<div class="logo">%s</div>
				<div class="social">%s</div>
				<div class="contact">%s</div>
				<div class="info">%s</div>
			</div>',
			$logo,
			$sosm,
			$cont,
			$info,
		);
	
}


function theme_brand_compro() {

	$info = get_option( 'brand_info' );


	// inform
	$nm  = ( ! empty( $info['nm'] ) ) ? $info['nm'] : '';
	$of  = ( ! empty( $info['of'] ) ) ? $info['of'] : '';
	$cp  = ( ! empty( $info['cp'] ) ) ? $info['cp'] : '';

	$render = sprintf( '<div class="company">
							<div class="item title  mb-1">%s</div>
							<p class="item address  mt-3 mb-5">%s</p>
							<p class="item compro  ">%s</p>
						</div>',
						esc_html( $nm ),
						esc_html( $of ),
						esc_html( $cp ),
					);

	return $render;
}


function theme_brand_contact() {


	$contact = get_option( 'brand_contact' );


	// contact
	$tl  = ( ! empty( $contact['tl'] ) ) ? $contact['tl'] : '';
	$ml  = ( ! empty( $contact['ml'] ) ) ? $contact['ml'] : '';
	$fx  = ( ! empty( $contact['fx'] ) ) ? $contact['fx'] : '';
	$wa  = ( ! empty( $contact['wa'] ) ) ? $contact['wa'] : '';



	$rtl  = ( ! empty( $tl ) ) ? '<div class="flex-a"><i class="las la-phone mr-2 my-3"></i><p class="item">'. esc_html( $tl ) .'</p></div>' : '';
	$rml  = ( ! empty( $ml ) ) ? '<div class="flex-a"><i class="las la-envelope mr-2 my-3"></i><p class="item">'. esc_html( $ml ) .'</p></div>' : '';
	$rfx  = ( ! empty( $fx ) ) ? '<div class="flex-a"><i class="las la-fax mr-2 my-3"></i><p class="item">'. esc_html( $fx ) .'</p></div>' : '';
	$rwa  = ( ! empty( $wa ) ) ? '<div class="flex-a"><i class="lab la-whatsapp mr-2 my-3"></i><p class="item">'. esc_html( $wa ) .'</p></div>' : '';



	$render =  sprintf( '<div class="contact my-3">
							<div class="item  flex-a">%s</div>
							<div class="item  flex-a">%s</div>
							<div class="item  flex-a">%s</div>
							<div class="item  flex-a">%s</div>
						</div>',
						wp_kses_post( $rtl ),
						wp_kses_post( $rml ),
						wp_kses_post( $rfx ),
						wp_kses_post( $rwa ),
					);
	return $render;
}


function theme_brand_social() {

	$social  = get_option( 'brand_social' );

	// social
	$fb  = ( ! empty( $social['fb'] ) ) ? $social['fb'] : '';
	$ig  = ( ! empty( $social['ig'] ) ) ? $social['ig'] : '';
	$lk  = ( ! empty( $social['lk'] ) ) ? $social['lk'] : '';
	$yt  = ( ! empty( $social['yt'] ) ) ? $social['yt'] : '';
	$tw  = ( ! empty( $social['tw'] ) ) ? $social['tw'] : '';

	$rfb  = ( ! empty( $fb ) ) ? '<li class="mr-3"><a href="'. esc_url($fb) .'"><i class="lab la-facebook"></i></a></li>' : '';
	$rig  = ( ! empty( $ig ) ) ? '<li class="mr-3"><a href="'. esc_url($ig) .'"><i class="lab la-instagram"></i></a></li>' : '';
	$rlk  = ( ! empty( $lk ) ) ? '<li class="mr-3"><a href="'. esc_url($lk) .'"><i class="lab la-linkedin"></i></a></li>' : '';
	$ryt  = ( ! empty( $yt ) ) ? '<li class="mr-3"><a href="'. esc_url($yt) .'"><i class="lab la-youtube"></i></a></li>' : '';
	$rtw  = ( ! empty( $tw ) ) ? '<li class="mr-3"><a href="'. esc_url($tw) .'"><i class="lab la-twitter-square"></i></a></li>' : '';


	$render = sprintf( '<ul class="social ls-none flex-a my-3">
						%s
						%s
						%s
						%s
						%s
						</ul>',
						wp_kses_post( $rfb ),
						wp_kses_post( $rig ),
						wp_kses_post( $rlk ),
						wp_kses_post( $ryt ),
						wp_kses_post( $rtw ),
					);
	return $render;
}


function theme_pagination( $data  ) {
    
	$total = $data->max_num_pages;
	$render = '';

	if ($total > 1){
		$paged = max( 1, get_query_var('page') );
		$paginate = paginate_links(array(
			'current' => $paged,
			'total'   => $total,
			'format'  => '?page=%#%',
			'prev_text'    => __('« prev'),
			'next_text'    => __('next »'),
		));

		$render = sprintf('<div class="paginate">%s</div>',
						$paginate,
					);
	}

	return $render;
}


function theme_readtime( $content = '', $words_per_minute = 300, $with_gutenberg = false ) {
    
	// In case if content is build with gutenberg parse blocks
	if ( $with_gutenberg ) {

		$blocks = parse_blocks( $content );
		$contentHtml = '';

		foreach ( $blocks as $block ) {
			$contentHtml .= render_block( $block );
		}

		$content = $contentHtml;
	}
			
	// Remove HTML tags from string
	$content = wp_strip_all_tags( $content );
			

	// When content is empty return 0
	if ( !$content ) {
		return 0;
	}
			
	// Count words containing string
	$words_count = str_word_count( $content );
			
	// Calculate time for read all words and round
	$minutes = ceil( $words_count / $words_per_minute );
			
	return $minutes;
}


function theme_termdata( $taxonomy_slug ) {
    
	$terms = get_terms( $taxonomy_slug, array( 'hide_empty' => true, ) ) ;
	$final = array();

	if ( !empty($terms) ) {
		foreach( $terms as $category ) {
			if( $category->parent == 0 ) {
				$final[$category->term_id] = get_object_vars( $category );
				foreach( $terms as $subcategory ) {
					if ( $subcategory->parent == $category->term_id ) {
						if ( $subcategory->parent == $category->term_id ) {
							$final[$subcategory->term_id] = get_object_vars( $subcategory );
						}
					}
				}
			}
		}
	}

	return $final;
}


function theme_search_default() {

    $form = sprintf('<form class="search" method="get" action="%s">
                            <div role="search" class="flex-a">
                            <input class="search-input" type="search" name="s" aria-label="Search site for:" placeholder="%s">
                            <button class="search-submit btn btn-primary" type="submit">%s</button>
                            </div>
                        </form>',
                        esc_url( home_url() ),
                        esc_html( 'To search, type and hit enter.', 'rozard_framework' ),
                        esc_html( 'Search', 'rozard_framework'),
                    );

    $menu = sprintf( '<i class="las la-search open-nav" data-target="theme-default-search"></i>' );


    $render = sprintf( '<div class="search">
                            <div id="theme-default-search" class="mobile-open form hide xs sm">%s</div>
                            <div class="action hide md lg xl xxl flex-a">%s</div>
                        </div>',
                        $form,
                        $menu
                    );

    printf( $render );
}


function get_theme_thumbnail() {
	
	$image = get_the_post_thumbnail_url( get_the_ID() );
	$noimg = get_site_url( get_main_site_id() ) . '/wp-admin/assets/image/styles/no-image.png' ;
	$links = get_the_permalink();

	if ( empty( $image ) ) {

		$render = sprintf( '<a href="%s" ><img src="%s" class="thumbnail full" alt="image-not-available" /></a>',
							esc_url( $links ),
							esc_url( $noimg ),
						);
	}
	else {

		$render = sprintf( '<a href="%s" ><img src="%s" class="thumbnail full" alt="image-not-available" /></a>',
							esc_url( $links ),
							esc_url( $image ),
						);
	}

	return $render;
}