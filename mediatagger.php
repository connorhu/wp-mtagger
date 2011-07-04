<?php
/*
Plugin Name: MediaTagger
Plugin URI: http://www.photos-dauphine.com/wp-mediatagger-plugin
Description: This extensively configurable plugin comes packed with a bunch of features enabling media tagging, including search and media taxonomy.
Author: www.photos-dauphine.com
Version: 3.0.1
Stable tag: 3.0.1
Author URI: http://www.photos-dauphine.com/
*/

/*  Copyright 2011 PHD - http://www.photos-dauphine.com  (email : http://www.photos-dauphine.com/ecrire )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include "mediatagger-lib.php";

//echo get_bloginfo('wpurl');

// Retrieve plugin version from above header
global $WPIT_SELF_VERSION;
global $WPIT_SELF_VERSION_STABLE;
foreach(array_slice(file(__FILE__), 0, 10) as $line) {$expl = explode(':', $line);  if (trim(current($expl))== 'Version') $WPIT_SELF_VERSION = trim(next($expl)); else if (trim(current($expl))== 'Stable tag') $WPIT_SELF_VERSION_STABLE = trim(next($expl));}

// Load localized language file
$wpit_dir = basename(dirname(__FILE__));
load_plugin_textdomain('mediatagger', 'wp-content/plugins/' . $wpit_dir, $wpit_dir);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//	Init MediaTagger plugin
//
function wpit_install(){
    global $wpdb;
	
	// If table already there, return with no action
	if($wpdb->get_var('SHOW TABLES LIKE "' . TERM_REL_IMG . '"') == TERM_REL_IMG){
		return;
	}

    $structure = 'CREATE TABLE ' . TERM_REL_IMG . '(
        object_id BIGINT(20) NOT NULL DEFAULT 0,
        term_taxonomy_id BIGINT(20) NOT NULL DEFAULT 0
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    $wpdb->query($structure);

}

//////////////////////
//
function wpit_menu(){
    include 'mediatagger-admin.php';
}

//////////////////////
//
function wpit_admin_actions(){
    add_options_page("MediaTagger", "MediaTagger", 10, "mediatagger", "wpit_menu");
}
 
add_action('activate_wp-mediatagger/mediatagger.php', 'wpit_install');
add_action('admin_menu', 'wpit_admin_actions');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//	Init MediaTagger widget
//
function wpit_widget($args) {
	
	$wpit_options = get_option('wpit_widget');
    extract($args);    //on extrait les variables natives d'affichage telles que $before_widget

	echo $before_widget;
    echo $before_title . $wpit_options['title'] . $after_title;
	if (trim($wpit_options['text']) != '')
		echo '<div class="textwidget">' . $wpit_options['text'] . '</div>';
	// Insert the MediaTagger tag cloud
	echo imgt_multisort_insert($wpit_options['result_url'], $wpit_options['num_tags'], $wpit_options['font_min'], $wpit_options['font_max'],
							$wpit_options['color_min'], $wpit_options['color_max'], 1);
	
    echo $after_widget; 
}

//////////////////////
//
function wpit_widget_control() {
    $options = get_option('wpit_widget');
	
    if ($_POST["wpit_widget_submit"]) {
		$options['title'] = strip_tags(stripslashes($_POST["wpit_widget_title"]));
		$options['text'] = stripslashes($_POST["wpit_widget_text"]);
		$options['num_tags'] = $_POST["wpit_widget_num_tags"];
		$options['font_min'] = $_POST["wpit_widget_font_min"];
		$options['font_max'] = $_POST["wpit_widget_font_max"];
		$options['color_min'] = $_POST["wpit_widget_color_min"];
		$options['color_max'] = $_POST["wpit_widget_color_max"];
		$options['result_url'] = strip_tags(stripslashes($_POST["wpit_widget_url"]));
		update_option('wpit_widget', $options);
    }
	
    $wpit_widget_title = htmlspecialchars($options['title'], ENT_QUOTES);
    $wpit_widget_text = htmlspecialchars($options['text'], ENT_QUOTES);
	$wpit_widget_num_tags = $options['num_tags'];
	$wpit_widget_font_min = $options['font_min'];
	$wpit_widget_font_max = $options['font_max'];
	$wpit_widget_color_min = $options['color_min'];
	$wpit_widget_color_max = $options['color_max'];
	$wpit_widget_url = $options['result_url'];
    ?>
  
    <p><label for="wpit_widget_title"><?php _e('Title', 'mediatagger'); ?> : </label><br/>
    <input id="wpit_widget_title" name="wpit_widget_title" size="30" value="<?php echo $wpit_widget_title; ?>" type="text"></p>
    <p><label for="wpit_widget_text"><?php _e('Text', 'mediatagger'); ?> : </label><br/>
    <textarea name="wpit_widget_text" cols="28" rows="6"><?php echo $wpit_widget_text ?></textarea></p>
    <p><label for="wpit_widget_num_tags"><?php _e('Number of displayed tags', 'mediatagger'); ?> </label><br/>
    <input id="wpit_widget_num_tags" name="wpit_widget_num_tags" size="4" value="<?php echo $wpit_widget_num_tags; ?>" type="text"></p>
    <p><label for="wpit_widget_font_min"><?php _e('Minimum font size', 'mediatagger'); ?> </label><br/>
    <input id="wpit_widget_font_min" name="wpit_widget_font_min" size="4" value="<?php echo $wpit_widget_font_min; ?>" type="text"></p>
    <p><label for="wpit_widget_font_max"><?php _e('Maximum font size', 'mediatagger'); ?> </label><br/>
    <input id="wpit_widget_font_max" name="wpit_widget_font_max" size="4" value="<?php echo $wpit_widget_font_max; ?>" type="text"></p>
    
    <p><label for="wpit_widget_color_min"><?php _e('Minimum font color (-1 to disable)', 'mediatagger'); ?> </label><br/>
    <input id="wpit_widget_color_min" name="wpit_widget_color_min" size="8" value="<?php echo $wpit_widget_color_min; ?>" type="text"></p>
    <p><label for="wpit_widget_color_max"><?php _e('Maximum font color (-1 to disable)', 'mediatagger'); ?> </label><br/>
    <input id="wpit_widget_color_max" name="wpit_widget_color_max" size="8" value="<?php echo $wpit_widget_color_max; ?>" type="text"></p>
    
    <p><label for="wpit_widget_url"><?php _e('Result page address', 'mediatagger'); ?> : </label><br/>
    <input id="wpit_widget_url" name="wpit_widget_url" size="30" value="<?php echo $wpit_widget_url; ?>" type="text"></p>
    
    <input type="hidden" id="wpit_widget_submit" name="wpit_widget_submit" value="1" /></p>
<?php
}

//////////////////////
//
function init_mediatagger_widget(){
	wp_register_sidebar_widget("MediaTagger", "MediaTagger", "wpit_widget", array('description'=>__('Display your MediaTagger tag cloud in the sidebar. Before that, you need to have properly tagged your medias in the MediaTagger plugin Admin Panel and have as well setup a result page that you will use as your tag cloud target page', 'mediatagger')));     
	register_widget_control('MediaTagger', 'wpit_widget_control', null, null);
}
 
add_action("plugins_loaded", "init_mediatagger_widget");


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// DEPRECATED starting 2.5.2 
// Insert image search form on a page and provide search result when tags selected and 
// search submitted
//
//
function wpit_multisort_insert($result_page_url='', $num_tags_displayed = '', $font_size_min = '', $font_size_max = '', 
							   $font_color_min = '', $font_color_max = '', $called_from_widget = 0){
	
	echo '<p style="background-color:#ff7;font-size:0.8em;padding:10px;">';
	echo '<em>' . __('The direct PHP call to the MediaTagger plugin core function wpit_multisort_insert() is deprecated starting version 2.5.2 of this plugin.', 'mediatagger') . '</em><br/><br/>';
	echo __('It is finally disabled starting version 2.5.4.5 and needs to be replaced by its shortcode equivalent. This does not require anymore running PHP in your page.', 'mediatagger') . ' ';
	echo __('That\'s a very simple modification, please refer for this purpose to the WP MediaTagger ', 'mediatagger') . '<a href="http://wordpress.org/extend/plugins/wp-mediatagger/installation/">' . 
		__('installation guide', 'mediatagger') . '</a>' . __(' and ', 'mediatagger') . '<a href="http://wordpress.org/extend/plugins/wp-mediatagger/faq/">' . 
		__('FAQ', 'mediatagger');
	echo '.</p>';
		
	//echo imgt_multisort_insert($result_page_url, $num_tags_displayed, $font_size_min, $font_size_max, $font_color_min, $font_color_max, $called_from_widget);
	
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// Insert image search form on a page and provide search result when tags selected and 
// search submitted
//
//
function imgt_multisort_insert($result_page_url='', $num_tags_displayed = '', $font_size_min = '', $font_size_max = '', 
							   $font_color_min = '', $font_color_max = '', $called_from_widget = 0){
	global $g_imgt_tag_taxonomy;
	global $WPIT_SELF_VERSION_STABLE;
	global $WPIT_GD_VERSION;
	$wpit_debug = 0;
	$strout = '';
	
	//print_ro($_POST);
	
	if (isset($_GET['tags'])){		// a GET url was formed : http://www.photos-dauphine.com/phototheque?tags=lumiere+arbre+foret
		$tag_list_get = $_GET['tags'];
		$tag_list_get = explode(' ', $tag_list_get);
		//print_ro($tag_list_get);
		$tax_id_list = imgt_slug_to_taxonomy($tag_list_get);
		//print_ro($tax_id_list);
		$search_mode=0;
		if (isset($_GET['display'])){		// a GET url was formed : http://www.photos-dauphine.com/phototheque?tag=lumiere+arbre+foret&display=cloud 
			// display argument can be :  cloud | form | combined ; by default the setup defined in the admin panel applies
			$search_display_get = $_GET['display'];
			//echo $search_display_get;
			switch($search_display_get) {
				case cloud: 	$search_mode=1; break;
				case combined: 	$search_mode=2; break;
				case form: 		$search_mode=3; break;
			}
		}
	}
	
	//$tax_id_list = (isset($tax_id_list) ? $tax_id_list : $_POST['tags']);
	$tax_id_list = (isset($tax_id_list) ? $tax_id_list : ($_POST['search'] == "Clear" ? array() : $_POST['tags']));
	
	// Define form prefix to avoid 2 same form names when widget displayed on result page
	$search_form_prefix = ($called_from_widget ? 'widget_' : ''); 
	
	// Get result page
	if ($result_page_url == '')
		$result_page_url = get_permalink();
		
	// Get preset modes 
	$preset_search_mode = admin_get_option_safe('wpit_search_default_display_mode', WPIT_SEARCH_INIT_DEFAULT_DISPLAY_MODE);	// 1: cloud only; 2: cloud & form; 3: form only
	$preset_result_mode = admin_get_option_safe('wpit_result_default_display_mode', WPIT_RESULT_INIT_DEFAULT_DISPLAY_MODE); // 1: gallery; 2: itemized image list; 3: title list
	$search_mode = ($called_from_widget ? 1 : (isset($search_mode) ? $search_mode : ( $_POST['coming_from_widget'] ? $preset_search_mode : (isset($_POST['search_mode']) ? $_POST['search_mode'] : $preset_search_mode))));	
	$is_search_mode_switchable = ($called_from_widget ? 0 : (isset($search_mode) && $search_mode == 0 ? 0 : admin_get_option_safe('wpit_search_display_switchable', WPIT_SEARCH_INIT_DISPLAY_SWITCHABLE)));
	$is_result_mode_switchable = admin_get_option_safe('wpit_result_display_switchable', WPIT_RESULT_INIT_DISPLAY_SWITCHABLE);
	$wpit_search_tags_excluded = admin_get_option_safe('wpit_search_tags_excluded', WPIT_SEARCH_INIT_TAGS_EXCLUDED);
	$wpit_admin_background_color = admin_get_option_safe('wpit_admin_background_color', WPIT_ADMIN_INIT_BACKGROUND_COLOR);

	$result_mode = (isset($_POST['result_mode']) ? $_POST['result_mode'] : $preset_result_mode);

	switch ($_POST['link_triggered']){
		// 0: nothing ; 1: cloud only ; 2: cloud & form ; 3: form only
		case 11:
		case 12:
		case 13: $search_mode = $_POST['link_triggered'] - 10; break; 
		// 1: gallery ; 2: itemized image list; 3: title list
		case 21:
		case 22:
		case 23: $result_mode = $_POST['link_triggered'] - 20; break; 
		// 30:prev page, 31:next page
		case 30: $change_page_previous = 1; break;	
		case 31: $change_page_next = 1; break;
	}

	if ($result_mode == 1) {			// gallery
		$num_img_per_page = admin_get_option_safe('wpit_gallery_image_num_per_page', WPIT_INIT_GALLERY_IMAGE_NUM_PER_PAGE);
		$img_norm_size = admin_get_option_safe('wpit_result_img_gallery_w_h', WPIT_RESULT_INIT_IMG_GALLERY_W_H);
		$img_border_width = admin_get_option_safe('wpit_gallery_image_border_w', WPIT_INIT_GALLERY_IMAGE_BORDER_W);
		$img_border_color = admin_get_option_safe('wpit_gallery_image_border_color', WPIT_INIT_GALLERY_IMAGE_BORDER_COLOR);
		$link_to_post = admin_get_option_safe('wpit_gallery_image_link_ctrl', WPIT_INIT_GALLERY_IMAGE_LINK_CTRL) - 1;
	} else if ($result_mode == 2){		//  itemized image list
		$num_img_per_page = admin_get_option_safe('wpit_list_image_num_per_page', WPIT_INIT_LIST_IMAGE_NUM_PER_PAGE);
		$img_norm_size = admin_get_option_safe('wpit_result_img_list_w_h', WPIT_RESULT_INIT_IMG_LIST_W_H);
	} else if ($result_mode == 3){		//  title list
		$num_img_per_page = admin_get_option_safe('wpit_list_title_num_per_page', WPIT_INIT_LIST_TITLE_NUM_PER_PAGE);
	}
	
	$wpit_result_display_optimize_xfer = admin_get_option_safe('wpit_result_display_optimize_xfer', WPIT_RESULT_INIT_OPTIMIZE_XFER);
	
	if ($search_mode <= 2) {  		// tagcloud or combined => prepare tagcloud display		
		$wpit_tagcloud_order = admin_get_option_safe('wpit_tagcloud_order', WPIT_INIT_TAGCLOUD_ORDER);

		if ($num_tags_displayed == '')
			$num_tags_displayed = admin_get_option_safe('wpit_tagcloud_num_tags', WPIT_INIT_TAGCLOUD_NUM_TAGS);	// 0 = all tags
		if ($font_size_min == '')
			$font_size_min = admin_get_option_safe('wpit_tagcloud_font_min', WPIT_INIT_TAGCLOUD_FONT_MIN);
		if ($font_size_max == '')
			$font_size_max = admin_get_option_safe('wpit_tagcloud_font_max', WPIT_INIT_TAGCLOUD_FONT_MAX);

		//$color_min_hex = ($called_from_widget ? '888888' : '83b4fc');	//'83b4fc';
		//$color_max_hex = ($called_from_widget ? '333333' : '5182ca');
		//$standard_text_color = '333333';
		
		if ($font_color_min == '')
			$font_color_min = admin_get_option_safe('wpit_tagcloud_color_min', WPIT_INIT_TAGCLOUD_COLOR_MIN);
		if ($font_color_max == '')
			$font_color_max = admin_get_option_safe('wpit_tagcloud_color_max', WPIT_INIT_TAGCLOUD_COLOR_MAX);
		$highlight_text_color = admin_get_option_safe('wpit_tagcloud_highlight_color', WPIT_INIT_TAGCLOUD_HIGHLIGHT_COLOR);
		
		$use_dynamic_colors = ( $font_color_min == -1 ? 0 : 1 );
		$use_hover_and_search_highlight = ( $highlight_text_color == -1 ? 0 : 1 );

		
		// filter tags to remove excluded ones
		foreach($g_imgt_tag_taxonomy as $tax)
			if (!is_tag_name_excluded($wpit_search_tags_excluded, $tax->name))
				$tax_tab[] = $tax;
				
		// Select highest ranking tags and shuffle
		uasort($tax_tab, imgt_cmp_objects_count);
		$tax_tab = array_reverse($tax_tab);
		if ($num_tags_displayed)
			$tax_tab = array_slice($tax_tab, 0, $num_tags_displayed);
		
		// Tags are already sorted by descending ranking
		if ($wpit_tagcloud_order == 0)
			uasort($tax_tab, imgt_cmp_objects_lexicography);
		if ($wpit_tagcloud_order == 2)
			shuffle($tax_tab);
	
		// Define font scale factor
		foreach ($tax_tab as $tax)
			$count[] = $tax->count;
		$count_diff = max($count) - min($count);
		if ( ($font_size_max == $font_size_min) || !$count_diff)
			$font_scale = 0;
		else
			$font_scale = ($font_size_max - $font_size_min) / $count_diff;
		
		// Define font scale factor
		$color_min_rgb = html2rgb($font_color_min);
		$color_max_rgb = html2rgb($font_color_max);
		if ( ($font_color_min == $font_color_max) || !$count_diff)
			$color_scale = array_fill(0, 3, 0);
		else {
			$color_scale[0] = ($color_max_rgb[0] - $color_min_rgb[0]) / $count_diff;
			$color_scale[1] = ($color_max_rgb[1] - $color_min_rgb[1]) / $count_diff;
			$color_scale[2] = ($color_max_rgb[2] - $color_min_rgb[2]) / $count_diff;
		}
		
	} // End prepare tag cloud
	
	if ($search_mode >= 2) {  // Prepare form display
		$num_tags_per_col = admin_get_option_safe('wpit_search_num_tags_per_col', WPIT_SEARCH_INIT_NUM_TAGS_PER_COL);
		$search_form_font = admin_get_option_safe('wpit_search_form_font', WPIT_SEARCH_INIT_FORM_FONT);

	} // End prepare form display
	
	$num_img_start = 0;
	//	Manage PREV / NEXT page _POST here
	if ($change_page_previous) {
		$num_img_start = $_POST['num_img_start'] - $num_img_per_page;		
	} else if ($change_page_next) {
		$num_img_start = $_POST['num_img_start'] + $num_img_per_page;
	}
	$num_img_stop = $num_img_start + $num_img_per_page;	// excluded
	
	if ($_POST['tagcloud'] > 0) {
		unset($tax_id_list);
		$tax_id_list[0] = $_POST['tagcloud'];
	}

	$strout .= '<script language="JavaScript" type="text/javascript">
';
	$strout .= '<!--
';
	$strout .= 'function ' . $search_form_prefix . 'post_submit(post_var_name, post_var_value) {
';
	$strout .= 'document.' . $search_form_prefix . 'searchform.elements[post_var_name].value = post_var_value ;
';
	$strout .= 'document.' . $search_form_prefix . 'searchform.submit();
';
	$strout .= '}
';
	$strout .= '-->
';
	$strout .= '</script>
';
	
	$strout .= '<form name="' . $search_form_prefix . 'searchform" method="post" action="' . $result_page_url . '" style="padding:0;margin:0">';
	$strout .= '<input type="hidden" name="search_mode" value="' . $search_mode . '">';
	$strout .= '<input type="hidden" name="result_mode" value="' . $result_mode . '">';
	$strout .= '<input type="hidden" name="tagcloud" value="">';
	$strout .= '<input type="hidden" name="num_img_start" value="' . $num_img_start . '">';
	$strout .= '<input type="hidden" name="link_triggered" value="">';
	if ($called_from_widget) $strout .= '<input type="hidden" name="coming_from_widget" value="1">';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// Display search mode selector  ////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($is_search_mode_switchable) { 
		$strout .= '<div style="clear:both;font-size:0.9em;padding:4px;margin:0;background-color:#' . $wpit_admin_background_color . '"><div style="float:right;color:#AAA;padding-right:5px;letter-spacing:1pt;font-variant:small-caps"><em>' . __('Search display', 'mediatagger') . '</em></div><div style="padding-left:5px">';
		if ($search_mode!=1) $strout .= '<a href="' . $result_page_url . '" onClick="' . $search_form_prefix . 'post_submit(\'link_triggered\',\'11\');return false" title="' .
			__('Display the search form as a tag cloud', 'mediatagger') . '">';
		$strout .= __('Tag cloud', 'mediatagger');
		if ($search_mode!=1) $strout .= '</a>';
		$strout .= ' &nbsp;';
		if ($search_mode!=3) $strout .= '<a href="' . $result_page_url . '" onClick="' . $search_form_prefix . 'post_submit(\'link_triggered\',\'13\');return false" title="' . __('Display the search form as a check boxes form', 'mediatagger') . '">';
		$strout .= __('Form', 'mediatagger');
		if ($search_mode!=3) $strout .= '</a>';
		$strout .= ' &nbsp;';
		if ($search_mode!=2) $strout .= '<a href="' . $result_page_url . '" onClick="' . $search_form_prefix . 'post_submit(\'link_triggered\',\'12\');return false" title="' . __('Display the search form as a combination of the tag cloud and check boxed form', 'mediatagger') . '">';
		$strout .= __('Combined', 'mediatagger'); 
		if ($search_mode!=2) $strout .= '</a>';
		$strout .= '</div></div>';
	}

	$strout .= '<p style="clear:both;padding:' . ($is_search_mode_switchable ? '15' : '0') . 'px 0 0 0;margin:0">';

	if ($search_mode > 0 && $search_mode <= 2) { // Display tag cloud
		$checked_tags = (isset($tax_id_list) ? $tax_id_list : array());
		foreach ($tax_tab as $tax){ 
			$color_rgb[0] = round($color_scale[0]*$tax->count + $color_min_rgb[0], 0);
			$color_rgb[1] = round($color_scale[1]*$tax->count + $color_min_rgb[1], 0);
			$color_rgb[2] = round($color_scale[2]*$tax->count + $color_min_rgb[2], 0);
			$strout .= '<a href="' . $result_page_url . '" style="font-size:' . round($font_scale*$tax->count + $font_size_min, 1) . 'pt;line-height:110%;text-decoration:none;' .
				($use_dynamic_colors ? 'color:' . rgb2html($color_rgb) . ';' : '') . 
				(in_array($tax->term_taxonomy_id, $checked_tags) && $use_hover_and_search_highlight && !$called_from_widget ? 'color:#' . $highlight_text_color : '') . 
				'" onClick="' . $search_form_prefix . 'post_submit(' . "'tagcloud','" . $tax->term_taxonomy_id . "');return false" . '"' . 
				($called_from_widget ? '' : ($use_hover_and_search_highlight && $use_dynamic_colors && !in_array($tax->term_taxonomy_id, $checked_tags) ? 
				' onmouseover="this.style.color=' . "'#" . $highlight_text_color . "'" . '" onmouseout="this.style.color=' . "'" . rgb2html($color_rgb) . "'" . '"' : '')) . 
				' title="' . $tax->count . ' ' . _n('occurence', 'occurences', $tax->count, 'mediatagger') . '">' . $tax->name . '</a> ';
		}	// if ($search_mode <= 2)
		$strout .= '</p>';
	} // end tag cloud
	
	if ($called_from_widget) {	// Leave now - nothing more to print, the tag cloud is completed.
		$strout .= '</form>';
		return $strout;
	}

	
	if (empty($tax_id_list) ) {	// case no tag selected
		if ($search_mode == 0)
			$strout .= '<em>'. __('None of the selected tag(s) match existing tags. The media search URL should be composed as http://www.mysite.com/library?tags=tag1+tag2+...+tagN, where http://www.mysite.com/library is the search result page. Check the spelling of the tag slugs', 'mediatagger') . '</em> : <strong>' . $_GET['tags'] . '</strong>';
		else if ($search_mode == 2)
			$strout .= '<em>'. __('You can search a media by theme either with the tag cloud above or selecting appropriate keywords below and clicking OK.', 'mediatagger') . '</em>';
		else if ($search_mode == 3)
			$strout .= '<em>'. __('You can search a media by theme by selecting appropriate keywords below and clicking OK.', 'mediatagger') . '</em>';
	} else {
		// Tags selected - search must be started
		$tagsSelected = 1;
		//printf(_n('Theme matched', 'Themes matched', sizeof($_POST['tags']), 'mediatagger')) ; 
		$strout .= '&raquo;<strong> ';
		foreach($tax_id_list as $n=>$img_tax_id) {
			if ($n) $strout .= ', ';
			$tax = imgt_get_tag_descriptors('term_taxonomy_id=' . $img_tax_id);
			$strout .= $tax->name;
		}
		$strout .= '</strong> : ';

		$multisort_img_list = imgt_get_image_ID($tax_id_list);	// search images matching tag list
		$num_img_found = sizeof($multisort_img_list);
		if (!$num_img_found) {
			$strout .= '<i>' . __('no media found matching this criteria list', 'mediatagger') . '</i><br/>';
		} else {
			if ($num_img_stop > $num_img_found)
				$num_img_stop = $num_img_found;
				
			$strout .= '<i>' . $num_img_found . ' ';
			$strout .= _n('media found', 'medias found', $num_img_found, 'mediatagger'); 
			$strout .= '</i><br/>&nbsp;<br/>';
			
			// Get image display size
			$img_min_w_h = round($img_norm_size*3/4, 0);
			$plugin_url =  WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__), "", plugin_basename(__FILE__));
			$thumb_url = $plugin_url . 'thumbnail.php';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// Display result mode selector  ////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($is_result_mode_switchable) {
	$strout .= '<div style="clear:both;font-size:0.9em;padding:4px;margin:0;background-color:#' . $wpit_admin_background_color . '"><div style="float:right;color:#AAA;padding-right:5px;letter-spacing:1pt;font-variant:small-caps"><em>' . __('Results display', 'mediatagger') . '</em></div><div style="padding-left:5px">';
	if ($result_mode != 1) $strout .= '<a href="' . $result_page_url . '" onClick="post_submit(\'link_triggered\',\'21\');return false" title="' . __('Display the results as an image gallery', 'mediatagger') . '">';
	$strout .= __('Gallery', 'mediatagger');
	if ($result_mode != 1) $strout .= '</a>';
	$strout .= ' &nbsp;'; 
	if ($result_mode != 2) $strout .= '<a href="' . $result_page_url  .'" onClick="post_submit(\'link_triggered\',\'22\');return false" title="' . __('Display the results as an itemized image list', 'mediatagger') . '">';
	$strout .= __('Itemized', 'mediatagger');
	if ($result_mode != 2) $strout .= '</a>';
	$strout .= ' &nbsp;';
	if ($result_mode != 3) $strout .= '<a href="' . $result_page_url . '" onClick="post_submit(\'link_triggered\',\'23\');return false" title="' .  __('Display the results as an image title list', 'mediatagger') . '">';
	$strout .= __('Titles', 'mediatagger');
	if ($result_mode != 3) $strout .='</a>';
	$strout .= '</div></div>';
}	// if ($is_result_mode_switchable) 
			
	if ($result_mode >= 2)		// image list or title list
		$strout .= '<p style="margin:0;padding:0;font-size:0.8em">&nbsp;</p>';

	// Display results : gallery, image list or title list
	for ($n = $num_img_start; $n < $num_img_stop; $n++) {
		$img_obj = $multisort_img_list[$n];
		$img_info = imgt_get_img_info($img_obj->ID);
		$img_ratio = $img_info->h/$img_info->w;
		
		if ($img_info->h > $img_info->w) {
			$img_h = $img_norm_size;
			$img_w = round($img_info->w * $img_h / $img_info->h, 0);
		} else {
			$img_w = $img_norm_size;
			$img_h = round($img_info->h * $img_w / $img_info->w, 0);					
		}
		if (($img_ratio < 0.6 || $img_ratio > 1.6) && ($img_h < $img_min_w_h || $img_w < $img_min_w_h)) { // likely panorama format case
			if ($img_h > $img_w) {
				$img_h = round($img_h * $img_min_w_h/$img_w, 0);
				$img_w = $img_min_w_h;
			} else {
				$img_w = round($img_w * $img_min_w_h/$img_h, 0);
				$img_h = $img_min_w_h;
			}
		}
		
		if ($img_w > $img_info->w || $img_h > $img_info->h) {
			$img_w = $img_info->w;
			$img_h = $img_info->h;
		}
			
		$img_tooltip = $img_obj->post_title . ' ('. $img_info->post_title . ')';
				switch ($result_mode) {
					case 1:	// gallery
						if ($wpit_result_display_optimize_xfer) {		// resize image before transfer for faster display
							$strout .= '<a href="' . ($result_mode==1 && $link_to_post ? $img_info->post_URI : $img_info->url) .
								'" title="' . $img_tooltip . '"><img src="' . $thumb_url . '?s=' . $img_info->image . '&w=' . $img_w . '&h=' . $img_h . 
								'" width="' . $img_w . '" height="' . $img_h . '" alt="' . $img_tooltip . '" ' . ($result_mode==1 ? 'style="border:' . 
								$img_border_width . 'px solid #' . $img_border_color . '"' : '') . '></a>';
						} else {		// resize image in browser
							$strout .= '<a href="' . ($result_mode==1 && $link_to_post ? $img_info->post_URI : $img_info->url) .
								'" title="' . $img_tooltip . '"><img src="' . $img_info->image . '" width="' . 
								$img_w . '" height="' . $img_h . '" alt="' . $img_tooltip . '" ' . ($result_mode==1 ? 'style="border:' . $img_border_width . 'px solid #' .
								$img_border_color . '"' : '') . '></a>';
						}
						break;
					case 2:	// image list
						if ($wpit_result_display_optimize_xfer) {		// resize image before transfer for faster display
							$strout .= '<p style="padding: 10px 0 0 0;margin:0">' . $img_obj->post_title . 
								' (<a href="'. $img_info->post_URI . '" title="'  . __('Go to page', 'mediatagger') . '">' . $img_info->post_title. '</a>)<br/>' .
								'<a href="' . $img_info->url . '" title="' . $img_tooltip . '"><img src="' . $thumb_url . '?s=' . $img_info->image . '&w=' . $img_w . '&h=' . 
								$img_h . '" width="' . $img_w . '" height="' . $img_h . '" alt="' . $img_tooltip . '"></a></p>'; 
						} else {
							$strout .= '<p style="padding: 10px 0 0 0;margin:0">' . $img_obj->post_title . 
								' (<a href="'. $img_info->post_URI . '" title="'  . __('Go to page', 'mediatagger') . '">' . $img_info->post_title. '</a>)<br/>' .
								'<a href="' . $img_info->url . '" title="' . $img_tooltip . '"><img src="' . $img_info->image . '" width="' . 
								$img_w . '" height="' . $img_h . '" alt="' . $img_tooltip . '"></a></p>'; 
						}
						break;
					case 3:	// title list
						$strout .= '<p style="padding: 2px 0 0 0;margin:0"><a href="'. $img_info->post_URI . '" title="'  . __('Go to page', 'mediatagger') . '">' . 
						$img_info->post_title. '</a> : ' . '<a href="' . $img_info->url . '" title="' . __('Access to media', 'mediatagger') . '">' . 
						$img_obj->post_title . '</a></p>';
						break;
				}	// end switch			
			}	// end for
		}
	}
	if ($num_img_start > 0 || $num_img_stop < $num_img_found) 
		$display_pagination = 1;
		
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////// Display pagination selector  ////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($display_pagination) { 
		$strout .= '<p style="font-size:0.9em;padding:4px;margin:15px 0 0 0;background-color:#' . $wpit_admin_background_color . '">&nbsp;<em>Page ' . (int)(1+$num_img_start/$num_img_per_page) . ' (';
		$strout .= sprintf(_n('image %d to %d', 'images %d to %d',  $num_img_found, 'mediatagger'), (int)($num_img_start+1), $num_img_stop) . ') &nbsp;&nbsp;</em>';
		if ($num_img_start > 0) $strout .= '<a href="' . $result_page_url . '" onClick="post_submit(\'link_triggered\',\'30\');return false" title="' . __("Click to display previous page",'mediatagger') . '">';
		$strout .= '&laquo; ' . __('previous', 'mediatagger') . ($num_img_start > 0 ? '</a>' : '') . '&nbsp;';
		if ($num_img_stop < $num_img_found) $strout .= '<a href="' . $result_page_url . '" onClick="post_submit(\'link_triggered\',\'31\');return false" title="' . __("Click to display next page",'mediatagger') . '">';
		$strout .= __('next', 'mediatagger') . ' &raquo;' . ($num_img_stop < $num_img_found ? '</a>' : '') . '</p>';
	}	// if ($display_pagination)
	if ($search_mode >= 2) {	// form
		if ($display_pagination || !$num_img_found || ($num_img_found && !$display_pagination) )
			$strout .= '<p style="margin:0;padding:5px 0 0 0">&nbsp;</p>';
		
		$strout .= '<div style="font-size:' . $search_form_font . 'pt">';
		$strout .= print_tag_form($tax_id_list);
		$strout .= '</div>';
		
		$strout .= '</div><div class="submit" style="clear:both;padding-top:15px;text-align:center"><input type="submit" value="OK" name="search" style="width:75px"><input type="submit" value="Clear" name="search" style="width:75px"></div>';
	} else if (isset($tax_id_list)){	// cloud only, in case tags are set
		foreach ($tax_id_list as $tax) 
			$strout .= '<input type="hidden" name="tags[]" value="' . $tax . '"> ';
	}

	if (admin_get_option_safe('wpit_admin_credit', WPIT_ADMIN_INIT_CREDIT))
		$strout .= '<div style="clear:both;float:right;font-size:0.7em;padding:5px 10px 0 0"><a href="http://www.photos-dauphine.com/wp-mediatagger-plugin" title="' . 
			__('Offer a media search engine to your blog with', 'mediatagger') . ' WP MediaTagger ' . $WPIT_SELF_VERSION_STABLE . '"><em>MediaTagger</em></a></div>';
	
	$strout .= '</form>';

	return $strout;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////
//
//	Define MediaTagger shortcode
//
// [mediatagger attributes]
//
function imgt_multisearch_shortcode_func($atts) {
	
	extract(shortcode_atts(array(
		'result_page_url' => '',
		'num_tags_displayed' => '',
		'font_size_min' => '',
		'font_size_max' => '',
		'font_color_min' => '',
		'font_color_max' => '',
	), $atts));
		
	$strout = imgt_multisort_insert($result_page_url, $num_tags_displayed, $font_size_min, $font_size_max, $font_color_min, $font_color_max);
	return $strout;
}

//
// Function below is a trick to run the short code with priority 7, ie before wpautop, and filters with default (10) priority
// Otherwise those formatting functions would not be applied onto this shortcode
//
function wpit_run_shortcode( $content ) {
	global $shortcode_tags;

	// Backup current registered shortcodes and clear them all out
	$orig_shortcode_tags = $shortcode_tags;
	$shortcode_tags = array();

	add_shortcode( 'mediatagger', 'imgt_multisearch_shortcode_func');

	// Do the shortcode (only the one above is registered)
	$content = do_shortcode( $content );

	// Put the original shortcodes back
	$shortcode_tags = $orig_shortcode_tags;

	return $content;
}

add_filter( 'the_content', 'wpit_run_shortcode', 7 );



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// Add image tags to caption 
//
//
function imgt_img_caption_shortcode($attr, $content = null) {
	
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	$su = (current_user_can('level_10') ? 1 : 0);
	
	// Build image tag list
	$img_id = substr(strstr($id, "_"), 1);
	$img_tags = imgt_get_image_tags($img_id);
	$tag_str = "";
	foreach($img_tags as $key=>$img_tag) {
		$tag_str .= ($key ? ", " : "") . $img_tag->name; 
	}
	if ($tag_str == "") {
		$tag_str = "No tags";
		if ($su) $caption = "<u>$caption</u>";
	}
	
	$href_su = ' href="/wp-admin/options-general.php?page=mediatagger&id='. $img_id . '"';

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ( $id ) $id = 'id="' . $id . '" ';

	return '<div ' . $id . 'class="wp-caption ' . $align . '">' .
		$content . '<p class="wp-caption-text"><a' . ($su ? $href_su : '') . ' title="' . $tag_str . '">' . $caption . '</a></p></div>';		

 }
 
add_shortcode('wp_caption', 'imgt_img_caption_shortcode');
add_shortcode('caption', 'imgt_img_caption_shortcode');


//
//	Add "settings" link to the plugin list page, on top of default "desactivate" and "modify" links
//
add_filter('plugin_action_links', 'imgt_plugin_action_links', 10, 2);

function imgt_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=mediatagger">' . __('Settings', 'mediatagger') . '</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

//
//	Add "Donate" link to the plugin list page, right after "version", "homepage" and "visit my site"
//
function imgt_set_plugin_meta($links, $file) {
	 
	$plugin = plugin_basename(__FILE__);
	if ($file == $plugin) {
		return array_merge(
			$links,
			array( sprintf( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WY6KNNHATBS5Q">' . __('Donate', 'mediatagger') . '</a>' ))
		);
	}
	return $links;
}
	 
add_filter( 'plugin_row_meta', 'imgt_set_plugin_meta', 10, 2 );


?>