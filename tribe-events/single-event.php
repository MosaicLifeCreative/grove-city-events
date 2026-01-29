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

// BANNER CONTROL: Set to true to enable banner, false to disable
$show_banner = true;

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();
$event_id = Tribe__Events__Main::postIdHelper( get_the_ID() );

?>

<div id="tribe-events-content" class="tribe-events-single">

    <!-- Featured Image with Date Box -->
    <?php if ( has_post_thumbnail( $event_id ) ) : ?>
        <div class="template-featured-image-wrapper">
            <img
                src="<?php echo esc_url( get_the_post_thumbnail_url( $event_id, 'full' ) ); ?>"
                alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id( $event_id ), '_wp_attachment_image_alt', true ) ); ?>"
                class="template-featured-image"
            />

            <!-- Date and Time Box -->
            <div class="event-date-time-box">
                <strong><?php echo tribe_get_start_date( $event_id, false, 'l, F j, Y' ); ?></strong>
                <?php echo tribe_get_start_time( $event_id ); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Event Title -->
    <h1 class="tribe-events-single-event-title">
        <?php echo get_the_title( $event_id ); ?>
    </h1>

    <!-- Event Information Box for Mobile -->
    <div class="event-info-box eib-mobile">
        <?php echo render_event_info_box( $event_id ); ?>
    </div>

    <!-- Main Content Container -->
    <div class="tribe-events-content-wrapper">
        
        <!-- Notices -->
        <?php tribe_the_notices() ?>

        <!-- Two Column Layout -->
        <div class="tribe-events-columns">
            
            <!-- Left Column: Event Description -->
            <div class="tribe-events-left-column">
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                    <div class="tribe-events-single-event-description tribe-events-content">
                        <?php the_content(); ?>
                    </div>
                    <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
                </div>

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
                <?php endwhile; ?>

                <!-- Banner Ad (Controlled by $show_banner variable above) -->
                <?php if ( $show_banner ) : ?>
                    <div class="event-banner-ad">
                        <hr class="banner-divider">
                        <h3>Stay Warm & Stylish in Grove City Gear!</h3>
                        <a href="https://buy.stripe.com/9B64gAagddBT1fj02U2Fa00?utm_source=event-ad&utm_medium=banner&utm_campaign=winter-2026" target="_blank" rel="noopener">
                            <picture>
                                <source media="(min-width: 768px)" srcset="https://grovecityevents.com/wp-content/uploads/2026/01/3d-hoodies-desktop-event-banner.png">
                                <source media="(max-width: 767px)" srcset="https://grovecityevents.com/wp-content/uploads/2026/01/3d-hoodies-mobile-event-banner.png">
                                <img src="https://grovecityevents.com/wp-content/uploads/2026/01/3d-hoodies-desktop-event-banner.png" 
                                     alt="Shop Grove 3D Hoodies and Tees at CBus Apparel" 
                                     class="banner-image">
                            </picture>
                        </a>
                        <hr class="banner-divider">
                    </div>
                <?php endif; ?>

                <!-- Social Sharing -->
                <?php echo do_shortcode('[et_social_share_custom]'); ?>
            </div>

            <!-- Right Column: Event Info, Ads, QR Code -->
            <div class="tribe-events-right-column">
                
                <!-- Event Information Box for Desktop -->
                <div class="event-info-box eib-desktop">
                    <?php echo render_event_info_box( $event_id ); ?>
                </div>

                <!-- AdSense Section -->
                <div class="adsense-label">ADVERTISEMENT</div>
                <div class="adsense-container">
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1911840510612788" crossorigin="anonymous"></script>
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
                <div id="qr-code-container" class="qr-code-wrapper" title="Right Click to Download & Save This Event's QR Code"></div>
                <p class="qr-code-instructions">Right Click to Download & Save This Event's QR Code</p>
            </div>

        </div>
    </div>

    <!-- Location Section -->
    <div class="event-location-info-wrapper">
        <div class="location-info">
            <h2>Location</h2>
            <p class="venue-name"><?php echo tribe_get_venue( $event_id ); ?></p>
            
            <?php 
            $venue_address = strip_tags( tribe_get_full_address( $event_id ) );
            if ( ! empty( $venue_address ) ) : ?>
                <p class="venue-address">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo urlencode( $venue_address ); ?>" target="_blank">
                        <?php echo $venue_address; ?>
                    </a>
                </p>
            <?php endif; ?>
        </div>

        <div class="event-google-map">
            <?php echo tribe_get_embedded_map( $event_id ); ?>
        </div>
    </div>

    <!-- Section Divider -->
    <hr class="section-divider">

    <!-- Upcoming Events Section -->
    <div class="tribe-upcoming-events-section">
        <h2>More Great Events in Grove City</h2>

        <div class="upcoming-events-wrapper">
            <?php
            $upcoming_events = tribe_get_events( [
                'posts_per_page' => 3,
                'start_date'     => current_time( 'Y-m-d H:i:s' ),
                'eventDisplay'   => 'list',
                'orderby'        => 'event_date',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'post_tag',
                        'field'    => 'slug',
                        'terms'    => array( 'ephh', 'specials' ),
                        'operator' => 'NOT IN',
                    ),
                ),
            ] );
            
            if ( $upcoming_events ) : ?>
                <?php foreach ( $upcoming_events as $event ) : ?>
                    <div class="upcoming-event-item">
                        <a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>" class="upcoming-event-image-link">
                            <?php echo get_the_post_thumbnail( $event->ID, 'full', array('class' => 'upcoming-event-image') ); ?>
                        </a>

                        <div class="event-details">
                            <a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>" class="upcoming-event-title-link">
                                <h3><?php echo get_the_title( $event->ID ); ?></h3>
                            </a>
                            <p><strong>Date:</strong> <?php echo tribe_get_start_date( $event->ID, false, 'F j, Y' ); ?></p>
                            <p><strong>Time:</strong> <?php echo tribe_get_start_time( $event->ID ); ?></p>
                            <p><strong>Venue:</strong> <?php echo tribe_get_venue( $event->ID ); ?></p>
                            <p><strong>Organizer:</strong> <?php echo tribe_get_organizer( $event->ID ); ?></p>

                            <?php $event_price = tribe_get_formatted_cost( $event->ID ); ?>
                            <?php if ( ! empty( $event_price ) ) : ?>
                                <p><strong>Price:</strong> <?php echo $event_price; ?></p>
                            <?php endif; ?>
                        </div>

                        <a href="<?php echo esc_url( get_permalink( $event->ID ) ); ?>" class="more-info-btn">
                            More Info
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No upcoming events found.</p>
            <?php endif; ?>
        </div>
    </div>

</div><!-- #tribe-events-content -->

<?php
/**
 * Helper function to render event info box content
 * This eliminates duplication between mobile and desktop versions
 */
function render_event_info_box( $event_id ) {
    ob_start();
    ?>
    
    <!-- Event Date -->
    <p><span class="icon-date"></span> <?php echo tribe_get_start_date( $event_id, false, 'F j, Y' ); ?></p>

    <!-- Event Time -->
    <p><span class="icon-time"></span> <?php echo tribe_get_start_time( $event_id ); ?> - <?php echo tribe_get_end_time( $event_id ); ?></p>

    <!-- Venue -->
    <?php if ( tribe_get_venue_id( $event_id ) ) : ?>
        <p><span class="icon-location"></span> 
            <a href="<?php echo esc_url( get_permalink( tribe_get_venue_id( $event_id ) ) ); ?>">
                <?php echo tribe_get_venue( $event_id ); ?>
            </a>
        </p>
    <?php endif; ?>

    <!-- Organizer -->
    <?php if ( tribe_get_organizer_id( $event_id ) ) : ?>
        <p><span class="icon-organizer"></span>
            <a href="<?php echo esc_url( get_permalink( tribe_get_organizer_id( $event_id ) ) ); ?>">
                <?php echo tribe_get_organizer( $event_id ); ?>
            </a>
        </p>
    <?php endif; ?>

    <!-- Phone -->
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

    <!-- Website -->
    <?php if ( tribe_get_event_website_url( $event_id ) ) : ?>
        <p><span class="icon-website"></span>
            <a href="<?php echo esc_url( tribe_get_event_website_url( $event_id ) ); ?>" target="_blank">
                View Event's Website
            </a>
        </p>
    <?php endif; ?>
    
    <?php
    return ob_get_clean();
}
?>