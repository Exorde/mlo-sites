<?php if (!defined('APPLICATION')) exit();
  $CountDiscussions = 0;
  $CategoryID = isset($this->_Sender->CategoryID) ? $this->_Sender->CategoryID : '';

  if ($this->Data !== FALSE) {
     foreach ($this->Data->Result() as $Category) {
        $CountDiscussions = $CountDiscussions + $Category->CountDiscussions;
     }
?>
<div class="menu_main_container">
   <ul id="menu_main" class="menu">
      <li class="menu-item"><span><?php echo Anchor(Gdn_Format::Text(T('All Discussions')), '/discussions'); ?><span class="Count"><?php echo number_format($CountDiscussions); ?></span></span></li>
<?php
   $MaxDepth = C('Vanilla.Categories.MaxDisplayDepth');
   $DoHeadings = C('Vanilla.Categories.DoHeadings');


   $first_level_items = array();
   $sub_items = array();
   foreach ($this->Data->Result() as $index => $Category) {
      if ($Category->Depth == 1){
        array_push($first_level_items, $Category);
          $name = $Category->Name;
      }else{
        //The top element's name is used as a key to fetch the array of the sub menu
        $sub_items[$name] = array();
        array_push($sub_items[$name], $Category);
        
      }
   }

   foreach ($first_level_items as $Category) {
      if ($Category->CategoryID < 0 || $MaxDepth > 0 && $Category->Depth > $MaxDepth)
         continue;


      echo '<li class="menu-item">';
      echo Wrap(Anchor(''.Gdn_Format::Text($Category->Name), '/categories/'.rawurlencode($Category->UrlCode)))
          .'<span class="Count">'.number_format($Category->CountAllDiscussions).'</span>';
      if ( array_key_exists($Category->Name, $sub_items)){
          echo '<div class="sub_menu_container">';
          echo "<ul>";
         foreach ($sub_items[$Category->Name] as $sub_category) {
            echo '<li class="menu-item">';
            echo Wrap(Anchor(''.Gdn_Format::Text($sub_category->Name), '/categories/'.rawurlencode($sub_category->UrlCode ),"main_nav_link"))
                .'<span class="Count">'.number_format($sub_category->CountAllDiscussions).'</span>';
            echo '</li>';
         }
          echo '</ul>';
          echo '</div>';
          //add a button to unfold the menu
          echo '<button type="button" class="hollow_button menu_more_button button_thick">+</button>';
      }
      echo "</li>\n";
   };
?>
</ul>
</div>
<?php }
