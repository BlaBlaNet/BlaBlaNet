<?php

namespace GeditLab\Theme;

class ZafiroConfig {

	function get_schemas() {
		$scheme_choices = array();
		$scheme_choices["---"] = t("Focus (BlaBlaNet default)");
		$files = glob('view/theme/Zafiro/schema/*.php');
		if($files) {
			foreach($files as $file) {
				$f = basename($file, ".php");
				if($f != 'default') {
					$scheme_name = $f;
					$scheme_choices[$f] = $scheme_name;
				}
			}
		}
		return $scheme_choices;
	}

	function get() {
		if(! local_channel()) { 
			return;
		}

		$arr = array();
		$arr['narrow_navbar'] = get_pconfig(local_channel(),'Zafiro', 'narrow_navbar' );
		$arr['nav_bg'] = get_pconfig(local_channel(),'Zafiro', 'nav_bg' );
		$arr['nav_gradient_top'] = get_pconfig(local_channel(),'Zafiro', 'nav_gradient_top' );
		$arr['nav_gradient_bottom'] = get_pconfig(local_channel(),'Zafiro', 'nav_gradient_bottom' );
		$arr['nav_active_gradient_top'] = get_pconfig(local_channel(),'Zafiro', 'nav_active_gradient_top' );
		$arr['nav_active_gradient_bottom'] = get_pconfig(local_channel(),'Zafiro', 'nav_active_gradient_bottom' );
		$arr['nav_bd'] = get_pconfig(local_channel(),'Zafiro', 'nav_bd' );
		$arr['nav_icon_colour'] = get_pconfig(local_channel(),'Zafiro', 'nav_icon_colour' );
		$arr['nav_active_icon_colour'] = get_pconfig(local_channel(),'Zafiro', 'nav_active_icon_colour' );
		$arr['link_colour'] = get_pconfig(local_channel(),'Zafiro', 'link_colour' );
		$arr['banner_colour'] = get_pconfig(local_channel(),'Zafiro', 'banner_colour' );
		$arr['bgcolour'] = get_pconfig(local_channel(),'Zafiro', 'background_colour' );
		$arr['background_image'] = get_pconfig(local_channel(),'Zafiro', 'background_image' );
		$arr['item_colour'] = get_pconfig(local_channel(),'Zafiro', 'item_colour' );
		$arr['comment_item_colour'] = get_pconfig(local_channel(),'Zafiro', 'comment_item_colour' );
		$arr['comment_border_colour'] = get_pconfig(local_channel(),'Zafiro', 'comment_border_colour' );
		$arr['comment_indent'] = get_pconfig(local_channel(),'Zafiro', 'comment_indent' );
		$arr['toolicon_colour'] = get_pconfig(local_channel(),'Zafiro','toolicon_colour');
		$arr['toolicon_activecolour'] = get_pconfig(local_channel(),'Zafiro','toolicon_activecolour');
		$arr['font_size'] = get_pconfig(local_channel(),'Zafiro', 'font_size' );
		$arr['body_font_size'] = get_pconfig(local_channel(),'Zafiro', 'body_font_size' );
		$arr['font_colour'] = get_pconfig(local_channel(),'Zafiro', 'font_colour' );
		$arr['radius'] = get_pconfig(local_channel(),'Zafiro', 'radius' );
		$arr['shadow'] = get_pconfig(local_channel(),'Zafiro', 'photo_shadow' );
		$arr['converse_width']=get_pconfig(local_channel(),"Zafiro","converse_width");
		$arr['align_left']=get_pconfig(local_channel(),"Zafiro","align_left");
		$arr['nav_min_opacity']=get_pconfig(local_channel(),"Zafiro","nav_min_opacity");
		$arr['top_photo']=get_pconfig(local_channel(),"Zafiro","top_photo");
		$arr['reply_photo']=get_pconfig(local_channel(),"Zafiro","reply_photo");
		return $this->form($arr);
	}

	function post() {
		if(!local_channel()) { 
			return;
		}

		if (isset($_POST['Zafiro-settings-submit'])) {
			set_pconfig(local_channel(), 'Zafiro', 'narrow_navbar', $_POST['Zafiro_narrow_navbar']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_bg', $_POST['Zafiro_nav_bg']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_gradient_top', $_POST['Zafiro_nav_gradient_top']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_gradient_bottom', $_POST['Zafiro_nav_gradient_bottom']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_active_gradient_top', $_POST['Zafiro_nav_active_gradient_top']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_active_gradient_bottom', $_POST['Zafiro_nav_active_gradient_bottom']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_bd', $_POST['Zafiro_nav_bd']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_icon_colour', $_POST['Zafiro_nav_icon_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_active_icon_colour', $_POST['Zafiro_nav_active_icon_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'link_colour', $_POST['Zafiro_link_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'background_colour', $_POST['Zafiro_background_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'banner_colour', $_POST['Zafiro_banner_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'background_image', $_POST['Zafiro_background_image']);
			set_pconfig(local_channel(), 'Zafiro', 'item_colour', $_POST['Zafiro_item_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'comment_item_colour', $_POST['Zafiro_comment_item_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'comment_border_colour', $_POST['Zafiro_comment_border_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'comment_indent', $_POST['Zafiro_comment_indent']);
			set_pconfig(local_channel(), 'Zafiro', 'toolicon_colour', $_POST['Zafiro_toolicon_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'toolicon_activecolour', $_POST['Zafiro_toolicon_activecolour']);
			set_pconfig(local_channel(), 'Zafiro', 'font_size', $_POST['Zafiro_font_size']);
			set_pconfig(local_channel(), 'Zafiro', 'body_font_size', $_POST['Zafiro_body_font_size']);
			set_pconfig(local_channel(), 'Zafiro', 'font_colour', $_POST['Zafiro_font_colour']);
			set_pconfig(local_channel(), 'Zafiro', 'radius', $_POST['Zafiro_radius']);
			set_pconfig(local_channel(), 'Zafiro', 'photo_shadow', $_POST['Zafiro_shadow']);
			set_pconfig(local_channel(), 'Zafiro', 'converse_width', $_POST['Zafiro_converse_width']);
			set_pconfig(local_channel(), 'Zafiro', 'align_left', $_POST['Zafiro_align_left']);
			set_pconfig(local_channel(), 'Zafiro', 'nav_min_opacity', $_POST['Zafiro_nav_min_opacity']);
			set_pconfig(local_channel(), 'Zafiro', 'top_photo', $_POST['Zafiro_top_photo']);
			set_pconfig(local_channel(), 'Zafiro', 'reply_photo', $_POST['Zafiro_reply_photo']);
		}
	}

	function form($arr) {

		if(feature_enabled(local_channel(),'advanced_theming')) 
			$expert = 1;
					

	  	$o .= replace_macros(get_markup_template('theme_settings.tpl'), array(
			'$submit' => t('Submit'),
			'$baseurl' => z_root(),
			'$theme' => \App::$channel['channel_theme'],
			'$expert' => $expert,
			'$title' => t("Theme settings"),
			'$narrow_navbar' => array('Zafiro_narrow_navbar',t('Narrow navbar'),$arr['narrow_navbar'], '', array(t('No'),t('Yes'))),
			'$nav_bg' => array('Zafiro_nav_bg', t('Navigation bar background color'), $arr['nav_bg']),
			'$nav_gradient_top' => array('Zafiro_nav_gradient_top', t('Navigation bar gradient top color'), $arr['nav_gradient_top']),
			'$nav_gradient_bottom' => array('Zafiro_nav_gradient_bottom', t('Navigation bar gradient bottom color'), $arr['nav_gradient_bottom']),
			'$nav_active_gradient_top' => array('Zafiro_nav_active_gradient_top', t('Navigation active button gradient top color'), $arr['nav_active_gradient_top']),
			'$nav_active_gradient_bottom' => array('Zafiro_nav_active_gradient_bottom', t('Navigation active button gradient bottom color'), $arr['nav_active_gradient_bottom']),
			'$nav_bd' => array('Zafiro_nav_bd', t('Navigation bar border color '), $arr['nav_bd']),
			'$nav_icon_colour' => array('Zafiro_nav_icon_colour', t('Navigation bar icon color '), $arr['nav_icon_colour']),	
			'$nav_active_icon_colour' => array('Zafiro_nav_active_icon_colour', t('Navigation bar active icon color '), $arr['nav_active_icon_colour']),
			'$link_colour' => array('Zafiro_link_colour', t('link color'), $arr['link_colour'], '', $link_colours),
			'$banner_colour' => array('Zafiro_banner_colour', t('Set font-color for banner'), $arr['banner_colour']),
			'$bgcolour' => array('Zafiro_background_colour', t('Set the background color'), $arr['bgcolour']),
			'$background_image' => array('Zafiro_background_image', t('Set the background image'), $arr['background_image']),	
			'$item_colour' => array('Zafiro_item_colour', t('Set the background color of items'), $arr['item_colour']),
			'$comment_item_colour' => array('Zafiro_comment_item_colour', t('Set the background color of comments'), $arr['comment_item_colour']),
			'$comment_border_colour' => array('Zafiro_comment_border_colour', t('Set the border color of comments'), $arr['comment_border_colour']),
			'$comment_indent' => array('Zafiro_comment_indent', t('Set the indent for comments'), $arr['comment_indent']),
			'$toolicon_colour' => array('Zafiro_toolicon_colour',t('Set the basic color for item icons'),$arr['toolicon_colour']),
			'$toolicon_activecolour' => array('Zafiro_toolicon_activecolour',t('Set the hover color for item icons'),$arr['toolicon_activecolour']),
			'$body_font_size' => array('Zafiro_body_font_size', t('Set font-size for the entire application'), $arr['body_font_size'], t('Example: 14px')),
			'$font_size' => array('Zafiro_font_size', t('Set font-size for posts and comments'), $arr['font_size']),
			'$font_colour' => array('Zafiro_font_colour', t('Set font-color for posts and comments'), $arr['font_colour']),
			'$radius' => array('Zafiro_radius', t('Set radius of corners'), $arr['radius']),
			'$shadow' => array('Zafiro_shadow', t('Set shadow depth of photos'), $arr['shadow']),
			'$converse_width' => array('Zafiro_converse_width',t('Set maximum width of content region in pixel'),$arr['converse_width'], t('Leave empty for default width')),
			'$align_left' => array('Zafiro_align_left',t('Left align page content'),$arr['align_left'], '', array(t('No'),t('Yes'))),
			'$nav_min_opacity' => array('Zafiro_nav_min_opacity',t('Set minimum opacity of nav bar - to hide it'),$arr['nav_min_opacity']),
			'$top_photo' => array('Zafiro_top_photo', t('Set size of conversation author photo'), $arr['top_photo']),
			'$reply_photo' => array('Zafiro_reply_photo', t('Set size of followup author photos'), $arr['reply_photo']),
			));

		return $o;
	}

}






