<script type="text/javascript">
<!--
$(document).on('ready', inicio);

function inicio(){
    
    detalle();

$( "#id-btn-dialog1" ).on('click', function(e) {
					e.preventDefault();
			
					var dialog = $( "#dialog-message" ).dialog({
						modal: true,
                        width: '80%',
						title: "",
						title_html: true,
						buttons: [ 
							{
								text: "OK",
								"class" : "btn btn-primary btn-mini",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
			
					/**
					dialog.data( "uiDialog" )._title = function(title) {
						title.html( this.options.title );
					};
					**/
				});
                
                
                
    $( "button[id^='button_']" ).on('click', boton);
    
    function boton(e)
    {
        e.preventDefault();
        var $movimientoID = e.currentTarget.attributes.movimientoID.value;
        var $inventarioID = e.currentTarget.attributes.inventarioID.value;
        var $valor = $("#parcial_" + $inventarioID).val();
        
        if(confirm("Seguro que desea agregar " + $valor + " piezas de esa clave ??"))
        {
            
        
            botonTransfer($movimientoID, $inventarioID, $valor);
            
            return true;
        }else{
            return false;
        }
        
    }

    $( "a[id^='link_']" ).on('click', boton);


}
    function detalle()
    {
        
        $movimientoID = $('#movimientoID').html();
        
        var $url = '<?php echo site_url('movimiento/detalle'); ?>';
        var $variables = { movimientoID: $movimientoID };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#detalle').html(data);
                
             });
        
    }
    
    function botonTransfer($movimientoID, $inventarioID, $valor)
    {
        
        var $url = '<?php echo site_url('movimiento/transferParcial'); ?>';
        var $variables = { movimientoID: $movimientoID, inventarioID: $inventarioID, valor: $valor };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                detalle();
                
             });
        
    }

    $('#cierre').on('click', cierre);
    
    function cierre(event){
        if(confirm("Seguro que deseas cerrar este Movimiento ??")){
            
            return true;
            
        }else{
            event.preventDefault();
            return false;
        }
    }
    


-->
</script>