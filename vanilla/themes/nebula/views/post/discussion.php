<?php if (!defined('APPLICATION')) exit();
$Session = Gdn::Session();
$CancelUrl = '/vanilla/discussions';
if (C('Vanilla.Categories.Use') && is_object($this->Category))
   $CancelUrl = '/vanilla/discussions/0/'.$this->Category->CategoryID.'/'.Gdn_Format::Url($this->Category->Name);

?>
<div id="DiscussionForm">
   <h1><?php echo $this->Data('Title'); ?></h1>
   <?php
      echo $this->Form->Open();
      echo $this->Form->Errors();
      $this->FireEvent('BeforeFormInputs');
		echo '<div class="P">';
			echo $this->Form->Label('Discussion Title', 'Name');
			echo Wrap($this->Form->TextBox('Name', array('maxlength' => 100, 'class' => 'InputBox BigInput')), 'div', array('class' => 'TextBoxWrapper'));
		echo '</div>';

      if ($this->ShowCategorySelector === TRUE) {
			echo '<div class="P">';
				echo '<div class="Category">';
				echo $this->Form->Label('Category', 'CategoryID'), ' ';
				echo $this->Form->CategoryDropDown('CategoryID', array('Value' => GetValue('CategoryID', $this->Category)));
				echo '</div>';
			echo '</div>';
      }
      
      $this->FireEvent('BeforeBodyInput');
		echo '<div class="P">';
	      echo Wrap($this->Form->TextBox('Body', array('MultiLine' => TRUE)), 'div', array('class' => 'TextBoxWrapper'));
		echo '</div>';

      $Options = '';
      // If the user has any of the following permissions (regardless of junction), show the options
      // Note: I need to validate that they have permission in the specified category on the back-end
      // TODO: hide these boxes depending on which category is selected in the dropdown above.
      if ($Session->CheckPermission('Vanilla.Discussions.Announce'))
         $Options .= '<li>'.$this->Form->CheckBox('Announce', T('Announce'), array('value' => '1')).'</li>';

      if ($Session->CheckPermission('Vanilla.Discussions.Close'))
         $Options .= '<li>'.$this->Form->CheckBox('Closed', T('Close'), array('value' => '1')).'</li>';

		$this->EventArguments['Options'] = &$Options;
		$this->FireEvent('DiscussionFormOptions');

      if ($Options != '') {
			echo '<div class="P">';
	         echo '<ul class="List Inline PostOptions">' . $Options .'</ul>';
			echo '</div>';
      }

      echo '<div class="Buttons">';
      $this->FireEvent('BeforeFormButtons');
      $button_text = property_exists($this, 'Discussion') ? T('Save') : T('Post Discussion');
      if (!property_exists($this, 'Discussion') || !is_object($this->Discussion) || (property_exists($this, 'Draft') && is_object($this->Draft))) {
         echo '<button name="Discussion/Save_Draft" class="Button DraftButton">'.T('Save Draft').'</button>';
      }
      echo '<button name="Discussion/Preview" class = "Button PreviewButton">'.T('Preview').'</button>';
      echo '<button name="Discussion/Post_Discussion" class ="Button DiscussionButton darker_button">'.$button_text.'</button>';
      $this->FireEvent('AfterFormButtons');
      echo '</div>';
      echo '<br />';
      echo Anchor(T('Cancel'), $CancelUrl, 'Cancel');
      echo $this->Form->Close();
   ?>
</div>
