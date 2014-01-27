<?php	// WP Mediatagger messages definition file

	///////////////////////////////////////////////////////////////////////////////////////
	//
	// Messages and text constants
	//
	//

	$t = new stdClass;
	
	$t-> activation = self::__( "Activation" );
	$t-> table_detected_not_created = self::__( "Taxonomy table detected in database - not created" );
	$t-> table_detected_converted = self::__( "Taxonomy table detected in database - converted." );
	$t-> table_not_detected_created = self::__( "Taxonomy table not detected in database - created" );
	$t-> loading = self::__( "Loading" );
	$t-> plugin_options_detected_serial = self::__( "Plugin options detected in database in <b>serialized</b> format - RELOADED successfully.");
	$t-> plugin_options_detected_itemized = self::__( "Plugin options detected in database in <b>itemized</b> format - RELOADED and SERIALIZED successfully.");
	$t-> plugin_options_not_detected =  self::__( "No plugin options detected in database from former versions - INITIALIZED successfully.");
	$t-> no_tag_detected = self::__( "<b>No tag detected in your blog - Start by adding tags to your blog before tagging media.</b>");
	$t-> select_media_before_tagging = self::__( 'Select at least one media in the list for tagging.');
	
	$t-> search_display = self::__( "Search display" );
	$t-> php_version_outdated = self::__( "PHP Version %.2f is the minimum required on your server to run the %s plugin." );
	$t-> php_version_current = self::__("Version %s was detected on the server.");
	$t-> update_options = self::__( "Update options" );
	$t-> others = self::__( "Others" );
	
	
/*	$def = array(
	
	'PHP_VERSION_TOO_OLD' => self::__("PHP Version %.2f is the minimum required on your server to run the %s plugin."),
	'PHP_VERSION_CURRENT' => self::__("Version %s was detected on the server."),
	
	'UPDATE_OPTIONS' => self::__("Update options"),

	'DEFAULT_TAG_GROUP_NAME' => self::__("Others"),

	'OPTIONS_MOUSE_OVER' => "Place your mouse over the option fields to display detailed option description.",
	
	'SEARCH_DISPLAY' =>	"Search display",

		
	'LAST' => "Last."	// to avoid forgetting to manage the absence of ',' on the last item
	);

	array_walk($def, function(&$string, $key){ $string = __($string, 'mediatagger');}); 
	array_walk($def, mdtg_callback_translate); 
	
	function mdtg_callback_translate(&$string, $key){ 
		$string = __($string, 'mediatagger');
	}*/

?>