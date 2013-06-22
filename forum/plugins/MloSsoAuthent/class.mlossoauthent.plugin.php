<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

// Define the plugin:
$PluginInfo['MLO SSO Authentication'] = array(
   'Description' => 'Allows cookie based SSO authentication by comparing a token to a session ID in a database',
   'Version' => '1.0',
   'RequiredApplications' => array('Vanilla' => '2.0.10'),
   'RequiredTheme' => FALSE, 
   'RequiredPlugins' => FALSE,
   'HasLocale' => FALSE,
   'SettingsUrl' => '/plugin/mlosso',
   'SettingsPermission' => 'Garden.AdminUser.Only',
   'Author' => "Tumulte",
   'AuthorEmail' => 'tumulte@musique-libre.org',
   'AuthorUrl' => 'http://www.musique-libre.org'
);

class MloSsoAuthentPlugin extends Gdn_Plugin {

   /**
    * Plugin constructor
    *
    * This fires once per page load, during execution of bootstrap.php. It is a decent place to perform
    * one-time-per-page setup of the plugin object. Be careful not to put anything too strenuous in here
    * as it runs every page load and could slow down your forum.
    */
   public function __construct() {
   }
   public function Base_Render_Before($Sender) {
      $user_id = $_COOKIE['sso_authent_mlo']['id'];
      if($user_id && !Gdn::Session()->IsValid()){
        //DB config
        include('config.php');
        //Get the session ID in the user manager database
        $connection = mysql_connect($db_conf['host'], $db_conf['user'], $db_conf['pass']) 
          or die ('Error connecting to the user mysql to get the sso');
        mysql_select_db($db_conf['db']);
        $query = "SELECT ".$db_conf['row']." FROM ".$db_conf['table']." WHERE id='".$user_id."'";
        $session_id = mysql_query($query);
        $result = mysql_result($session_id, 0);
        //IF there is a user, and the token in the cookie matches the one in the DB : logon !
        if($_COOKIE['sso_authent_mlo']['token'] == $result){
          Gdn::Session()->Start($user_id);
        }
      }
   }
}
