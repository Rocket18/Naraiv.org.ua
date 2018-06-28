<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?>
<?=$breadcrumb['hardcoded_segment'].' » ';?>
<?=$breadcrumb['breadcrumb_arrow'];?>
<a class="download" href="/photo/add">Завантажити фотографії</a>
</div>
<table id="table" ></table>
<div id="le_tablePager"></div>
<div id="dialog-message"></div>
 <div id="back-top"><a href="#top"><img src="<?=base_url();?>img/up.png" title="Вверх" alt="Вгору"></a></div>
</div>
<script type="text/javascript">
$(function(){
        var pager = $('#le_tablePager');
		 var lastsel;
$('#table').jqGrid({
	url:'/photo/photo_jqgrid',
	datatype: 'json',
	mtype: 'POST',
	height: 500,
	width:736,
	colNames:['Картинка','Категорія','Доступ','Назва','Завантажено'],
	colModel :[
	{name:'photo_src',sortable:false,search:false,editable: false,align: 'center', width:150,formatter:createimg},
	{name:'cat', index:'cat', width:100,align: 'center',editable:true, edittype:"select",
	editoptions:{value:"0:Школа;1:Село і люди;2:Природа;3:У нас в клубі;4:Інше"},formatter:'select', stype:"select",searchoptions:{sopt:['in','ni'], value:"0:Школа;1:Село і люди;2:Природа;3:У нас в клубі;4:Інше",multiple: true}},
	{name:'access', index:'access', width:150,align: 'center',editable: true, edittype:"select",stype:"select",editoptions: {value:"0:Для всіх;1:Тільки для зареєстрованих"},formatter:'select',searchoptions:{sopt:['eq','ne'],value:"0:Для всіх;1:Тільки для зареєстрованих"}},
	{name:'title', index:'title', width:200,editable:true, edittype:"text",searchoptions:{sopt:['bw','bn','ew',,'en','cn','nc']}},
	{name:'date', index:'date', width:100,editable:false, edittype:"text",formatter: 'date',formatoptions:{srcformat:'Y-m-d H:i:s',newformat:'d F Y'},searchoptions:{sopt:['lt','le','gt','ge'],dataInit: function(element){$(element).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});}}}
	],
	pager: pager,
	rowNum:20,
	rowList:[20,40,100],
	sortname: 'id',
	sortorder: 'desc',
	caption: 'Мої фотографії',
	rownumbers: true,
	rownumWidth: 25,
	viewrecords: true,
	onSelectRow: function (id)
	{
    	if (id && id !== lastsel)
		{
        	jQuery('#table').jqGrid('restoreRow', lastsel);
                jQuery('#table').jqGrid('editRow', id, true);
               lastsel = id;
         }
    },
	editurl:'/photo/jqgrid_crud'
	});
	$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
	{add:false,edit:false,del:true,search: true},
	{},
	{},
	{},
	{ multipleSearch:true, closeAfterSearch:true, showQuery: true }
	// Опции окон удаления
	);
jQuery("#table").jqGrid('editRow',rowid, 
{ 
    keys : true
});
/*jQuery("#table").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});*/
function createimg(links) 
{
	var output;
	output = '<img src="/img/photos/thumbs/'+links+'" width="150" height="90">';
	return output;
}

jQuery('#table_iledit').click(function()
{
	var selr = jQuery('#table').jqGrid('getGridParam','selrow'); 
	if(!selr) message('Попередження',"Оберіть запис для редагування");  	
});
});
</script>