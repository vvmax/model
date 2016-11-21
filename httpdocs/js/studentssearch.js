$(document).ready(function () {
	var schoolDiv = $('#school'),
			schoolSel = schoolDiv.find('select:first'),
			townSel = $('#town'),
			classInp = $('#class'),
			loginInp = $('#login'),
			secondnameInp = $('#secondname'),
			firstnameInp = $('#firstname'),
			form = $('#searchform');
	var onSubmit = function (event) {
		if (
				townSel.val() > -1
				|| classInp.val() !== ''
				|| loginInp.val().length > 1
				|| secondnameInp.val().length > 1
				|| firstnameInp.val().length > 1
				)
		{
			var formData = form.serializeArray();
			formData.push({name: 'action', value: 'search'});
			$.ajax({
				url: '/api.php',
				data: formData,
				method: 'get',
				dataType: 'json',
				success: function (data)
				{
					console.log(123);
					var table = $('#searchtable');
					table.empty();
					for (i = 0; i < data.users.length; ++i)
					{

						var html='<tr>';
						html+='<td>'+
								data.users[i].SECONDNAME+' '+
								data.users[i].FIRSTNAME+' '+
								data.users[i].LASTNAME+
								'</td>';
						html+='<td>'+
								data.users[i].TOWNS_NAME+' '+
								data.users[i].SCHOOLS_NAME+' '+
								data.users[i].FORM+
								'</td>';
						html+='<td>'+data.users[i].LOGIN+'</td>';
						if(data.users[i].FRIENDS_STUDENTID==data.users[i].ID)
						{html+='<td>Добавлен</td>'}
						else
						{html+='<td><a href="#" onclick="addStudent(this,'+data.users[i].ID+')" class="button">Добавить</a></td>';};
					    html+='</tr>';
						table.append(html);
					}
					/**
					 0: Object
					 FIRSTNAME: "Максим"
					 ID: "2"
					 LOGIN: "vvmax01"
					 SCHOOLS_NAME: "Лицей"
					 SECONDNAME: "Воробьев"
					 TOWNS_NAME: "Иваново"
					 */
					}
			})
		}
		return false;
	};
	secondnameInp.bind('input', onSubmit);
	classInp.bind('input', onSubmit);
	loginInp.bind('input', onSubmit);
	firstnameInp.bind('input', onSubmit);
	schoolSel.change(onSubmit);
	form.submit(onSubmit);
	townSel.change(function () {
		var townId = $(this).val();
		if (townId === -1)
		{
			schoolSel.empty();
			schoolDiv.hide();
		}
		else
		{
			$.ajax({
				url: '/api.php',
				data: {Id: townId, action: 'getSchool'},
				method: 'get',
				dataType: 'json',
				success: function (data)
				{
					schoolSel.empty();
					schoolSel.append($('<option/>', {val: -1, text: ''}));
					for (i = 0; i < data.schools.length; ++i)
					{
						schoolSel.append($('<option/>', {val: data.schools[i].ID, text: data.schools[i].NAME}));
					}
					;
					if (data.schools.length !== 0)
					{
						schoolDiv.slideDown();
					}
					else
					{
						schoolDiv.slideUp();
					}
				}
			});
		}
	});
});
function addStudent(bt,id)
{
	var btn = $(bt);
	console.log(id);
	$.ajax({
				url: '/api.php',
				data: {STUDENTID: id, action: 'addStudent'},
				method: 'get',
				dataType: 'json',
				success: function (result) 
				{
					
					if(result.error===0)
					{
						console.log(btn,btn.parent('td'));
						btn.parent('td').empty().text('Добавлен');
					}
					else
					{}
				}
	});
};