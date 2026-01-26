//Grove City Events//

(function ($) {
    $(document).ready(function () {
        //Pick icon image
        var headerIcons = [
            'https://grovecityevents.com/wp-content/uploads/2024/04/live-music.png',
            'https://grovecityevents.com/wp-content/uploads/2024/04/theater.png',
            'https://grovecityevents.com/wp-content/uploads/2024/04/festival.png',
            'https://grovecityevents.com/wp-content/uploads/2024/04/fireworks.png',
            'https://grovecityevents.com/wp-content/uploads/2024/04/martini-glass.png',
            'https://grovecityevents.com/wp-content/uploads/2024/04/tickets-header.png'
        ];

        var randomIndex = Math.floor(Math.random() * headerIcons.length);
        var randomImgUrl = headerIcons[randomIndex];
        $('.randomIcon').attr('src', randomImgUrl);

        //Create date for header
        var currentDate = new Date();
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        var dayOfWeek = currentDate.toLocaleDateString('en-US', { weekday: 'long' });
        var monthName = monthNames[currentDate.getMonth()];
        var dayOfMonth = currentDate.getDate();
        var daySuffix = getDaySuffix(dayOfMonth);
        var year = currentDate.getFullYear();

        var formattedDate = dayOfWeek + ', ' + monthName + ' ' + dayOfMonth + daySuffix + ', ' + year;
        $('#currentDate').text(formattedDate);

        function getDaySuffix(day) {
            if (day >= 11 && day <= 13) {
                return 'th';
            }
            switch (day % 10) {
                case 1: return 'st';
                case 2: return 'nd';
                case 3: return 'rd';
                default: return 'th';
            }
        }

        //Generate QR Code
        var qrCodeContainer = $("#qr-code-container");
        var eventUrl = window.location.href;
        var qrCode = new QRCode(qrCodeContainer[0], {
            text: eventUrl,
            width: 256,
            height: 256,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrCode.makeCode();
    });

    $(window).on('load', function () {
        // Email sign up referrer tracking
        let params = (new URL(document.location)).searchParams;
        let referrer = params.get('ref');
        console.log("Referrer", referrer);

        $('.Referrer').each(function () {
            $(this).val(referrer);
        });

        $('form').submit(function () {
            $('.Referrer').each(function () {
                $(this).val(referrer);
            });
        });
    });

    // Global Menu
    $(document).ready(function () {
        $('#global-menu-toggle').on('click', function () {
            $('.global-menu-container').toggleClass('open');
        });

        $('.close-btn').on('click', function () {
            $('.global-menu-container').removeClass('open');
        });

        $('.submenu-toggle').on('click', function () {
            const $submenu = $(this).next('.submenu');
            const $caret = $(this).find('.submenu-caret');

            $submenu.toggleClass('open');
            $(this).toggleClass('open');

            if ($submenu.hasClass('open')) {
                $caret.css('transform', 'rotate(90deg)');
            } else {
                $caret.css('transform', 'rotate(-90deg)');
            }
        });
    });

    // Frequently Asked Questions - Refactored
    $(document).ready(function () {
        // Hide all answers on page load
        for (let i = 1; i <= 15; i++) {
            $('#a' + i).hide();
        }

        // Add click handlers for all questions
        for (let i = 1; i <= 15; i++) {
            (function(index) {
                $('#q' + index).click(function () {
                    $('#a' + index).toggle();
                    
                    if ($('#a' + index).is(':visible')) {
                        $('#qa' + index).css('transform', 'rotate(90deg)');
                    } else {
                        $('#qa' + index).css('transform', 'rotate(-90deg)');
                    }
                });
            })(i);
        }
    });

    // Christmas Snow
    var $heroSection = $('.hero-section');
    var $snowContainer = $('<div class="snow-container"></div>');
    $heroSection.append($snowContainer);

    function createSnowflake() {
        var $snowflake = $('<div class="snowflake"></div>');
        $snowflake.css('left', Math.random() * 100 + '%');

        var size = Math.random() * 10 + 10;
        $snowflake.css({
            'width': size + 'px',
            'height': size + 'px'
        });

        var opacity = Math.random() * 0.2 + 0.8;
        $snowflake.css('opacity', opacity);

        var duration = Math.random() * 5 + 5;
        var delay = Math.random() * 3;
        $snowflake.css({
            'animationDuration': duration + 's',
            'animationDelay': delay + 's'
        });

        $snowContainer.append($snowflake);

        setTimeout(function () {
            $snowflake.remove();
        }, duration * 1000);
    }

    setInterval(createSnowflake, 500);

})(jQuery);