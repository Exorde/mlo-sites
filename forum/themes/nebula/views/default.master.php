<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-ca">
<head>
   <?php include '../inc/global_statics.php'; ?>
   <?php include '../inc/vanilla_statics.php'; ?>
   <?php $this->RenderAsset('Head'); ?>
    
</head>
<body id="<?php echo $BodyIdentifier; ?>" class="<?php echo $this->CssClass; ?>">
   <?php include '../inc/general_menu.php'; ?>
  <div id="Frame" >
		<header class="Banner" id="branding">
      <hgroup>
      <?php include '../inc/global_logo.php'; ?>
      <h1 id="site-title"><a id="home_link"  href="<?php echo Url('/'); ?>"><span><?php echo Gdn_Theme::Logo(); ?></span></a></h1>
     </hgroup>
     <nav id="access">
          <ul  class="menu">
              <?php
              $Session = Gdn::Session();
            if ($this->Menu) {
              $this->Menu->AddLink('Dashboard', T('Dashboard'), '/dashboard/settings', array('Garden.Settings.Manage'), array('class' =>'menu-item'));
              // $this->Menu->AddLink('Dashboard', T('Users'), '/user/browse', array('Garden.Users.Add', 'Garden.Users.Edit', 'Garden.Users.Delete'));
              $this->Menu->AddLink('Activity', T('Activity'), '/activity', FALSE, array('class' => 'menu-item'));
              $this->Menu->RemoveLink('Discussions', T('Discussions'));
              $this->Menu->AddLink('Discussions', T('Discussions'), '/discussions', FALSE, array('Standard' => TRUE, 'class' => 'Discussions menu-item'));
              if ($this->Menu && $Session->IsValid()) {
                 $Inbox = T('Inbox');
                 $CountUnreadConversations = $Session->User->CountUnreadConversations;
                 if (is_numeric($CountUnreadConversations) && $CountUnreadConversations > 0)
                    $Inbox .= ' <span>'.$CountUnreadConversations.'</span>';
                    
                 $this->Menu->RemoveLink('Conversations', $Inbox);
                 $this->Menu->AddLink('Conversations', $Inbox, '/messages/all', FALSE, array('Standard' => TRUE, 'class' => 'Inbox menu-item'));
              }

              if ($Session->IsValid()) {
                $Name = $Session->User->Name;
                $CountNotifications = $Session->User->CountNotifications;
                if (is_numeric($CountNotifications) && $CountNotifications > 0)
                  $Name .= ' <span class="Alert">'.$CountNotifications.'</span>';

                       if (urlencode($Session->User->Name) == $Session->User->Name)
                          $ProfileSlug = $Session->User->Name;
                       else
                          $ProfileSlug = $Session->UserID.'/'.urlencode($Session->User->Name);
                $this->Menu->AddLink('User', $Name, '/profile/'.$ProfileSlug, array('Garden.SignIn.Allow'), array('class' => 'UserNotifications menu-item'));
              }
              echo $this->Menu->ToString();
            }
          ?>
          </ul>
          <div id="SearchBox"><?php
          $Form = Gdn::Factory('Form');
          $Form->InputPrefix = '';
          echo 
            $Form->Open(array('action' => Url('/search'), 'method' => 'get')),
            $Form->TextBox('Search'),
            '<button>ok</button>',
            $Form->Close();
          ?>
          </div>
     </nav>	
	 </header>
	 <div id="Body">
		 
	 <div id="Panel">
      <?php $this->RenderAsset('Panel'); ?>
	  </div>
	  <div id="Content">
      <?php $this->RenderAsset('Content'); ?>
	  </div>
	  
	 </div>
	 <div id="Foot">
			<?php
				$this->RenderAsset('Foot');
				echo Wrap(Anchor(T('Powered by Vanilla'), C('Garden.VanillaUrl')), 'div');
			?>
  </div>
</body>
</html>
