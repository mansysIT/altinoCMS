$(function() {
    
    $(".codeMirrorArea").each(function() {
        editor($(this).attr("id"));
    });
      
});

function editor(id)
{   
    window[id] = CodeMirror.fromTextArea(document.getElementById(id), {
                lineNumbers: true,
                lineWrapping: true,
                mode: "text/html",
                tabMode: "indent",
                theme: "elegant"
            });
}

function getCode(id)
{
    return window[id].getValue();
}
