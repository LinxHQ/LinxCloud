<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */
/* @var $model LbContractDocument */

$this->breadcrumbs=array(
	'Lb Contracts'=>array('index'),
	'Create',
);

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" ><h3>Contracts</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New Contract'), 'url'=>$this->createUrl('create') ),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';

?>

<h3>New Contract</h3>

<?php $this->renderPartial('_form', array(
                                            'model'=>$model,
                                            'documentModel'=>$documentModel,
                                            'customer_id'=>$customer_id,
                                            'paymentModel'=>$paymentModel
                            )); ?>