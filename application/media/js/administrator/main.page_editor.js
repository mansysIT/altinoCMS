var editor = CKEDITOR.replace('editor1', 
{
    width : 700,
    height: 500,
    contentsCss : ['application/media/css/format.css', 'application/media/css/style.css', 'application/media/css/screen.css', 'application/media/css/allRating.css'],
    toolbar : 
    [ 
        { name: 'document', items : [ 'Source','NewPage','Preview' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
        { name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        '/',
		{ name: 'styles', items : [ 'Styles','Format' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'tools', items : [ 'Maximize','-','About' ] },
        '/',
        { name: 'CMS tools', items: [ 'SuperCMS_TranslateButton' ] }        
    ]
});

editor.on('pluginsLoaded', function(ev)
{
    if (!CKEDITOR.dialog.exists('SuperCMS_TranslateDialog'))
    {
        CKEDITOR.dialog.add('SuperCMS_TranslateDialog', function(editor)
        {
       	    return {
      		    title : 'Dodaj nowe tłumaczenie',
          		minWidth : 400,
          		minHeight : 80,
                height: 80,
          		contents : 
                [{
    				id : 'tab1',
    				label : 'Dodaj nowe tłumaczenie',
    				title : 'Dodaj nowe tłumaczenie',
    				elements : 
                    [{
  						id : 'input1',
  						type : 'text',
  						label : 'Wprowadź nazwę tłumaczenia',
                        validate : CKEDITOR.dialog.validate.notEmpty("To pole nie może być puste!")
   					}]
     			}],
                onOk : function()
                {
                	var dialog = this;
                    var tr = "[sTr]" + dialog.getValueOf('tab1', 'input1') + "[eTr]";
                    editor.insertText(tr);
                }
       	    };
        });
    }

    editor.addCommand('SuperCMS_TranslateCommand', new CKEDITOR.dialogCommand('SuperCMS_TranslateDialog'));

    editor.ui.addButton('SuperCMS_TranslateButton',
    {
        label : 'Dodaj/edytuj tłumaczenie',
        command : 'SuperCMS_TranslateCommand',
        icon: 'images/page_editor_lang.png'
    });
    
});