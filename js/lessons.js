// JavaScript Document
$(function(){
	var myGridOne = $('#table_one'),
		myGridTwo = $('#table_two');
myGridOne.jqGrid({
	  url:'/main/get_lessons/one',
	  datatype: 'json',
	  mtype: 'POST',
	  height: 300,
	  width: 700,
	  colNames:['Урок','Клас','Понеділок','Вівторок','Середа','Четвер','П\'ятниця','Субота'],
	  colModel :
	  [
		{name:'les',width:50},
		{name:'class',width:1,hidden: true},
		{name:'Monday',width:164,},
		{name:'Tuesday',width:164},
		{name:'Wednesday',width:164},
		{name:'Thursday',width:164},
		{name:'Friday',width:164},
		{name:'Saturday',width:100}
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
/*Школа I-IIст.*/
myGridTwo.jqGrid({
	url:'/main/get_lessons/two',
	datatype: 'json',
	mtype: 'POST',
	height: 300,
	width: 700,
	colNames:['Урок','Клас','Понеділок','Вівторок','Середа','Четвер','П\'ятниця','Субота'],
	colModel :
	[
		{name:'les', width:50},
		{name:'class', width:1,hidden: true},
		{name:'Monday',  width:164},
		{name:'Tuesday',  width:164},
		{name:'Wednesday', width:164},
		{name:'Thursday', width:164},
		{name:'Friday', width:164},
		{name:'Saturday', width:100}
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
});
