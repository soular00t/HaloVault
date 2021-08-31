<?php header('Content-type: javascript/text; charset=utf8'); header("Access-Control-Allow-Origin: *"); require_once "../inc/core.php"; 
$users_sql = $_SQL->query("select uname as username, alias as alias, avatar as image from users");
while($user = $users_sql->fetch_assoc()) {
	$users[] = $user;
} ?>

$(document).ready(function () {
	$.getScript("/js/bootstrap-typeahead.js");
	$.getScript("/js/dewSocket.js").done(function () {
		var rcon = new dewWebSocket(true);
	});
	$.getScript("/js/mention.js").done(function () {
		$("#multi-users").mention({
			queryBy: ['alias', 'username'],
			users: <?=json_encode($users);?>
		}); 
	});

	$(function() {
		$('#edit').areYouSure(
			{
				message: 'It looks like you have been editing something. '
				+ 'If you leave before saving, your changes will be lost.'
			}
		);
	});

	new Fingerprint2().get(function(result, components){
		$("body").append('<img src="/inc/ping.php?h=' + result + '" style="display:none" />');
	});

	function loadMore(parent_id, amount) {
		amount--;
		$("#" + parent_id + " > *:lt(" + amount + ")").show();
		$("#" + parent_id + " > *:gt(" + amount + ")").hide();
		if ($("#" + parent_id + " > *:hidden").length == 0) $("[data-action=load-more][data-bound='" + parent_id + "']").hide();
	}
	$("[data-load-more]").each(function() {
		loadMore($(this).attr("id"), $(this).data("load-more"));
		$("[data-action=load-more][data-bound='" + $(this).attr("id") + "']").data("count", $(this).data("load-more"));
	});
	$("[data-action=load-more]").click(function() {
		var new_count = ($(this).data("count") + 10);
		$(this).data("count", new_count);
		loadMore($(this).data("bound"), new_count);
	});

	
	});

	$(function() {
		$( ".dialog" ).dialog({
			autoOpen: false,
			width: 'auto',
			height: 'auto',
			show: {
				effect: "explode",
				duration: 500
			},
			hide: {
				effect: "fold",
				duration: 700
			}
		});

		$( ".dialog_link" ).click(function() {
			$("#" + $(this).data("dialog")).dialog("open");
		});
	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip({container:'.forgeList'})
	});


	window.navPos = $(".nav").offset().top;
	$(document).scroll(function() {
		if ($(window).scrollTop() >= window.navPos) {
			$(".nav").addClass("fixed");
		} else {
			$(".nav").removeClass("fixed");
		}
	});

	$('input#public').on('change', function() {
		$('input#public').not(this).prop('checked', false);  
	});

	$('form').append('<input type="hidden" name="_TOKEN" value="<?=$_TOKEN;?>" />');