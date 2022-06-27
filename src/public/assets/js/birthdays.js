$(function(){
    function loadBirthdays() {
        $.ajax({
            url: '/api/birthdays?tz=America/Los_Angeles',
            success: function(res) {
                $('.birthdays').empty();
                if (res['data'].length > 0) {
                    $.each(res['data'], function($_, birthday){
                        $('.birthdays').append(
                            $('<div>')
                                .append($('<span>').html(birthday['message'])));
                    });
                } else {
                    $('.birthdays').append(
                            $('<div>').append($('<span>').html('🤷 Got nothin` yet...')));
                }
            }
        })
    }

    $('form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: '/api/birthdays/add',
            method: 'post',
            data: $(this).serialize(),
            success: function(res){
                if (res['success']) {
                    loadBirthdays();
                    alert('Added 👍');
                } else {
                    console.error('Error adding birthday: ', res.errors);
                    alert('Failed 🥲 [see console for details]');
                }
            }
        })
    });

    loadBirthdays();
});
