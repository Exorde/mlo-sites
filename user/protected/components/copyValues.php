<?php
class copyValues extends CApplicationComponent{
    public function database(){
      return  array(
        'forum' => Yii::app()->dbforum,
        'blog' => Yii::app()->dbblog,
      );
    }


    public function copy($username,$password,$email){
      //Insert user data in the forum. I use 'Deleted' because of the activation
      $connection= $this->database();

      //###########  FORUM  ##############
      $sqlForum="INSERT INTO GDN_User (UserID, Name, Password, HashMethod,  Email,Deleted) 
            VALUES ($ID, '$username','$password', 'dogma','$email','1');";
      $command=$connection['forum']->createCommand($sqlForum);
      $command->execute();
      //Get the ID of the newly created user
      $getIDSqlForum = "SELECT UserID FROM GDN_User WHERE Name = '$username'";
      $commandID=$connection['forum']->createCommand($getIDSqlForum);
      $IDQuery = $commandID->query();
      $IDQuery = $IDQuery->readAll();
      $ID = $IDQuery[0]['UserID'];

      //add user ID and role in the table
      $sqlForumRole="INSERT INTO GDN_UserRole (UserID, RoleID) 
                VALUES ('$ID', '4432');";
      $commandRole=$connection['forum']->createCommand($sqlForumRole);
      $commandRole->execute();

      //############  BLOG ##########
      $nice_name = strtolower($username);
      $sqlBlog="INSERT INTO wp_users (ID, user_login, user_pass, user_email, user_nicename) 
        VALUES ($ID, '$username','$password', '$email', '$nice_name');";
      $command=$connection['blog']->createCommand($sqlBlog);
      $command->execute();
    }

    public function updatePassword($username,$password){
      $connection= $this->database();
      ####### FORUM #####
      $sql="UPDATE GDN_User SET Password = '$password' WHERE Name = '$username'";
      $command=$connection['forum']->createCommand($sql);
      $command->execute();
      ####### BLOG  #######
      $sql="UPDATE wp_users SET user_pass = '$password' WHERE user_login = '$username'";
      $command=$connection['blog']->createCommand($sql);
      $command->execute();
    }

    public function activateAccount($username){
      ####### FORUM #####
      $connection=$this->database();
      $sql="UPDATE GDN_User SET Deleted = '0' WHERE Name = '$username'";
      $command=$connection['forum']->createCommand($sql);
      $command->execute();

      ###### BLOG ######
      //Get the ID of the newly created user
      $getIDSqlBlog = "SELECT ID FROM wp_users WHERE user_login = '$username'";
      $commandID=$connection['blog']->createCommand($getIDSqlBlog);
      $IDQuery = $commandID->query();
      $IDQuery = $IDQuery->readAll();
      $ID = $IDQuery[0]['ID'];
      //add user ID and role in the table
      //wp_ is the blog, they are contributors (can write but can't publish)
      //wp_2_ is doc, it's a wiki-like, therefore, they are editors (can publish and edit, including others' posts)
      $sqlBlogRole =  "INSERT INTO wp_usermeta SET user_id = '$ID', meta_key ='wp_capabilities', meta_value='a:1:{s:11:\"contributor\";b:1;}';
                       INSERT INTO wp_usermeta SET user_id = '$ID', meta_key ='wp_2_capabilities', meta_value='a:1:{s:6:\"editor\";b:1;}';
                       INSERT INTO wp_usermeta SET user_id = '$ID', meta_key ='nickname', meta_value='$username';";
      $command=$connection['blog']->createCommand($sqlBlogRole);
      $command->execute();

    }
}
?>
