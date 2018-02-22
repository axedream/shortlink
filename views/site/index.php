<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Short link';
$basic_url = Yii::$app->params['basic_url'];

$script = <<< JS
    
var addAddres = function () {
        $.ajax({
            url: window.location.protocol + "//" + window.location.hostname + "/site-ajax/get-short-url",
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function(){
                $("#short_link_div").text('');
            },
            data: { output: { url : $("#url-url").val() } },
            cache: false,
            success: function (msg) {
                if (!msg.error) {
                    $("#short_link_div").text('$basic_url' +'/'+ msg.msg.short_url);
                }
            }
            //console.log(msg);
        });
    };
$(function(){
    $("#get_short_ulr").on('click',function(e){
        addAddres();
        e.preventDefault();
        return false;
    });    
});
JS;

$this->registerJs($script, yii\web\View::POS_END,'ajax');

?>
<div class="site-index">
    <div class="row">
        <div class="col-md-9">

            <?php $form = ActiveForm::begin(['id'=>'formShortUrl']); ?>

            <div class="form-group">
                <div class="col-lg-12">
                    <?= $form->field($model,'url')->textInput(['placeholder'=>'Введите полный адрес сайта: http(s)://адресс']) ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                    <a type="button" href='' class="btn btn-primary" id="get_short_ulr">Получить ссылку</a>
                </div>
            </div>

            <?php ActiveForm::end() ?>

        </div>
        <div class="col-md-3"></div>
        <div class="col-md-12"><br><br></div>
        <div class="col-md-9">
            <div class="col-md-12">
                <label class="control-label" for="url-url">Короткая ссылка</label>
                <div class="form-control bg-success" id="short_link_div" style></div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>

</div>
