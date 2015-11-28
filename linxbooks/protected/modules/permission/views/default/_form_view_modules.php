<?php

/**
 * @author Thongnv 
 */


// get the modules actually installed on the file system
$modFiles = Modules::model()->readDirs('modules');
//print_r($modFiles);
$modelMod = Modules::model()->getModules();
foreach ($modelMod as $modelModItem) {
    if($modFiles[$modelModItem['module_directory']] == $modelModItem['module_directory'])
        $modFiles[$modelModItem['module_directory']]="";
}
?>
<h3><?php echo Yii::t('lang', 'Modules Active'); ?></h3>
<?php
    $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'lb-module-grid',
        'dataProvider'=>$model->search(),
        'columns'=>array(
            array(
                'header'=>'#',
                'name'=>'module_order',
                'type'=>'raw',
                'headerHtmlOptions'=>array('width'=>'10'),
            ),
            array(
                'name'=>'module_name',
                'type'=>'raw',
                'headerHtmlOptions'=>array('width'=>'180'),
            ),
            array(
                'name'=>'module_text',
                'type'=>'raw',
                'headerHtmlOptions'=>array('width'=>'180'),
            ),
            array(
                'name'=>'modules_description',
                'type'=>'raw',
            ),
            array(
                'header'=>'Menu Status',
                'name'=>'module_hidden',
                'type'=>'raw',
                'value'=>'($data->module_hidden==1) ? "<a href=\'#\' onclick=\"ajaxUpdateStatusModule(\'$data->lb_record_primary_key\',0); return false;\"><i class=\'icon-ok-sign\'></i> visible</a>" : "<a href=\'#\' onclick=\"ajaxUpdateStatusModule(\'$data->lb_record_primary_key\',1); return false;\" ><i class=\'icon-remove-sign\'></i> Hidden</a>"',
                'headerHtmlOptions'=>array('width'=>'100'),
            ),
            array(
                'header'=>'Actions',
                'headerHtmlOptions'=>array('style'=>'text-align:center;width:80px'),
                'htmlOptions'=>array('style'=>'text-align:center'),
                'type'=>'raw',
                'value'=>'\'<a href="#" onclick="ajaxDeleteModule(\'.$data->lb_record_primary_key.\')" id="member_delete" data-original-title="Xóa" rel="tooltip" title><i class="icon-trash"></i> Remove</a>\'', 
            ),
        ),
    ));
?>

<h3><?php echo Yii::t('lang', 'Modules Deactivate'); ?></h3>
<table class="items table table-striped">
    <thead>
        <tr>
            <td><b>Module Name</b></td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($modFiles as $modItem) {
            $ok = @include_once( Yii::app()->getBasePath().'/modules/'.$modItem.'/setup.php' );
            if($modItem!="" && $ok)
            {
                
        ?>
            <tr>
                <td><?php echo $modItem; ?></td>
                <td><a href="<?php echo $this->createUrl('installModule',array('mod_name'=>$modItem)); ?>">Install</a></td>
            </tr>
        <?php }} ?>
    </tbody>
</table>
<script>
    function ajaxDeleteModule(module_id)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('deleteModule'); ?>',
            beforeSend: function(){
                if(confirm('Bạn có chắc muốn xóa module này không?'))
                    return true;
                return false;
            },
            data:{module_id:module_id},
            success: function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    window.location.assign('<?php echo $this->createUrl('viewModules'); ?>');
                else
                    alert("error");
                    
            },
        });
    }
    
    function ajaxUpdateStatusModule(module_id,status)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('updateStatusModule'); ?>',
            beforeSend: function(){
                //code
            },
            data:{modules_id:module_id,status:status},
            success: function(data){
                location.reload();
            }
        })
    }
</script>