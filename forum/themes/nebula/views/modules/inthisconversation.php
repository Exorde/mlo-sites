<?php if (!defined('APPLICATION')) exit(); ?>
<section class="Box">
   <h1 class="titlization"><?php echo T('In this Conversation'); ?></h1>
   <ul class="PanelInfo">
   <?php
   $Result = $this->Data->Result();
   foreach ($this->Data->Result() as $User) {
      echo '<li>';

      if (GetValue('Deleted', $User))
         echo Wrap(UserAnchor($User, 'UserLink'), 'del',
            array('title' => sprintf(T('%s has left this conversation.'), htmlspecialchars(GetValue('Name', $User))))
            );
      else
         echo Wrap(UserAnchor($User, 'UserLink'), 'strong');
      

      echo '</li>';
   }
   ?>
   </ul>
</section>
