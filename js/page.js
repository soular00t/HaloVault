function loadPage(start, rows) {
	$.ajax({
		type:'post',
		url:'/inc/paginate.php',
		data:'paginate=maps&start='+start+'&rows='+rows,
		success:function(e) {

			$('.forgeList').html(e);

			if($('.forgeList .row').length == rows) {
				$('#next').show();
			}
			else {
				$('#next').hide();
			}
			if(start == 0) {
				$('#prev').hide();
			}
			else {
				$('#prev').show();
			}

			$('.skip_to.first').html(((parseInt($('#pagination input[name="page_num"]').val())+1 >= parseInt($('.skip_to.last_page').html()))?'':parseInt($('#pagination input[name="page_num"]').val())+1));
			$('.skip_to.second').html(((parseInt($('#pagination input[name="page_num"]').val())+2 >= parseInt($('.skip_to.last_page').html()))?'':parseInt($('#pagination input[name="page_num"]').val())+2));
			$('.skip_to.third').html(((parseInt($('#pagination input[name="page_num"]').val())+3 >= parseInt($('.skip_to.last_page').html()))?'':parseInt($('#pagination input[name="page_num"]').val())+3));
		}
	});
}

$(function() {
	var rows = 20;

	$('.load_more').click(function() {
		var page_num_input = $(this).parent().find('input[name="page_num"]');

		if($(this).attr('id')=='prev') {
			$(page_num_input).val(parseInt($(page_num_input).val())-1);
		}
		else {
			$(page_num_input).val(parseInt($(page_num_input).val())+1);
		}

		var page_num = parseInt($(page_num_input).val());

		var start = (page_num == 0)?0:(page_num*rows)+1;

		loadPage(start, rows);

	});

	$('.skip_to').click(function() {
		var this_num = parseInt($(this).html());
		var page_num_input = $(this).parent().find('input[name="page_num"]');
		var start = (this_num == 1)?0:((this_num-1)*rows)+1;
		loadPage(start, rows);
		$(page_num_input).val(this_num-1);
	});
	
	$.post('/inc/paginate.php', 'paginate=maps&row_count=1', function(e) {	
		var last_page = Math.ceil(parseInt(e)/rows);
		$('.last_page').html(last_page);
	});

	$('#next').click();
});