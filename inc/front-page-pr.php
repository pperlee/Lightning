<?php
/*-------------------------------------------*/
/*	customize_register
/*-------------------------------------------*/
add_action( 'customize_register', 'lightning_front_pr_blocks_customize_register' );
function lightning_front_pr_blocks_customize_register($wp_customize) {

	/*-------------------------------------------*/
	/*	Front PR
	/*-------------------------------------------*/
	$wp_customize->add_section( 'lightning_front_pr', array(
		'title'				=> _x('Lightning Front Page PR Block', 'lightning theme-customizer', 'lightning'),
		'priority'			=> 700,
		// 'panel'				=> 'lightning_setting',
	) );

	$wp_customize->add_setting('lightning_theme_options[front_pr_hidden]', array(
		'default'			=> false,
		'type'				=> 'option',
		'capability'		=> 'edit_theme_options',
		'sanitize_callback' => 'lightning_sanitize_checkbox',
	) );

	// Add control
	$wp_customize->add_control( 'front_pr_hidden', array(
		'label'     => _x('Hide Front Page PR Block', 'lightning theme-customizer', 'lightning'),
		'section'  => 'lightning_front_pr',
		'settings' => 'lightning_theme_options[front_pr_hidden]',
		'type' => 'checkbox',
		'priority' => 1,
		'description' => __('* If you want to use the more advanced features and set a PR Block anywhere, please Install the WordPress official directory registration plug-in "VK All in One Expansion Unit (Free)" and use the "VK PR Blocks widgets". ', 'lightning'),
	) );


	$front_pr_default = array(
		'icon' => array(
			1 => 'fa-check',
			2 => 'fa-cogs',
			3 => 'fa-file-text-o'
			),
		'title' => array(
			1 => __( 'For all purposes', 'lightning' ),
			2 => __( 'Powerful features', 'lightning' ),
			3 => __( 'Surprisingly easy', 'lightning' )
			),
		'description' => array(
			1 => __( 'Lightning is a simple and customize easy WordPress theme.It corresponds by the outstanding versatility to the all-round also in business sites and blogs.', 'lightning' ),
			2 => __( 'By using the plug-in "VK All in One Expansion Unit (free)", you can use the various functions and rich widgets.', 'lightning' ),
			3 => __( 'Lightning is includes to a variety of ideas for making it easier to business site. Please experience the ease of use of the Lightning.', 'lightning' )
			),
		'link' => array(
			1 => '',
			2 => '',
			3 => ''
			),
		);

	$priority = 1;
	for ( $i = 1; $i <= 3; ) {
		$wp_customize->add_setting('lightning_theme_options[front_pr_icon_'.$i.']', array(
			'default'			=> $front_pr_default['icon'][$i],
			'type'				=> 'option',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_setting('lightning_theme_options[front_pr_title_'.$i.']', array(
			'default'			=> $front_pr_default['title'][$i],
			'type'				=> 'option',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_setting('lightning_theme_options[front_pr_description_'.$i.']', array(
			'default'			=> $front_pr_default['description'][$i],
			'type'				=> 'option',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_setting('lightning_theme_options[front_pr_link_'.$i.']', array(
			'default'			=> $front_pr_default['link'][$i],
			'type'				=> 'option',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		) );
		// Add control
		$priority ++;

		$wp_customize->add_control( new Custom_Text_Control( 
			$wp_customize, 
			'front_pr_icon_'.$i, 
			array(
				'label'    => _x('Icon ', 'lightning theme-customizer', 'lightning').' '.$i,
				'section'  => 'lightning_front_pr',
				'settings' => 'lightning_theme_options[front_pr_icon_'.$i.']',
				'type' => 'text',
				'description' => 'Ex : fa-file-text-o [ <a href="http://fontawesome.io/icons/" target="_blank">Icon list</a> ]',
				'priority' => $priority,
			)
		) );

		$wp_customize->add_control(  
			'front_pr_title_'.$i, 
			array(
				'label'    => _x('Title', 'lightning theme-customizer', 'lightning').' '.$i,
				'section'  => 'lightning_front_pr',
				'settings' => 'lightning_theme_options[front_pr_title_'.$i.']',
				'type' => 'text',
				'priority' => $priority,
			)
		);

		$wp_customize->add_control(  
			'front_pr_description_'.$i, 
			array(
				'label'    => _x('Text', 'lightning theme-customizer', 'lightning').' '.$i,
				'section'  => 'lightning_front_pr',
				'settings' => 'lightning_theme_options[front_pr_description_'.$i.']',
				'type' => 'textarea',
				'priority' => $priority,
			)
		);

		$wp_customize->add_control(  
			'front_pr_link_'.$i, 
			array(
				'label'    => _x('Link URL', 'lightning theme-customizer', 'lightning').' '.$i,
				'section'  => 'lightning_front_pr',
				'settings' => 'lightning_theme_options[front_pr_link_'.$i.']',
				'type' => 'text',
				'priority' => $priority,
			)
		);

		$i++;
	}
}

function lightning_front_pr_blocks_styles() {
	
    global $lightning_theme_options;
	$options = $lightning_theme_options;
	if ( !isset( $options['front_pr_hidden'] ) || !$options['front_pr_hidden'] ){
		if ( isset( $options['color_key'] ) && $options['color_key'] ){
			$color_key = $options['color_key'];
		} else {
			$color_key = '#337ab7';
		}
		$custom_css = "
			.prBlock_icon { border:1px solid {$color_key}; }
			.prBlock_icon .font_icon { color:{$color_key}; }
			a:hover .prBlock_icon { background-color:{$color_key}; }
			a:hover .prBlock_icon .font_icon { color:#fff; }
		";
	    wp_add_inline_style( 'lightning-theme-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'lightning_front_pr_blocks_styles' );

add_action( 'lightning_home_content_top_widget_area_before', 'lightning_front_pr_blocks_add' );
function lightning_front_pr_blocks_add(){
	global $lightning_theme_options;
	$options = $lightning_theme_options;
	/*
	isset( $options['front_pr_hidden'] ) ... Users from conventional
	$options['front_pr_hidden'] ... User setted hidden
	*/
	if ( !isset( $options['front_pr_hidden'] ) || !$options['front_pr_hidden'] ){
		echo '<section class="widget">';
		echo '<div class="prBlocks row">';
		for ( $i = 1; $i <= 3; ) {
			echo '<article class="prBlock prBlock_lighnt col-sm-4">';
			$options_array = array('icon','title','description','link');
			foreach ($options_array as $key => $value) {
				if ( !isset( $options['front_pr_'.$value.'_'.$i] ) ){
					$options['front_pr_'.$value.'_'.$i] = '';
				}
			}

			if ( $options['front_pr_link_'.$i] ) echo '<a href="'.esc_url( $options['front_pr_link_'.$i] ).'">';

			if ( $options['front_pr_icon_'.$i] ) {
				// echo '<div class="prBlock_icon" style="background-color:'.esc_attr( $options['color_key'] ).'">';
				echo '<div class="prBlock_icon">';
				echo '<i class="fa '.$options['front_pr_icon_'.$i].' font_icon"></i>';
				echo '</div>';
			}
			
			echo '<h1 class="prBlock_title">'.esc_html( $options['front_pr_title_'.$i] ).'</h1>';
			echo '<p class="prBlock_summary">'.esc_html( $options['front_pr_description_'.$i] ).'</p>';

			if ( $options['front_pr_link_'.$i] ) echo '</a>';
			echo '</article><!--//.prBlock -->'."\n";

			$i++;
		}
		echo '</div>';
		echo '</section>';
	}	
}

