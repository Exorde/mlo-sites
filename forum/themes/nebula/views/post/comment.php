<?php if (!defined('APPLICATION')) exit();
$Session = Gdn::Session();
$NewOrDraft = !isset($this->Comment) || property_exists($this->Comment, 'DraftID') ? TRUE : FALSE;
$Editing = isset($this->Comment);
?>
<div class="MessageForm CommentForm">
   <?php if (!$Editing) { ?>
   <?php
   } else {
      $this->Form->SetFormValue('Body', $this->Comment->Body);
   }
   echo $this->Form->Open();
   echo $this->Form->Errors();
   
   $CommentOptions = array('MultiLine' => TRUE);
   /*
    Caused non-root users to not be able to add comments. Must take categories
    into account. Look at CheckPermission for more information.
   if (!$Session->CheckPermission('Vanilla.Comment.Add')) {
      $CommentOptions['Disabled'] = 'disabled';
      $CommentOptions['Value'] = T('You do not have permission to write new comments.');
   }
   */
   $this->FireEvent('BeforeBodyField');
   echo Wrap($this->Form->TextBox('Body', $CommentOptions), 'div', array('class' => 'TextBoxWrapper'));
   $this->FireEvent('AfterBodyField');
   echo "<div class=\"Buttons\">\n";
   $this->FireEvent('BeforeFormButtons');
   $CancelText = T('Back to Discussions');
   $CancelClass = 'Back';
   if (!$NewOrDraft) {
      $CancelText = T('Cancel');
      $CancelClass = 'Cancel';
   }

   
   /*
    Caused non-root users to not be able to add comments. Must take categories
    into account. Look at CheckPermission for more information.
   if (!Gdn::Session()->CheckPermission('Vanilla.Comment.Add'))
      $ButtonOptions['Disabled'] = 'disabled';
   */
   // TODO : reimplement draft + preview
   /*
   if (!$Editing)
      echo '<button type="button" class="PreviewButton TabLink">'.T('Preview');
   if ($NewOrDraft)
      echo '<button type="button" class= "DraftButton TabLink">'.T('Save Draft');
   */
   $button_text = $Editing ? T('Save Comment') : T('Post Comment');
   echo '<button class="darker_button">'.$button_text.'</button>';
   echo "</div>\n";
   echo '<br />';
   echo Gdn_Theme::Link('forumroot', $CancelText, NULL, array(
       'class' => $CancelClass
   ));
   $this->FireEvent('AfterFormButtons');
   echo $this->Form->Close();
   ?>
</div>
