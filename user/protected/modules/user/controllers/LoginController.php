<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
		 {
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->createSession();
      //redirect to the remote page
          if (isset($_GET['url'])){
            header( 'Location:'.$_GET['url']);
            die;
          }
					if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
        $this->render('/user/login',array('model'=>$model));
		} else
      //redirect to the remote page
      if (isset($_GET['url'])){
            header( 'Location:'.$_GET['url']);
            die;
      }
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function createSession() {
		$user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
    //create the session token
    $user->session = uniqid(crypt(rand()).'_', 'true');

    //create the cookie with the user ID and the token
    setcookie("sso_authent_mlo[id]", $user->id, time()+3600,"/", 'mlo.loc');
    setcookie("sso_authent_mlo[token]", $user->session, time()+3600,"/", 'mlo.loc');
    //strore the time of last visit
    $user->lastvisit = time();
    $user->save();
	}

  public function actionRemoteLogin(){
		$model=new UserLogin;
    $this->renderPartial('/user/loginminimal',array('model'=>$model, 'url'=>$_GET['url']));
  }

}
