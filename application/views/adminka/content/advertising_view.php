<section>
<table id="table" ></table>
<div id="le_tablePager"></div>
</section>
<script type="text/javascript">
$(function(){
        var pager = $('#le_tablePager');
		// var curRowId = -1;
$('#table').jqGrid({
                  url:'/adminka/getDataGrid/advertising',
                  datatype: 'json',
                  mtype: 'POST',
				  height: 345,
				  width: 1024,
                  colNames:['Заголовок','Категорія','Телефон','Ім\'я','Опис','Email','Skype','Добавив','Дата'],
                  colModel :[
                    {name:'title', index:'title',width:100,editable:true, edittype:"text", editrules: { required: true }, editoptions: {size: 50}},
					{name:'cat', index:'cat',align: 'center',editable:true,width:100, edittype:"select",
	editoptions:{value:"1:Куплю;2:Продам;3:Шукаю;4:Послуги"},formatter:'select', stype:"select",searchoptions:{sopt:['in','ni'], value:"0:Куплю;1:Продам;2:Шукаю;3:Послуги",multiple: true}},
				{name:'tel', index:'tel',editable:true,width:100, edittype:"text", editrules: { required: true }, editoptions: {size: 50}},
         		{name:'name', index:'name', width:50,editable:true, edittype:"text",searchoptions:{sopt:['bw','bn','ew','en','cn','nc']}},
				{name:'description', width:250,editable:true, edittype:"text",searchoptions:{sopt:['bw','bn','ew','en','cn','nc']}},
				{name:'email', index:'email', width:100,editable:true, edittype:"text",searchoptions:{sopt:['bw','bn','ew','en','cn','nc']}},
				{name:'skype', index:'skype', width:50,editable:true, edittype:"text",searchoptions:{sopt:['bw','bn','ew','en','cn','nc']}},
				{name:'ip_id', index:'ip_id', width:50,editable:true, edittype:"text",searchoptions:{sopt:['bw','bn','ew','en','cn','nc']}},
				{name:'date', index:'date', width:100,editable:false, edittype:"text",formatter: 'date',formatoptions:{srcformat:'Y-m-d H:i:s',newformat:'d F Y'},searchoptions:{sopt:['lt','le','gt','ge'],dataInit: function(element){$(element).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});}}}
                   ],
                  pager: pager,
				  rowNum:20,
                  rowList:[20,40,50,100],
				  sortname: 'id',
                  sortorder: 'asc',
				  viewrecords: true,
                  caption: 'Оголошення',
				  rownumbers: true,
				  rownumWidth: 40,
        		  editurl: '/adminka/jqgrid_crud/advertising'

         });
$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
    {add:true,edit:true,del:true,search: false},
	{closeAfterAdd:true, recreateForm: true, width:460},   // Edit options
    {closeOnEscape:true,closeAfterEdit:true, recreateForm: true, width:460}    //
	

	 // Опции окон удаления
);
});
</script>