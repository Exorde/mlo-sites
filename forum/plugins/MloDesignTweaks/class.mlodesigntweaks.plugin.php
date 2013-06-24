<?php
	// Define the plugin:
	$PluginInfo['MLO Design tweaks'] = array(
	   'Description' => "Tweaks the design of vanilla to make it fit in MLO's general design",
	   'Version' => '1.0',
	   'RequiredApplications' => array('Vanilla' => '2.0.10'),
	   'RequiredTheme' => FALSE, 
	   'RequiredPlugins' => FALSE,
	   'HasLocale' => FALSE,
	   'SettingsUrl' => '/plugin/MloDesignTweaks',
	   'SettingsPermission' => 'Garden.AdminUser.Only',
	   'Author' => "Tumulte",
	   'AuthorEmail' => 'tumulte@dogmazic.net',
	   'AuthorUrl' => 'http://www.musique-libre.org'
	);

	class MloDesignTweaks extends Gdn_Plugin {
	  //nothing to do here...
	}
?>
