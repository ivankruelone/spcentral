<script>

var Script = function () {
    
    $('[data-toggle="modal"]').click(function(e) {
    
        e.preventDefault();
        var url = e.currentTarget.attributes.href.value;
        
        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, function(data) {
                $('<div id="myModal" class="modal hide fade higherWider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-body">' + data + ' </div><div class="modal-footer"><button class="btn btn-small btn-danger pull-right" data-dismiss="modal"><i class="icon-remove"></i>Cerrar</button></div></div>').modal();
            });
        }
    });




  jQuery.extend( jQuery.fn.dataTableExt.oSort, {
      "formatted-num-pre": function ( a ) {
        a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
        return parseFloat( a );
    },
 
    "formatted-num-asc": function ( a, b ) {
        return a - b;
    },
 
    "formatted-num-desc": function ( a, b ) {
        return b - a;
    }
} );

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "num-html-pre": function ( a ) {
        var x = String(a).replace( /<[\s\S]*?>/g, "" );
        return parseFloat( x );
    },
 
    "num-html-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "num-html-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );



jQuery(function($) {
    
    
    
				var oTable1 = $('#ventas-table').dataTable( {
				    
                    "aoColumns": [
                { "sSortDataType": "dom-text" },
                { "sSortDataType": "dom-text" },
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "formatted-num"},
                { "sSortDataType": "dom-text", "sType": "num-html" },
                { "sSortDataType": "dom-text", "sType": "num-html" },
                { "sSortDataType": "dom-text", "sType": "num-html" },
                { "sSortDataType": "dom-text", "sType": "num-html" },
                { "sSortDataType": "dom-text", "sType": "num-html" },
            ]
            
				 } );
                
    });
    
}();

</script>