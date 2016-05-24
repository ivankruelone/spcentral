<script type="text/javascript">
<!--

$(document).on('ready', preview);
$('#niveles').on('change', preview);
$('#posiciones').on('change', preview);

function preview()
{
    var $niveles = $('#niveles').val();
    var $posiciones = $('#posiciones').val();
    
    var $url = '<?php echo site_url('almacen/previewModulo'); ?>';
    var $variables = { niveles : $niveles, posiciones: $posiciones };
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $('#preview').html(data);
            
            
            
         });

}
	
-->
</script>