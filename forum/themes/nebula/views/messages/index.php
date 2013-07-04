<?php if (!defined('APPLICATION')) exit(); ?>
<section class="DataList">
  <h1><?php echo $this->Participants; ?></h1>
  <?php
  if ($this->Data('Conversation.Subject') && C('Conversations.Subjects.Visible')) {
     echo '<h2>'.htmlspecialchars($this->Data('Conversation.Subject')).'</h2>';
  }

  if ($this->Data('_HasDeletedUsers')) {
     echo '<div class="Info">', T('One or more users have left this conversation.', 'One or more users have left this conversation. They won\'t receive any more messages unless you add them back in to the conversation.'), '</div>';
  }
  ?>
  <?php
  $this->FireEvent('BeforeConversation');
  echo $this->Pager->ToString('less');
  ?>
  <ul class=" MessageList Conversation">
     <?php
     $MessagesViewLocation = $this->FetchViewLocation('messages');
     include($MessagesViewLocation);
     ?>
  </ul>
  <?php echo $this->Pager->ToString(); ?>
</section>
