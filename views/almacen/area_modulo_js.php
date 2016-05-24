<script type="text/javascript">
<!--
	$('.clona').on('click', clona);
    
    function clona(event)
    {
        if(confirm('Seguro que deseas CLONAR este modulo ?'))
        {
            return true;
        }else{
            event.preventDefault();
            return false;
        }
    }


	$('.elimina').on('click', elimina);
    
    function elimina(event)
    {
        event.preventDefault();
        var $rel = event.currentTarget.attributes.rel.value;
        var $url = event.currentTarget.attributes.href.value;
        
        if(confirm('Seguro que deseas ELIMINAR este ' + $rel + ' ?'))
        {
            gotoURL($url);
            return true;
        }else{
            
            return false;
        }
    }

    function gotoURL($url){
        
        var $variables = { };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                location.reload();
                                
             });
    
    }


    function gotoURL2($url, $posiciones){
        
        var $variables = { posiciones: $posiciones};
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                location.reload();
                                
             });
    
    }

	$('.agrega').on('click', agrega);

    function agrega(event)
    {
        event.preventDefault();
        var $rel = event.currentTarget.attributes.rel.value;
        var $url = event.currentTarget.attributes.href.value;
        
        if(confirm('Seguro que deseas AGREGAR este ' + $rel + ' ?'))
        {
            if($rel == 'NIVEL')
            {
                var $posiciones = prompt("Cuantas posiciones tendra este nuevo nivel: ", "5");
                gotoURL2($url, $posiciones);
            }else{
                gotoURL($url);
            }
            
            return true;
        }else{
            
            return false;
        }
    }
    
    
    $('#idArticulo').on('change', articuloCombo);
    
    function articuloCombo(event)
    {
        var $cont = $(this).find(":selected").text();
        var $paso = $cont.split("|");
        $("#cvearticulo").html($paso[0]);
        $("#susa").html($paso[1]);
        $("#descripcion").html($paso[2]);
        $("#pres").html($paso[3]);
    }
    

				$( "a[id^='id-btn-dialog-']" ).on('click', function(e) {
					e.preventDefault();
                    
                    var $ubicacion = e.currentTarget.id;
                    $ubicacion = $ubicacion.replace('id-btn-dialog-', '');
                    
                    
                    var $rel = e.currentTarget.attributes.rel.value;
                    var $minimo = e.currentTarget.attributes.minimo.value;
                    var $maximo = e.currentTarget.attributes.maximo.value;
                    
                    $("#minimo").val($minimo);
                    $("#maximo").val($maximo);

                    if($rel > 0)
                    {
                        $('#idArticulo').val($rel);
                    }
                    
					var dialog = $( "#dialog-message" ).dialog({
						modal: true,
						title: "Elige un valor",
						title_html: false,
						buttons: [ 
							{
								text: "Cancel",
								"class" : "btn btn-mini",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							},
							{
								text: "OK",
								"class" : "btn btn-primary btn-mini",
								click: function() {
								    //var $ubicacion = e.currentTarget.id;
                                    //$ubicacion = $ubicacion.replace('id-btn-dialog-', '');
                                    var $id = $('#idArticulo').val();
                                    
                                    var $min = $('#minimo').val();
                                    var $max = $('#maximo').val();
                                    asigna($ubicacion, $id, $min, $max);
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
			

					
				});
                
                function asigna($ubicacion, $id, $minimo, $maximo)
                {
                    var $url = '<?php echo site_url('almacen/asignaIDUbicacion'); ?>';
                    var $variables = { ubicacion: $ubicacion, id: $id, minimo: $minimo, maximo: $maximo };
                    var posting = $.post( $url, $variables );
                        
                         posting.done(function( data ) {
                            
                            location.reload();
                                            
                         });
                }

-->
</script>