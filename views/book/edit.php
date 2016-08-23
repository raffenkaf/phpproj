<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Редактирование книги';
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
	if ($('#addAuthorList input').length < 1) {
		$("#emptyAuthorIdField").removeAttr('value');
		$("#emptyAuthorIdField").next().show();
	}
}

</script>
<h2> <?= $this->title ?> </h2>
<br />
<div class="registrationData">
    <?php $form = ActiveForm::begin([
        'id' => 'add-book',
        'options' => ['class' => 'registrationData']    		
    ]); ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?php foreach ($model->authors as $author) { ?>
            a
        <?php } ?>        
        <?= $form->field($model, 'genre')->textInput() ?>
        <?= $form->field($model, 'published_date')->widget(DatePicker::className(), [
        	    'dateFormat' => 'yyyy-MM-dd'                
            ]);
        ?>
        <?= $form->field($model, 'description')->textarea([
        	    'rows' => '10',
        	    'cols' => '41'
            ])
        ?>
        <div class="cover">
            <img alt="Книжная обложка" src="<?= Yii::getAlias('@web').'/'. $model->book_cover_path ?>">
        </div>        
        <?= $form->field($model, 'bookCover')->fileInput()->label('Изменить лого') ?>
        <?= $form->field($model, 'bookFile')->fileInput()->label('Заменить книгу') ?>
        <div class="addAuthorList" id="addAuthorList">
        <?php foreach ($model->authors as $author) {?>
            <?= Html::input('hidden', 'authorId[]', $author['id']) ?>
            <?= Html::label('Автор', null, ['class' => 'authorName leftFloat']) ?>
            <?= Html::label($author['name'], null, ['class' => 'authorName leftFloat']) ?>
            <?= Html::button('Убрать автора', ['onClick' => 'cancelAuthor('.$author['id'].');']) ?>
        <?php } ?>
        </div>
        <div class="textCenter"><h4>Добавить автора</h4><br /></div>
        <?= Html::label('Поиск автора', 'searchBox') ?>        
        <?= Html::input('text','searchBox', null, ['class' => 'searchBox', 'id' => 'searchBox', 'autocomplete' => 'off']) ?>
        <?= Html::button('Добавить', ['id' => 'addAuthor', 'onClick' => 'addNewAuthor();']) ?>
        <div class="suggesstionBox" id="suggesstionBox"></div>
        <?= $form->field($model, 'authorIdFlag')->hiddenInput(['id' => 'emptyAuthorIdField', 'value'=>'tmp'])->label(false) ?>
        <?= Html::submitButton('Сохранить', ['id' => 'saveButton']) ?>
    <?php $form = ActiveForm::end(); ?>
</div>