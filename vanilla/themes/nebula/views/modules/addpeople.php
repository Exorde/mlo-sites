<?php if (!defined('APPLICATION')) exit(); ?>
<div class="Box AddPeople">
   <?php
      echo $this->Form->Open();
      echo '<label for "AddPeople/AddPeople">'.T('Add People to this Conversation').'</label>';
      echo Wrap($this->Form->TextBox('AddPeople', array('MultiLine' => TRUE, 'class' => 'MultiComplete')), 'div', array('class' => 'TextBoxWrapper'));
      echo '<button>'.T('Add').'</button>';
      echo $this->Form->Close();
   ?>
</div>
