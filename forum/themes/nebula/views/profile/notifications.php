<?php if (!defined('APPLICATION')) exit();
if ($this->ActivityData->NumRows() > 0) {
   echo '<ul class="DataList">';
   include($this->FetchViewLocation('activities', 'activity', 'dashboard'));
   echo '</ul>';
   echo $this->Pager->ToString('more');
} else {
   ?>
<div class="Empty"><?php echo T('You do not have any notifications yet.'); ?></div>
   <?php
}
