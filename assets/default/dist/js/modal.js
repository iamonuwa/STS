$(document).on('click', '#preview_record', function (e) {
	e.preventDefault();
	$.post('',
	{
		id: $(this).attr('data-id')
	},
	function(html){
			$(".modal-body").html(html);
		}
	);
});