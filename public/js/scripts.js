$(function(){

	function deplace() {
		$('#presentation_artiste').animate({
			top: '+=1'
		},
			100,
			'linear',
			function () {
				$('#lienArtiste').addClass('active_link');
			});
	}


	$('#page-loader').delay(600).fadeOut(400, function() {
		$('#accueil').fadeIn();	
	});

	$('main').fadeIn;

	$('#oeuvre_reset').parent('div').css('display', 'inline');
	$('#oeuvre_submit').parent('div').css('display', 'inline');

	$('#form_reset').parent('div').css('display', 'inline');
	$('#form_submit').parent('div').css('display', 'inline');
	
	$('#client_reset').parent('div').css('display', 'inline');
	$('#client_submit').parent('div').css('display', 'inline');
	
	$('#membre_reset').parent('div').css('display', 'inline');
	$('#membre_submit').parent('div').css('display', 'inline');

	


	$('#lienContact').click(function () {
		$("#lienContact").addClass("active_link");
	});

	$('#lienArtiste').click(function () {
		$("#accueil").animate({ top: '751px' });
		$("#lienArtiste").addClass("active_link");
	});

	$("#membre_adresses_0").siblings('label').hide();

	$('#lienArtiste').click(function () {
		var the_id = $('#artiste');
		$('html, body').animate({
			scrollTop: $(the_id).offset().top
		}, 'slow');
		return false;
	});

	$('#lienContact').click(function () {
		var the_id = $('#contact');
		$('html, body').animate({
			scrollTop: $(the_id).offset().top
		}, '2000');
		return false;
	});

});
