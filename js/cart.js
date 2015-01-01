/**
 *   Set decimal point
 */	
function appSetDecimalPoint(num){
	var num_ = (num != null) ? num.toString() : "";
	var currency_format = document.getElementById("hid_currency_format").value;
	
	if(currency_format == 'european'){
		num_ = num_.replace(".", ",");
		return num_;
	}
	return num_;
}

/**
 *   Update total sum of shopping cart
 */	
function appUpdateTotalSum(ind, num, total_extras){
	arrExtrasSelected[ind] = num;
	
	var booking_initial_fee = document.getElementById("hid_booking_initial_fee").value;
	var vat_percent = document.getElementById("hid_vat_percent").value;
	var vat_sum = 0;
	var order_price = document.getElementById("hid_order_price").value;
	var currency_symbol = document.getElementById("hid_currency_symbol").value;
	var extras_total_sum = 0;
	var cart_total_sum = 0;
	
	for(i=0; i < total_extras; i++){
		extras_total_sum += (arrExtrasSelected[i] * arrExtras[i]);
	}
	
	vat_sum = parseFloat((parseFloat(order_price) + parseFloat(booking_initial_fee) + parseFloat(extras_total_sum)) * parseFloat(vat_percent / 100));
	cart_total_sum = parseFloat((parseFloat(order_price) + parseFloat(booking_initial_fee) + parseFloat(extras_total_sum)) + parseFloat(vat_sum));
	
	document.getElementById("reservation_vat").innerHTML = currency_symbol+appSetDecimalPoint(vat_sum.toFixed(2));
	document.getElementById("reservation_total").innerHTML = currency_symbol+appSetDecimalPoint(cart_total_sum.toFixed(2));
	
	// show effect on changed text
	jQuery("#reservation_vat").animate({opacity: 0.25}, 70).animate({opacity: 1}, 70);  
	jQuery("#reservation_total").animate({opacity: 0.25}, 70).animate({opacity: 1}, 70);  	
}
