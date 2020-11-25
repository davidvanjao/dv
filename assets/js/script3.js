$(function(){
	$('#pesquisaModelo').on('keyup', function(){
		var pesquisa = $(this).val();

		$.ajax({
			url:'modelo.processo.php',
			type:'POST',
			data:{pesquisa:pesquisa},
			success:function(html) {
				$('#resultado').html(html);

			}
		});
	});
});
