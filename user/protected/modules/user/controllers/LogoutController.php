<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
    setcookie("sso_authent_mlo[id]",'', time()-3600,"/", 'musique-libre.org');
    setcookie("sso_authent_mlo[token]",'', time()-3600,"/", 'musique-libre.org');
    //don't redirect if it's a remote log out
    if(isset($_GET['url'])){
      return;
    }else{
      $this->redirect(Yii::app()->controller->module->returnLogoutUrl);
    }
	}

}
