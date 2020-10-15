var Root="http://"+document.location.hostname+"/";
/*
$('#BotaoPagamento').on('click',function(event){
    event.preventDefault();

    $.ajax({
        url: Root+"Controllers/ControllerPagamentoDireto.php",
        type: 'POST',
        dataType:'html',
        success:function(data){
            $('#code').val(data);
            $('#FormPagamento').submit();
        }
    });
});
*/
// Iniciar a seção de pagamento
function iniciarSessao()
{
    $.ajax({
       url: Root+"Controllers/ControllerId.php",
        type: 'POST',
        dataType: 'json',
        success:function(data){
            //PagSeguroDirectPayment.setSessionId(data.id);
			console.log(data);
        }
    });
}
iniciarSessao();
