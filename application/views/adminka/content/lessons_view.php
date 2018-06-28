<section>
<table id="table_one"></table>
<div id="le_tablePager"></div>
<table id="table_two"></table>
<div id="le_tablePager2"></div>
<div id="dialog-message"  style="display:none"></div>
<div id="dialog" style="display:none" title="">
<form action="" method="post" id="school">
<select id="class" name="class"></select>
<input type="hidden" id="oper"  name="oper" />
<table>
<tr>
<?php 
$i=0;
$day  = array("Урок","Пн","Вт","Ср","Чт","Пн","Сб");
do
{
	echo "<td>$day[$i]</td>";	
}
while(++$i<count($day))
?>
</tr>
<?php 
$i=1;
$tab=1;
do
{
	echo "<tr><td>$i";
	$j=0;
	do
	{
		echo "<td><input tabindex=\"".$tab."\" type=\"text\" name=\"day".$j."[]\"></td>";
		$tab++;
	}
	while(++$j<6);
	echo "</td></tr>";
}
while(++$i<=8);
?>
</table>
</form>
</div>
</section>
<script type="text/javascript">
function addLessons(school,data,oper) 
{
	var j,i,bad,tab,title;
	$('input').attr("disabled", "disabled");//Блокування полів форми
	 $( "form" )[ 0 ].reset();//Очистка Форми
	 $("#oper").val(oper);//Запис операції з формою
	$('#class').on('change', function() 
	{
		var k = $(this).val();
		if(k==0)$('input').attr("disabled", "disabled"); 
		else $('input').removeAttr("disabled");
		//Заповнення полів форми записами
		if(oper=='edit' && k !=0)
		{ 
			tab=1;
			for (var i = 0; i < data.length; i++)
	  		{
				if(data[i].class == k)
				{
					$('input[tabindex='+tab++ +']').val(data[i].Monday);
					$('input[tabindex='+tab++ +']').val(data[i].Tuesday);
					$('input[tabindex='+tab++ +']').val(data[i].Wednesday);
					$('input[tabindex='+tab++ +']').val(data[i].Thursday);
					$('input[tabindex='+tab++ +']').val(data[i].Friday);
					$('input[tabindex='+tab++ +']').val(data[i].Saturday)
				}
 			 }
		}
	});
	//Поле вибору класу
	$('#class').html('').append($('<option value="0">Оберіть клас:</option>') );
	(school=='one')?j=11:j=9;//Кількість класів
	i=1;
	for(var i=1;i<=j;i++)
	{
			var l=0;
			for (var l = 0; l < data.length; l++)	
				if(data[l].class==i){bad = true; break; }else{bad = false;}
			if(oper == 'edit')
			{
				if(bad)
					$('#class').append($('<option value="'+i+'">Клас '+ i+'</option>'));
			}
			else if(oper == 'add')
			{
				if(!bad)
					$('#class').append($('<option value="'+i+'">Клас '+ i+'</option>'));
			}
	}
	if(school=='one')
		(oper=='edit')? title = 'Внести зміни в розклад занять|ЗОШ I-IIIст.':title = 'Додати розклад занять|ЗОШ I-IIIст.';
	else
		(oper=='edit')?title = 'Внести зміни в розклад занять|ЗОШ I-IIст.':title = 'Додати розклад занять|ЗОШ I-IIст.';
	//Вивід вікна з формою
    $( "#dialog" ).dialog({
	  height: 355,
      width: 975,
      modal: true,
	  title : title,
      buttons: {
         "OK" : function() 
		{
			if($('#class').val() == 0)
				message('Попередження','Будь ласка, оберіть клас');
			else
			{	//Відправка даних на сервер
				$.post("/adminka/addLes/"+school,$("#school").serialize(),function(msg)
				{
					message('Повідомлення',msg);
					$( "form" )[ 0 ].reset();
					$('#dialog').dialog( "close" );
					$('#table_'+school).trigger( 'reloadGrid' );
				},'json');
			}
		},
        "Відміна": function() 
		{
          $( this ).dialog("close");
        }
      }
		});
  };
  /*Школа I-IIIст.*/
$(function(){
	var myGridOne = $('#table_one'),
		myGridTwo = $('#table_two');
myGridOne.jqGrid({
	  url:'/adminka/get_lessons/one',
	  datatype: 'json',
	  mtype: 'POST',
	  height: 300,
	  width: 1024,
	  colNames:['Урок','Клас','Понеділок','Вівторок','Середа','Четвер','П\'ятниця','Субота'],
	  colModel :
	  [
		{name:'les',index:'les',width:40},
		{name:'class',width:40,hidden: true},
		{name:'Monday',width:164,},
		{name:'Tuesday',width:164},
		{name:'Wednesday',width:164},
		{name:'Thursday',width:164},
		{name:'Friday',width:164},
		{name:'Saturday',width:164}
	   ],
	  pager:"le_tablePager",
	  rowNum:88,
	  rowList: [],        // disable page size dropdown
      pgbuttons: false,     // disable page control like next, back button
	   pgtext: null, 
	  caption: 'Розклад занять в Нараївській ЗОШ I-IIIст.',
	  grouping:true,
	  groupingView : 
	  {
		groupField : ['class'],
		groupColumnShow : [false],
		groupText : ['<b>Клас {0}</b>'],
		groupCollapse : true,
		groupOrder: ['asc']   		
	  }  
});	
// Управління тулбаром таблиці
myGridOne.jqGrid('navGrid','#le_tablePager',  
    {add:false,edit:false,del:false,search: false}).navButtonAdd('#le_tablePager',{
            caption:"",
			title:"Внести зміни", 
			 buttonicon:" ui-icon-pencil",
			onClickButton: function()
			{
				var fullData = myGridOne.jqGrid('getRowData');
				addLessons('one',fullData,'edit');	
			}, 
			position:"first"
            }).navButtonAdd('#le_tablePager',{
            caption:"",
			title:"Додати розклад", 
			 buttonicon:" ui-icon-plus",
			onClickButton: function()
			{
				var fullData = myGridOne.jqGrid('getRowData');
				addLessons('one',fullData,'add');
			}, 
			position:"first"
          
});
  /*Школа I-IIст.*/
myGridTwo.jqGrid({
	url:'/adminka/get_lessons/two',
	datatype: 'json',
	mtype: 'POST',
	height: 300,
	width: 1024,
	colNames:['Урок','Клас','Понеділок','Вівторок','Середа','Четвер','П\'ятниця','Субота'],
	colModel :
	[
		{name:'les', index:'les', width:40},
		{name:'class', index:'class', width:40,hidden: true},
		{name:'Monday',  width:164,sortable:false},
		{name:'Tuesday',  width:164,sortable:false},
		{name:'Wednesday', width:164,sortable:false},
		{name:'Thursday', width:164,sortable:false},
		{name:'Friday', width:164,sortable:false},
		{name:'Saturday', width:164,sortable:false}
	],
	pager:"le_tablePager2",
	rowNum:72,
	rowList: [],        // disable page size dropdown
    pgbuttons: false,     // disable page control like next, back button
	pgtext: null,
	grouping:true,
	groupingView : 
	{
		groupField : ['class'],
		groupColumnShow : [false],
		groupText : ['<b>Клас {0}</b>'],
		groupCollapse : true, 		
	},
	caption: 'Розклад занять в Нараївській ЗОШ I-IIст.'
}); 
// Управління тулбаром таблиці 	
myGridTwo.jqGrid('navGrid','#le_tablePager2', 
    {add:false,edit:false,del:false,search: false}).navButtonAdd('#le_tablePager2',{
            caption:"",
			title:"Внести зміни", 
			 buttonicon:" ui-icon-pencil",
			onClickButton: function()
			{
				var fullData = myGridTwo.jqGrid('getRowData');
				addLessons('two',fullData,'edit');
			}, 
			position:"first"
            }).navButtonAdd('#le_tablePager2',{
            caption:"",
			title:"Додати розклад", 
			 buttonicon:" ui-icon-plus",
			onClickButton: function()
			{
				var fullData = myGridTwo.jqGrid('getRowData');
				addLessons('two',fullData,'add');
			}, 
			position:"first"
            });
});
</script>