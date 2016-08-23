<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Добавление книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
var authorId = null;
var authorName = null;
var authorLabel = '<?= Html::label('Автор', null, ['class' => 'authorName']) ?>';
var cancelAuthorButton = null;
var isRepeat = false;
var hiddenInputAuthorId = '<?= Html::input('hidden', 'authorId[]') ?>';
//AJAX call for autocomplete 
$(document).ready(function(){
	$(".searchBox").keyup(function(){
		if ($(this).val().length < 2) {
			return;
		}
		$.ajax({
		    type: "POST",
		    url: "/author/autocomplete",
		    data:'keyword='+$(this).val(),
		    beforeSend: function(){
		    	$('#searchBox').css("background","#FFF no-repeat 165px");
		    },
		    success: function(data){
			    $('#suggesstionBox').show();
			    $('#suggesstionBox').html(data);
			    $('#searchBox').css("background","#FFF");
		    }
		});
	});
});
//To select author name
function selectAuthor(methodAuthorName, methodAuthorid) {
	authorName = methodAuthorName;
    $("#searchBox").val(authorName);
    $("#suggesstionBox").hide();
    $("#addAuthor").show();
    authorId = methodAuthorid;
}

function addNewAuthor() {
	cancelAuthorButton = '<button type="button" onclick="cancelAuthor('+authorId+');">Отменить выбор</button>';
	$("#addAuthor").hide();
	$("#searchBox").val("");
	$("#addAuthorList input").each(function() {
		if ($(this).val() == authorId ) {
			isRepeat = true;
		}
	})
    if (isRepeat) {
    	isRepeat = false;
    	return;
	}
    $("#addAuthorList").append(hiddenInputAuthorId);
    $("#addAuthorList input").last().val(authorId);
    $("#addAuthorList").append(authorLabel);
    $("#addAuthorList").append(authorLabel);
    $("#addAuthorList label").last().text(authorName);
    $("#addAuthorList label").last().attr("class", 'authorTextLabel');
    $("#addAuthorList").append(cancelAuthorButton);
    $("#emptyAuthorIdField").next().hide();
    $("#emptyAuthorIdField").val('tmp');
}

function cancelAuthor(methodAuthorid) {
    $('#addAuthorList input').each(function() {        
		if ($(this).val() == methodAuthorid ) {
			$(this).next().next().next().remove();
			$(this).next().next().remove();
			$(this).next().remove();
			$(this).remove();
		}		
	})
	if ($('#addAuthorList input')) {
		$("#emptyAuthorIdField").removeAttr('value');
		$("#emptyAuthorIdField").next().show();
	}
}

</script>
<h2> <?= $this->title ?> </h2>
<div class="registrationData">
    <?php $form = ActiveForm::begin([
        'id' => 'addBook',
        'options' => ['class' => 'registrationData']    		
    ]); ?>        
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'genre')->textInput() ?>
        <?= $form->field($model, 'published_date')->widget(DatePicker::className(), [
        	    'dateFormat' => 'yyyy'                
            ]);
        ?>
        <?= $form->field($model, 'description')->textarea([
        	    'rows' => '10',
        	    'cols' => '41'
            ])->hint('Аннотация')
        ?>
        <?= $form->field($model, 'bookCover')->fileInput() ?>
        <?= $form->field($model, 'bookFile')->fileInput() ?>
        <div class="addAuthorList" id="addAuthorList"></div>
        <div class="textCenter"><h4>
            Выбрать автора (если не найдете вашего автора среди существующих авторов - 
            <?= Html::a('добавьте его в нашу базу', ['author/add']) ?>).</h4></div><br />
        <?= Html::label('Поиск автора', 'searchBox', ['class' => 'searchBoxLabel']) ?>        
        <?= Html::input('text','searchBox', null, ['class' => 'searchBox', 'id' => 'searchBox', 'autocomplete' => 'off']) ?>
        <?= Html::button('Добавить', ['id' => 'addAuthor', 'onClick' => 'addNewAuthor();']) ?>
        <div class="suggesstionBox" id="suggesstionBox"></div>
        <?= $form->field($model, 'authorIdFlag')->hiddenInput(['id' => 'emptyAuthorIdField'])->label(false) ?>
        <?= Html::submitButton('Сохранить', ['id' => 'saveButton']) ?>
    <?php $form = ActiveForm::end(); ?>
</div>
