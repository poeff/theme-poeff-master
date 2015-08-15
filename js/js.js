jQuery(document).ready(function($){

    // $('.search-form').hide();
    $('.show-search').on('click', function(){
        $('.social-links li').not('.search').toggle();
        $('#search-wrap').toggle();
        return false;
    });

    $('.panel-group').each(function(){
        $(this).find('.panel-collapse').first().addClass('in');
    });

    $('.comments-area').each(function(){
        var form = $(this).find('.comment-form'),
            button = $(this).find('.comment-reply-title');
        $(form).hide();
        $(button).addClass('btn btn-primary');
        $(button).on('click', function(){
            $(form).toggle();
        });
    });


$('body.single').each(function() {
    if(window.location.hash) {
      $('.comment-form').show();
    } else {
      // Fragment doesn't exist
    }
});


    $( "input[name='cptch_number']" ).addClass('form-control');

    $('#dgx-donate-form-donor-section > p').addClass('clearfix');

});
