$(document).ready(function () {
	var schoolSel = $('#school');
	$('#town').change(function () {
		var townId = $(this).val();
		if (townId == -1)
		{
			schoolSel.empty();
			schoolSel.hide();
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
						schoolSel.slideDown();
					}
					else
					{
						schoolSel.fadeOut();
					}
				}
			})
		}
	});
});