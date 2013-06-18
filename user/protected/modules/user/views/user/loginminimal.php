


<div class="form" id="login_form">
<?php echo CHtml::beginForm(array('login&url='.$url)); ?>

	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="form_row">
    <?php $username_text = UserModule::t('username');?>
		<?php echo CHtml::activeLabelEx($model,$username_text); ?>
		<?php echo CHtml::activeTextField($model,$username_text, array('placeholder' => $username_text)) ?>
	</div>
	
	<div class="form_row">
    <?php $password_text = UserModule::t('password');?>
		<?php echo CHtml::activeLabelEx($model,$password_text); ?>
		<?php echo CHtml::activePasswordField($model,$password_text, array('placeholder' => $password_text)) ?>
	</div>
	
	
	<div class="form_row rememberMe">
		<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
		<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
	</div>

	<div class="form_row submit">
    <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		<?php echo CHtml::htmlButton(UserModule::t("Login"), array('type'=>'submit', 'class' => 'darker_button')); ?>
	</div>
	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
