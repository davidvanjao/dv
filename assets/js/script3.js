$(function(){

	$('#pesquisa').on('keyup', function(){
		var texto = $(this).val();

		$.ajax({
			url:'busca.php',
			type:'POST',
			data:{texto:texto},
			success:function(html) {
				$('#resultado').html(html);

			}
		});
	});

});
