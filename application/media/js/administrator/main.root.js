/* ###

:: APP CONTROLLER :: MAKE IMAGE DIR RELATIVE :: images/ ::

### */

$(document).ajaxStart(showUI).ajaxStop($.unblockUI);
        
function showUI()
{
    $.blockUI({
            message: '<h1>Trwa przetwarzanie... Czekaj!</h1>',
            css: { 
                    border: 'none', 
                    padding: '15px',
                    backgroundColor: '#000', 
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    opacity: .5, 
                    color: '#fff' 
                }
        });
}

$(function() {

    $(".clearBtn").click(function() {
        var cel = $(this).attr("alt");
        if(cel !== undefined)
        {
            $("." + cel).val("");
        }
    });
    
    $(".remIdButton").live("click", function() {
        
        // Pobranie wartości z nazwy ostatniego input'a
        var currId = $("td.idTranslationInput input").last().attr("name");
        // Ekstrakcja wartości liczbowej
        currId = currId.substr(2);
        
        $("td.idTranslationInput div.id"+currId).remove();
    });
    
    $(".addIdButton").click(function() {
        
        // Pobranie wartości z nazwy ostatniego input'a
        var currId = $("td.idTranslationInput input").last().attr("name");
        // Ekstrakcja wartości liczbowej
        currId = currId.substr(2);
        nextId = parseInt(currId)+1;
        
        $("td.idTranslationInput").append("<div class=\"id"+(nextId)+"\"><input type=\"text\" name=\"id"+(nextId)+"\" value=\"\" /><a href=\"javascript:void(0);\" class=\"remIdButton\"><img src=\"images/remove.png\" alt=\"REM\" /></a></div>");
    });
    
    $(".remLangButton").live("click", function() {
        
        // Pobranie wartości z nazwy ostatniego input'a
        var currId = $("td.idLangInput input").last().attr("name");
        // Ekstrakcja wartości liczbowej
        currId = currId.substr(4);
        
        $("td.idLangInput div.lang"+currId).remove();
    });
    
    $(".addLangButton").click(function() {
        
        // Pobranie wartości z nazwy ostatniego input'a
        var currId = $("td.idLangInput input").last().attr("name");
        // Ekstrakcja wartości liczbowej
        currId = currId.substr(4);
        nextId = parseInt(currId)+1;
        
        $("td.idLangInput").append("<div class=\"lang"+(nextId)+"\"><input type=\"text\" name=\"lang"+(nextId)+"\" value=\"\" /><a href=\"javascript:void(0);\" class=\"remLangButton\"><img src=\"images/remove.png\" alt=\"REM\" /></a></div>");
    });
    
    // Ajaxowe zapisanie formy
    
    $(".TC_formSaverBtn").click(function() {
        
        $.ajax({
            type: "POST",
            url: "application/media/_external/translation.php",
            processdata: false,
            data: "checkTr=true&name="+$("#nameOftranslation").val(),
            success: function(data)
            {
                if(data == "true")
                {
                    document.translationForm.submit();
                }
                else
                {
                    alert("Wystąpił błąd podczas sprawdzania poprawności wiersza \"Nazwa\". Możliwe, że taka nazwa istnieje w bazie danych.");
                }
                
            }	            
       	});
        
    });

});

function addNewtranslationID(tablename, columnname)
{
    var newId = prompt("Czy zaproponowana nazwa ID jest wg. Ciebie OK?", columnname);
    if(newId != null && newId != "")
    {
        addNewtranslationID_db(tablename, newId);
    }
}

function addNewtranslationID_db(tablename, columnname)
{
    $.ajax({
        type: "POST",
        url: "application/media/_external/translation.php",
        processdata: false,
        data: "addNewID=true&tablename="+tablename+"&columnname="+columnname,
        success: function(data)
        {
            if(data == "true")
            {
                window.location.reload();
            }
            else
            {
                alert("Wystąpił błąd podczas dodawania nowego ID tłumaczeń!");
            }
            
        }	            
   	});
}

function saveAllTranslations(obj, loc)
{
    var res = "";
    $(obj).each(function() {
        res += $(this).attr("name") + "=" + getCode($(this).attr("id")) + "&";
    });
    
    n = res.lastIndexOf("&");
    res = res.substr(0, n);
    
    db = loc.split(";");
    
    $.ajax({
        type: "POST",
        url: "application/media/_external/translation.php",
        processdata: false,
        data: "editID=true&tablename="+db[0]+"&columnname="+db[1]+"&"+res,
        success: function(data)
        {
            if(data == "true")
            {
                window.location.reload();
            }
            else
            {
                alert("Wystąpił błąd podczas edycji tłumaczenia!");
            }
            
        }	            
   	});
}

function removeTranslation(tablename)
{
    var conf = confirm("Czy na pewno chcesz usunąć całe tłumaczenie "+tablename.substr(3).replace("_", "/")+" ?");
    if(conf)
    {
        $.ajax({
            type: "POST",
            url: "application/media/_external/translation.php",
            processdata: false,
            data: "removeTr=true&tablename="+tablename,
            success: function(data)
            {
                if(data == "true")
                {
                    window.location.reload();
                }
                else
                {
                    alert("Wystąpił błąd podczas usuwania tłumaczenia!");
                }
            }	            
       	});
    }
}

function addNewSubpage(controller)
{
    var name = prompt("Podaj nazwę dla nowej strony", '');
    if(name != null && name != "")
    {
        $.ajax({
            type: "POST",
            url: "application/media/_external/administrator.php",
            processdata: false,
            data: "addNewSubpage=true&controller="+controller+"&pagename="+name,
            success: function(data)
            {
                if(data == "true")
                {
                    window.location.reload();
                }
                else
                {
                    alert(data);
                }
            }	            
       	});
    }
}

function removeSelected(controller)
{
    var result = "";
    
    $("input[name='subpage'][type='checkbox']:checked").each(function() {
        result = result + $(this).val() + ", ";
    });
    
    result = result.substr(0, result.length - 2);
    
    if(result != undefined && result != "")
    {
        var ask = confirm("Czy na pewno chcesz usunąć " + result + " ?");
        if(ask)
        {
            $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "removeSubpage=true&controller="+controller+"&pages="+result,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
        }
    }
}

function saveController(controller)
{
    var ask = confirm("Czy chcesz zapisać zmiany w pliku " + controller + ".php ?");
    if(ask)
    {
        var code = getCode();

        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "saveController=true&controller="+controller+"&content="+code,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
}

function saveMethod(controller, method)
{
    var module = "";
    var model = "";
    var hook = "";
    
    $("input[name='module'][type='checkbox']:checked").each(function() {
        module = module + $(this).val() + ", ";
    });
    
    module = module.substr(0, module.length - 2);
    
    $("input[name='model'][type='checkbox']:checked").each(function() {
        model = model + $(this).val() + ", ";
    });
    
    model = model.substr(0, model.length - 2);
    
    $("input[name='hook'][type='checkbox']:checked").each(function() {
        hook = hook + $(this).val() + ", ";
    });
    
    hook = hook.substr(0, hook.length - 2);
    
    if(module != undefined && module != "")
    {
        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "saveMethod=true&controller="+controller+"&method="+method+"&main="+module+"&model="+model+"&hook="+hook,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
        
    
}

function saveMethodSource(controller, method)
{
    var ask = confirm("Czy chcesz zapisać zmiany w pliku " + controller + ".php ?");
    if(ask)
    {
        var code = getCode();

        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "saveMethodSource=true&controller="+controller+"&method="+method+"&code="+code,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
}

function saveModule(module)
{
    var ask = confirm("Czy chcesz zapisać zmiany w pliku " + module + ".php ?");
    if(ask)
    {
        var code = getCode();

        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "saveModule=true&module="+module+"&content="+code,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
}


function htmlspecialchars_decode (string, quote_style) {
    // http://kevin.vanzonneveld.net
    // +   original by: Mirek Slugen
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Mateusz "loonquawl" Zalega
    var optTemp = 0,
        i = 0,
        noquotes = false;
    if (typeof quote_style === 'undefined') {
        quote_style = 2;
    }
    string = string.toString().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
    var OPTS = {
        'ENT_NOQUOTES': 0,
        'ENT_HTML_QUOTE_SINGLE': 1,
        'ENT_HTML_QUOTE_DOUBLE': 2,
        'ENT_COMPAT': 2,
        'ENT_QUOTES': 3,
        'ENT_IGNORE': 4
    };
    if (quote_style === 0) {
        noquotes = true;
    }
    if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
        quote_style = [].concat(quote_style);
        for (i = 0; i < quote_style.length; i++) {
            // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
            if (OPTS[quote_style[i]] === 0) {
                noquotes = true;
            } else if (OPTS[quote_style[i]]) {
                optTemp = optTemp | OPTS[quote_style[i]];
            }
        }
        quote_style = optTemp;
    }
    if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
        string = string.replace(/&#0*39;/g, "'"); // PHP doesn't currently escape if more than one 0, but it should
        // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
    }
    if (!noquotes) {
        string = string.replace(/&quot;/g, '"');
    }
    // Put this in last place to avoid escape being double-decoded
    string = string.replace(/&amp;/g, '&');

    return string;
}



function saveUserPage(controller, method)
{
    var ask = confirm("Czy chcesz zapisać wprowadzone zmiany ?");
    if(ask)
    {
        CKEDITOR.instances['editor1'].updateElement();
        var content = CKEDITOR.instances['editor1'].getData();
        content = htmlspecialchars_decode(content);
        content = content.replace("&nbsp;", " ");
        
        var title = $("#pageTitle").val();
        
        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: true,
                data: "saveUserPage=true&controller="+controller+"&method="+method+"&content="+escape(content)+"&pageTitle="+title,
                dataType: 'html',
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
}

function addNewPage(beginInfo)
{
    var newId = prompt(beginInfo + "Wprowadź nazwę nowej strony.");
    var pattern = /^[A-Za-z]+$/g;
    var test = pattern.test(newId);
    if(test)
    {
        doAddNewPage(newId);
    }
    else if(!test)
    {
        addNewPage("Wpisana nazwa strony jest niepoprawna. Wpisz ją ponownie.\n");
    }
}

function doAddNewPage(pagename)
{
    if(pagename != null)
    {
        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "addNewPage=true&pagename="+pagename,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
}

function removePage(pagename)
{
    var ask = confirm("Czy napewno chcesz usunąć stronę '" +pagename+ "'?");
    if(ask)
    {
        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "removePage=true&pagename="+pagename,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
}

function addNewModule()
{
    var name = prompt("Podaj nazwę nowego modułu", '');
    if(name != null && name != "")
    {
        $.ajax({
            type: "POST",
            url: "application/media/_external/administrator.php",
            processdata: false,
            data: "addNewModule=true&module="+name,
            success: function(data)
            {
                if(data == "true")
                {
                    window.location.reload();
                }
                else
                {
                    alert(data);
                }
            }	            
       	});
    }
}

function removeModule(module)
{
    var ask = confirm("Czy napewno chcesz usunąć moduł '" +module+ "'?");
    if(ask)
    {
        $.ajax({
                type: "POST",
                url: "application/media/_external/administrator.php",
                processdata: false,
                data: "removeModule=true&module="+module,
                success: function(data)
                {
                    if(data == "true")
                    {
                        window.location.reload();
                    }
                    else
                    {
                        alert(data);
                    }
                }	            
           	});
    }
}





































