jQuery(document).ready(function($) {
    $("#bookinfo-autofill").click( function(){ 

        let autofill = $("#bookinfo-autofill").is(':checked');
        if ( autofill ) {
            $("#search-book").css("display", "block");
            $("#search-button").css("display", "block");
        } else {
            $("#search-book").css("display", "none");
            $("#search-button").css("display", "none");
            $("#book-result").html('');
            $('#wpbk-thumbnail-label').css("display", "none");
            $('#wpbk-thumbnail-url').css("display", "none");
        }
    });

    $(document).on('click', '#btn-autofill', function() {
        let autofill = $("#bookinfo-autofill").is(':checked');
        if ( autofill ) {
            let bookName = $("input[name=autofill-book-name]:checked").val();
            
            jQuery.post({
                url: wpbk_ajax_object.ajaxurl,
                data: {
                    'action': 'wpbk_book_information_api',
                    'search_term' : bookName,
                    'nonce' : wpbk_ajax_object.ajaxnonce,
                    'search_type' : 'specific'
                },
                success:function(data) {
                    let bookData = $.parseJSON(data);
                    if (typeof(bookData.volumeInfo.authors) != "undefined" && bookData.volumeInfo.authors !== null) {
                        let bookAuthors = '';
                        $.each( bookData.volumeInfo.authors ,  function( index, author ) {
                            bookAuthors += author + ', ';
                        });
                        bookAuthors = $.trim(bookAuthors);
                        bookAuthors = bookAuthors.slice(0, -1);
                        $('#wpbk_author_name').val(bookAuthors);
                    }

                    if (typeof(bookData.volumeInfo.categories) != "undefined" && bookData.volumeInfo.categories !== null) {
                        let categories = '';
                        $.each( bookData.volumeInfo.categories ,  function( index, category ) {
                            categories += category + ' , ';
                        });
                        
                        categories = $.trim(categories);
                        categories = categories.slice(0, -1);
                        $('#wpbk-suggest-category-label, #wpbk-suggest-category').css("display", "table-cell");
                        $('#wpbk-line').css("display", "block");
                        $('#wpbk-suggest-category').html(categories);
                    }

                    if (typeof(bookData.volumeInfo.imageLinks.thumbnail) != "undefined" && bookData.volumeInfo.imageLinks.thumbnail !== null) {
                        $('#wpbk-thumbnail-label, #wpbk-thumbnail-url').css("display", "table-cell");
                        $('#wpbk-line').css("display", "block");
                        $('#wpbk-thumbnail-url').attr("href", bookData.volumeInfo.imageLinks.thumbnail);
                        $('#wpbk-thumbnail-url').html(bookData.volumeInfo.imageLinks.thumbnail);
                    }

                    if (typeof(bookData.volumeInfo.publishedDate != "undefined" && bookData.volumeInfo.publishedDate !== null) ) {
                        let publishYear = (bookData.volumeInfo.publishedDate).substring(0, 4);
                        $('#wpbk_published_year').val(publishYear);
                    }

                    $('#wpbk_publisher').val(bookData.volumeInfo.publisher);
                    $('#wpbk_url').val(bookData.volumeInfo.previewLink);
                    $('#wpbk_book_pages').val(bookData.volumeInfo.pageCount);
                    $('#wpbk_rating').val(bookData.volumeInfo.averageRating);
                    $('#wpbk_language').val(bookData.volumeInfo.language);
                    $('#wpbk_description').val(bookData.volumeInfo.description);
                },
                error: function(errorThrown){
                    $("#book-result").css( { 'display':'block', 'color':'red' } );
                    $("#book-result").html( errorThrown );
                }
            });
        }
    });

    $("#search-button").click( function(){ 

        let autofill = $("#bookinfo-autofill").is(':checked');
        if ( autofill ) {
            let searchTerm =  $("#search-book").val();
            $("#book-search-loading").css("display", "table-cell");
            jQuery.post({
                url: wpbk_ajax_object.ajaxurl,
                data: {
                    'action': 'wpbk_book_information_api',
                    'search_term' : searchTerm,
                    'nonce' : wpbk_ajax_object.ajaxnonce,
                    'search_type' : 'generic'
                },
                success: function(data) {
                    try {
                        if ( !( data === null || data === undefined || data === '' || typeof(data) === 'object' ) ) {
                            let searchData = $.parseJSON(data);
                            $("#book-result").css( { 'display':'block', 'color':'green' } );
                            $("#book-result").html('');
                            $.each( searchData, function(index, item) {
                                htmlData = "<p><input type='radio' id='box-"+ item.id +"' name='autofill-book-name' value='"+ item.id  +"'  > <label for='box-"+ item.id +"'>"+ item.volumeInfo.title +"</label> </p>";
                                $("#book-result").append( htmlData );
                            } );
                            $("#book-result").append("</br><button id='btn-autofill' name='btn-autofill'> Autofill </button>");
                            $("#book-search-loading").css("display", "none");
                        } else {
                            $("#book-result").html( " Error fetching data... " );    
                        } 
                    } catch ( error ) {
                        $("#book-result").html( " Error processing result... " );
                   } finally {
                        $("#book-search-loading").css("display", "none");
                   }    
                    
                },
                error: function(errorThrown){
                    $("#book-result").css( { 'display':'block', 'color':'red' } );
                    $("#book-result").html( errorThrown );
                   
                }
            });
        }
    });
});