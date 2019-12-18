$(function() {
      
	$(".allModuleLists").toggle();
    $(".allModelLists").toggle();
	
});

function toggleModuleList(id)
{
	$("#moduleList"+id).toggle();
}

function toggleModelList(id)
{
	$("#modelList"+id).toggle();
}