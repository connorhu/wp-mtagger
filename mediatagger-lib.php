<?php

global $wpdb;
global $g_imgt_tag_taxonomy;

define(TERM_REL_IMG, $wpdb->term_relationships . '_img');
//define(TERM_REL_IMG, $wpdb->term_relationships . '_img_test');	// for test purpose : uncomment this line and comment line above

//
//	Default WPIT option values
//
define(WPIT_ADMIN_MIN_PHP_VERSION, 40000);
define(WPIT_ADMIN_INIT_MEDIA_FORMATS, 'jpeg,gif,png');
define(WPIT_ADMIN_INIT_DISPLAY_OPTIONS, '1');				// 1: display   '' :hide
define(WPIT_ADMIN_INIT_DISPLAY_OPTIONS, '1');				// 1: display   '' :hide
define(WPIT_ADMIN_INIT_DISPLAY_OPTIONS, '1');				// 1: display   '' :hide
define(WPIT_ADMIN_INIT_TAGS_SOURCE, '1');					// 1: tags	2: tags and categories	3: categories
define(WPIT_ADMIN_INIT_OVERRIDE_POST_TAXONOMY, '0');		// 0: do not modify post taxonomy, 1: when tagging images, overrides post tags with self contained image tags logically ORd
define(WPIT_ADMIN_INIT_TAGS_GROUPS, '');
define(WPIT_ADMIN_INIT_BACKGROUND_COLOR, 'eef');
define(WPIT_ADMIN_INIT_CREDIT, '1');
define(WPIT_ADMIN_INIT_NUM_TAGS_PER_COL, 30);
define(WPIT_ADMIN_INIT_IMG_WIDTH_HEIGHT, 400);
define(WPIT_ADMIN_INIT_IMAGE_BORDER_W, 20);
define(WPIT_ADMIN_INIT_IMAGE_BORDER_COLOR, 'eee');
define(WPIT_ADMIN_INIT_TAGS_EXCLUDED, '');
define(WPIT_SEARCH_INIT_NUM_TAGS_PER_COL, 30);
define(WPIT_SEARCH_INIT_FORM_FONT, 10);					// font size for the tag search form (pt)
define(WPIT_SEARCH_INIT_TAGS_EXCLUDED, '');
define(WPIT_SEARCH_INIT_DEFAULT_DISPLAY_MODE, 2);		// 1: tagcloud    2: tagcloud + form   3: form
define(WPIT_SEARCH_INIT_DISPLAY_SWITCHABLE, 1);
define(WPIT_RESULT_INIT_IMG_LIST_W_H, 250);
define(WPIT_RESULT_INIT_IMG_GALLERY_W_H, 100);
define(WPIT_RESULT_INIT_DEFAULT_DISPLAY_MODE, 1);		// 1: gallery    2: itemized image list   3: image title list
define(WPIT_RESULT_INIT_DISPLAY_SWITCHABLE, 1);			// 1: is switchable, 0: is not
define(WPIT_RESULT_INIT_OPTIMIZE_XFER, 0);			// 1: optimize, 0: dont optimize
define(WPIT_INIT_TAGCLOUD_NUM_TAGS, 0);					// 0: display all tags
define(WPIT_INIT_TAGCLOUD_ORDER, 0);					// 0: alphabetical ascent ; 1: descending hit order ; 2: random
define(WPIT_INIT_TAGCLOUD_FONT_MIN, 8);
define(WPIT_INIT_TAGCLOUD_FONT_MAX, 25);
define(WPIT_INIT_TAGCLOUD_COLOR_MIN, 'bbbbbb');
define(WPIT_INIT_TAGCLOUD_COLOR_MAX, '000000');
define(WPIT_INIT_TAGCLOUD_HIGHLIGHT_COLOR, '000000');
define(WPIT_INIT_GALLERY_IMAGE_BORDER_W, 0);
define(WPIT_INIT_GALLERY_IMAGE_BORDER_COLOR, 'fff');
define(WPIT_INIT_GALLERY_IMAGE_LINK_CTRL, 1);			// 1: link to image		2: link to post
define(WPIT_INIT_GALLERY_IMAGE_NUM_PER_PAGE, 50);
define(WPIT_INIT_LIST_IMAGE_NUM_PER_PAGE, 10);
define(WPIT_INIT_LIST_TITLE_NUM_PER_PAGE, 30);

$supported_formats = array("jpeg"=>"image/jpeg", 
					"gif"=>"image/gif",
					"png"=>"image/png",
					"txt"=>"text/plain",
					"rtf"=>"application/rtf",
					"pdf"=>"application/pdf",
					"mp3"=>"audio/mpeg");


// Initiate taxonomy structure
imgt_taxonomy_update();
//print_ro($g_imgt_tag_taxonomy);


////////////////////////////////////////////////////////////////
//
//	Convenience display routine for taxonomy structure
//
function print_ro($a_obj){echo "<pre>";print_r($a_obj);echo "</pre>";}

function phdbg($a){if ($_SERVER['REMOTE_ADDR'] == "82.233.108.8"){print_ro($a);}}


////////////////////////////////////////////////////////////////
//
//	Strip accents
//
function strip_accents($string){return strtr(utf8_decode($string),'‡·‚„‰ÁËÈÍÎÏÌÓÔÒÚÛÙıˆ˘˙˚¸˝ˇ¿¡¬√ƒ«»… ÀÃÕŒœ—“”‘’÷Ÿ⁄€‹›','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');}


////////////////////////////////////////////////////////////////
//
//	Detect if first letter is a vowel
//
function is_first_vowel($string){ $vowels = array('A','E','I','O','U','Y'); return (in_array(substr(ucfirst($string), 0, 1), $vowels) ? 1 : 0);}

////////////////////////////////////////////////////////////////
//
// 	Replacement for array_uintersect, not available before PHP5
//
if (!function_exists('array_uintersect')) {
function array_uintersect()
{
	$args = func_get_args();
	if (count($args) < 3) {
		user_error('wrong parameter count for array_uintersect()', E_USER_WARNING);
		return;
	}
	// Get compare function
	$user_func = array_pop($args);
	if (!is_callable($user_func)) {
		if (is_array($user_func)) {
			$user_func = $user_func[0] . '::' . $user_func[1];
		}
		user_error('array_uintersect() Not a valid callback ' . $user_func, E_USER_WARNING);
		return;
	}
	// Check arrays
	$array_count = count($args);
	for ($i = 0; $i < $array_count; $i++) {
		if (!is_array($args[$i])) {
			user_error('array_uintersect() Argument #' . ($i + 1) . ' is not an array', E_USER_WARNING);
			return;
		}
	}
	// Compare entries
	$output = array();
	foreach ($args[0] as $key => $item) {
		for ($i = 1; $i !== $array_count; $i++) {
			$array = $args[$i];
			foreach($array as $key0 => $item0) {
				if (!call_user_func($user_func, $item, $item0)) {
					$output[$key] = $item;
				}
			}
		}            
	}
	return $output;
}
}


////////////////////////////////////////////////////////////////
//
// 	Replacement for in_array(), bringing compatibility issues 
//	with some PHP4 versions (bugs leading to false warnings)
//
function in_array_fast($elem, $array)
{
   $top = sizeof($array) -1;
   $bot = 0;

   while($top >= $bot) {
      $p = floor(($top + $bot) / 2);
      if ($array[$p] < $elem) $bot = $p + 1;
      elseif ($array[$p] > $elem) $top = $p - 1;
      else return TRUE;
   }
    
   return FALSE;
} 


////////////////////////////////////////////////////////////////
//
// 	Retrieve PHP_VERSION_ID ; if does not exist (<5.2.7), emulate
//
function admin_get_php_version() {
	if (!defined('PHP_VERSION_ID')) {	// defined starting 5.2.7
		$version = explode('.', PHP_VERSION);
		define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
	}
	// PHP_VERSION_ID is defined as $major_version * 10000 + $minor_version * 100 + $release_version;
	if (PHP_VERSION_ID < 50207) {
		define('PHP_MAJOR_VERSION',   $version[0]);
		define('PHP_MINOR_VERSION',   $version[1]);
		define('PHP_RELEASE_VERSION', $version[2]);
	}
	return PHP_VERSION_ID;
}


////////////////////////////////////////////////////////////////
//
// 	Color conversion routines
//
function html2rgb($color) {
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}

function rgb2html($r, $g=-1, $b=-1) {
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return '#'.$color;
}


////////////////////////////////////////////////////////////////
//
// 	Check valid hex color code
//
function check_valid_colorhex($colorCode) {
    // If user accidentally passed along the # sign, strip it off
    $colorCode = ltrim($colorCode, '#');
    if (ctype_xdigit($colorCode) && (strlen($colorCode) == 6 || strlen($colorCode) == 3)) return true;
    else return false;
}


////////////////////////////////////////////////////////////////
//
// 	Check valid tags group definition
//
function check_valid_tag_group_definition($text) {
	
	$wpit_admin_tags_source = admin_get_option_safe('wpit_admin_tags_source', WPIT_ADMIN_INIT_TAGS_SOURCE);
	if (imgt_build_tag_groups($text, $wpit_admin_tags_source, $num_groups) > 0) return false;
	return true;
}


////////////////////////////////////////////////////////////////
//
// 	Check list string is a list of CSV existing tag names 
//
function check_string_is_taglist($list_str) {
	if (!strlen(trim($list_str))) return true;
	$tag_table = explode(',', $list_str);
	foreach($tag_table as $tag_name) {
		$tag_name = trim($tag_name);
		$tag_desc = imgt_get_tag_descriptors('name='.$tag_name);
		if (!ctype_digit($tag_desc->term_id)) return false;
	}
	return true;
}


////////////////////////////////////////////////////////////////
//
// 	Check if a tag name is part of the exclusion list 
//
function is_tag_name_excluded($tag_list, $check_tag_name) {
	$tag_table = explode(',', $tag_list);
	foreach($tag_table as $tag_name) {
		$tag_name = trim($tag_name);
		if ($check_tag_name == $tag_name) return true;
	}
	return false;
}


////////////////////////////////////////////////////////////////
//
// 	Retrieve option value.
//	If the option does not exist in the option table, create it and set to default, returning this default value
//	If the option exists but is empty, set to default and return this default value
//
function admin_get_option_safe($option_name, $default_value) {
	if (($option_val = get_option($option_name, "option_not_found")) != "option_not_found") {
		return $option_val;
	}
	add_option($option_name);
	update_option($option_name, $default_value);
	return $default_value;
}


////////////////////////////////////////////////////////////////
//
// 	Validate data from admin form
//
function imgt_get_valid_post_data(&$option_value, $option_name, $valid_condition_str, &$is_invalid, &$errmsg, $err_string){
	$eval_exec_ok = 0;
	$tmp_option_value = $_POST[$option_name];
		
	$valid_condition_str = str_replace('VALUE', $tmp_option_value, $valid_condition_str);
	//echo '"' . $valid_condition_str . '" . <br/>';
	$eval_exec_ok = @eval("\$is_invalid = ! ($valid_condition_str) ; return 1 ;");
	//echo ' exec : ' . ($eval_exec_ok ? '1' : '0') . ' invalid : ' . ($is_invalid ? '1' : '0') . '<br/>';
	if ($eval_exec_ok != 1 || $is_invalid) {
		$errmsg[] = '- ' . $err_string;
		$is_invalid = 1;	// force in case eval could not evaluate
	} else {
		$option_value = $tmp_option_value;
	}
}


////////////////////////////////////////////////////////////////
//
// 	Validate data from admin form
//
function imgt_get_valid_post_media_formats(&$option_value, $option_name, &$is_invalid, &$errmsg, $err_string, &$media_format_changed){
	$media_format_changed = 0;
	$tmp_option_value = $_POST[$option_name];
		
	if (count($tmp_option_value) > 0) {
		if (implode(',', $option_value) != implode(',', $tmp_option_value)) {
			//echo "post_media_formats CHANGED <br/>";
			$media_format_changed = 1;
		}
		$option_value = $tmp_option_value;
	} else {
		$errmsg[] = '- ' . $err_string;
		$is_invalid = 1;	// force in case eval could not evaluate
	}
		
}


////////////////////////////////////////////////////////////////
//
// 	Set highlight for error messages
//
function imgt_get_error_highlight($invalid_param, &$h_on, &$h_off){
	$h_on = '';
	$h_off = '';
	if ($invalid_param) {
		$h_on = '<span class="option_highlight">';
		$h_off = '</span>';
	}
}


////////////////////////////////////////////////////////////////
//
// 	Build tag groups based on admin panel grouping definition
//
function imgt_build_tag_groups($wpit_admin_tags_groups, $wpit_admin_tags_source){
	global $g_imgt_tag_taxonomy;
	$used_tags = array();
	$tags_groups = array();
	
	$groups_str = trim(stripslashes($wpit_admin_tags_groups));
	if (!strlen($groups_str)) {
		return -1;
	}
	
	$groups = explode(chr(13), $groups_str);	// split by lines
	
	foreach($groups as $key=>$line){
		// For each line, split group name from group tags for each group definition
		$grpdef = explode('=', $line);
		
		if (count($grpdef) != 2) {	// group definition line does not respect the GROUPNAME = TAGLIST format
			return 10;
		} else if (!strlen(trim($grpdef[0])) || !strlen(trim($grpdef[1]))) {
			if ($key < count($groups)-1)	// this is a syntax error
				return 20;
			else {							// this is the default group name declaration
				$default_group_name = trim($grpdef[0]);
				break;
			}
		} else if (!check_string_is_taglist($grpdef[1])) {	// list holds at least on item which is not a tag
			return 30;
		}
		// Split CSV tag list
		$grpitems = explode(',', $grpdef[1]);
		array_walk($grpitems, 'imgt_walk_trim');
		
		$group_item = new StdClass;
		$group_item->group_name = trim($grpdef[0]);
		$group_item->group_tags = $grpitems;
		$used_tags = array_merge($used_tags, $grpitems);
		$tags_groups[] = $group_item;
	}
	
	// add tags not listed in any group
	$used_tags = array_unique($used_tags);
	$grpitems = array();
	foreach($g_imgt_tag_taxonomy as $tax) {
		if (!in_array($tax->name, $used_tags))
			$grpitems[] = $tax->name;
	}
	if (count($grpitems)) {
		$group_item = new StdClass;
		$group_item->group_name = (isset($default_group_name) ? $default_group_name : __('Others', 'mediatagger'));
		$group_item->group_tags = $grpitems;
		$tags_groups[] = $group_item;
	}
	
	// reorder taxonomy by tags, and associate appropriate category
	foreach($tags_groups as $tags_group) {
		foreach($tags_group->group_tags as $tag_name) {
			$tag_desc = imgt_get_tag_descriptors('name=' . $tag_name);
			$tag_desc->category = $tags_group->group_name;
			$imgt_tag_taxonomy[] = $tag_desc;
		}
	}
	
	// Copy the sorted taxonomy local copy to the global
	$g_imgt_tag_taxonomy = $imgt_tag_taxonomy;	
	return 0;
}


////////////////////////////////////////////////////////////////
//
// Print tag form
//
function print_tag_form($checked_tags, $admin_page = 0) {
	global $g_imgt_tag_taxonomy;
	$strout = '';
	
	if ($admin_page) {
		$num_tags_per_col = admin_get_option_safe('wpit_admin_num_tags_per_col', WPIT_ADMIN_INIT_NUM_TAGS_PER_COL);
		$tags_excluded = admin_get_option_safe('wpit_admin_tags_excluded', WPIT_ADMIN_INIT_TAGS_EXCLUDED);
	} else {	// search page
		$num_tags_per_col = admin_get_option_safe('wpit_search_num_tags_per_col', WPIT_SEARCH_INIT_NUM_TAGS_PER_COL);
		$tags_excluded = admin_get_option_safe('wpit_search_tags_excluded', WPIT_SEARCH_INIT_TAGS_EXCLUDED);
	}
	
	if (!count($checked_tags))
		$checked_tags = array();

	$multiple_groups = 0;
	$wpit_admin_tags_source = admin_get_option_safe('wpit_admin_tags_source', WPIT_ADMIN_INIT_TAGS_SOURCE);
	$wpit_admin_tags_groups = admin_get_option_safe('wpit_admin_tags_groups', WPIT_ADMIN_INIT_TAGS_GROUPS);
	$wpit_admin_background_color = admin_get_option_safe('wpit_admin_background_color', WPIT_ADMIN_INIT_BACKGROUND_COLOR);
	if ($wpit_admin_tags_source == 2 || strlen($wpit_admin_tags_groups)>0)
		$multiple_groups = 1;

	$group = '';
	$new_group = 0;
	$tag_displayed_count = 0;
	foreach ($g_imgt_tag_taxonomy as $key=>$g_imgt_tag_taxonomy_item) {
		if ($g_imgt_tag_taxonomy_item->category != $group) {	// detect group transition
			$group = $g_imgt_tag_taxonomy_item->category;
			$new_group = 1;
		} else {
			$new_group = 0;	
		}
		
		if ($multiple_groups && $new_group) {
			if (!(($tag_displayed_count+1) % $num_tags_per_col)) {	// avoid to have group name at column bottom with first element on next col
				$tag_displayed_count++;
			} else if (!(($tag_displayed_count+2) % $num_tags_per_col)) { 	// avoid to have group name at column bottom with second element on next col
				$tag_displayed_count+=2;
			}
			if (!($tag_displayed_count % $num_tags_per_col)){	// start new col on modulo
				if ($tag_displayed_count) $strout .=  '</div >';
				$strout .= '<div style="float:left">';
			}
			if ($admin_page)
				$strout .= '<span style="background-color:#' . $wpit_admin_background_color . ';font-weight:bold">' . $group . "</span><br/>";
			else 
				$strout .= '<p style="padding:1px;margin:1px;background-color:#' . $wpit_admin_background_color . ';font-style:italic">&nbsp;' . $group . "</p>";				
			$tag_displayed_count++;
		}
		
		if (!($tag_displayed_count % $num_tags_per_col)){	// start new col on modulo
			$not_last_group_tag = 0;
			$is_last_tag = (end($g_imgt_tag_taxonomy) == $g_imgt_tag_taxonomy_item ? 1 : 0);	// last tag of the taxonomy
			if (!$is_last_tag) {
				if ($g_imgt_tag_taxonomy[(int)($key+1)]->category  == $group)
					$not_last_group_tag = 1;
			}
			if (!$multiple_groups || $not_last_group_tag){	// tag is not the last of its group
				if ($tag_displayed_count) $strout .= '</div >';
				$strout .= '<div style="float:left">';
			} else
				$tag_displayed_count--;		// avoid to have a tag belonging to a group alone at the top of the next column
		}
		
		if (is_tag_name_excluded($tags_excluded, $g_imgt_tag_taxonomy_item->name)) continue;
		
		if  ($admin_page) {
			$checked = in_array_fast($g_imgt_tag_taxonomy_item, $checked_tags);
		} else {	// search page
			//print_ro($checked_tags);
			$checked = in_array($g_imgt_tag_taxonomy_item->term_taxonomy_id, $checked_tags);		
		}
		$strout .= '<input type="checkbox" value=' . $g_imgt_tag_taxonomy_item->term_taxonomy_id . " name=tags[]" . ($checked? " checked" : "") . '> ' . 
			($checked ? '<span style="color:#00F">' : "") .	$g_imgt_tag_taxonomy_item->name . ($checked ? "</span>" : "") . 
			'<span style="font-size:0.7em;color:#999" title="' . $g_imgt_tag_taxonomy_item->count . ' ' . 
			_n('media associated to tag', 'medias associated to tag', $g_imgt_tag_taxonomy_item->count, 'mediatagger') .
			' : ' . $g_imgt_tag_taxonomy_item->name . '"> ' . $g_imgt_tag_taxonomy_item->count . "&nbsp;</span><br />";
		$tag_displayed_count++;
	}
	return $strout;
}


////////////////////////////////////////////////////////////////
//
// Return first non tag associated image, or -1 if all images 
// are associated
//
function admin_get_current_image($img_list, $reason) {
	
	if (empty($img_list)) {
		echo '<div class="updated"><strong><p>';
		switch ($reason) {
			case 1:
				_e("This blog does not hold any media.", 'mediatagger'); echo "</p><p>";
				_e("Start to populate the WordPress Media Library before trying to tag those medias.", 'mediatagger');
				break;
			case 2:
				_e("Medias are already all tagged.", 'mediatagger'); echo "</p><p>"; 
				_e('To modify tagging, go to the Media Explorer view and select "tagged medias" or "all medias".', 'mediatagger');
				break;
			case 3:
				_e("There is no tagged media yet.", 'mediatagger'); echo "</p><p>"; 
				_e('To start tagging, go to the Tag Editor view or select "untagged medias" or "all medias" in the Media Explorer view.', 'mediatagger');
				break;
		}
		echo "</p></strong></div>";
		return 0;
	} else {
		return current($img_list);
	}
}


////////////////////////////////////////////////////////////////
//
// Return 0 if list of tags is empty, 1 otherwise
//
function admin_check_taxonomy_not_empty(){
	global $g_imgt_tag_taxonomy;
	
	if (empty($g_imgt_tag_taxonomy)) {
		echo '<div class="updated"><strong><p>';
		_e("No tag was found in this blog", 'mediatagger'); echo "</p><p>";
		_e("Start to create a list of tag that you will use to tag your medias", 'mediatagger');
		echo "</p></strong></div>";
		return 0;				  
	}
	return 1;
}


////////////////////////////////////////////////////////////////
//
// Get relative path for a file with absolute path :
//	/space_3/p/phd/www/phd/wp-content/plugins/imageTagger/imageTagger.php
//		will give
//	/wp-content/plugins/imageTagger/imageTagger.php
//
function get_relative_path($path) {	
	// Next lines typically returns '/wp_content'
	$wp_upload_dir = wp_upload_dir();
	$upload_base_dir = array_pop(explode(get_option('siteurl'),$wp_upload_dir['baseurl']));
	//$upload_base_dir = $wp_upload_dir['baseurl'];
	
	if ( 0 ) {
		echo ">> wp_upload_dir() : "; print_ro(wp_upload_dir());
		echo ">> upload_url_path : " . $wp_upload_dir['baseurl'] . "<br/>";
		echo ">> upload_base_dir : " . $upload_base_dir . "<br/>";
		echo ">> path = " . $path . "<br/>";
		echo ">> strstr(path, upload_base_dir) = " . strstr($path, $upload_base_dir) . "<br/>";
	}
	
	return strstr($path, $upload_base_dir);
}


////////////////////////////////////////////////////////////////
//
// Get Mime Type function - in case not installed on server
//

if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

////////////////////////////////////////////////////////////////
//
// Check that exec is enabled on the server 
//
function exec_enabled() {
	$disabled = explode(', ', ini_get('disable_functions'));
	return !in_array('exec', $disabled);
}

////////////////////////////////////////////////////////////////
//
// Generic get MIME type function, whatever exec activated or not 
//
function get_mime_type_generic($file) {

	/********* !!!!
	found problem with this method : rtf file detected as text/rtf rather than application/rtf ;
	used as replacement direct call to mime_content_type
	***********/
	
	if (exec_enabled()) {	// really detect MIME type
		exec("file -bi " . $file, $mime_type);
		$mime = explode(';', $mime_type[0]);
		$mime_type = trim($mime[0]);
	}
	else {	// sniff MIME type
		$mime_type = mime_content_type($file);
	}
		
	return $mime_type;
}


////////////////////////////////////////////////////////////////
//
// retrieve information relative to image :  title, relative path to image, 
//	W and H, post title, post URI
//
function imgt_get_img_info($obj_id) {
	global $wpdb;
	$img_info = new StdClass;
	$plugin_icon_path = get_bloginfo('url') .'/wp-content/plugins/' . basename(dirname(__FILE__)) . '/icons/';
	//$base_upload_dir = array_pop(explode($_SERVER['DOCUMENT_ROOT'], get_option( 'upload_path' )));
	//echo ">> _SERVER['DOCUMENT_ROOT'] : " . $_SERVER['DOCUMENT_ROOT'] . "<br/>";
	//echo ">> base_upload_dir : " . $base_upload_dir . "<br/>";
	//echo ">> get_option( 'upload_path' ) : " . get_option( 'upload_path' ) . "<br/>";
		
	$img_info->title = get_the_title($obj_id);
	$img_info->mime = mime_content_type(get_attached_file($obj_id));
	$img_info->url = wp_get_attachment_url($obj_id);
	
	switch($img_info->mime) {
		case "image/jpeg":
		case "image/gif":
		case "image/png":
			$img_info->image = 	$img_info->url;
			break;
		case "application/pdf":
			$img_info->image = $plugin_icon_path . "icon_pdf.jpg";
			break;
		case "audio/mpeg":
			$img_info->image = $plugin_icon_path . "icon_mp3.jpg";
			break;			
		case "text/plain":
			$img_info->image = $plugin_icon_path . "icon_txt.jpg";
			break;			
		case "application/rtf":
			$img_info->image = $plugin_icon_path . "icon_rtf.jpg";
			break;			
	}
	
	list($img_info->w, $img_info->h) = @getimagesize($img_info->image);
	
	$post_obj = get_post($obj_id);	// retrieve image object
	
	// look for parent and parent address
	if ($post_obj->post_parent) {	// normal case
		$post_obj = get_post($post_obj->post_parent);
		$img_info->post_ID = $post_obj->ID;
		$img_info->post_URI = get_permalink($post_obj->ID);	//$post_obj->guid;
		$img_info->post_title = $post_obj->post_title;
	} else {	// treat the rich-text-tag plugin case to link to the tag page
		//echo "found case";
		$sql_query = 'SELECT term_id ' .
						'FROM ' . $wpdb->term_taxonomy . ' ' .
						'WHERE `description` LIKE "%' . $img_info->url . '%"';
		$sql_result = run_mysql_query($sql_query);
		//print_ro($sql_result);
		
		/*$sql_query = 'SELECT slug ' .
						'FROM ' . $wpdb->terms . ' ' .
						'WHERE `term_id` = "' . $sql_result[0]->term_id . '"';
		$sql_result = run_mysql_query($sql_query);*/
		//print_ro($sql_result);
		
		$img_info->post_ID = -1;
		if (!empty($sql_result)) {
			$img_info->post_URI = get_tag_link($sql_result[0]->term_id);	//get_bloginfo('url') . '/?tag=' . $sql_result[0]->slug;
			$img_info->post_title = "Tag : " . $sql_result[0]->slug;
		}
	}
	
	//print "image parent post ID : " . $img_info->post_ID . "<br/>";
	//print "image parent post URI : " . $img_info->post_URI . "<br/>";
	//print "image parent post title : " . $img_info->post_title . "<br/>";
	
	return $img_info;
}


////////////////////////////////////////////////////////////////
//
//	Callback functions
//
function imgt_cmp_objects_slug($ref, $item){
	if ($ref->slug == $item->slug)
		return 0;
	return -1;
}

function imgt_cmp_objects_name($ref, $item){
	if ($ref->name == $item->name)
		return 0;
	return -1;
}

function imgt_cmp_objects_term_id($ref, $item){
	if ($ref->term_id == $item->term_id)
		return 0;
	return -1;
}

function imgt_cmp_objects_term_taxonomy_id($ref, $item){
	if ($ref->term_taxonomy_id == $item->term_taxonomy_id)
		return 0;
	return -1;
}

function imgt_cmp_objects_count($a, $b){
	if ($a->count == $b->count)
		return 0;
	return ($a->count < $b->count) ? -1 : 1;
}

function imgt_cmp_objects_lexicography($a, $b){
	//echo $a->name . " " . strtr($a->name, 'È', 'e') . "<br/>";
	//echo substr($a->name, 8, 1) . " " . ord(substr($a->name, 8, 1)) . "<br/>";
	$cmp = strcasecmp(strip_accents($a->name), strip_accents($b->name));
	return ($cmp == 0 ? 0 : ($cmp > 0 ? 1 : -1));
}

function imgt_walk_add_category(&$a, $key, $category){
	$a->category = $category;
}

function imgt_walk_trim(&$a){
	$a = trim($a);
}

function imgt_filter_keyword($a){
	global $imgt_filter_keyword;
	$img_info = imgt_get_img_info($a);

	if (stristr($img_info->post_title, $imgt_filter_keyword) !== false || stristr($img_info->title, $imgt_filter_keyword) !== false)
		return true;
}


////////////////////////////////////////////////////////////////////////////////////
//
// Return list of image ids matching a keyword
//
function imgt_match_keyword($list_type, $keyword){
	global $imgt_filter_keyword;
	$imgt_filter_keyword = $keyword;
	
	/*////////////////////////////////////////////////////////////////////////////////////////
	//	Dump alternative - not faster than SQL queries
	global $wpdb;
	$sql_query = 'SELECT * '.
				 'FROM ' . $wpdb->posts . ' AS pos ' .
				 'WHERE pos.post_mime_type IN ("image/jpeg","image/gif","image/png")';
	$imgt_imgs = run_mysql_query($sql_query);
	
	$imgs = array();
	foreach($imgt_imgs as $img_src) {
		$img_info = wp_get_attachment_image_src($img_src->ID, 'full');
		$imgs[$img_src->ID]->title = $img_src->post_title;
		$imgs[$img_src->ID]->url = $img_info[0];
		$imgs[$img_src->ID]->w = $img_info[1];
		$imgs[$img_src->ID]->h = $img_info[2];
		$post_obj = get_post($img_src->ID);
		$post_obj = get_post($post_obj->post_parent);
		$imgs[$img_src->ID]->post_title = $post_obj->guid;
		$imgs[$img_src->ID]->post_url = $post_obj->post_title;;
	}

	//print_ro($imgs);
	////////////////////////////////////////////////////////////////////////////////////////*/
	
	$img_list = imgt_get_images($list_type, $count, $reason); 
	
	if (!sizeof($img_list)) {
		imgt_get_images('all_images', $count, $reason);
		// $count->total = 1;	// UNCOMMENT TO SIMULATE all images tagged, no image tagged OR no image at all
		if ($list_type == 'all_images' || !$count->total ) 
			admin_get_current_image($img_list, 1);
		else if ($list_type == 'untagged_images') 
			admin_get_current_image($img_list, 2);
		else if ($list_type == 'tagged_images') 
			admin_get_current_image($img_list, 3);
		return array();
	}
	
	if (strlen($imgt_filter_keyword) > 0)
		$img_list_filtered = array_filter($img_list, imgt_filter_keyword);
	else 
		$img_list_filtered = $img_list;
	
	return array_values($img_list_filtered);
}


////////////////////////////////////////////////////////////////////////////////////
//
// Return array of tag names from array of taxonomy
//
function imgt_taxonomy_to_name($tax, $use_keys=0){
	$tax_name = array();
	if (empty($tax))
		return $tax_name;
		
	foreach($tax as $tax_key=>$tax_id){
		$id = ($use_keys? $tax_key : $tax_id);
		$tag_desc = imgt_get_tag_descriptors('term_taxonomy_id=' . $id);
		$tax_name[] = (empty($tag_desc) ? get_cat_name($id) : $tag_desc->name);
	}
	
	natcasesort($tax_name);
	
	return $tax_name;
}

////////////////////////////////////////////////////////////////////////////////////
//
// Return array of taxonomy IDs from array of slugs
//
function imgt_slug_to_taxonomy($slug_list){

	$tax_list = array();
	if (empty($slug_list))
		return $tax_list;
		
	foreach($slug_list as $slug){
		$tax = imgt_get_tag_descriptors('slug=' . $slug);
		if (!empty($tax))
			$tax_list[] = $tax->term_taxonomy_id;
	}

	return $tax_list;
}

////////////////////////////////////////////////////////////////////////////////////
//
// Return object composed of term_taxonomy_id, term_id, slug and name
// based on 1 of those 4 elements passed as argument
//
function imgt_get_tag_descriptors($search_str) {
	global $g_imgt_tag_taxonomy;
	
	$search_obj = new StdClass;
	$search_obj->term_taxonomy_id = '';
	$search_obj->term_id = '';
	$search_obj->slug = '';
	$search_obj->name = '';

	$a_search_str = explode('=', $search_str);

	switch ($a_search_str[0]) {
		case 'term_taxonomy_id' : $search_obj->term_taxonomy_id = $a_search_str[1]; $y = array_uintersect($g_imgt_tag_taxonomy, array($search_obj),
									"imgt_cmp_objects_term_taxonomy_id"); break;
		case 'term_id' :          $search_obj->term_id = $a_search_str[1]; $y = array_uintersect($g_imgt_tag_taxonomy, array($search_obj), "imgt_cmp_objects_term_id"); break;	
		case 'slug' :             $search_obj->slug = $a_search_str[1]; $y = array_uintersect($g_imgt_tag_taxonomy, array($search_obj), "imgt_cmp_objects_slug"); break;	
		case 'name' :             $search_obj->name = $a_search_str[1]; $y = array_uintersect($g_imgt_tag_taxonomy, array($search_obj), "imgt_cmp_objects_name"); break;			
	}
	return current($y);
}


////////////////////////////////////////////////////////////////
//
// Run mysql query and do minimum error checking
//
function run_mysql_query($sql_query) {
	global $wpdb;
	
	$sql_result = $wpdb->get_results($sql_query);
	if (mysql_error()) {
		echo 'MYSQL query returned error executing query <strong>"'. $sql_query . '"</strong> : <br/>=> <span style="color:red">' .  htmlentities(mysql_error()) . '</span><br/>';
		$sql_result = "SQL_EXEC_ERROR";
	}
	return $sql_result;
}


////////////////////////////////////////////////////////////////
//
// Retrieve list of taxonomies for post tags and set global
//
function imgt_taxonomy_update(){
	global $wpdb;
	global $g_imgt_tag_taxonomy;
	$g_imgt_tag_taxonomy_tags = array();
	$g_imgt_tag_taxonomy_cats = array();	
	
	// first : fix any image taxonomy discrepancy, like orphean image can be (image id referenced in image taxonomy but not in posts table anymore as single entry
	imgt_get_images('count_images', $count, $reason);
	if ( $count->total != $count->tagged + $count->untagged) {
		// echo "Image taxonomy needs to be fixed : " . $count->total . ' != ' .  $count->tagged . ' + ' . $count->untagged; 
		// Search orphean image ids in the image taxonomy ; compare all image IDs to the tagged image IDs
		// No IDs should be in the "tagged" without being in the "all" ; in this case delete the entries in the tagged to cleanup
		$img_id_all = imgt_get_images('all_images', $count, $reason);
		$img_id_tagged = imgt_get_images('tagged_images', $count, $reason);		
		//print_ro($img_id_all);
		//print_ro($img_id_tagged);
		$img_orphean_id = array_diff($img_id_tagged, $img_id_all);
		if (!empty($img_orphean_id)) {
			echo "MediaTagger plugin detected media(s) referenced in the media taxonomy but not anymore in the posts table - Probably deleted" . ".<br/>";
			echo "The entries for media(s)" . " " . implode(', ', $img_orphean_id) . " " . "are removed from the media taxonomy table" . ".<br/>";
			
			$orphean_list = '(' . implode(',', $img_orphean_id) . ')';
			$sql_query = 'DELETE FROM ' .  TERM_REL_IMG . ' ' .
						 'WHERE object_id IN ' . $orphean_list;
			echo $sql_query;
			run_mysql_query($sql_query);
		}
	}

		
	$wpit_admin_tags_source = admin_get_option_safe('wpit_admin_tags_source', WPIT_ADMIN_INIT_TAGS_SOURCE);	// 1: tags   2: tags & categories    3: categories
	$wpit_admin_tags_groups = admin_get_option_safe('wpit_admin_tags_groups', WPIT_ADMIN_INIT_TAGS_GROUPS);
	
	if ($wpit_admin_tags_source <= 2) {	// select only tags, or tags and categories
		$sql_query = 'SELECT term_taxonomy_id, tax.term_id, slug, name '.
					 'FROM ' . $wpdb->term_taxonomy . ' AS tax INNER JOIN ' . $wpdb->terms . ' AS ter ON tax.term_id = ter.term_id ' .
					 'WHERE tax.taxonomy = "post_tag" ';
		$g_imgt_tag_taxonomy_tags = run_mysql_query($sql_query);
		array_walk($g_imgt_tag_taxonomy_tags, imgt_walk_add_category, __('Tags', 'mediatagger'));
	}
	
	if ($wpit_admin_tags_source >= 2) {	// only select categories, or tags and categories
		$sql_query = 'SELECT term_taxonomy_id, tax.term_id, slug, name '.
					 'FROM ' . $wpdb->term_taxonomy . ' AS tax INNER JOIN ' . $wpdb->terms . ' AS ter ON tax.term_id = ter.term_id ' .
					 'WHERE tax.taxonomy = "category" ';
		$g_imgt_tag_taxonomy_cats = run_mysql_query($sql_query);
		array_walk($g_imgt_tag_taxonomy_cats, imgt_walk_add_category, __('Categories', 'mediatagger'));
	}
	
	$g_imgt_tag_taxonomy = array_merge($g_imgt_tag_taxonomy_tags, $g_imgt_tag_taxonomy_cats);
	
	
	// Build tag groups as defined in the admin interface
	imgt_build_tag_groups($wpit_admin_tags_groups, $wpit_admin_tags_source);
	
	// Count images per tags
	imgt_update_taxonomy_stats();
	
	//print_ro($g_imgt_tag_taxonomy);

}


////////////////////////////////////////////////////////////////////////////////////
//
// Make stats on tags ; add it as a 'count' field to the tag structure
//
function imgt_update_taxonomy_stats(){
	global $wpdb;
	global $g_imgt_tag_taxonomy;
	
	foreach($g_imgt_tag_taxonomy as $key=>$taxonomy_elt){
		$sql_query = 'SELECT * '.
			'FROM ' . TERM_REL_IMG . ' ' .
			'WHERE term_taxonomy_id = ' . $taxonomy_elt->term_taxonomy_id;
		$sql_query_result = run_mysql_query($sql_query);
		$taxonomy_elt->count = sizeof($sql_query_result);
	}
}


////////////////////////////////////////////////////////////////////////////////////
//
// Return array of tag objects corresponding to img_id
// If no tag assigned to the image, return empty array
//
function imgt_get_image_tags($img_id){
	global $wpdb;
	global $g_imgt_tag_taxonomy;
	$imgt_tags = array();
	
	//echo "into 'imgt_get_image_tags(\$img_id=" . $img_id . ")'<br/>";	//DBG
		
	$sql_query = 'SELECT term_taxonomy_id '.
				 'FROM ' . TERM_REL_IMG . ' AS img ' .
				 'WHERE img.object_id = ' . $img_id . ' ' .
				 'ORDER by term_taxonomy_id';
	$imgt_taxonomies = run_mysql_query($sql_query);
	
	foreach($imgt_taxonomies as $imgt_taxonomy){
		$imgt_tags[] = imgt_get_tag_descriptors('term_taxonomy_id=' . $imgt_taxonomy->term_taxonomy_id);
	}
	
	return $imgt_tags;
}

////////////////////////////////////////////////////////////////////////////////////
//
// Return array of img IDs corresponding to a list of taxonomy_term_id 
// like array(2,4,13)
//
function imgt_get_image_ID($a_tax_id){
	global $wpdb;
	$a_name_str = "";
	
	if (empty($a_tax_id))
		return array();
	
	foreach($a_tax_id as $n=>$tax_id) {
		$sql_query = 'SELECT DISTINCT object_id '.
					 'FROM ' . TERM_REL_IMG . ' AS img ' .
					 'WHERE img.term_taxonomy_id=' . $tax_id . ' ' .
					 'ORDER by object_id';			
		$imgt_img_id_sqls = run_mysql_query($sql_query);
		
		if (empty($imgt_img_id_sqls))	// no chance to find any intersection in case of multisearch ; and for simple search, we know there are no matches ...
			return array();
				
		$imgt_img_id = array();
		foreach($imgt_img_id_sqls as $imgt_img_id_sql){
			$imgt_img_id[] = $imgt_img_id_sql->object_id;
		}
		
		// Search images ID common to all selected tags
		if (empty($multisort_imgt_img_id)) {
			$multisort_imgt_img_id = $imgt_img_id;
		} else {
			$multisort_imgt_img_id = array_intersect($multisort_imgt_img_id, $imgt_img_id);
		}
		if (empty($multisort_imgt_img_id))	// at first empty intersection, return empty ...
			return array();
	}
	
	foreach($multisort_imgt_img_id as $img_id) {
		$multisort_img_list[] = get_post($img_id);
	}
	
	return $multisort_img_list;
}

////////////////////////////////////////////////////////////////////////////////////
//
// Set tags based on taxonomy array for image img_id
//
function imgt_set_image_tags($img_id, $a_taxonomy_term_id) {
	global $wpdb;
	
	// Clear previously set tags (if already existing)
	$sql_query = 'DELETE FROM ' . TERM_REL_IMG . ' ' .
				 'WHERE ' . TERM_REL_IMG . '.object_id = ' . $img_id;
	run_mysql_query($sql_query);
	
	// If tag list not empty : set new tags (otherwise : it is a reset
	if (!empty($a_taxonomy_term_id)){
		// Build SQL new values list
		$sql_string_values = '(' . $img_id. ',' . implode('),('.$img_id.',', $a_taxonomy_term_id) . ')';
		
		// set new tags on $img_id
		$sql_query = 'INSERT INTO ' . TERM_REL_IMG . ' ' .
					 '(`object_id`, `term_taxonomy_id`) VALUES ' . $sql_string_values;
		run_mysql_query($sql_query);
	}
	// update taxonomy stats
	imgt_update_taxonomy_stats();
}


////////////////////////////////////////////////////////////////////////////////////
//
// Format string for admin panel : list of checkboxes with supported formats
//		
//
function get_supported_formats_checkbox_string($selected_formats) {
	global $supported_formats;
	
	$file_format_strout = "";				
	
	foreach ($supported_formats as $ext=>$mime) {
		$file_format_strout .= '<input type="checkbox" value=' . $ext . " name=wpit_admin_media_formats[]" . 
			(in_array($ext, $selected_formats) ? " checked" : "") . '> ' .  $ext . " &nbsp;\n";
	}
	return $file_format_strout;
}


////////////////////////////////////////////////////////////////////////////////////
//
// Get list of images not assigned with tag
//		what : all_images, tagged_images, untagged_images, count_images
//
function imgt_get_images($what, &$count, &$reason) {
	global $wpdb;
	global $supported_formats;
	$count = new StdClass;
	$count->total = 0;
	$count->tagged = 0;
	$count->untagged = 0;
	$reason = 0;

	//$reason = 1; return array();		// UNCOMMENT THIS LINE TO SIMULATE BLOG WITHOUT IMAGE
	//$reason = 2; return array();		// UNCOMMENT THIS LINE TO SIMULATE BLOG WITH ALL IMAGES TAGGED
	
	$wpit_admin_media_formats = explode(',', admin_get_option_safe('wpit_admin_media_formats', WPIT_ADMIN_INIT_MEDIA_FORMATS));
	$mime_string = "";
	foreach ($wpit_admin_media_formats as $ext) {
		$mime_string .= ',"' . $supported_formats[$ext] . '"';
	}
	$mime_string = substr($mime_string, 1);		// remove first comma
	//echo "MIME types : " . $mime_string . "<br/>";
	
	// Get all images and supported attachments
	$sql_query = 'SELECT ID '.
				 'FROM ' . $wpdb->posts . ' AS pos ' .
				 'WHERE pos.post_mime_type IN (' . $mime_string . ')';
	$imgt_imgs_a = run_mysql_query($sql_query);

	foreach($imgt_imgs_a as $obj)
		$imgt_imgs[] = $obj->ID;
	if (empty($imgt_imgs)) {
		$reason = 1;
		return array();
	}
	sort($imgt_imgs);
	//print_ro($imgt_imgs);
	$count->total = sizeof($imgt_imgs);
	
	// Get tagged images
	$sql_query = 'SELECT DISTINCT object_id '.
				 'FROM ' . TERM_REL_IMG . ' ' .
				 'WHERE 1';
	$imgt_imgs_tagged_a = run_mysql_query($sql_query);
	
	$imgt_imgs_tagged = array();
	foreach($imgt_imgs_tagged_a as $obj)
		$imgt_imgs_tagged[] = $obj->object_id;
	sort($imgt_imgs_tagged);
	//print_ro($imgt_imgs_tagged);
	$count->tagged = sizeof($imgt_imgs_tagged);
	
	// Get untagged by difference
	$untagged_img_list = array_diff($imgt_imgs, $imgt_imgs_tagged);
	if (empty($untagged_img_list)) $reason = 2;
	$count->untagged = sizeof($untagged_img_list);
	
	switch ($what) {
		case 'all_images' : return $imgt_imgs; break;
		case 'tagged_images' : return $imgt_imgs_tagged; break;
		case 'untagged_images' :  return $untagged_img_list; break;
		case 'count_images' : return array(); break;
	}

}


////////////////////////////////////////////////////////////////////////////////////
//
// Retrieve all tags associated to images for a given post (remove any image
//	tag that is a category to avoid messing wordpress post categorizing)
//
function imgt_get_image_tags_from_post_id($post_id){
	global $wpdb;
	$tax_id_list = array();
	$debug = 0;
	
	//echo "into 'imgt_get_image_tags_from_post_id(\$post_id=" . $post_id . ")<br/>";	//DBG
		
	// Retrieve tags associated to post images
	$attached_images =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $post_id );
	//print_ro($attached_images);
	if (empty($attached_images))
		return array();
	
	foreach($attached_images as $img_id=>$img){
		$attached_images[$img_id] = imgt_get_image_tags($img_id);	
	}
	//print_ro($attached_images);
		
	foreach($attached_images as $img_id){
		foreach ($img_id as $tag){
			if (!in_array($tag->term_taxonomy_id, $tax_id_list) && get_cat_name($tag->term_id) == "")
				$tax_id_list[] = $tag->term_taxonomy_id;
		}
	}
	sort($tax_id_list);
	//print_ro($tax_id_list);
	
	//
	//	Exclude any image tag that would be a category
	//
	/*$sql_query = 'SELECT term_taxonomy_id '.
				 'FROM ' . $wpdb->term_taxonomy . ' ' .
				 'WHERE taxonomy = "category"';
	$mysql_result = run_mysql_query($sql_query);
	foreach($mysql_result as $res)
		$cat[] = $res->term_taxonomy_id;
	//print_ro($cat);
	foreach($tax_id_list as $tax) {
		if (!in_array($tax, $cat))
			$tax_id_list2[] = $tax;
	}*/
	
	if ($debug) {
		echo "Tags detected from the image taxonomy : <br/>";
		print_ro(imgt_taxonomy_to_name($tax_id_list));
	}
	
	return $tax_id_list;
}


////////////////////////////////////////////////////////////////////////////////////
//
// Set tags for a post
//
function imgt_update_post_tags($post_id, $update, &$update_required){
	global $wpdb;
	$update_required = 1;
	
	// Retrieve image taxonomy
	$tag_list = imgt_get_image_tags_from_post_id($post_id);
	
	//
	// 1 - retrieve current category(ies) and tags
	//
	$current_tax = array();
	$cats = array();

	$category = get_the_category($post_id);
	foreach($category as $cat)
		$cats[] = $cat->term_taxonomy_id;
	
	$query_result = get_the_tags($post_id);
	if (!empty($query_result)) {
		foreach ($query_result as $tax)
			$current_tax[] = $tax->term_taxonomy_id;
		sort($current_tax);
	}
	
	if (count($current_tax) == count($tag_list) && !count(array_diff($current_tax, $tag_list))) {
		$update_required = 0;
		return $tag_list;	// tags are already properly set
	}
	
	//$original_cats = implode(', ', imgt_taxonomy_to_name($cats));
	if (!$update) {
		$original_tags = implode(', ', imgt_taxonomy_to_name($current_tax));
		$new_tags = implode(', ', imgt_taxonomy_to_name($tag_list));
		echo '=== <em>' . __('Post', 'mediatagger') . '</em> : <strong>' . get_the_title($post_id) . "</strong> ===<br/>";
		//echo '<em>' . _n('Original category', 'Original categories', count($cats), 'mediatagger') . ":</em> " . $original_cats . "<br/>";
		echo '<em>' . _n('Original tag', 'Original tags', count($current_tax), 'mediatagger') . ":</em> " . $original_tags . "<br/>";
		echo '<em>' . _n('New tag', 'New tags', count($current_tax), 'mediatagger') . ":</em> " . $new_tags . "<br/>";
		//print_ro($current_tax);
		//print_ro($tag_list);
		return $tag_list;
	}
			
	//
	// 2 - delete current tags and cat(s)
	//
	$sql_query = 'DELETE FROM ' .  $wpdb->term_relationships . ' ' .
				 'WHERE object_id = ' . $post_id;
	run_mysql_query($sql_query);
		
	//
	// 3 - reset original cat(s) and set new tags
	//
	$cat_tag_list = array_merge($cats, $tag_list);
	
	$sql_string_values = '(' . $post_id. ',' . implode(',0),('.$post_id.',', $cat_tag_list) . ')';
	$sql_string_values = substr($sql_string_values, 0, strlen($sql_string_values)-1) . ',0)';
		
	$sql_query = 'INSERT INTO ' . $wpdb->term_relationships . ' ' .
				 '(`object_id`, `term_taxonomy_id`, `term_order`) VALUES ' . $sql_string_values;
	//echo $sql_query . "<br/>";
	run_mysql_query($sql_query);
	
	//
	// 4 - update tag count for tags previously set (and potentially erased) and new tags
	//
	$tags_count_updt_list = array_unique(array_merge($current_tax, $tag_list));
	foreach	($tags_count_updt_list as $tag) {
		$tag_desc = imgt_get_tag_descriptors('term_taxonomy_id=' . $tag);
		//print_ro($tag_desc);
		$new_count = count(query_posts('tag=' . $tag_desc->slug . '&posts_per_page=-1'));
		//echo $new_count . "<br/>";
		$sql_query = 'UPDATE ' . $wpdb->term_taxonomy . ' '.
					'SET count = "' . $new_count . '" ' .
					'WHERE term_taxonomy_id = "' . $tag . '"';
		run_mysql_query($sql_query);	
	}
		
	return $tag_list;	// return real tag list associated to the post, excluding any category
}

////////////////////////////////////////////////////////////////////////////////////
//
// Retrieve all post IDs
//
function imgt_get_all_post_id(){
	global $wpdb;
		
	$sql_query = 'SELECT ID '.
				 'FROM ' . $wpdb->posts . ' AS posts ' .
				 'WHERE posts.post_type = "post" ' .
				 'ORDER by ID';
	$mysql_result = run_mysql_query($sql_query);
	foreach($mysql_result as $post_id) {
		$posts_id[] = $post_id->ID;
	}
	
	return $posts_id;
}


////////////////////////////////////////////////////////////////////////////////////
//
// Database integrity fix : remove post revision entries from wp_posts table
//
function imgt_database_fix_post_revisions($fix_revisions_liststr) {
	global $wpdb;

	if (empty($fix_revisions_liststr)) {
		echo "<p><strong>>> " . __('Post revision cleanup : nothing to clean', 'mediatagger') . ".</strong><p><br/>";
		return;
	}

	$sql_query = 'DELETE FROM ' . $wpdb->posts . ' WHERE ID IN (' . $fix_revisions_liststr . ')';
	
	printf('<p><strong>>> ' . __('Cleaning up table %s from post revisions', 'mediatagger') . '<br/>', $wpdb->posts);
	printf('>> ' . __('Running SQL : %s', 'mediatagger') . ' ...<br/>', $sql_query);
	run_mysql_query($sql_query);
	echo ">> " . __('Done', 'mediatagger') . ".</strong></p>";
}


////////////////////////////////////////////////////////////////////////////////////
//
// Database integrity fix : remove post attachment entries from wp_posts table
//
function imgt_database_fix_post_attachments($fix_attachments_liststr) {
	global $wpdb;

	if (empty($fix_attachments_liststr)) {
		echo "<p><strong>>> " . __('Post attachment cleanup : nothing to clean', 'mediatagger') . ".</strong><p><br/>";
		return;
	}

	$sql_query = 'DELETE FROM ' . $wpdb->posts . ' WHERE ID IN (' . $fix_attachments_liststr . ')';
	
	printf('<p><strong>>> ' . __('Cleaning up table %s from unused attachments', 'mediatagger') . '<br/>', $wpdb->posts);
	printf('>> ' . __('Running SQL : %s', 'mediatagger') . ' ...<br/>', $sql_query);
	run_mysql_query($sql_query);
	echo ">> " . __('Done', 'mediatagger') . ".</strong></p>";

}


////////////////////////////////////////////////////////////////////////////////////
//
// Database integrity fix : cleanup post taxonmy table from posts not existing anymore in posts table
//
function imgt_database_fix_post_taxonomy($fix_posttax_liststr) {
	global $wpdb;

	if (empty($fix_posttax_liststr)) {
		echo "<p><strong>>> " . __('Post taxonomy cleanup : nothing to clean', 'mediatagger') . ".</strong><p><br/>";
		return;
	}

	$sql_query = 'DELETE FROM ' . $wpdb->term_relationships . ' WHERE object_id IN (' . $fix_posttax_liststr . ')';
	
	printf('<p><strong>>> ' . __('Cleaning up table %s from entries referring to posts not having anymore an entry in the posts table', 'mediatagger') . '<br/>', $wpdb->wp_term_relationships);
	printf('>> ' . __('Running SQL : %s', 'mediatagger') . ' ...<br/>', $sql_query);
	run_mysql_query($sql_query);
	echo ">> " . __('Done', 'mediatagger') . ".</strong></p>";

}


////////////////////////////////////////////////////////////////////////////////////
//
// Database integrity fix : cleanup image taxonmy table from images not existing anymore in posts table
//
function imgt_database_fix_image_taxonomy($fix_imgtax_liststr) {
	global $wpdb;

	if (empty($fix_imgtax_liststr)) {
		echo "<p><strong>>> " . __('Image taxonomy cleanup : nothing to clean', 'mediatagger') . ".</strong><p><br/>";
		return;
	}

	$sql_query = 'DELETE FROM ' . TERM_REL_IMG . ' WHERE object_id IN (' . $fix_imgtax_liststr . ')';
	
	printf('<p><strong>>> ' . __('Cleaning up table %s from entries referring to media not having anymore an entry in the posts table', 'mediatagger') . '<br/>', TERM_REL_IMG);
	printf('>> ' . __('Running SQL : %s', 'mediatagger') . ' ...<br/>', $sql_query);
	run_mysql_query($sql_query);
	echo ">> " . __('Done', 'mediatagger') . ".</strong></p>";

}


////////////////////////////////////////////////////////////////////////////////////
//
// Audit database inconsistencies under the angle of images between tables POST, WP_TERMS_RELATIONSHIPS and WP_TERMS_RELATIONSHIPS_IMG :
//		- images with dedicated entry in POSTS database ("attachment") 
//			+ not referred anymore to by any post (therefore image is appearantly needless, might be one uploaded for a post that was deleted meanwhile), or 
//			+ not tagged (normal if the image was just added to the database)
//		- image appearing in the image taxonomy table and not present anymore as a dedicated entry in the POSTS table ("attachment")
//
function imgt_database_audit(&$fix_revisions_liststr, &$fix_attachments_liststr, &$fix_posttax_liststr, &$fix_imgtax_liststr, $pure_audit){
	global $wpdb;
	
	echo ($pure_audit ? "<br/>" : '') . __('Check below the possibly detected database inconsistencies', 'mediatagger') . '.<br/>';
	echo __('If you go for the cleanup, the process will delete some entries in the posts, post taxonomy and image taxonomy table(s)', 'mediatagger') . '.<br/>';
	echo '<span style="color:#00F">' . __('For this reason it is mandatory to backup your database before to be able to revert to the original database setup if needed', 'mediatagger') . '</span>.<br/>';
	echo __('In any case, read entirely the list of impacted entries shown in the analysis below before deciding to cleaning up', 'mediatagger') . '.<br/><br/>';
	echo __('Given the dependencies, execute the following sequence partially or totally, assuming you have the proper understanding of the consequences on your database', 'mediatagger') . '.<br/>';
	echo '<span style="color:#00F">' . __('If any doubt, do not run the cleanup sequence you are not clear with', 'mediatagger') . '.</span><br/><br/>';
	
	printf('1 - ' . __('Left-over post revisions (table %s)', 'mediatagger') . '<br/>', $wpdb->posts);
	echo '<p style="margin:0;padding:0 0 5px 24px;font-style:italic">' . 
		__('This step does not induce any risk of data loss. It will erase posts revisions automatically created and not needed anymore', 'mediatagger') . '.</p>';
		
	printf('2 - ' . __('Media library elements not included in any post content (table %s)', 'mediatagger') . '<br/>', $wpdb->posts);
	echo '<p style="margin:0;padding:0 0 5px 24px;font-style:italic">' . 
		__('This step might present risk of data loss and requires proper understanding and judgment ; it will remove attachments from the table if this attachment does not appear anywhere in any of the posts content. Do not use it if you created a media library with items not included in the posts, and still want to keep this library unchanged', 'mediatagger') . '.</p>';
		
	printf('3 - ' . __('Left-over post taxonomies (table %s)', 'mediatagger') . '<br/>', $wpdb->term_relationships);
	echo '<p style="margin:0;padding:0 0 5px 24px;font-style:italic">' . 
		__('This step does not induce any risk of data loss. It will erase from the post taxonomy table post IDs still tagged but not present anymore in the posts table as attachment entries', 'mediatagger') . '.</p>';

	printf('4 - ' . __('Left-over medias taxonomies (table %s)', 'mediatagger') . '<br/>', TERM_REL_IMG);
	echo '<p style="margin:0;padding:0 0 5px 24px;font-style:italic">' . 
		__('This step does not induce any risk of data loss. It will erase from the media taxonomy table image IDs still tagged but not present anymore in the posts table as attachment entries', 'mediatagger') . '.</p>';

	printf('5 - ' . __('Information only : Medias remaining untagged (table %s)', 'mediatagger') . '<br/>', TERM_REL_IMG);
	echo '<p style="margin:0;padding:0 0 10px 24px;font-style:italic">' . 
		__('This analysis provides you the list of untagged images. To fix situation where medias would remain untagged, go to the MediaTagger Tag Editor and complete the job', 'mediatagger') . '.</p>';

	echo __('The benefit of this cleanup is to reduce your database to the only required information, therefore improving site reactivity and decreasing required processing power', 'mediatagger') . '.<br/><br/>';
	
	echo "<h3>" . __('Analysis result', 'mediatagger') . ' : </h3>';
	
	//
	//	1 - Search post revisions
	//
	printf('<p><strong>1 - ' . __('Left-over post revisions (table %s)', 'mediatagger') . '</strong></p>', $wpdb->posts);
	$sql_query = 'SELECT ID, post_title ' .
				'FROM '  . $wpdb->posts . ' ' .
				'WHERE post_type = "revision" ' .
				'ORDER BY ID';
	$mysql_result = run_mysql_query($sql_query);
	//print_ro($mysql_result);
	if (($mysql_result = run_mysql_query($sql_query)) !== "SQL_EXEC_ERROR") {
		$fix_revisions_liststr = '';	
		if (empty($mysql_result))
			echo '<p class="post_list">' . __('No left-over post revision found - No cleanup needed', 'mediatagger') . '.</p>';
		else {
			foreach($mysql_result as $item) {
				echo '<p class="post_list">- ' . $item->post_title . ' (id ' . $item->ID . ')</p>';
				$fix_revisions_liststr .= $item->ID . ',';	
			}
			$fix_revisions_liststr = substr($fix_revisions_liststr, 0, strlen($fix_revisions_liststr) - 1);		
		}
	}
	
	
	//
	//	2 - Attachments left-over :  for each image : get guid and check there is minimum 1 post with post_type != revision referring to this image
	//
	// 	Watch the damn self join SQL query !!!
	//
	printf('<p><strong>2 - ' . __('Media library elements not included in any post (table %s)', 'mediatagger') . '</strong></p>', $wpdb->posts);
	
	$sql_query = 'SELECT posts.ID as ID, posts.guid as path, posts.post_mime_type as mime_type, posts2.post_title AS post_title, posts2.ID AS post_id ' .
					'FROM '  . $wpdb->posts . ' AS posts ' .
					'LEFT JOIN '  . $wpdb->posts . ' AS posts2 ' .
					'ON posts2.post_content LIKE CONCAT("%",posts.guid,"%") AND posts2.post_type != "revision" ' . 
					'WHERE posts.post_type = "attachment"';
	if (($mysql_result = run_mysql_query($sql_query)) !== "SQL_EXEC_ERROR") {
		$cleanup_needed = 0;
		$fix_attachments_liststr = '';
		foreach($mysql_result as $item) {
			if (empty($item->post_id)) {
				echo '<p class="post_list">- ' . $item->mime_type . ' - <em>' . $item->path  . ' </em>(id ' . $item->ID . ')</p>';
				$fix_attachments_liststr .= $item->ID . ',';	
				$cleanup_needed = 1;
			}
		}
		if ($cleanup_needed) {
			$fix_attachments_liststr = substr($fix_attachments_liststr, 0, strlen($fix_attachments_liststr) - 1);
		} else 
			echo '<p class="post_list">' . __('No orphean attachment found - no cleanup needed', 'mediatagger') . '.</p>';
	}
	
	//
	//	3 - Left-over post taxonomies : taxonomies provided for a given post id not existing anymore in table posts
	//
	printf('<p><strong>3 - ' . __('Left-over post taxonomies (table %s)', 'mediatagger') . '</strong></p>', $wpdb->term_relationships);

	$sql_query = 'SELECT DISTINCT term_relationships.object_id, posts.post_title, posts.ID ' .
					'FROM ' .  $wpdb->term_relationships . ' AS term_relationships ' .
					'LEFT JOIN ' . $wpdb->posts . ' AS posts ' .
					'ON posts.ID = term_relationships.object_id ' .
					'WHERE 1 ' .
					'ORDER BY object_id';
	if (($mysql_result = run_mysql_query($sql_query)) !== "SQL_EXEC_ERROR") {
		$cleanup_needed = 0;
		$fix_posttax_liststr = '';
		foreach($mysql_result as $item) {
			if (empty($item->ID)) {
				echo '<p class="post_list">- ' . $item->object_id . '</p>';
				$fix_posttax_liststr .= $item->object_id . ',';	
				$cleanup_needed = 1;
			}
		}
		if ($cleanup_needed) {
			$fix_posttax_liststr = substr($fix_posttax_liststr, 0, strlen($fix_posttax_liststr) - 1);
		} else 
			echo '<p class="post_list">' . __('No left-over post taxonomy found - no cleanup needed', 'mediatagger') . '.</p>';
	}

	//
	//	4 - Left-over image taxonomies : taxonomies provided for a given image id not existing anymore in table posts
	//
	//	Note that this type of left over is permanently monitored ; therefore this detection should never find any case
	//
	printf('<p><strong>4 - ' . __('Left-over media taxonomies (table %s)', 'mediatagger') . '</strong></p>', TERM_REL_IMG);

	$sql_query = 'SELECT DISTINCT term_relationships_img.object_id, posts.post_title, posts.ID ' .
					'FROM ' . TERM_REL_IMG . ' AS term_relationships_img ' .
					'LEFT JOIN ' . $wpdb->posts . ' AS posts ' .
					'ON posts.ID = term_relationships_img.object_id ' .
					'WHERE 1 ' .
					'ORDER BY object_id';
	if (($mysql_result = run_mysql_query($sql_query)) !== "SQL_EXEC_ERROR") {
		$cleanup_needed = 0;
		$fix_imgtax_liststr = '';
		foreach($mysql_result as $item) {
			if (empty($item->ID)) {
				echo '<p class="post_list">- ' . $item->object_id . '</p>';
				$fix_imgtax_liststr .= $item->object_id . ',';	
				$cleanup_needed = 1;
			}
		}
		if ($cleanup_needed) {
			$fix_imgtax_liststr = substr($fix_imgtax_liststr, 0, strlen($fix_imgtax_liststr) - 1);
		} else 
			echo '<p class="post_list">' . __('No left-over media taxonomy found - no cleanup needed', 'mediatagger') . '.</p>';
	}
		
	//
	//	5 - Untagged images
	//
	printf('<p><strong>5 - ' . __('Information only : Medias remaining untagged (table %s)', 'mediatagger') . '</strong></p>', TERM_REL_IMG);

	$sql_query = 'SELECT DISTINCT posts.ID, posts.post_title, posts.guid, term_relationships_img.object_id ' .
					'FROM ' . $wpdb->posts . ' AS posts ' .
					'LEFT JOIN ' . TERM_REL_IMG . ' AS term_relationships_img ' .
					'ON posts.ID = term_relationships_img.object_id ' .
					'WHERE posts.post_mime_type IN ("image/jpeg","image/gif","image/png") ' .
					'ORDER BY posts.ID';					
	if (($mysql_result = run_mysql_query($sql_query)) !== "SQL_EXEC_ERROR") {
		$cleanup_needed = 0;
		foreach($mysql_result as $item) {
			if (empty($item->object_id)) {
				echo '<p class="post_list">- ' . $item->post_title . ' - <em>' . $item->guid  . ' </em>(id ' . $item->ID . ')</p>';
				$cleanup_needed = 1;
			}
		}
		if (!$cleanup_needed) 
			echo '<p class="post_list">' . __('All the medias are tagged, you made it well !', 'mediatagger') . '</p>';
	}

}


?>