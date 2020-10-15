var amount = $('#amount').val();

pagamento();

function pagamento() {

    $('.PAC').hide();
    $('.SEDEX').hide();
    $('.SEMFRETE').hide();	

}

function tipoFrete(shippingType){
    if(shippingType == "1"){
        $('.PAC').show();
        $('.SEDEX').hide();
		$('.SEMFRETE').hide();		
    }
    if(shippingType == "2"){
        $('.PAC').hide();
        $('.SEDEX').show();
		$('.SEMFRETE').hide();		
    }
    if(shippingType == "3"){
        $('.PAC').hide();
        $('.SEDEX').hide();
		$('.SEMFRETE').show();		
    }
}
