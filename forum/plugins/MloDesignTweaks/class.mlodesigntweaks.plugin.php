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
    public function ProfileController_AddSideMenu_Handler(&$Sender){
      echo 'plou';

    }
    public function ProfileController_AfterAddSideMenu_Handler(&$Sender){
       $SideMenu = $Sender->EventArguments['SideMenu'];
       // No password may have been set if they have only signed in with a connect plugin
       $passwordLabel = T('Change My Password');
       if ($this->User->HashMethod && $this->User->HashMethod != "Vanilla")
         $passwordLabel = T('Set A Password');
       $SideMenu->RemoveLink('Options', $passwordLabel);
       $SideMenu->RemoveLink('Options', T('Edit Account'));
       $SideMenu->RemoveLink('Options', T('Edit Preferences'));
			 $SideMenu->RemoveLink('Options', T('Edit My Account'));

    }
	}
?>
