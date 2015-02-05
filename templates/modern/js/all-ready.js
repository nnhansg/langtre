// All ready
$(document).ready(function() {
	//======================================
	$('.book_price_type_1').click(function(){
		$('input.price_type').val(1);
		$('input.room_price').val($(this).attr('data-room-price'));
		$(this).parents('form:first').submit();
	});

	$('.book_price_type_2').click(function(){
		$('input.price_type').val(2);
		$('input.room_price').val($(this).attr('data-room-price'));
		$(this).parents('form:first').submit();
	});

	//======================================
	hs.graphicsDir = '/templates/modern/vendor/highslide/graphics/';
	hs.outlineType = 'rounded-white';
	hs.showCredits = false;
	hs.wrapperClassName = 'draggable-header';
	hs.minWidth = 600;
});