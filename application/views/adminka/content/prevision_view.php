<section>
<table id="table" ></table>
<div id="le_tablePager"></div>
</section>
<script type="text/javascript">
$(function(){
        var pager = $('#le_tablePager');
		// var curRowId = -1;
$('#table').jqGrid({
                  url:'/adminka/getDataGrid/prevision',
                  datatype: 'json',
                  mtype: 'POST',
				  height: 345,
				  width: 1024,
                  colNames:['Передбачення'],
                  colModel :[
                    {name:'prognoz', index:'prognoz',editable:true, edittype:"text", editrules: { required: true }, editoptions: {size: 50}},
         
                   ],
                  pager: pager,
				  rowNum:20,
                  rowList:[40,50,100],
				  sortname: 'id',
                  sortorder: 'asc',
				  viewrecords: true,
                  caption: 'Передбачення для вас',
				  rownumbers: true,
				  rownumWidth: 40,
        		  editurl: '/adminka/jqgrid_crud/prevision'

         });
$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
    {add:true,edit:true,del:true,search: false},
	{closeAfterAdd:true, recreateForm: true, width:460},   // Edit options
    {closeOnEscape:true,closeAfterEdit:true, recreateForm: true, width:460}    //
	

	 // Опции окон удаления
);
});
</script>