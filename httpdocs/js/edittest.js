page = {
	categoryCount: 0,
	init: function () {
		$('#edittesttable').on('click', '.jsaddelement', page.onAddElement);
		$('#addcategory').click(page.onAddCategory);
		$('#edittesttable').on('click', '.jsdeletenew', page.onDeleteNew);
		page.categoryCount = $('.jscategory').length;
	},
	onDeleteNew: function () {
		var row = $(this).closest('tr');
		var rows = $('tr.jselement,tr.jscategory');
		var indx = row.index('tr.jselement,tr.jscategory');
		var i;
		for (i=indx+1; i<rows.length;++i)
		{
			var jrow = $(rows[i]);
			if (jrow.hasClass('jscategory'))
			{

				break;
			};
			jrow.remove();
			
		};
		row.remove();
	},
	onAddElement: function () {
		var text, row = $(this).closest('tr');
		text = '<tr class = "jselement">' +
				'<td colspan="3">' +
				'<input  name="CATEGORY[' + row.data('index') + '][ELEMENT][]" type="text" placeholder="Название элемента">' +
				'</td>' +
				'<td>' +
				'<a class = "jsdeletenew delete" href="javascript: void(0);"> &times; </a>' +
				'</td>' +
				'</tr>';
		$(text).insertAfter(row);
	},
	onAddCategory: function () {
		var text, row = $(this).closest('tr');
		text = '<tr class="jscategory" data-index="new' + page.categoryCount + '">' +
				'<td>'+
				'<input class="centered" type="text" value="0" name="CATEGORY[new' + page.categoryCount + '][SORT]" size="1">'+
				'</td>'+
				'<td>' +
				'<input name="CATEGORY[new' + page.categoryCount + '][NAME]" type="text" placeholder="Ветвь схемы">' +
				'</td>' +
				'<td>' +
				'<button type="button" class="jsaddelement">+ Элемент</button>' +
				'</td>' +
				'<td>' +
				'<a class = "jsdeletenew delete" href="javascript: void(0);"> &times; </a>' +
				'</td>' +
				'</tr>';
		page.categoryCount++;
		$(text).insertBefore(row);
	}
};
$(document).ready(function () {
	page.init();
});