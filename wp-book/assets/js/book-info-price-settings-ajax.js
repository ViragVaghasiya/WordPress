jQuery(document).ready(function($) {
    $("#wpbk-recalc-button").click( function() { 

        let current_fx_rate_type = $("#forex-rate-type").val();
        if ($.trim(current_fx_rate_type) == '') {
            $("#price-update-result").css( { 'display':'block', 'color':'red' } );
            $("#price-update-result").html( '! Please Select A Forex Rate type.' );
        } else {
            $("#price-update-result").html( '' );
            $("#price-update-loading").css('display','table');
            $("#wpbk-recalc-button").remove();
            let current_base_currency = $("#wpbk-base-currency").val();
            
            // This does the ajax request
            jQuery.post({
                url: wpbk_ajax_object.ajaxurl,
                data: {
                    'action': 'wpbk_base_currency_book_price_update',
                    'target_currency' : current_base_currency,
                    'fx_type' : current_fx_rate_type,   
                    'nonce' : wpbk_ajax_object.ajaxnonce,
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    $("#price-update-result").css( { 'display':'block', 'color':'green' } );
                    $("#price-update-result").html( data );
                },
                error: function(errorThrown){
                    $("#price-update-result").css( { 'display':'block', 'color':'red' } );
                    $("#price-update-result").html( errorThrown );
                }
            });
            $("#price-update-loading").css('display','none');
        }
     });


    $("#forex-rate-manual-update").click( function() {
        
        $('#forex-rate-manual-update').css('display', 'none');
        
        // This does the ajax request
        jQuery.post({
            url: wpbk_ajax_object.ajaxurl,
            data: {
                'action': 'wpbk_forex_rate_manual_update', 
                'nonce' : wpbk_ajax_object.ajaxnonce,
            },
            success:function(data) {
                // This outputs the result of the ajax request
                $("#forex-rate-manual-update").css( { 'display':'block', 'color':'green' } );
                $("#forex-rate-manual-update").css( 'font-size', 'inherit' );
                $("#forex-rate-manual-update").removeAttr("href");
                $("#forex-rate-manual-update").html( 'Updated... Refresh the page' );
                $("#forex-rate-manual-update").off('click');
            },
            error: function(errorThrown){
                $("#forex-rate-manual-update").css( { 'display':'inline', 'color':'red' } );
                $("#forex-rate-manual-update").html( 'Error...' );
            }
        });
        $("#price-update-loading").css('display','none');
    });         
});