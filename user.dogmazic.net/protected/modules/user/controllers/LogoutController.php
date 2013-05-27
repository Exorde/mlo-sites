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
    setcookie("sso_authent_mlo[id]",'', time()-3600,"/", 'mlo.loc');
    setcookie("sso_authent_mlo[token]",'', time()-3600,"/", 'mlo.loc');
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

}
