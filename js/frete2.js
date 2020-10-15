	function LoadFrete() {
		//alert('botão funcionando!!');
		
		var cep_destino = $('#cep_destino').val();

		$.ajax({
			url: 'application/models/calcula-frete_model.php',
			type:'POST',
			dataType:'html',
			cache: false,
			data: {cep_destino: cep_destino},
			success:function(data){
				
				console.log('Valor do Frete = ' +data);
				$('#valor_frete').val(data);
				
				var valor_prod = $('#valor_prod').val();
				
				valor_prod 	= valor_prod.replace(',','.');
				data  		= data.replace(',','.');
				var total 	= parseFloat(data) + parseFloat(valor_prod);
				$('#valor_total').val(total);
				

			}, beforeSend: function(){
			
			}, error: function(jqXHR, textStatus, errorThrown){
				console.log('Erro');
			}
		});
		
	}
