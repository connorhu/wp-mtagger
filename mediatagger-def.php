<?php	// WP Mediatagger messages definition file

	$t = new stdClass;
	
	///////////////////////////////////////////////////////////////////////////////////////
	//
	// Messages and text constants
	//
	//
	
	$t-> activation = "Activation";
	$t-> table_detected_not_created = "Taxonomy table detected in database - not created";
	$t-> table_detected_converted = "Taxonomy table detected in database - converted.";
	$t-> table_not_detected_created = "Taxonomy table not detected in database - created";
	$t-> loading = "Loading";
	$t-> plugin_options_detected_serial = "Plugin options detected in database in <b>serialized</b> format - RELOADED successfully.";
	$t-> plugin_options_detected_itemized = "Plugin options detected in database in <b>itemized</b> format - RELOADED and SERIALIZED successfully.";
	$t-> plugin_options_not_detected =  "No plugin options detected in database from former versions - INITIALIZED successfully.";
	$t-> no_tag_detected = "<b>No tag detected in your blog - Start by adding tags to your blog before tagging media.</b>";
	$t-> select_media_before_tagging = 'Select at least one media in the list for tagging.';
	$t-> displaying = 'Displaying';
	$t-> view = 'View';
	$t-> all_media = 'All media';
	$t-> tagged_media = 'Tagged media';
	$t-> untagged_media = 'Untagged media';
	$t-> list_media = 'List';
	$t-> search_all_media = 'Search all media';
	$t-> display = 'Display';
	$t-> display_depth = 'Display depth';
	$t-> media_starting_from = 'media starting from';
	$t-> start_display_index = 'Start display index';

	$t-> tag = 'Tag';
	$t-> add_to_list = 'Add to list';
	$t-> remove_from_list = 'Remove from list';
	$t-> reset_list = 'Reset list';
	
	$t-> search_display = "Search display";
	$t-> php_version_outdated = "PHP Version %.2f is the minimum required on your server to run the %s plugin.";
	$t-> php_version_current = "Version %s was detected on the server.";
	$t-> update_options = "Update options";
	$t-> others = "Others";






	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	//	Process strings
	//
	//
	$file_basename = self::$PLUGIN_DIR_PATH . 'languages/' . self::$PLUGIN_NAME_LC . '-def-i18n';
	$i18n_filename = $file_basename . '.php';
	$md5_filename = $file_basename . '.md5';
	
	$md5_ref = @file_get_contents($md5_filename);
	$md5 = md5_file(__FILE__);
	//echo $md5_ref . '<br/>';
	//echo $md5 . '<br/>';

	if ($md5 != $md5_ref) {
		echo "MD5 differs <br/>";

		$t_tab = (array)$t;
		foreach ($t_tab as $key => $string) {
			$t_tab[$key] = '_("' . $string . '");' . "\n";
		}
		array_unshift($t_tab, "<?php\n\n");
		array_push($t_tab, "\n?>"); 
		file_put_contents($i18n_filename, $t_tab);
		file_put_contents($md5_filename, $md5);
	}
	
	$t_tab = (array)$t;
	foreach ($t_tab as $key => $string) {
		$t_tab[$key] = __($string, self::$PLUGIN_NAME_LC);
		$t_tab[$key . '_'] = $string;
	}
	$t = (object)$t_tab;


?>