<?php
$this->breadcrumbs=array(
	Yii::t("site",'Users')=>array('admin'),
	$model->username,
);
?>
<h1><?php echo Yii::t("site",'View User').' "'.$model->username.'"'; ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(Yii::t("site",'Create User'),array('create')),
			CHtml::link(Yii::t("site",'Update User'),array('update','id'=>$model->id)),
			CHtml::linkButton(Yii::t("site",'Delete User'),array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t("site",'Are you sure to delete this item?'))),
		),
	)); 


	$attributes = array(
		'id',
		'username',
	);
	
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => Yii::t("site",$field->title),
					'name' => $field->varname,
					'type'=>'raw',
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
				));
		}
	}
	
	array_push($attributes,
		'password',
		'email',
		'activkey',
		array(
			'name' => 'createtime',
			'value' => date("d.m.Y H:i:s",$model->createtime),
		),
		array(
			'name' => 'lastvisit',
			'value' => (($model->lastvisit)?date("d.m.Y H:i:s",$model->lastvisit):Yii::t("site","Not visited")),
		),
		array(
			'name' => 'superuser',
			'value' => User::itemAlias("AdminStatus",$model->superuser),
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
	

?>
