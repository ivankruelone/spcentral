<script type="text/javascript">
<!--

$(document).on('ready', imagen);
$('#rackID').on('change', imagen);

function imagen()
{
    var $rackID = $('#rackID').val();
    
    var $url = '<?php echo site_url('almacen/changeRackID'); ?>';
    var $variables = { rackID : $rackID };
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $('#rack').html(data);
            
            
            
         });

}
	
-->
</script>