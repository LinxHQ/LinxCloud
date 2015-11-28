<?php /* @var $this Controller */ 
$url=YII::app()->baseUrl;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.blockUI.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
</head>

<body>
<div id="linx-menu-top">
    <?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'items'=>array(
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                            'encodeLabel'=>false,
                'items'=>array(
                    array('label'=>'Home', 'url'=>array('/site/index')),
                    array('label'=>'My Account', 
                        'url'=>array('/linxAccount/view', 'id' => Yii::app()->user->id),
                        'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Accounts', 
                        'url'=>array('/linxAccount/admin'),
                        'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Create', 'url'=>array('/linxAccount/create'), 
                        'visible'=>!Yii::app()->user->isGuest),
                    //array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                    //array('label'=>'Contact', 'url'=>array('/site/contact')),
                    array('label'=>'Login', 'url'=>array('/site/login'), 
                        'visible'=>Yii::app()->user->isGuest),
                    //array('label'=>'Team', 'url'=>array('/linxHQAccountTeamMember/accountTeamMember/admin'), 'visible'=>!Yii::app()->user->isGuest),
                    //array('label'=>'Invite', 'url'=>array('/linxHQAccountTeamMember/accountInvitation/create'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                                    //array('label'=>'<span style="width: 100%; text-align: right; margin: auto;margin-top: 4px;" id="linx-menu-app"></span>', 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest)
                ),
            ),
        ),
    )); ?>
    <div id="linx-menu-top-left">
        <div class="btn-group">
              <?php echo LinxAccountProfile::model()->getProfilePhoto(Yii::app()->user->id, false, 34); ?>
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo LinxAccountProfile::model()->getShortFullName(Yii::app()->user->id ); ?> <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="<?php echo $url.'/index.php/linxAccount/'.Yii::app()->user->id ;?>">My Account</a></li>
                <li><a href="<?php echo $url.'/index.php/site/logout';?>">Loguot</a></li>
              </ul>
        </div> 
    </div>
</div>

<div class="container" id="page">

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->
<div id="footer">
<!--    <br><center>Copyright © 2015, Kuckoo. Sản phẩm của LinxHQ Pte Ltd. Nhà phân phối: C.Ty TNHH Giải Pháp Phần Mềm Sơn Lâm</center>-->
</div><!-- footer -->
</body>
</html>
