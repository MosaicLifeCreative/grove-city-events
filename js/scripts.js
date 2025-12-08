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
        // Get the current date
        var currentDate = new Date();

        // Array of month names
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        // Get day of the week (e.g., "Sunday")
        var dayOfWeek = currentDate.toLocaleDateString('en-US', { weekday: 'long' });

        // Get month name (e.g., "April")
        var monthName = monthNames[currentDate.getMonth()];

        // Get day of the month with suffix (e.g., "28th")
        var dayOfMonth = currentDate.getDate();
        var daySuffix = getDaySuffix(dayOfMonth); // Function to get day suffix (st, nd, rd, th)

        // Get full year (e.g., "2024")
        var year = currentDate.getFullYear();

        // Construct the formatted date string
        var formattedDate = dayOfWeek + ', ' + monthName + ' ' + dayOfMonth + daySuffix + ', ' + year;

        // Display the formatted date on the webpage
        $('#currentDate').text(formattedDate);

        // Function to get day suffix (st, nd, rd, th)
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
        // Get the container element to display the QR code
        var qrCodeContainer = $("#qr-code-container");

        // Dynamically get the current page URL
        var eventUrl = window.location.href;

        // Create QR code instance
        var qrCode = new QRCode(qrCodeContainer[0], {
            text: eventUrl,
            width: 256,
            height: 256,
            colorDark: "#000000", // QR code color
            colorLight: "#ffffff", // Background color
            correctLevel: QRCode.CorrectLevel.H // Error correction level
        });

        // Display the QR code in the container
        qrCode.makeCode();
    });

    $(window).on('load', function () {
        // Email sign up referrer tracking
        let params = (new URL(document.location)).searchParams;
        let referrer = params.get('ref');
        console.log("Referrer", referrer);  // This will log the referrer to the console

        // Set the referrer value in all forms with class 'Referrer'
        $('.Referrer').each(function () {
            $(this).val(referrer);
        });

        // Ensure the referrer value is set before the form submission
        $('form').submit(function () {
            $('.Referrer').each(function () {
                $(this).val(referrer);
            });
        });
    });

    //Display the bubble menu
    var rotated = false;
    $('.expandable-button').click(function () {
        $(this).toggleClass('active'); // Toggle the 'active' class on button click
        $('.speech-bubble').toggle(); // Toggle the display of the speech bubble menu

        rotated = !rotated;
        if (rotated) {
            $(this).css('transform', 'rotate(135deg)');
        } else {
            $(this).css('transform', 'none');
        } 
    });

    // Global Menu
    $(document).ready(function () {
        // Toggle menu when clicking on the hamburger button
        $('#global-menu-toggle').on('click', function () {
            $('.global-menu-container').toggleClass('open');
        });

        // Close menu when clicking on the close button (X)
        $('.close-btn').on('click', function () {
            $('.global-menu-container').removeClass('open');
        });

        // Toggle submenu visibility and caret rotation
        $('.submenu-toggle').on('click', function () {
            const $submenu = $(this).next('.submenu'); // Get the next submenu
            const $caret = $(this).find('.submenu-caret'); // Get the caret

            // Toggle the 'open' class on both the submenu and the toggle button
            $submenu.toggleClass('open');
            $(this).toggleClass('open');

            // Rotate caret when submenu is open or closed
            if ($submenu.hasClass('open')) {
                $caret.css('transform', 'rotate(90deg)'); // Point down when open
            } else {
                $caret.css('transform', 'rotate(-90deg)'); // Point right when closed
            }
        });
    });

    /*Member Menu
    $('#slide-in-open').click(function () {
        $(this).toggleClass('open');
        $('.slide-in-menu-container').toggleClass('slide-in-menu');
        $('.overlay-off').toggleClass('overlay-on');
    });
    $('.menu-close').click(function () {
        $('#slide-in-open').toggleClass('open');
        $('.slide-in-menu-container').toggleClass('slide-in-menu');
        $('.overlay-off').toggleClass('overlay-on');
    });*/

    //Frequently Asked Questions
    $(document).ready(function () {
        $('#a1, #a2, #a3, #a4, #a5, #a6, #a7, #a8, #a9, #a10, #a11, #a12, #a13, #a14, #a15').hide();
    });

    $('#q1').click(function () {
        $('#a1').toggle();

        if ($('#a1').is(':visible')) {
            $('#qa1').css('transform', 'rotate(90deg)');
        } else {
            $('#qa1').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q2').click(function () {
        $('#a2').toggle();

        if ($('#a2').is(':visible')) {
            $('#qa2').css('transform', 'rotate(90deg)');
        } else {
            $('#qa2').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q3').click(function () {
        $('#a3').toggle();

        if ($('#a3').is(':visible')) {
            $('#qa3').css('transform', 'rotate(90deg)');
        } else {
            $('#qa3').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q4').click(function () {
        $('#a4').toggle();

        if ($('#a4').is(':visible')) {
            $('#qa4').css('transform', 'rotate(90deg)');
        } else {
            $('#qa4').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q5').click(function () {
        $('#a5').toggle();

        if ($('#a5').is(':visible')) {
            $('#qa5').css('transform', 'rotate(90deg)');
        } else {
            $('#qa5').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q6').click(function () {
        $('#a6').toggle();

        if ($('#a6').is(':visible')) {
            $('#qa6').css('transform', 'rotate(90deg)');
        } else {
            $('#qa6').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q7').click(function () {
        $('#a7').toggle();

        if ($('#a7').is(':visible')) {
            $('#qa7').css('transform', 'rotate(90deg)');
        } else {
            $('#qa7').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q8').click(function () {
        $('#a8').toggle();

        if ($('#a8').is(':visible')) {
            $('#qa8').css('transform', 'rotate(90deg)');
        } else {
            $('#qa8').css('transform', 'rotate(-90deg)');
        }
    });

    $('#q9').click(function () {
        $('#a9').toggle();

        if ($('#a9').is(':visible')) {
            $('#qa9').css('transform', 'rotate(90deg)');
        } else {
            $('#qa9').css('transform', 'rotate(-90deg)');
        }
    });

    // Gift Guide
    $('.filter-btn').on('click', function () {
        $(this).toggleClass('active');

        // Get all active categories
        const activeCategories = $('.filter-btn.active').map(function () {
            return $(this).data('category');
        }).get();

        // Show or hide product items based on active categories
        $('.product-item').each(function () {
            const item = $(this);
            const matchesCategory = activeCategories.some(category =>
                item.hasClass(category)
            );

            if (matchesCategory) {
                item.addClass('active');
                item.find('.product-card').css('display', 'flex'); // Ensure the product-card is visible
            } else {
                item.removeClass('active');
                item.find('.product-card').css('display', 'none'); // Hide the product-card for inactive items
            }
        });

        // Show or hide the no-selection message
        if (activeCategories.length === 0) {
            $('#no-selection-message').show();
        } else {
            $('#no-selection-message').hide();
        }
    });

    //Christmas Snow
    var $heroSection = $('.hero-section'); // Assuming your hero section has this class
    var $snowContainer = $('<div class="snow-container"></div>');
    $heroSection.append($snowContainer);

    function createSnowflake() {
        var $snowflake = $('<div class="snowflake"></div>');

        // Set random horizontal position
        $snowflake.css('left', Math.random() * 100 + '%');

        // Set random size between 10px and 20px
        var size = Math.random() * 10 + 10; // Random size between 10px and 20px
        $snowflake.css({
            'width': size + 'px',
            'height': size + 'px'
        });

        // Set random opacity between 0.8 and 1
        var opacity = Math.random() * 0.2 + 0.8; // Opacity between 0.8 and 1
        $snowflake.css('opacity', opacity);

        // Set random animation duration and delay for a natural look
        var duration = Math.random() * 5 + 5; // Random duration between 5s and 10s
        var delay = Math.random() * 3; // Random delay between 0s and 3s
        $snowflake.css({
            'animationDuration': duration + 's',
            'animationDelay': delay + 's'
        });

        $snowContainer.append($snowflake);

        // Remove snowflake after it falls
        setTimeout(function () {
            $snowflake.remove();
        }, duration * 1000); // Remove after the animation ends
    }

    // Generate snowflakes every 500ms
    setInterval(createSnowflake, 500);

    //WooCommerce
    var select = $('#pa_size'); // Target the size dropdown by its ID
    var options = select.find('option');

    // Define the correct order based on the labels (S, M, L, XL, 2XL)
    var sizeOrder = ['S', 'M', 'L', 'XL', '2XL'];

    // Create a new table row for the buttons
    var buttonRow = $('<tr class="size-button-row"><td colspan="2"><div class="size-buttons"></div></td></tr>').insertAfter('.variations tr');
    var buttonContainer = buttonRow.find('.size-buttons');

    // Remove any pre-selection from the dropdown
    select.val(''); // Ensure no option is selected on load

    // Sort the options based on the labels, matching them against the sizeOrder array
    options.sort(function (a, b) {
        var aText = $(a).text().trim(); // Get the label (text) of the option
        var bText = $(b).text().trim();

        return sizeOrder.indexOf(aText) - sizeOrder.indexOf(bText);
    });

    options.each(function () {
        var option = $(this);
        if (option.val()) {
            var button = $('<button type="button">' + option.text() + '</button>');

            // Click event to select the dropdown option
            button.on('click', function () {
                select.val(option.val()).change(); // Update the dropdown selection
                buttonContainer.find('button').removeClass('active'); // Remove active class from all buttons
                $(this).addClass('active'); // Add active class to the clicked button
            });

            buttonContainer.append(button); // Append the button to the container
        }
    });

    // QTY & Stock Indicator
    // Add the QTY label if it's missing
    if (!$('.qty-label').length) {
        $('.quantity').before('<label class="qty-label">QTY</label>');
    }

    // Move the stock message once it's fully rendered
    function moveStockMessage() {
        var stockMessage = $('.woocommerce-variation-availability .stock');
        var qtyInput = $('.quantity');
        var qtyLabel = $('.qty-label');

        // Remove any existing stock messages to avoid duplicates
        $('.stock.in-stock, .stock.out-of-stock').remove();

        if (stockMessage.length && qtyInput.length) {
            // Move the stock message after the QTY label but before the QTY input
            qtyLabel.after(stockMessage);
        }
    }

    // Run the function after the variation has been selected
    $('form.variations_form').on('show_variation', function () {
        moveStockMessage();
    });

    // Run it on page load as well, to handle default selections
    moveStockMessage();

})(jQuery);