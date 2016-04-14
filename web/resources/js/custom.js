(function($, window, require, undefined) {
    "use strict";

    var $configurationList  = $('.configuration--list .list--items'),
        $configurationForm  = $('.configuration-filter--form form'),
        $formInput          = $configurationForm.find('input'),
        timeout             = null,
        $configurationCount = $('.configuration--count');

    $formInput.on('change input', function() {
        if(timeout)
        {
            clearTimeout(timeout);
        }

        timeout = setTimeout(function() {
            $configurationForm.submit();
        }, 250);
    });

    $configurationForm.on('submit', function(e) {
        e.preventDefault();

        var url  = $(this).attr('action'),
            data = $(this).serialize();

        $.post(url, data, function(response) {
            $configurationList.empty();

            response.data.forEach(function(item) {
                var $item = $('<div />', {
                    'data-configId': item.id,
                    'html': item.label,
                    'class': 'item'
                });

                $item.appendTo($configurationList);
                $item.on('click', function() {
                    console.log('Loading configuration with id %d...', item.id);
                });
            });

            $configurationCount.html(response.count)
        });

    });

    $configurationForm.submit();

})(jQuery, window, require);