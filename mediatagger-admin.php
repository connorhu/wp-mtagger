<?php
if (admin_get_php_version() < WPIT_ADMIN_MIN_PHP_VERSION) { ?>		
<div class="updated"><strong><p><?php _e("PHP Version 4 is the minimum required on your server to run the MediaTagger plugin.", 'mediatagger') ?></p>
<p><?php printf(__("Version %s was detected on the server.", 'mediatagger'), phpversion()) ?></p></strong></div>
<?php
return;
}

global $g_imgt_tag_taxonomy;
global $WPIT_SELF_VERSION;
global $WPIT_GD_VERSION;

?>


<style type="text/css">
	hr {color:#ccc; background-color:#ccc; height:1px; border:0; }
	.option_highlight {background-color:#FFB;color:#000; }
	.label {display:inline-block;float:left;line-height:2em;vertical-align:middle;width:400px;margin:0;padding:0 0 0 15px;}
	input {padding:1px 0 3px 3px;margin:0; }
	.legend {clear:both;font-size:0.8em;font-style:italic;margin:0;padding:0 0 5px 30px; }
	.post_list {clear:both;font-size:0.9em;margin:0;padding:0 0 0 30px; }
	.comment {clear:both;font-size:1em;margin:0;padding:0 0 0 30px; }
	}
</style>

<script language="JavaScript" type="text/javascript">
<!--
function post_submit(post_var_name, post_var_value) {
  	document.wpit_tagger.elements[post_var_name].value = post_var_value ;
  	document.wpit_tagger.submit();
}
function options_submit(post_var_name, post_var_value) {
  	document.wpit_options.elements[post_var_name].value = post_var_value ;
  	document.wpit_options.submit();
}
-->
</script>


<?php
// Read in existing option values from database

$wpit_admin_media_formats = explode(',', admin_get_option_safe('wpit_admin_media_formats', WPIT_ADMIN_INIT_MEDIA_FORMATS));
$wpit_admin_display_options = admin_get_option_safe('wpit_admin_display_options', WPIT_ADMIN_INIT_DISPLAY_OPTIONS);
$wpit_admin_tags_source = admin_get_option_safe('wpit_admin_tags_source', WPIT_ADMIN_INIT_TAGS_SOURCE);
$wpit_admin_tags_groups = admin_get_option_safe('wpit_admin_tags_groups', WPIT_ADMIN_INIT_TAGS_GROUPS);
$wpit_admin_background_color = admin_get_option_safe('wpit_admin_background_color', WPIT_ADMIN_INIT_BACKGROUND_COLOR);
$wpit_admin_override_post_taxonomy = admin_get_option_safe('wpit_admin_override_post_taxonomy', WPIT_ADMIN_INIT_OVERRIDE_POST_TAXONOMY);
$wpit_admin_credit = admin_get_option_safe('wpit_admin_credit', WPIT_ADMIN_INIT_CREDIT);
$wpit_admin_image_border_w = admin_get_option_safe('wpit_admin_image_border_w', WPIT_ADMIN_INIT_IMAGE_BORDER_W);
$wpit_admin_image_border_color = admin_get_option_safe('wpit_admin_image_border_color', WPIT_ADMIN_INIT_IMAGE_BORDER_COLOR);
$wpit_admin_num_tags_per_col = admin_get_option_safe('wpit_admin_num_tags_per_col', WPIT_ADMIN_INIT_NUM_TAGS_PER_COL);
$wpit_admin_tags_excluded = admin_get_option_safe('wpit_admin_tags_excluded', WPIT_ADMIN_INIT_TAGS_EXCLUDED);
$wpit_admin_img_width_height = admin_get_option_safe('wpit_admin_img_width_height', WPIT_ADMIN_INIT_IMG_WIDTH_HEIGHT);
$wpit_search_num_tags_per_col = admin_get_option_safe('wpit_search_num_tags_per_col', WPIT_SEARCH_INIT_NUM_TAGS_PER_COL);
$wpit_search_form_font = admin_get_option_safe('wpit_search_form_font', WPIT_SEARCH_INIT_FORM_FONT);
$wpit_search_tags_excluded = admin_get_option_safe('wpit_search_tags_excluded', WPIT_SEARCH_INIT_TAGS_EXCLUDED);
$wpit_search_default_display_mode = admin_get_option_safe('wpit_search_default_display_mode', WPIT_SEARCH_INIT_DEFAULT_DISPLAY_MODE);
$wpit_search_display_switchable = admin_get_option_safe('wpit_search_display_switchable', WPIT_SEARCH_INIT_DISPLAY_SWITCHABLE);
$wpit_result_default_display_mode = admin_get_option_safe('wpit_result_default_display_mode', WPIT_RESULT_INIT_DEFAULT_DISPLAY_MODE);
$wpit_result_display_switchable = admin_get_option_safe('wpit_result_display_switchable', WPIT_RESULT_INIT_DISPLAY_SWITCHABLE);
$wpit_result_display_optimize_xfer = admin_get_option_safe('wpit_result_display_optimize_xfer', WPIT_RESULT_INIT_OPTIMIZE_XFER);
$wpit_tagcloud_num_tags = admin_get_option_safe('wpit_tagcloud_num_tags', WPIT_INIT_TAGCLOUD_NUM_TAGS);
$wpit_tagcloud_order = admin_get_option_safe('wpit_tagcloud_order', WPIT_INIT_TAGCLOUD_ORDER);
$wpit_tagcloud_font_min = admin_get_option_safe('wpit_tagcloud_font_min', WPIT_INIT_TAGCLOUD_FONT_MIN);
$wpit_tagcloud_font_max = admin_get_option_safe('wpit_tagcloud_font_max', WPIT_INIT_TAGCLOUD_FONT_MAX);
$wpit_tagcloud_color_min = admin_get_option_safe('wpit_tagcloud_color_min', WPIT_INIT_TAGCLOUD_COLOR_MIN);
$wpit_tagcloud_color_max = admin_get_option_safe('wpit_tagcloud_color_max', WPIT_INIT_TAGCLOUD_COLOR_MAX);
$wpit_tagcloud_highlight_color = admin_get_option_safe('wpit_tagcloud_highlight_color', WPIT_INIT_TAGCLOUD_HIGHLIGHT_COLOR);
$wpit_gallery_image_border_w = admin_get_option_safe('wpit_gallery_image_border_w', WPIT_INIT_GALLERY_IMAGE_BORDER_W);
$wpit_gallery_image_border_color = admin_get_option_safe('wpit_gallery_image_border_color', WPIT_INIT_GALLERY_IMAGE_BORDER_COLOR);
$wpit_gallery_image_link_ctrl = admin_get_option_safe('wpit_gallery_image_link_ctrl', WPIT_INIT_GALLERY_IMAGE_LINK_CTRL);
$wpit_gallery_image_num_per_page = admin_get_option_safe('wpit_gallery_image_num_per_page', WPIT_INIT_GALLERY_IMAGE_NUM_PER_PAGE);
$wpit_result_img_list_w_h = admin_get_option_safe('wpit_result_img_list_w_h', WPIT_RESULT_INIT_IMG_LIST_W_H);
$wpit_result_img_gallery_w_h = admin_get_option_safe('wpit_result_img_gallery_w_h', WPIT_RESULT_INIT_IMG_GALLERY_W_H);
$wpit_list_image_num_per_page = admin_get_option_safe('wpit_list_image_num_per_page', WPIT_INIT_LIST_IMAGE_NUM_PER_PAGE);
$wpit_list_title_num_per_page = admin_get_option_safe('wpit_list_title_num_per_page', WPIT_INIT_LIST_TITLE_NUM_PER_PAGE);

if (function_exists("gd_info")){
	$gd_info = gd_info();
	$gd_version = $gd_info['GD Version'];
} else {
	$gd_version = 0;
	$wpit_result_display_optimize_xfer = 0;
}

//
// First : Process option form data if form was validated
//
$wpit_errmsg = array();
if (strlen($_POST['Submit']) > 0) {

	imgt_get_valid_post_media_formats($wpit_admin_media_formats, 'wpit_admin_media_formats',
		$invalid_wpit_admin_media_formats, $wpit_errmsg, __('At least one file format must be selected (General)', 'mediatagger'), $media_format_changed);

	$wpit_admin_tags_source = $_POST['wpit_admin_tags_source'];		// combo choice - no need of error checking 

	imgt_get_valid_post_data($wpit_admin_tags_groups, 'wpit_admin_tags_groups', 'check_valid_tag_group_definition("VALUE")',
		$invalid_wpit_admin_tags_groups, $wpit_errmsg, __('Tag group definition : incorrect syntax (General)', 'mediatagger'));
	$wpit_admin_tags_groups = trim($wpit_admin_tags_groups);
	
	imgt_get_valid_post_data($wpit_admin_background_color, 'wpit_admin_background_color', "check_valid_colorhex('VALUE')",
		$invalid_wpit_admin_background_color, $wpit_errmsg, __('The fields background color must be a valid hexadecimal color code as 3ff or a1b160 (General)', 'mediatagger'));

	$wpit_admin_override_post_taxonomy = $_POST['wpit_admin_override_post_taxonomy'];		// combo choice - no need of error checking

	$wpit_admin_credit = $_POST['wpit_admin_credit'];		// combo choice - no need of error checking

	imgt_get_valid_post_data($wpit_admin_image_border_w, 'wpit_admin_image_border_w', 'is_int(VALUE) && VALUE >= 0',
		$invalid_wpit_admin_image_border_w, $wpit_errmsg, __('The image frame pixel width must be an integer greater than 0 (Tag Editor)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_admin_image_border_color, 'wpit_admin_image_border_color', "check_valid_colorhex('VALUE')",
		$invalid_wpit_admin_image_border_color, $wpit_errmsg, __('The image frame color must be a valid hexadecimal color code as 3ff or a1b160 (Tag Editor)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_admin_num_tags_per_col, 'wpit_admin_num_tags_per_col', 'is_int(VALUE) && VALUE > 0',
		$invalid_wpit_admin_num_tags_per_col, $wpit_errmsg, __('The number of tags displayed by column must be an integer greater than 0 (Tag Editor)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_admin_tags_excluded, 'wpit_admin_tags_excluded', 'check_string_is_taglist("VALUE")',
		$invalid_wpit_admin_tags_excluded, $wpit_errmsg, __('The tag exclusion list must contain available tags separated by commas (Tag Editor)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_admin_img_width_height, 'wpit_admin_img_width_height', 'is_int(VALUE) && VALUE >= 100',
		$invalid_wpit_admin_img_width_height, $wpit_errmsg, __('The maximum image pixel width or height must be an integer greater than 100 (Tag Editor)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_search_num_tags_per_col, 'wpit_search_num_tags_per_col', 'is_int(VALUE) && VALUE > 0',
		$invalid_wpit_search_num_tags_per_col, $wpit_errmsg, __('The number of tags displayed by column must be an integer greater than 0 (Search format)', 'mediatagger'));
	
	imgt_get_valid_post_data($wpit_search_form_font, 'wpit_search_form_font', 'is_int(VALUE) && VALUE > 0',
		$invalid_wpit_search_form_font, $wpit_errmsg, __('The search form font must be a positive integer expressed in pt (Search format)', 'mediatagger'));
	
	imgt_get_valid_post_data($wpit_search_tags_excluded, 'wpit_search_tags_excluded', 'check_string_is_taglist("VALUE")',
		$invalid_wpit_search_tags_excluded, $wpit_errmsg, __('The tag exclusion list must contain available tags separated by commas (Search format)', 'mediatagger'));

	imgt_get_valid_search_default_display_mode($wpit_search_default_display_mode, 'wpit_search_default_display_mode',
		$invalid_wpit_search_default_display_mode, $wpit_errmsg, __('At least one default display mode needs to be selected (Search format)', 'mediatagger'));	

	$wpit_search_display_switchable = $_POST['wpit_search_display_switchable'];		// combo choice - no need of error checking

	imgt_get_valid_post_data($wpit_result_img_list_w_h, 'wpit_result_img_list_w_h', 'is_int(VALUE) && VALUE >= 10',
		$invalid_wpit_result_img_list_w_h, $wpit_errmsg, __('The maximum image pixel width or height must be an integer greater than 10 (Image list output format)', 'mediatagger'));
	
	imgt_get_valid_post_data($wpit_result_img_gallery_w_h, 'wpit_result_img_gallery_w_h', 'is_int(VALUE) && VALUE >= 10',
		$invalid_wpit_result_img_gallery_w_h, $wpit_errmsg, __('The maximum image pixel width or height must be an integer greater than 10 (Gallery output format)', 'mediatagger'));

	$wpit_result_default_display_mode = $_POST['wpit_result_default_display_mode'];		// combo choice - no need of error checking
	
	$wpit_result_display_switchable = $_POST['wpit_result_display_switchable'];			// combo choice - no need of error checking

	$wpit_result_display_optimize_xfer = $_POST['wpit_result_display_optimize_xfer'];	// combo choice - no need of error checking

	imgt_get_valid_post_data($wpit_tagcloud_num_tags, 'wpit_tagcloud_num_tags', 'is_int(VALUE) && VALUE >= 0',
		$invalid_wpit_tagcloud_num_tags, $wpit_errmsg, __('The number of tags displayed in the tag cloud must be an integer greater than 0 ; if 0 all the tags are displayed (Search format)', 'mediatagger'));

	$wpit_tagcloud_order = $_POST['wpit_tagcloud_order'];	// combo choice - no need of error checking
	
	imgt_get_valid_post_data($wpit_tagcloud_font_min, 'wpit_tagcloud_font_min', 'is_int(VALUE) && VALUE >= 0',
		$invalid_wpit_tagcloud_font_min, $wpit_errmsg, __('Tag cloud minimum font size must be a positive integer (Search format)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_tagcloud_font_max, 'wpit_tagcloud_font_max', 'is_int(VALUE) && VALUE >= 0',
		$invalid_wpit_tagcloud_font_max, $wpit_errmsg, __('Tag cloud maximum font size must be a positive integer (Search format)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_tagcloud_color_min, 'wpit_tagcloud_color_min', "intval('VALUE') == -1 || check_valid_colorhex('VALUE')",
		$invalid_wpit_tagcloud_color_min, $wpit_errmsg, __('The minimum tagcloud color must be a valid hexadecimal color code as 3ff or a1b160, or -1 for not using dynamic colors (Search format)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_tagcloud_color_max, 'wpit_tagcloud_color_max', "intval('VALUE') == -1 || check_valid_colorhex('VALUE')",
		$invalid_wpit_tagcloud_color_max, $wpit_errmsg, __('The maximum tagcloud color must be a valid hexadecimal color code as 3ff or a1b160, or -1 for not using dynamic colors (Search format)', 'mediatagger'));
	
	if ($wpit_tagcloud_color_min == -1 && $wpit_tagcloud_color_max != -1){
		$wpit_tagcloud_color_max = -1;
		$wpit_errmsg[] = __('Maximum tag cloud color forced to -1 to disable dynamic tag cloud colors (minimum tag cloud color was manually set to -1)', 'mediatagger');
		$invalid_wpit_tagcloud_color_max = 1;
	}
	if ($wpit_tagcloud_color_min != -1 && $wpit_tagcloud_color_max == -1) {
		$wpit_tagcloud_color_min = -1;
		$wpit_errmsg[] = __('Minimum tag cloud color forced to -1 to disable dynamic tag cloud colors (maximum tag cloud color was manually set to -1)', 'mediatagger');
		$invalid_wpit_tagcloud_color_min = 1;
	}
	
	imgt_get_valid_post_data($wpit_tagcloud_highlight_color, 'wpit_tagcloud_highlight_color', "intval('VALUE') == -1 || check_valid_colorhex('VALUE')",
		$invalid_wpit_tagcloud_highlight_color, $wpit_errmsg, __('The tag cloud highlighting font color must be a valid hexadecimal color code as 3ff or a1b160, or -1 for no higlighting effect (Search format)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_gallery_image_border_w, 'wpit_gallery_image_border_w', 'is_int(VALUE) && VALUE >= 0',
		$invalid_wpit_gallery_image_border_w, $wpit_errmsg, __('The image frame pixel width must be an integer greater than 0 (Gallery output format)', 'mediatagger'));	
	
	imgt_get_valid_post_data($wpit_gallery_image_border_color, 'wpit_gallery_image_border_color', "check_valid_colorhex('VALUE')",
		$invalid_wpit_gallery_image_border_color, $wpit_errmsg, __('The image frame color must be a valid hexadecimal color code as 3ff or a1b160 (Gallery output format)',
		'mediatagger'));
	
	$wpit_gallery_image_link_ctrl = $_POST['wpit_gallery_image_link_ctrl'];				// combo choice - no need of error checking
	
	imgt_get_valid_post_data($wpit_gallery_image_num_per_page, 'wpit_gallery_image_num_per_page', 'is_int(VALUE) && VALUE > 0',
		$invalid_wpit_gallery_image_num_per_page, $wpit_errmsg, __('The number of images per page must be positive (Gallery output format)', 'mediatagger'));
	
	imgt_get_valid_post_data($wpit_list_image_num_per_page, 'wpit_list_image_num_per_page', 'is_int(VALUE) && VALUE > 0',
		$invalid_wpit_list_image_num_per_page, $wpit_errmsg, __('The number of images per page must be positive (Image list output format)', 'mediatagger'));

	imgt_get_valid_post_data($wpit_list_title_num_per_page, 'wpit_list_title_num_per_page', 'is_int(VALUE) && VALUE > 0',
		$invalid_wpit_list_title_num_per_page, $wpit_errmsg, __('The number of image titles per page must be positive (Title list output format)', 'mediatagger'));


// Update database with new values
	update_option( 'wpit_admin_media_formats', implode(',', $wpit_admin_media_formats));
	update_option( 'wpit_admin_tags_source', $wpit_admin_tags_source );
	update_option( 'wpit_admin_tags_groups', $wpit_admin_tags_groups);
	update_option( 'wpit_admin_background_color', $wpit_admin_background_color);
	update_option( 'wpit_admin_override_post_taxonomy', $wpit_admin_override_post_taxonomy);
	update_option( 'wpit_admin_credit', $wpit_admin_credit);
	update_option( 'wpit_admin_image_border_w', $wpit_admin_image_border_w );
	update_option( 'wpit_admin_image_border_color', $wpit_admin_image_border_color );
	update_option( 'wpit_admin_num_tags_per_col', $wpit_admin_num_tags_per_col );
	update_option( 'wpit_admin_tags_excluded', $wpit_admin_tags_excluded );
	update_option( 'wpit_admin_img_width_height', $wpit_admin_img_width_height );
	update_option( 'wpit_search_num_tags_per_col', $wpit_search_num_tags_per_col );
	update_option( 'wpit_search_form_font', $wpit_search_form_font );
	update_option( 'wpit_search_tags_excluded', $wpit_search_tags_excluded );
	update_option( 'wpit_search_default_display_mode', $wpit_search_default_display_mode );
	update_option( 'wpit_search_display_switchable', $wpit_search_display_switchable );
	update_option( 'wpit_tagcloud_num_tags', $wpit_tagcloud_num_tags );
	update_option( 'wpit_tagcloud_order', $wpit_tagcloud_order );
	update_option( 'wpit_tagcloud_font_min', $wpit_tagcloud_font_min );
	update_option( 'wpit_tagcloud_font_max', $wpit_tagcloud_font_max );
	update_option( 'wpit_tagcloud_color_min', $wpit_tagcloud_color_min );
	update_option( 'wpit_tagcloud_color_max', $wpit_tagcloud_color_max );
	update_option( 'wpit_tagcloud_highlight_color', $wpit_tagcloud_highlight_color );
	update_option( 'wpit_selector_background_color', $wpit_selector_background_color );
	update_option( 'wpit_gallery_image_border_w', $wpit_gallery_image_border_w );
	update_option( 'wpit_gallery_image_border_color', $wpit_gallery_image_border_color );
	update_option( 'wpit_gallery_image_link_ctrl', $wpit_gallery_image_link_ctrl );
	update_option( 'wpit_gallery_image_num_per_page', $wpit_gallery_image_num_per_page );
	update_option( 'wpit_result_img_list_w_h', $wpit_result_img_list_w_h );
	update_option( 'wpit_result_img_gallery_w_h', $wpit_result_img_gallery_w_h );
	update_option( 'wpit_result_default_display_mode', $wpit_result_default_display_mode );
	update_option( 'wpit_result_display_switchable', $wpit_result_display_switchable );
	update_option( 'wpit_result_display_optimize_xfer', $wpit_result_display_optimize_xfer );
	update_option( 'wpit_list_image_num_per_page', $wpit_list_image_num_per_page );
	update_option( 'wpit_list_title_num_per_page', $wpit_list_title_num_per_page );
}	// end : form submission


if (strlen($_POST['update_tax']) > 0) {		// case : update done on all posts with image taxonomy
	$post_id_list = imgt_get_all_post_id();
	$n_required = 0;
	foreach($post_id_list as $post_id) {
		imgt_update_post_tags($post_id, 1, $updt_required);
		$n_required += $updt_required;
	}
	$wpit_errmsg[] = $n_required . '  ' . _n('post has been updated with the media taxonomy.', 'posts have been updated with the media taxonomy.' , $n_required, 'mediatagger');
}

// Rebuild tag list
imgt_taxonomy_update();

//print_ro($g_imgt_tag_taxonomy);
//$g_imgt_tag_taxonomy = array();		// UNCOMMENT TO SIMULATE NO TAGs
if (!admin_check_taxonomy_not_empty())		// in case no tag is detected in the blog :  exit right now
	exit();

if (0){
	echo "view = " . $_POST['view'] . "<br/>";;
	echo "list_type = " . $_POST['list_type'] . "<br/>";;
	echo "list_img_id = " . $_POST['list_img_id'] . "<br/>";;
	echo "panel_img_id = " . $_POST['panel_img_id'] . "<br/>";;
	echo "display_options = " . ($display_options ? 'true' : 'false') . "<br/>";;
	echo "submit = " . strlen($_POST['Submit']) . "<br/>";
}

// Define if options panel is hidden or displayed
if (!isset($_POST['display_options']))
	$display_options = $wpit_admin_display_options;
else
	$display_options = $_POST['display_options'];
update_option('wpit_admin_display_options', $display_options );	// record setup in DB

// Define view 
if (strlen($_POST['view']) > 0) {	// switch from media tagging panel to list view or reversely
	$view = $_POST['view'];
} else {	// default
	$view = "tagging_view";
}

if ($_POST['list_img_id']>0){		// user clicked on an media title in the admin panel, list mode => switch view to tagging
	$obj_id=$_POST['list_img_id'];
	$view = "tagging_view";
}

// Define list type (used for list view)
if (strlen($_POST['list_type']) > 0)
	$list_type = $_POST['list_type'];
else
	$list_type = "untagged_images";
	
if (strlen(trim($_POST['list_view_search'])) > 0)
	$list_view_search = trim($_POST['list_view_search']);

// Define image offset for list view pagination
if (!$_POST['list_image_start_page'])
	$list_image_start_page = 0;
else
	$list_image_start_page = $_POST['list_image_start_page'];


//
// Then : Process images form data 
//
if ($view == 'tagging_view') {
	$img_list = imgt_get_images('untagged_images', $count, $reason);
	// Retrieve image
	if (!$obj_id) {						// object not selected yet (only way : coming from list view having clicked on an image)
		if (isset($_GET['id'])){		// user clicked on image caption on a post or page
			$obj_id=$_GET['id'];
		} else if ($_POST['panel_img_id'] > 0 && !$media_format_changed){		// user tagged an image
			$obj_id=$_POST['panel_img_id'];
		} else {	// user came to the admin panel straight. In this case select the first available image
			$obj_id = admin_get_current_image($img_list, $reason);
		}
	}
	
	//echo "image selected in tagging panel : " . $obj_id . "<br/>";	// DBG
	
	$print_msg_image_tagged = 0;
	$former_obj_id = 0;
	$img_info = imgt_get_img_info($obj_id);
	$treat_post_tags = $wpit_admin_override_post_taxonomy & (get_post_type($img_info->post_ID) == "post");
	
	if(isset($_POST['set']) || isset($_POST['clear']) || isset($_POST['setandnext'])) {
		$new_tag_list = (isset($_POST['clear']) ? array() : $_POST['tags']);
		// update DB
		imgt_set_image_tags($obj_id, $new_tag_list);
		$image_tagged_with_list = implode(', ', imgt_taxonomy_to_name($new_tag_list));
		$img_list = imgt_get_images('untagged_images', $count, $reason);
		
		if ($treat_post_tags) {	// Update post taxonomy from image taxonomy
			$auto_post_tags = imgt_update_post_tags($img_info->post_ID, 1, $updt_required);
			$print_msg_image_tagged_n2 = sizeof($auto_post_tags);
			$post_tagged_with_list = implode(', ', imgt_taxonomy_to_name($auto_post_tags));
			$processed_post_name = $img_info->post_title;
		}
		
		if (isset($_POST['setandnext'])) {
			// retrieve next image
			$former_obj_id = $obj_id;
			$obj_id = admin_get_current_image($img_list, $reason);
		}
		$print_msg_image_tagged_n = sizeof($new_tag_list);
		$print_msg_image_tagged = ($print_msg_image_tagged_n ? 1 : 2);		// tagged or reset depending on tag count
	} else if(isset($_POST['get'])) {
		// retrieve original values = do nothing
		$print_msg_image_tagged = 3;		// retrieved
	}
} else { 	// image list view
	imgt_get_images('count_images', $count, $reason);
}
?>

<div class="wrap">

<!-- Start by displaying image tagger panel -->
<h2>MediaTagger - <?php ($view == 'tagging_view' ? _e('Tag Editor', 'mediatagger') : _e('Media Explorer', 'mediatagger')) ?> <span style="color:#CCC">(<span title="<?php echo __('Total number of medias', 'mediatagger') . '">' . $count->total . '</span>/<span title="' . __('Number of medias tagged', 'mediatagger') . '">' . $count->tagged . '</span>/<span title="' . __('Number of medias remaining untagged', 'mediatagger') . '">' . $count->untagged ?></span>)</span>&nbsp;&nbsp;<span style="font-size:0.5em">
<?php if ($view == 'tagging_view') { ?>
	<a href="" onClick="post_submit('view', 'list_view');return false"><?php _e('Switch to ', 'mediatagger') ; _e('Media Explorer', 'mediatagger') ?> &raquo;
<?php } else { ?>
	<a href="" onClick="post_submit('view', 'tagging_view');return false">&laquo; <?php _e('Switch to ', 'mediatagger') ; _e('Tag Editor', 'mediatagger') ?></a>
<?php } ?>
</a></span></h2><br/>

<form name="wpit_tagger" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=mediatagger">
<input type="hidden" name="display_options" value="<?php echo $display_options ?>">

<?php if ($view == 'tagging_view') { // ===================================================== Tagging view ===================================================== ?>
<input type="hidden" name="view" value="tagging_view">
<input type="hidden" name="list_type" value="<?php echo $list_type ?>">
<input type="hidden" name="panel_img_id" value="<?php echo $obj_id ?>">

<?php
// Retrieve image information
if ($obj_id) {
	//$untagged_count = sizeof($img_list);
	$img_info = imgt_get_img_info($obj_id);
	$post_type = get_post_type($img_info->post_ID);
	$show_post_tags = $wpit_admin_override_post_taxonomy & ($post_type == "post");
	// print_ro($img_info);
	$img_filename = basename($img_info->url);
	$processed_img_filename = $img_filename;
	if ($former_obj_id) {
		$former_img_info = imgt_get_img_info($former_obj_id);
		$processed_img_filename = basename($former_img_info->url);		
	}
	$img_tags = imgt_get_image_tags($obj_id);
	//print_ro($img_tags);
	
	if ($show_post_tags) {	// Read post taxonomy from image taxonomy
		$auto_post_tags = imgt_get_image_tags_from_post_id($img_info->post_ID);
		$post_tagged_with_list = implode(', ', imgt_taxonomy_to_name($auto_post_tags));
		$processed_post_name = $img_info->post_title;
	}
	
?>

<div style="clear:both;float:left"><a href="<?php echo $img_info->url ?>"><img src="<?php echo $img_info->image ?>"  <?php echo ($img_info->w<$img_info->h ? 'height' : 'width')."=" . $wpit_admin_img_width_height ?>" style="border:<?php echo $wpit_admin_image_border_w ?>px solid #<?php echo $wpit_admin_image_border_color ?>"/></a></div>
<div style="float:left"><p style="padding-left:10px"><i><?php _e('File', 'mediatagger') ?> :</i> <?php echo $img_filename ?><br /><i><?php _e('Description', 'mediatagger') ?> :</i> <?php echo $img_info->title ?><br/><?php if (!empty($post_type)){ ?><i><?php echo ucfirst($post_type) ?> :</i> <a href="<?php echo $img_info->post_URI ?>"><?php echo $img_info->post_title ?></a><?php } else echo '<em>(' . __('Orphean media, not linked to any post', 'mediatagger') . ')</em>' ?><br /><br /><i><?php _e('Media tags', 'mediatagger') ?></i> : 
<?php
if (empty($img_tags))
	_e("None", 'mediatagger');
else {
	foreach($img_tags as $n=>$img_tag)
		echo ($n ? ', ' : '') . $img_tag->name;
}
if ($show_post_tags) {
?>
<p style="width:600px;padding-left:10px"><i><?php _e('Tags post') ?></i> :
<?php
	if (empty($post_tagged_with_list))
		_e("None", 'mediatagger');
	else {
		echo $post_tagged_with_list;
	}
	echo "</p>";
}
?>

</p></p></div><div style="clear:both">&nbsp;</div><br/>


<?php // Display tag form	
	echo print_tag_form($img_tags, 1);
?>
</div>

<div class="submit" style="clear:both;padding:15px 0 10px 0"><input type="submit" value="<?php _e("Set and Next", 'mediatagger') ?> &raquo;" name="setandnext"> <input type="submit" value="<?php _e("Set", 'mediatagger') ?>" name="set"> <input type="submit" value="<?php _e("Get", 'mediatagger') ?>" name="get"> <input type="submit" value="<?php _e("Clear", 'mediatagger') ?>" name="clear"></div>

<?php
	if ($print_msg_image_tagged == 1 || $print_msg_image_tagged == 2) {  ?>
		<div class="updated">
        	<p><?php _e('Media', 'mediatagger') ?> <strong><?php echo $processed_img_filename . '</strong> ' .
			($print_msg_image_tagged_n ? _n('tagged with theme', 'tagged with themes', $print_msg_image_tagged_n, 'mediatagger') . ' <strong>' . $image_tagged_with_list . '</strong>' : __('tags reset', 'mediatagger')) ?>.</p>
          <?php if ($treat_post_tags) { ?>
            <p><?php _e('Post', 'mediatagger') ?> <strong><?php echo $processed_post_name . '</strong> ' . 
			 ($print_msg_image_tagged_n2 ? _n(' tagged with theme', ' tagged with themes', $print_msg_image_tagged_n2, 'mediatagger') . ' <strong>' . $post_tagged_with_list . '</strong>' : __('tags reset', 'mediatagger')) ?>.</p>
          <?php } ?>
        </div>
	<?php } else if ($print_msg_image_tagged == 3) { ?>
		<div class="updated">
        	<p><?php _e('Media', 'mediatagger') ?> <strong><?php echo $processed_img_filename . '</strong> : ' . __('media tags read from database.', 'mediatagger') ?></p>
          <?php if ($treat_post_tags) { ?>
        	<p><?php _e('Post', 'mediatagger') ?> <strong><?php echo $processed_post_name . '</strong> : ' . __('media tags read from database.', 'mediatagger') ?></p>
          <?php } ?>
        </div>
	<?php }
	} // end if ($obj_id) ?>
</form>
<?php } // end display tagging panel ?>


<?php if ($view == 'list_view') { // ===================================================== List view ===================================================== 
	$num_img_per_page = 100;
	$img_list = imgt_match_keyword($list_type, $list_view_search);
	//print_ro($img_list);
	$num_img = count($img_list);
	$start_img_num = $list_image_start_page;
	$stop_img_num = $start_img_num + $num_img_per_page;
	if ($stop_img_num > $num_img)
		$stop_img_num = $num_img;
	$start_previous = $list_image_start_page - $num_img_per_page;
	$start_next = $list_image_start_page + $num_img_per_page;
	if (strlen($keyword) > 0  && !$num_img )
		echo '<div class="updated"><strong><p><i>' . __("No media matching this search.", "mediatagger") . '</p></strong></div>';	
?>
<input type="hidden" name="view" value="list_view">
<input type="hidden" name="list_type" value="<?php echo $list_type ?>">
<input type="hidden" name="list_image_start_page" value="">
<input type="hidden" name="list_img_id" value="">

<p style="padding:0px 0px 20px 0px;margin:0;font-size:0.9em"><em><?php _e('Displaying medias', 'mediatagger') ?> :</em> <?php echo ($list_type != 'tagged_images' ? '<a href="" title="' . __('Display tagged medias', 'mediatagger') . '" onClick="post_submit(' . "'list_type', 'tagged_images');return false" . '">' : '') . __('tagged', 'mediatagger') .  ($list_type != 'tagged_images' ? '</a>' : '') . '&nbsp; ' . ($list_type != 'untagged_images' ? '<a href="" title="' . __('Display untagged medias', 'mediatagger') . '" onClick="post_submit(' . "'list_type', 'untagged_images');return false" . '">' : '') . __('untagged', 'mediatagger') . ($list_type != 'utagged_images' ? '</a>' : '') . '&nbsp; ' . ($list_type != 'all_images' ? '<a href="" title="' . __('Display all medias', 'mediatagger') . '" onClick="post_submit(' . "'list_type', 'all_images');return false" . '">' : '') . __('all', 'mediatagger') . ($list_type != 'all_images' ? '</a>' : '') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="list_view_search" value="<? echo $list_view_search ?>" size="40" title="<?php _e('The search currently supports single keyword pattern - Search will be done on media title and hosting post or page title', 'mediatagger') ?>"></p>

<?php
	if ($num_img > $num_img_per_page) { 	// display pagination
		$paginate_image_list = '<em>' . __('Medias', 'mediatagger') . ' ' . (int)($start_img_num+1) . ' ' . __('to', 'mediatagger') . ' ' . $stop_img_num . ' / ' . $num_img . '</em>&nbsp;&nbsp;&nbsp;' . ($list_image_start_page >= $num_img_per_page ? '<a href="" onClick="post_submit(' . "'list_image_start_page', '" . $start_previous . "');return false" . '">' : '') . '< ' . __('Previous', 'mediatagger') . ($list_image_start_page >= $num_img_per_page ? '</a>' : '') . '&nbsp;&nbsp;' . ($stop_img_num < $num_img ? '<a href="" onClick="post_submit(' . "'list_image_start_page', '" . $start_next . "');return false" . '">' : '') . __('Next', 'mediatagger') . ' >' . ($stop_img_num < $num_img ? '</a>' : '');
		echo '<p style="padding:0;margin:0 0 20px 0">' . $paginate_image_list . '</p>';
	}

	for($i = $start_img_num; $i < $stop_img_num; $i++) {
		$img_id = $img_list[$i];
		$img_info = imgt_get_img_info($img_id);
		$img_tags = imgt_get_image_tags($img_id);
		//echo $img_id;
		//print_ro($img_info);
		//print_ro($img_tags);
		$bckcol = ($i % 2 ? "ffffff" : "f0f0f0");
		echo '<div style="clear:both;background-color:#' .  $bckcol . '"><p style="clear:both;float:left;width:500px;margin:0;padding:0">' . 
		($img_info->post_ID < 0 ? '<em>(' . __('Orphean media, not linked to any post', 'mediatagger') . ')</em>' : '<a href="'. $img_info->post_URI . '" title="'  . 
		__('Go to page', 'mediatagger') . '" style="color:#889">' . $img_info->post_title . '</a>') . ' : <a href="" title="' . __('Tag media', 'mediatagger') . " " .
		$img_id . '" onClick="post_submit(' . "'" . 'list_img_id' . "'" . ",'" . $img_id . "'" . ');return false">' . $img_info->title . '</a></p><p style="margin:0;padding:0">';
		foreach($img_tags as $key=>$img_tag) {
			if ($key) echo ", ";
			echo $img_tag->name; 
		}
		if (!count($img_tags))
			echo "&nbsp;";
		echo '</p></div>';
	}
	
	if ($num_img > $num_img_per_page)	// display pagination
		echo '<p style="clear:both;margin:0;padding:20px 0 30px 0">' . $paginate_image_list . '</p>';

?>

</form>

<?php } // End list view ?>


<hr />



<!-- Then display the option form  ======================================================================================================= -->
<form name="wpit_options" method="post" action="">
<input type="hidden" name="view" value="<?php echo $view?>">
<input type="hidden" name="list_type" value="<?php echo $list_type ?>">
<input type="hidden" name="display_options" value="<?php echo $display_options ?>">
<input type="hidden" name="panel_img_id" value="<?php echo $obj_id ?>">
<input type="hidden" name="preview" value="">
<input type="hidden" name="checkpdf" value="">
<input type="hidden" name="audit" value="">
<input type="hidden" name="fix_post_revisions" value="">
<input type="hidden" name="fix_post_attachements" value="">
<input type="hidden" name="fix_post_taxonomy" value="">
<input type="hidden" name="fix_image_taxonomy" value="">

<h2><?php _e('MediaTagger Options', 'mediatagger') ?> 
<?php if (!$_POST['preview']) { ?>
&nbsp;<span style="font-size:0.5em"><a href="" onClick="options_submit('display_options', '<?php echo !$display_options ?>');return false"><?php echo ($display_options ? '&laquo; ' . __('Hide', 'mediatagger') : __('Show', 'mediatagger')) . ' ' . __('options setup panel', 'mediatagger') . ($display_options ? '' : ' &raquo;') ?></a></span>
<?php } ?>
</h2>


<?php	
if ($display_options && !$_POST['preview'] && !$_POST['checkpdf'] && !$_POST['audit'] && !$_POST['fix_post_revisions'] && !$_POST['fix_post_attachements'] && 
		!$_POST['fix_post_taxonomy'] && !$_POST['fix_image_taxonomy']) {
?>
<?php
// Print acknowledge message
if ( strlen($_POST[ 'Submit' ]) > 0  || strlen($_POST['update_tax']) > 0 ) { ?>
	<div class="updated" style="margin-bottom:10px"><strong> 
<?php
	if (strlen($_POST[ 'Submit' ]) > 0) {
		if (!empty($wpit_errmsg)) {
			foreach ($wpit_errmsg as $errmsg) {
				echo '<p>' . $errmsg . '</p>';
			}
			echo '<p style="padding-top:7px">&raquo; ' ; printf(_n("Invalid value restored to the last correct setting.", "Invalid values restored to the last correct settings.",
				sizeof($wpit_errmsg), 'mediatagger')); echo '</p>';
	  	} else { ?>
	<p><?php _e('Options saved.', 'mediatagger') ?></p> 
	<?php }
	} else if (strlen($_POST['update_tax']) > 0) {
		foreach ($wpit_errmsg as $errmsg) {
			echo '<p>' . $errmsg . '</p>';
		}
	} ?>
</strong></div>
<?php } ?>


<strong><?php _e("General", 'mediatagger'); ?></strong><br/>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_media_formats, $h_on, $h_off);
echo $h_on ; _e("File formats for tagging", 'mediatagger' ); echo $h_off; ?></p>
<?php echo get_supported_formats_checkbox_string($wpit_admin_media_formats); ?>
<p class="legend"><?php _e('This defines the set of files available for tagging (admin) and searching (visitors)', 'mediatagger')?></p>

<p class="label"><?php _e("Tagging source", 'mediatagger' ); ?></p>
<select name="wpit_admin_tags_source">
<option value="1" <?php echo ($wpit_admin_tags_source == 1 ? "selected" : "") . '>'; _e("Tags", 'mediatagger') ?>&nbsp;</option>
<option value="3" <?php echo ($wpit_admin_tags_source == 3 ? "selected" : "") . '>'; _e("Categories", 'mediatagger') ?>&nbsp;</option>
<option value="2" <?php echo ($wpit_admin_tags_source == 2 ? "selected" : "") . '>'; _e("Tags and categories", 'mediatagger') ?>&nbsp;</option></select>
<p class="legend"><?php _e('You can tag medias either with your blog tags, with your categories, or with your tags and categories merged together', 'mediatagger')?></p>

<div style="float:left"><p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_tags_groups, $h_on, $h_off);
echo $h_on ; _e("Tags groups", 'mediatagger'); echo $h_off; ?>
<p class="legend" style="width:350px"><?php _e('Optional : you can regroup the above tags by groups so that those tags are displayed by groups. This applies to the tagging panel form as well as to the search form. If you do not need to categorize your tags, keep this field empty. Otherwise, use the following CSV syntax, one group definition per line : ', 'mediatagger')?><br /><span style="font-style:normal">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('my_group1_name', 'mediatagger')?>=tag1,tag2,tag5,tag7, ... ,tag n <br />&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('my_group2_name', 'mediatagger')?>=tag3,tag4,tag6, ... , tag m<br/>&nbsp;&nbsp;&nbsp;&nbsp;...</span><br/><?php _e('Spaces do not matter - The tags not listed in these groups will be listed at the end in the default category. Optionnally, you can name this default category by adding as last line', 'mediatagger') ?> :<br/><span style="font-style:normal">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('my_default_group_name', 'mediatagger')?>=</span> <?php _e('(do not add anything after "=")', 'mediatagger')?><br/><?php _e('By default the tags are disposed by column automatically ; you can override this rule by leaving a blank line before the group you want to start to the next column.', 'mediatagger') ?></p></div><div><textarea name="wpit_admin_tags_groups" cols="70" rows="11"><?php echo stripslashes($wpit_admin_tags_groups); ?></textarea></div>

<div style="clear:both"><p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_background_color, $h_on, $h_off);
echo $h_on ; _e("Fields background color", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_admin_background_color" value="<?php echo $wpit_admin_background_color; ?>" size="8">
<p class="legend"><?php _e('This color is used for the fields background in the tagging panel and search form', 'mediatagger')?></p></div><br/>



<strong><?php _e("Media taxonomy", 'mediatagger'); ?></strong><br/>

<p class="label"><?php _e("Override original post taxonomy with media taxonomy", 'mediatagger' ); ?></p>
<select name="wpit_admin_override_post_taxonomy">
<option value="1" <?php echo ($wpit_admin_override_post_taxonomy==1 ? "selected" : "") . '>'; _e("Yes", 'mediatagger') ?>&nbsp;</option>
<option value="0" <?php echo ($wpit_admin_override_post_taxonomy==0 ? "selected" : "") . '>'; _e("No", 'mediatagger') ?>&nbsp;</option></select>
<p class="legend"><span style="color:#00F"><strong>- <?php _e("Carefully read this note", 'mediatagger'); ?> -</strong></span><br/>
<?php _e('This option allows to let the media taxonomy defined with MediaTagger supersede the post taxonomy provided as standard by WordPress', 'mediatagger') ?>.<br/>
<?php _e("If you activate this feature : every time you tag a media from the MediaTagger editor", 'mediatagger') ?>,<br/>
<?php _e("the post containing this media will be associated to the tag list formed from a logical OR between all the tags set on the medias contained in the post", 'mediatagger') ?>.<br/>
<?php _e("Any former tag manually set on the post will be lost and supersed by this logical media taxonomy combination", 'mediatagger') ?>.<br/>
<strong><?php _e("For that reason you should backup your WordPress database before the first activation of this feature", 'mediatagger') ?></strong>.</p>

<?php if ($wpit_admin_override_post_taxonomy) { ?>
    <p class="label"><?php _e("Preview the Media Taxonomy scheme", 'mediatagger' ); ?></p>
    <p style="margin:2px 0 0 0;padding:0"><a href="" onClick="options_submit('preview','1');return false;"><?php _e('Preview', 'mediatagger')?></a></p>
    <p class="legend"><?php _e('This preview function lets you evaluate what would the media taxonomy be compared to your current posts tagging', 'mediatagger') ?>.<br/>
    <?php _e('After clicking this link you will be directed to the preview page. From this page you will then have the choice to run an automatic retagging batch', 'mediatagger') ?>.</p><br/>
<?php }  else echo '<br/>';  ?>



<strong><?php _e("Tag Editor", 'mediatagger'); ?></strong><br/>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_tags_excluded, $h_on, $h_off);
echo $h_on ; _e("Tagging excluded tags", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_admin_tags_excluded" value="<?php echo $wpit_admin_tags_excluded; ?>" size="60">
<p class="legend"><?php _e('List of comma separated tag names defined in your blog and that will not appear in the Tag Editor above', 'mediatagger')?></p>
 
<p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_num_tags_per_col, $h_on, $h_off);
echo $h_on ; _e("Number of tags displayed per column", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_admin_num_tags_per_col" value="<?php echo $wpit_admin_num_tags_per_col; ?>" size="4" <?php echo (imgt_detect_form_column_breaks() ? 'readonly' : ''); ?> >
<p class="legend"><?php _e('Set this number to have a convenient columnar display of your tags in the Tag Editor above, properly spread over the above available horizontal space', 'mediatagger')?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_img_width_height, $h_on, $h_off);
echo $h_on ; _e("Maximum image pixel width or height", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_admin_img_width_height" value="<?php echo $wpit_admin_img_width_height; ?>" size="4">
<p class="legend"><?php _e('Used to scale the images displayed on the Tag Editor above. The largest of the (width, height) will be scaled to this number', 'mediatagger')?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_image_border_w, $h_on, $h_off);
echo $h_on ; _e("Image frame pixel width", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_admin_image_border_w" value="<?php echo $wpit_admin_image_border_w; ?>" size="4">
<p class="legend"><?php _e('This parameter sets the image border width', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_admin_image_border_color, $h_on, $h_off);
echo $h_on ; _e("Image frame color in hex format", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_admin_image_border_color" value="<?php echo $wpit_admin_image_border_color; ?>" size="8"><br/><br/>



<strong><?php _e("Search format", 'mediatagger'); ?></strong><br/>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_search_tags_excluded, $h_on, $h_off);
echo $h_on ; _e("Search excluded tags", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_search_tags_excluded" value="<?php echo $wpit_search_tags_excluded; ?>" size="60">
<p class="legend"><?php _e('List of comma separated tag names defined in your blog and that will not appear in the list of searchable tags', 'mediatagger')?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_search_default_display_mode, $h_on, $h_off);
echo $h_on ; _e("Default search display mode", 'mediatagger' ); ?></p>
<input type="checkbox" value=cloud name=wpit_search_default_display_mode[] <?php echo (wpmt_is_search_mode("cloud", $wpit_search_default_display_mode) ? "checked" : "") ?> > <?php _e("Tag cloud", 'mediatagger'); ?> &nbsp;
<input type="checkbox" value=form name=wpit_search_default_display_mode[] <?php echo (wpmt_is_search_mode("form", $wpit_search_default_display_mode) ? "checked" : "") ?> > <?php _e("Tag form", 'mediatagger'); ?> &nbsp;
<input type="checkbox" value=field name=wpit_search_default_display_mode[] <?php echo (wpmt_is_search_mode("field", $wpit_search_default_display_mode) ? "checked" : "") ?> > <?php _e("Search field", 'mediatagger'); ?>
<p class="legend"><?php _e('Tag cloud is more compact but does not allow the multi-criteria search provided by the check boxes form.', 'mediatagger')?><br/>
<?php _e('The combined mode permits to refine the initial search done with the cloud thanks to the form.', 'mediatagger') ?></p>

<p class="label"><?php _e("Visitors can switch between available search formats", 'mediatagger' ); ?></p>
<select name="wpit_search_display_switchable">
<option value="1" <?php echo ($wpit_search_display_switchable==1 ? "selected" : "") . '>'; _e("Yes", 'mediatagger') ?>&nbsp;</option>
<option value="0" <?php echo ($wpit_search_display_switchable==0 ? "selected" : "") . '>'; _e("No", 'mediatagger') ?>&nbsp;</option></select>
<p class="legend"><?php _e('If "yes" is selected, the result page allows the user to dynamically select the most appropriate search format', 'mediatagger') ?>.<br/>
<?php _e("Otherwise, format is fixed to default display style set above - Javascript must be enabled in the navigator to use this capability", 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_search_num_tags_per_col, $h_on, $h_off);
echo $h_on ; _e("Number of tags displayed per column in form mode", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_search_num_tags_per_col" value="<?php echo $wpit_search_num_tags_per_col; ?>" size="4" <?php echo (imgt_detect_form_column_breaks() ? 'readonly' : ''); ?> '>'
<p class="legend"><?php _e('Set this number to have a convenient columnar display of your tags in the search section, properly spread over the available horizontal space', 'mediatagger')?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_search_form_font, $h_on, $h_off);
echo $h_on ; _e("Search form font size (pt)", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_search_form_font" value="<?php echo $wpit_search_form_font; ?>" size="4">
<p class="legend"><?php _e('Font size to be used for the search form made of check boxes and tags', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_tagcloud_num_tags, $h_on, $h_off);
echo $h_on ; _e("Number of tags displayed in the tag cloud", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_tagcloud_num_tags" value="<?php echo $wpit_tagcloud_num_tags; ?>" size="4">
<p class="legend"><?php _e('Number of tags selected among the highest ranked displayed in the tag cloud ; put 0 to get all the tags', 'mediatagger') ?></p>

<p class="label"><?php _e("Tag cloud order", 'mediatagger' ); ?></p>
<select name="wpit_tagcloud_order">
<option value="0" <?php echo ($wpit_tagcloud_order==0 ? "selected" : "") . '>'; _e("Alphabetical", 'mediatagger') ?>&nbsp;</option>
<option value="1" <?php echo ($wpit_tagcloud_order==1 ? "selected" : "") . '>'; _e("Rank", 'mediatagger') ?>&nbsp;</option>
<option value="2" <?php echo ($wpit_tagcloud_order==2 ? "selected" : "") . '>'; _e("Random", 'mediatagger') ?>&nbsp;</option></select>
<p class="legend"><?php _e('Select the appropriate option to have the tags ordered aphabetically, by occurence or randomly, depending on your application', 'mediatagger') ?>.<br/>
<?php _e('Note that this ordering is applied after having selected the highest ranking tags according to the parameter just above', 'mediatagger') ?>.</p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_tagcloud_font_min, $h_on, $h_off);
echo $h_on ; _e("Tag cloud minimum font size (pt)", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_tagcloud_font_min" value="<?php echo $wpit_tagcloud_font_min; ?>" size="4">
<p class="legend"><?php _e('This parameter sets the font size for the least used tag', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_tagcloud_font_max, $h_on, $h_off);
echo $h_on ; _e("Tag cloud maximum font size (pt)", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_tagcloud_font_max" value="<?php echo $wpit_tagcloud_font_max; ?>" size="4">
<p class="legend"><?php _e('This parameter sets the font size for the most used tag', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_tagcloud_color_min, $h_on, $h_off);
echo $h_on ; _e("Minimum tag cloud color in hex format", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_tagcloud_color_min" value="<?php echo $wpit_tagcloud_color_min; ?>" size="8">
<p class="legend"><?php _e('Tag cloud dynamic colors : this font color will be used for the tags with the lowest use. Set to -1 to not use dynamic colors', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_tagcloud_color_max, $h_on, $h_off);
echo $h_on ; _e("Maximum tag cloud color in hex format", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_tagcloud_color_max" value="<?php echo $wpit_tagcloud_color_max; ?>" size="8">
<p class="legend"><?php _e('Tag cloud dynamic colors : this font color will be used for the tags with the highest use. Set to -1 to not use dynamic colors', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_tagcloud_highlight_color, $h_on, $h_off);
echo $h_on ; _e("Tag cloud highlighting font color in hex format", 'mediatagger'); echo $h_off; ?></p>
<input type="text" name="wpit_tagcloud_highlight_color" value="<?php echo $wpit_tagcloud_highlight_color; ?>" size="8">
<p class="legend"><?php _e('This font color is used to highlight the tags selected for a search ; used also for the tag cloud hover effect when dynamic colors are used for the tag cloud', 'mediatagger') ?>.<br/>
<?php _e('Set to -1 if you don\'t want hover effect in your tag cloud with dynamic colors and if you don\'t want to highlight the selected tag', 'mediatagger') ?></p><br/>



<strong><?php _e("Output format", 'mediatagger' ); ?></strong><br/>

<p class="label"><?php _e("Default result display mode", 'mediatagger' ); ?></p>
<select name="wpit_result_default_display_mode">
<option value="1" <?php echo ($wpit_result_default_display_mode == 1 ? "selected" : "") . '>'; _e("Image gallery", 'mediatagger') ?>&nbsp;</option>
<option value="2" <?php echo ($wpit_result_default_display_mode == 2 ? "selected" : "") . '>'; _e("Image list", 'mediatagger') ?>&nbsp;</option>
<option value="3" <?php echo ($wpit_result_default_display_mode == 3 ? "selected" : "") . '>'; _e("Title list", 'mediatagger') ?>&nbsp;</option></select>
<p class="legend"><?php _e('Select gallery style for a condensed graphical output, title list for pure text.', 'mediatagger')?><br/>
<?php _e('Images will be scaled in both cases using maximum image pixel width or height specified below', 'mediatagger') ?></p>

<p class="label"><?php _e("Visitors can switch between available output formats", 'mediatagger' ); ?></p>
<select name="wpit_result_display_switchable">
<option value="1" <?php echo ($wpit_result_display_switchable==1 ? "selected" : "") . '>'; _e("Yes", 'mediatagger') ?>&nbsp;</option>
<option value="0" <?php echo ($wpit_result_display_switchable==0 ? "selected" : "") . '>'; _e("No", 'mediatagger') ?>&nbsp;</option></select><br/>
<p class="legend"><?php _e('If "yes" is selected, the result page allows the user to dynamically select the most appropriate output format', 'mediatagger') ?>.<br/>
<?php _e("Otherwise, format is fixed to default output style set above - Javascript must be enabled in the navigator to use this capability", 'mediatagger') ?></p>

<p class="label"><?php _e("Optimize thumbnail transfer", 'mediatagger'); ?></p>
<select name="wpit_result_display_optimize_xfer" <?php echo ($gd_version ? '' : 'disabled') ?>>
<option value="1" <?php echo ($wpit_result_display_optimize_xfer ? "selected" : "") . '>'; _e("Yes", 'mediatagger') ?>&nbsp;</option>
<option value="0" <?php echo (!$wpit_result_display_optimize_xfer ? "selected" : "") . '>'; _e("No", 'mediatagger') ?>&nbsp;</option></select><br/>
<p class="legend"><?php _e('If "Yes" is selected, the GD graphic library will be used server side to resize the images to the exact dimension used for displaying in the client browser', 'mediatagger') ?>.<br/>
<?php _e("Otherwise, the images will be transferred in full format and directly resized in the browser", 'mediatagger') ?>.<br/>
<strong><?php _e("For given server configurations, this optimization does not produce the expected result", 'mediatagger') ?>.</strong><br/>
<?php _e("When activating this option, check on your search page that the result gallery or image list is displayed correctly", 'mediatagger') ?>.<br/>
<?php _e("If not, disable this option as proposed by default", 'mediatagger') ?>.<br/>
<?php _e("This option is selectable only if the GD library is detected on the server (check in the footnote below)", 'mediatagger') ?>.</p><br/>

<strong><?php _e("Gallery output format", 'mediatagger' ); ?></strong><br/>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_gallery_image_num_per_page, $h_on, $h_off);
echo $h_on ; _e("Number of images per gallery page ", 'mediatagger' ); echo $h_off; ?></p>
<input type="text" name="wpit_gallery_image_num_per_page" value="<?php echo $wpit_gallery_image_num_per_page; ?>" size="4">
<p class="legend"><?php _e('Number of images to be listed on the search result page in case the display format is set to "Gallery"', 'mediatagger') ?></p>

<p class="label"><?php _e("Link on the gallery thumbnails points to ", 'mediatagger' ); ?></p>
<select name="wpit_gallery_image_link_ctrl">
<option value="1" <?php echo ($wpit_gallery_image_link_ctrl==1 ? "selected" : "") . '>'; _e('Plain size image', 'mediatagger') ?>&nbsp;</option>
<option value="2" <?php echo ($wpit_gallery_image_link_ctrl==2 ? "selected" : "") . '>'; _e('Post containing the image', 'mediatagger') ?>&nbsp;</option></select>
<p class="legend"><?php _e('Select "Plain size image" to link the gallery thumbnails to the full size image', 'mediatagger') ?>.<br/>
<?php _e('Otherwise the thumbnails will be linked to the post where the image was posted', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_result_img_gallery_w_h, $h_on, $h_off);
echo $h_on ; _e("Maximum image pixel width or height ", 'mediatagger' ); echo $h_off; ?></p>
<input type="text" name="wpit_result_img_gallery_w_h" value="<?php echo $wpit_result_img_gallery_w_h; ?>" size="4">
<p class="legend"><?php _e('Used to scale the images displayed in gallery display mode on the Image Tag Search Result Page. The largest of the (width, height) will be scaled to this number', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_gallery_image_border_w, $h_on, $h_off);
echo $h_on ; _e("Image frame pixel width ", 'mediatagger' ); echo $h_off; ?></p>
<input type="text" name="wpit_gallery_image_border_w" value="<?php echo $wpit_gallery_image_border_w; ?>" size="4">
<p class="legend"><?php _e('Image border width used for the gallery display style. If border is set to 0, images are displayed border to border', 'mediatagger') ?>.<br/><?php _e('In case an image framing plugin or theme is activated, this setting will be likely superseded by the specific framing theme or plugin', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_gallery_image_border_color, $h_on, $h_off);
echo $h_on ; _e("Image border color in hex format ", 'mediatagger' ); echo $h_off; ?></p>
<input type="text" name="wpit_gallery_image_border_color" value="<?php echo $wpit_gallery_image_border_color; ?>" size="8">
<p class="legend"><?php _e('Image border color used to frame each gallery image. This parameter is significant only if the image border set above is greater than 0', 'mediatagger') ?>.<br/><?php _e('In case an image framing plugin or theme is activated, this setting will be likely superseded by the specific framing theme or plugin', 'mediatagger') ?></p><br/>



<strong><?php _e("Image list output format", 'mediatagger' ); ?></strong><br/>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_list_image_num_per_page, $h_on, $h_off);
echo $h_on ; _e("Number of images per list page ", 'mediatagger' ); echo $h_off; ?></p>
<input type="text" name="wpit_list_image_num_per_page" value="<?php echo $wpit_list_image_num_per_page; ?>" size="4">
<p class="legend"><?php _e('Number of images to be listed on the search result page in case the display format is set to "Image list"', 'mediatagger') ?></p>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_result_img_list_w_h, $h_on, $h_off);
echo $h_on ; _e("Maximum image pixel width or height ", 'mediatagger' ); echo $h_off; ?></p>
<input type="text" name="wpit_result_img_list_w_h" value="<?php echo $wpit_result_img_list_w_h; ?>" size="4">
<p class="legend"><?php _e('Used to scale the images displayed in itemized display mode on the Image Tag Search Result Page. The largest of the (width, height) will be scaled to this number', 'mediatagger') ?></p><br/>



<strong><?php _e("Title list output format", 'mediatagger' ); ?></strong><br/>

<p class="label"><?php imgt_get_error_highlight($invalid_wpit_list_title_num_per_page, $h_on, $h_off);
echo $h_on ; _e("Number of image titles per list page ", 'mediatagger' ); echo $h_off; ?></p>
<input type="text" name="wpit_list_title_num_per_page" value="<?php echo $wpit_list_title_num_per_page; ?>" size="4">
<p class="legend"><?php _e('Number of image titles to be listed on the search result page in case the display format is set to "Title list"', 'mediatagger') ?></p><br/>



<strong><?php _e("Misceallenous", 'mediatagger' ); ?></strong><br/>


<p class="label"><?php _e("Audit database integrity", 'mediatagger' ); ?></p>
<p style="margin:2px 0 0 0;padding:0"><a href="" onClick="options_submit('audit','1');return false;"><?php _e('Audit', 'mediatagger')?></a></p>
<p class="legend"><?php _e('This preview function lets you evaluate the inconsistencies detected in your WordPress database', 'mediatagger') ?>.<br/>
<?php _e('After clicking this link you will be directed to the preview page. From this page you will then have the choice to run automatic cleanup batches', 'mediatagger') ?>.<br/>
<?php _e('This function involves heavy SQL computation. Depending on your hosting plan, this checker can be aborted if you exceed the maximum number of SQL queries allowed in your plan', 'mediatagger') ?>.</p>

<p class="label"><?php _e("Display credit line", 'mediatagger' ); ?></p>
<input type="checkbox" name="wpit_admin_credit" value="1" <?php echo ($wpit_admin_credit ? "checked=\"checked\"" : "") ?> >
<p class="legend"><?php _e('A possibility is offered to not display the very tiny MediaTagger credit line shown below the search form in plain format (not in widget)', 'mediatagger')?>.<br/>
<?php _e('Anyhow, be aware of the very significative work that was required to develop this plugin to push it to what you can enjoy today', 'mediatagger')?>.<br/>
<?php _e('If you decide not to show this line and assuming you like this plugin, I let to your good willingness the possibility to include anywhere else on your site', 'mediatagger')?><br/>
<?php _e('a credit line linking back to my home site (http://www.photos-dauphine.com)', 'mediatagger')?>.</p>


<div class="submit" style="padding-top:5px"><input type="submit" name="Submit" value="<?php _e('Update Options', 'mediatagger' ) ?> &raquo;" /></div>

<? } // end if ($display_options) 
else if ($_POST['preview']) {

echo "<br/>" . __('Review below the results you would get by applying the media taxonomy to your posts', 'mediatagger') . ' ;<br/>';
echo __('Only the posts showing discrepancies between original post tagging and media taxonomy are listed', 'mediatagger') . ' ;<br/>';
echo __('If you agree with the tagging scheme modification, click the Update button below', 'mediatagger') . ' ;<br/>';
echo __('The update process will modify the posts taxonomy and therefore your WordPress database', 'mediatagger') . ' ;  <br/>';
echo '<span style="color:#00F"><em>' . __('For this reason it is recommended to backup your database before to be able to revert to the original setup if needed', 'mediatagger') . '</span></em>.<br/><br/>';

$post_id_list = imgt_get_all_post_id();
$n_required = 0;

foreach($post_id_list as $post_id) {
	imgt_update_post_tags($post_id, 0, $updt_required);
	$n_required += $updt_required;
}

if ($n_required) {
	echo '<br/>' . $n_required . '  ' . _n('post needs to have its taxonomy updated.', 'posts need to have their taxonomy updated.' , $n_required, 'mediatagger');
?>

<div class="submit" style="padding-top:15px"><input type="submit" name="update_tax" value="<?php _e('Update posts tags using media taxonomy', 'mediatagger' ) ?> &raquo;" /> <input type="submit" name="Cancel" value="<?php _e('Cancel', 'mediatagger' ) ?>" /></div>

<?php
} else {
	_e('No update is required, the post taxonomy is already aligned on the media taxonomy.', 'mediatagger');
?>

<div class="submit" style="padding-top:15px"><input type="submit" name="no_update_required" value="<?php _e('OK', 'mediatagger' ) ?>" /></div>

<?php	
	}
}	// end image taxonomy preview
else if ($_POST['checkpdf']){	// check pdf conversion
	imgt_check_pdf_converter(1, 1);			// args : force check, verbose
	echo '<input type="submit" name="return" value="' . __('Return', 'mediatagger' ) .  ' ">';
}	// end pdf conversion check
else if ($_POST['audit'] || $_POST['fix_post_revisions'] || $_POST['fix_post_attachements'] || $_POST['fix_post_taxonomy'] || $_POST['fix_image_taxonomy']) {
	if ($_POST['fix_post_revisions'])
		imgt_database_fix_post_revisions($_POST['fix_revisions_liststr']);
	if ($_POST['fix_post_attachements'])
		imgt_database_fix_post_attachments($_POST['fix_attachments_liststr']);
	if ($_POST['fix_post_taxonomy'])
		imgt_database_fix_post_taxonomy($_POST['fix_posttax_liststr']);
	if ($_POST['fix_image_taxonomy'])
		imgt_database_fix_image_taxonomy($_POST['fix_imgtax_liststr']);
	
	imgt_database_audit($fix_revisions_liststr, $fix_attachments_liststr, $fix_posttax_liststr, $fix_imgtax_liststr, $_POST['audit'])
?>
<input type="hidden" name="fix_revisions_liststr" value="<?php echo $fix_revisions_liststr ?>">
<input type="hidden" name="fix_attachments_liststr" value="<?php echo $fix_attachments_liststr ?>">
<input type="hidden" name="fix_posttax_liststr" value="<?php echo $fix_posttax_liststr ?>">
<input type="hidden" name="fix_imgtax_liststr" value="<?php echo $fix_imgtax_liststr ?>">

<div class="submit" style="padding-top:15px">
<input type="submit" name="fix_post_revisions" value="1 - <?php _e('Clean post revisions', 'mediatagger' ) ?>" /> 
<input type="submit" name="fix_post_attachements" value="2 - <?php _e('Clean post attachments', 'mediatagger' ) ?>" /> 
<input type="submit" name="fix_post_taxonomy" value="3 - <?php _e('Clean post taxonomy', 'mediatagger' ) ?>" /> 
<input type="submit" name="fix_image_taxonomy" value="4 - <?php _e('Clean media taxonomy', 'mediatagger' ) ?>" /> &nbsp;&nbsp;&nbsp;
<input type="submit" name="return" value="<?php _e('Return', 'mediatagger' ) ?>" /></div>


<?php
}	// end audit
?>

</form>

<hr />
<p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="padding-right:10px; float:left">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="WY6KNNHATBS5Q">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>

</form>

<?php echo __('If you found this plugin useful for your site, you are free to make a donation for supporting the development and maintenance.', 'mediatagger') . '<br/>'. __('Remind that even small donations matter and are encouraging !', 'mediatagger' ) ?>
</p>

<hr />
<p style="padding:0;margin-top:-5px;font-size:0.8em"><em><?php echo ' <a href="http://www.photos-dauphine.com/wp-mediatagger-plugin" title="WordPress MediaTagger Plugin Home">WP MediaTagger</a> ' . $WPIT_SELF_VERSION . ' | ' ; echo 'PHP ' . phpversion() .  ' | MySQL ' . mysql_get_server_info() . ' | GD Lib ' . ( $gd_version ? $gd_version : __('not available','mediatagger') ) ;?></em></p>

</div>

