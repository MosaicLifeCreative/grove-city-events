<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = Tribe__Events__Main::postIdHelper( get_the_ID() );

?>

<div id="tribe-events-content" class="tribe-events-single" style="width: 100%; padding: 0; margin: 0 auto; position: relative;">

    <!-- Featured Image Wrapper with Date Box -->
    <?php if ( has_post_thumbnail( $event_id ) ) : ?>
        <div class="template-featured-image-wrapper" style="position: relative; width: 100%; display: flex; justify-content: center; margin-bottom: 20px; height:400px;">
            <img
                src="<?php echo esc_url( get_the_post_thumbnail_url( $event_id, 'full' ) ); ?>"
                alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id( $event_id ), '_wp_attachment_image_alt', true ) ); ?>"
                class="template-featured-image"
                style="position: absolute; width: 69vw; left: 50%; transform: translateX(-50%);"
            />

            <!-- Date and Time Box -->
            <div class="event-date-time-box" style="
                font-size: 20px;
                background-color: rgba(255,255,255,0.8);
                border-radius: 10px;
                overflow: hidden;
                padding: 22px 37px;
                z-index: 1;
                position: relative;
                height: fit-content;
                display:flex;
                flex-direction:column;
                margin-top:auto;
                margin-right:auto;
                margin-bottom:22px;
                backdrop-filter: blur(5px) saturate(180%);
                color:black;
            ">
                <strong><?php echo tribe_get_start_date( $event_id, false, 'l, F j, Y' ); // Display day of the week, followed by date ?></strong>
                <?php echo tribe_get_start_time( $event_id ); // Display only the start time ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Event Title after Featured Image -->
    <h1 class="tribe-events-single-event-title" style="text-align: left; font-size: 2.5rem; margin-top: 50px; margin-bottom:28px; color: black;">
        <?php echo get_the_title( $event_id ); ?>
    </h1>

    <!-- Event Information Box for Mobile -->
    <div class="event-info-box eib-mobile">
        <!-- Event Date -->
        <p><span class="icon-date"></span> <?php echo tribe_get_start_date( $event_id, false, 'F j, Y' ); ?></p>

        <!-- Event Start and End Time -->
        <p><span class="icon-time"></span> <?php echo tribe_get_start_time( $event_id ); ?> - <?php echo tribe_get_end_time( $event_id ); ?></p>

        <!-- Event Location (Correct Venue Link) -->
        <?php if ( tribe_get_venue_id( $event_id ) ) : ?>
            <p><span class="icon-location"></span> 
                <a href="<?php echo esc_url( get_permalink( tribe_get_venue_id( $event_id ) ) ); ?>">
                    <?php echo tribe_get_venue( $event_id ); ?>
                </a>
            </p>
        <?php endif; ?>

        <!-- Organizer (Correct Organizer Link) -->
        <?php if ( tribe_get_organizer_id( $event_id ) ) : ?>
            <p><span class="icon-organizer"></span>
                <a href="<?php echo esc_url( get_permalink( tribe_get_organizer_id( $event_id ) ) ); ?>">
                    <?php echo tribe_get_organizer( $event_id ); ?>
                </a>
            </p>
        <?php endif; ?>

        <!-- Phone Number (Clean Display) -->
        <?php if ( tribe_get_phone( $event_id ) ) : ?>
            <p><span class="icon-phone"></span> <?php echo tribe_get_phone( $event_id ); ?></p>
        <?php endif; ?>

        <!-- Categories -->
        <?php 
        $categories = get_the_terms( $event_id, 'tribe_events_cat' );
        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
            <p><span class="icon-categories"></span>
            <?php
                $category_links = array();
                foreach ( $categories as $category ) {
                    $category_links[] = '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
                }
                echo implode( ', ', $category_links );
            ?>
            </p>
        <?php endif; ?>

        <!-- Event Website URL with Custom Text -->
        <?php if ( tribe_get_event_website_url( $event_id ) ) : ?>
            <p><span class="icon-website"></span>
                <a href="<?php echo esc_url( tribe_get_event_website_url( $event_id ) ); ?>" target="_blank">
                    View Event's Website
                </a>
            </p>
        <?php endif; ?>
    </div>

    <!-- Nested container for the rest of the content to keep it constrained -->
    <div class="tribe-events-content-wrapper" style="max-width: 1200px; margin: 0 auto;">
        <!-- Notices -->
        <?php tribe_the_notices() ?>

        <!-- Event Content and Sidebar Columns -->
        <div class="tribe-events-columns">
            <!-- Left Column: Event Description (60%) -->
            <div class="tribe-events-left-column">

                <!-- Display Event Description Once -->
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                    <div class="tribe-events-single-event-description tribe-events-content">
                        <!-- This outputs the content only once -->
                        <?php the_content(); ?>
                    </div>
                    <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
                </div> <!-- #post-x -->

                <?php while ( have_posts() ) : the_post(); ?>
                    <!-- Other event details or metadata can stay here -->
                    <?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
                <?php endwhile; ?>

                <!-- Cbus Apparel Banner Ad -->
                <!--<div class="cbus-apparel-banner" style="text-align:left; margin: 10px 0;">
                    <hr style="margin: 0 0 25px; border: none; border-top: 1px solid #f8f8f8;">
                    <h3 style="font-weight:700; margin-bottom:15px;">Grab Your Grove City Gear Just in Time for Halloween!</h3>
                    <a href="https://cbusapparel.com/products/grove-city-tower-of-terror-tees/?utm_source=gce&utm_medium=banner&utm_campaign=event-page" target="_blank" rel="noopener">
                        <picture> -->
                            <!-- Desktop 
                            <source media="(min-width: 768px)" srcset="https://grovecityevents.com/wp-content/uploads/2025/09/tower-of-terror-tees-banner-970x250-1.png"> -->
                            <!-- Mobile 
                            <source media="(max-width: 767px)" srcset="https://grovecityevents.com/wp-content/uploads/2025/09/tower-of-terror-tees-banner-600x500-1.png"> -->
                            <!-- Fallback 
                            <img src="https://grovecityevents.com/wp-content/uploads/2025/09/tower-of-terror-tees-banner-970x250-1.png" 
                                 alt="Shop Grove City Tower of Terror Tees at Cbus Apparel" 
                                 style="width:100%; height:auto;">-->
                        <!-- </picture>
                    </a>
                    <hr style="margin: 25px 0; border: none; border-top: 1px solid #f8f8f8;">
                </div>-->

                <!-- This adds the Monarch buttons -->
                <?php echo do_shortcode('[et_social_share_custom]'); ?>
            </div>

            <div class="tribe-events-right-column">         
                <!-- Event Information Box for Desktop -->
                <div class="event-info-box  eib-desktop">
                    <!-- Event Date -->
                    <p><span class="icon-date"></span> <?php echo tribe_get_start_date( $event_id, false, 'F j, Y' ); ?></p>

                    <!-- Event Start and End Time -->
                    <p><span class="icon-time"></span> <?php echo tribe_get_start_time( $event_id ); ?> - <?php echo tribe_get_end_time( $event_id ); ?></p>

                    <!-- Event Location (Correct Venue Link) -->
                    <?php if ( tribe_get_venue_id( $event_id ) ) : ?>
                        <p><span class="icon-location"></span> 
                            <a href="<?php echo esc_url( get_permalink( tribe_get_venue_id( $event_id ) ) ); ?>">
                                <?php echo tribe_get_venue( $event_id ); ?>
                            </a>
                        </p>
                    <?php endif; ?>

                    <!-- Organizer (Correct Organizer Link) -->
                    <?php if ( tribe_get_organizer_id( $event_id ) ) : ?>
                        <p><span class="icon-organizer"></span>
                            <a href="<?php echo esc_url( get_permalink( tribe_get_organizer_id( $event_id ) ) ); ?>">
                                <?php echo tribe_get_organizer( $event_id ); ?>
                            </a>
                        </p>
                    <?php endif; ?>

                    <!-- Phone Number (Clean Display) -->
                    <?php if ( tribe_get_phone( $event_id ) ) : ?>
                        <p><span class="icon-phone"></span> <?php echo tribe_get_phone( $event_id ); ?></p>
                    <?php endif; ?>

                    <!-- Categories -->
                    <?php 
                    $categories = get_the_terms( $event_id, 'tribe_events_cat' );
                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                        <p><span class="icon-categories"></span>
                        <?php
                            $category_links = array();
                            foreach ( $categories as $category ) {
                                $category_links[] = '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
                            }
                            echo implode( ', ', $category_links );
                        ?>
                        </p>
                    <?php endif; ?>

                    <!-- Event Website URL with Custom Text -->
                    <?php if ( tribe_get_event_website_url( $event_id ) ) : ?>
                        <p><span class="icon-website"></span>
                            <a href="<?php echo esc_url( tribe_get_event_website_url( $event_id ) ); ?>" target="_blank">
                                View Event's Website
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- AdSense Section -->
                <div style="font-size:14px; color:#666; text-align:center; margin-top:20px;">ADVERTISEMENT</div>
                <div style="margin: 5px auto 25px; text-align: center;">
                  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1911840510612788"
                         crossorigin="anonymous"></script>
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-format="fluid"
                         data-ad-layout-key="-6t+ed+2i-1n-4w"
                         data-ad-client="ca-pub-1911840510612788"
                         data-ad-slot="5017065523"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>

                <!-- QR Code Section -->
                <div id="qr-code-container" title="Right Click to Download & Save This Event's QR Code" alt="Right Click to Download & Save This Event's QR Code" style="margin-top: 20px;"></div>

                <!-- Instructional Text Below QR Code -->
                <p style="text-align: center; margin-top: 10px;">Right Click to Download & Save This Event's QR Code</p>
            </div>

        </div>
    </div> <!-- Close constrained content container -->

    <!-- New Row for Full-Width Location Info and Map -->
    <div class="event-location-info-wrapper" style="width: 100%; padding: 20px 0;">
        <div class="location-info" style="text-align: left; padding: 0; margin: 0;">
            <h2 style="font-size: 22px; font-weight: bold;">Location</h2>

            <!-- Display Venue Name -->
            <p style="font-size: 16px; color: black; margin-bottom: 0 !important; padding-bottom:0;"><?php echo tribe_get_venue( $event_id ); ?></p>

            <!-- Display Venue Address with Google Maps link -->
            <?php 
            $venue_address = strip_tags( tribe_get_full_address( $event_id ) ); // Strip HTML tags from the address
            if ( ! empty( $venue_address ) ) : ?>
                <p style="font-size: 16px; color: #334aff; margin: 0;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo urlencode( $venue_address ); ?>" target="_blank" style="color: #334aff;">
                        <?php echo $venue_address; ?>
                    </a>
                </p>
            <?php endif; ?>
        </div>

        <!-- Display Google Map (full-width) -->
        <div class="event-google-map" style="width: 100%; height: 400px;">
            <?php echo tribe_get_embedded_map( $event_id ); // This displays the Google Map ?>
        </div>
    </div>

    <!-- Divider before Upcoming Events -->
    <hr style="margin: 40px 0 25px; border: none; border-top: 1px solid #f8f8f8;">


    <!-- Upcoming Events Section -->
    <div class="tribe-upcoming-events-section" style="padding: 20px 0;">
        <h2 style="font-size: 24px; text-align: center; font-weight: 700; color: black; margin-bottom:15px;">More Great Events in Grove City</h2>

        <div class="upcoming-events-wrapper" style="display: flex; justify-content: space-between; gap: 20px; align-items: stretch;">
            <?php
            // Set up a query for the next 3 upcoming events
            $upcoming_events = tribe_get_events( [
            'posts_per_page' => 3, // Limit to 3 events
            'start_date'     => current_time( 'Y-m-d H:i:s' ), // Get events starting from now
            'eventDisplay'   => 'list', // Use 'list' display for the upcoming events
            'orderby'        => 'event_date', // Order by the event start date
            'tax_query'      => array(
                array(
                    'taxonomy' => 'post_tag', // The taxonomy for tags
                    'field'    => 'slug',
                    'terms'    => array( 'ephh', 'specials' ), // The slugs of the tags to exclude
                    'operator' => 'NOT IN', // Exclude events with this tag
                ),
            ),
        ] );
            if ( $upcoming_events ) : ?>
                <?php foreach ( $upcoming_events as $event ) : ?>
                    <div class="upcoming-event-item" style="flex: 1; text-align: left; border-radius: 4px; padding: 10px; display: flex; flex-direction: column; justify-content: space-between;">
                    
                        <!-- Event Image -->
                        <a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>">
                            <?php echo get_the_post_thumbnail( $event->ID, 'full', array(
                                'style' => 'width: 100%; aspect-ratio: 4/3 !important; object-fit: cover !important; border-radius: 4px;',
                            ) ); ?>
                        </a>

                        <!-- Event Details -->
                        <div class="event-details" style="flex-grow: 1; margin-top: 10px;">
                            <!-- Clickable Event Title -->
                            <a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>" style="text-decoration: none;">
                                <h3 style="font-size: 20px; margin: 10px 0; color:black; line-height:1.1em;"><?php echo get_the_title( $event->ID ); ?></h3>
                            </a>
                            <p style="font-size: 16px; color:black; padding-bottom:0;"><strong>Date:</strong> <?php echo tribe_get_start_date( $event->ID, false, 'F j, Y' ); ?></p>
                            <p style="font-size: 16px; color:black; padding-bottom:0;"><strong>Time:</strong> <?php echo tribe_get_start_time( $event->ID ); ?></p>
                            <p style="font-size: 16px; color:black; padding-bottom:0;"><strong>Venue:</strong> <?php echo tribe_get_venue( $event->ID ); ?></p>
                            <p style="font-size: 16px; color:black; padding-bottom:0;"><strong>Organizer:</strong> <?php echo tribe_get_organizer( $event->ID ); ?></p>

                            <!-- Conditionally display the price label only if there's a price -->
                            <?php $event_price = tribe_get_formatted_cost( $event->ID ); ?>
                            <?php if ( ! empty( $event_price ) ) : ?>
                                <p style="font-size: 16px; color:black; padding-bottom:0;"><strong>Price:</strong> <?php echo $event_price; ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- More Info Button -->
                        <a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>" class="more-info-btn" style="
                            display: block;
                            width: 100%;
                            padding: 10px 20px;
                            font-size: 22px;
                            font-weight:bold;
                            background-color: #334aff;
                            color: white;
                            text-decoration: none;
                            border-radius: 4px;
                            text-align: center;
                            margin-top: 10px;
                            transition: background-color 0.3s;">
                            More Info
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No upcoming events found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- CSS for Button Hover Effect -->
    <style>
        .more-info-btn:hover {
            background-color: #5c6eff !important;
        }
    </style>

</div><!-- #tribe-events-content -->
