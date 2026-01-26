<?php
function my_theme_enqueue_styles() {
    $parent_style = 'divi-style';

    // Enqueue parent theme style
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    // Enqueue QRCode script from CDN
    wp_enqueue_script( 'qrcode', 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js', array(), null, true );

    // Enqueue custom JavaScript file
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery', 'qrcode'), '1.0', true );

    // Enqueue child theme style
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// Update The Events Calendar Map Size
add_filter( 'tribe_events_embedded_map_style', function() {
    return 'width: 100%; height: 400px';
});

// Remove add to calendar from full event list
add_filter(
    'tec_views_v2_subscribe_links',
    function ( $visible ) { 
        if ( ! is_singular( Tribe__Events__Main::POSTTYPE ) ) { 
            return false; 
        }
        return $visible; 
    }, 
    15, 
    1 
);

// Limit file size for The Events Calendar uploads
add_filter( 'tribe_community_events_max_file_size_allowed', function() {
    return 1048576; // 1MB
});

// Adds Monarch sharing shortcode
function monarchShortcode(){
    $monarch = $GLOBALS['et_monarch'];
    $monarch_options = $monarch->monarch_options;
    return $monarch->generate_inline_icons('et_social_inline_custom');
}
add_shortcode('et_social_share_custom', 'monarchShortcode');

// Allow Event Partners to see events I created for them
add_filter( 'tribe_community_events_get_event_query', 'get_events', 15, 3 );
function get_events( $data, $args, $full ): \WP_Query {
    unset($args['meta_query']);
    return tribe_get_events( $args, $full );
}

// Exclude The Events Calendar scripts from SiteGround Optimizer defer/minify
function exclude_tec_scripts_from_optimization( $exclude_list ) {
    $tec_scripts = [
        '/wp-content/plugins/the-events-calendar/src/resources/js/tribe-events.js',
        '/wp-content/plugins/events-calendar-pro/src/resources/js/tribe-events-pro.js',
        '/wp-content/plugins/the-events-calendar-filterbar/src/resources/js/filter-bar.js',
        '/wp-content/plugins/the-events-calendar-community-events/src/resources/js/community-events.js',
    ];
    return array_merge( $exclude_list, $tec_scripts );
}
add_filter( 'sgo_js_minify_exclude', 'exclude_tec_scripts_from_optimization' );
add_filter( 'sgo_js_async_exclude', 'exclude_tec_scripts_from_optimization' );
add_filter( 'sgo_javascript_combine_exclude', 'exclude_tec_scripts_from_optimization' );

// Create member menu shortcode
function render_event_partner_menu() {
    if (is_user_logged_in()) {
        return '<div id="hidden-event-partner-menu" style="display: none;">'
            . '<div class="event-partner-menu">'
            . '<h3 style="color: white; font-weight: bold; margin-top: 20px;">Event Partners</h3>'
            . '<a href="/partner-home" class="global-menu-item"><span class="material-symbols-outlined">handshake</span> Partner Dashboard</a>'
            . '<a href="/submit-an-event" class="global-menu-item"><span class="material-symbols-outlined">add</span> Add Event</a>'
            . '<a href="/my-events" class="global-menu-item"><span class="material-symbols-outlined">local_activity</span> My Events</a>'
            . '<a href="/account" class="global-menu-item"><span class="material-symbols-outlined">account_circle</span> My Account</a>'
            . '<a href="/logout" class="global-menu-item"><span class="material-symbols-outlined">logout</span> Logout</a>'
            . '</div>'
            . '</div>';
    }
}
add_shortcode('event_partner_menu', 'render_event_partner_menu');

// Hide the Login menu item if logged in
add_action('wp_head', function() {
    if (is_user_logged_in()) {
        echo '<style>#menu-login { display: none; }</style>';
    }
});

/* ==========================
   CACHE MANAGEMENT
   Aggressive purging for SiteGround Dynamic/File-Based Caching
   ========================== */

// Central cache purge function
function gce_purge_all_caches() {
    if (function_exists('wpgs_purge_cache')) {
        wpgs_purge_cache(home_url());
    }
}

// Clear cache on user login
add_action('um_on_login', function($user_id) {
    gce_purge_all_caches();
}, 10, 1);

// Purge cache when Events Calendar events are published/updated/deleted
add_action('save_post_tribe_events', function($post_id) {
    // Avoid infinite loops on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    gce_purge_all_caches();
}, 20);

add_action('trash_post_tribe_events', 'gce_purge_all_caches', 20);
add_action('untrash_post_tribe_events', 'gce_purge_all_caches', 20);

// Purge when organizers/venues are updated (affects event pages)
add_action('save_post_tribe_organizer', function($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    gce_purge_all_caches();
}, 20);

add_action('save_post_tribe_venue', function($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    gce_purge_all_caches();
}, 20);

/* ==========================
   End Cache Management
   ========================== */

// Fix featured image links in The Events Calendar
add_filter( 'tribe_template_html:events/v2/list/event/featured-image', function ( $html, $file, $name, $template ) {
    $event = $template->get( 'event' );
    $anchor_open = sprintf(
        '<a href="%s" title="%s" rel="bookmark" class="tribe-events-calendar-list__event-featured-image-link" tabindex="-1" aria-hidden="true">',
        esc_url( $event->permalink ),
        esc_attr( $event->title )
    );
    $html = preg_replace(
        '/(<img[^>]*>)/',
        $anchor_open . '$1</a>',
        $html
    );
    return $html;
}, 10, 4 );

// Slim SEO Sitemap include Events
add_filter( 'slim_seo_sitemap_post_types', function ( $post_types ) {
    $post_types[] = 'tribe_events';
    return $post_types;
});

// Register query var
add_filter('query_vars', function($vars){
  $vars[] = 'cl_moffset';
  return $vars;
});

// Rewrite: /chatling/events/m/0 .. /11
add_action('init', function () {
  add_rewrite_rule(
    '^chatling/events/m/([0-9]{1,2})/?$',
    'index.php?cl_moffset=$matches[1]',
    'top'
  );
});

// Simple renderer for the feed page
add_action('template_redirect', function () {
  $m = get_query_var('cl_moffset', null);
  if ($m === null) return;

  // Hard clamp 0..11 just in case
  $offset = max(0, min(11, intval($m)));

  // Compute start/end of that month in site timezone
  $tz  = new DateTimeZone(wp_timezone_string() ?: 'UTC');
  $start = new DateTime('first day of this month', $tz);
  $start->modify("+$offset months")->setTime(0,0,0);
  $end   = clone $start;
  $end->modify('last day of this month')->setTime(23,59,59);

  // Query The Events Calendar by date range
  $events = tribe_get_events([
    'start_date' => $start->format('Y-m-d H:i:s'),
    'end_date'   => $end->format('Y-m-d H:i:s'),
    'posts_per_page' => 300,   // adjust if needed
    'hide_upcoming'  => false,
  ]);

  // Output minimal, scraper-friendly HTML
  header('Content-Type: text/html; charset=utf-8');
  echo "<!doctype html><meta charset='utf-8'><title>GCE m/$offset</title>";
  echo "<main class='cl-feed'>";
  foreach ($events as $e) {
    $title = esc_html(get_the_title($e));
    $link  = esc_url(get_permalink($e));
    $when  = tribe_get_start_date($e, true, 'D, M j @ g:ia');
    $venue = esc_html(tribe_get_venue($e));
    $desc  = wp_strip_all_tags(get_the_excerpt($e) ?: get_post_field('post_content', $e));
    echo "<article class='cl-item'>
            <h2>$title</h2>
            <p><strong>$when</strong>".($venue ? " — $venue" : "")."</p>
            <p>$desc</p>
            <p><a href='$link'>Details</a></p>
          </article>";
  }
  echo "</main>";
  exit;
});

// One-time: visit Settings → Permalinks (or run this once after deploy)
register_activation_hook(__FILE__, function(){ flush_rewrite_rules(); });
register_deactivation_hook(__FILE__, function(){ flush_rewrite_rules(); });

// Organizer + Venue sitemap: /organizers-venues-sitemap.xml
add_action('init', function () {
    add_rewrite_rule('^organizers-venues-sitemap\.xml$', 'index.php?gce_ov_sitemap=1', 'top');
    add_rewrite_tag('%gce_ov_sitemap%', '([0-1])');
});

add_action('template_redirect', function () {
    if (get_query_var('gce_ov_sitemap') !== '1') return;

    header('Content-Type: application/xml; charset=UTF-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // Organizers
    $organizers = get_posts([
        'post_type'      => 'tribe_organizer',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ]);
    foreach ($organizers as $org) {
        $loc     = get_permalink($org->ID);
        $lastmod = get_post_modified_time('c', true, $org->ID);
        echo "<url><loc>" . esc_url($loc) . "</loc><lastmod>$lastmod</lastmod></url>";
    }

    // Venues
    $venues = get_posts([
        'post_type'      => 'tribe_venue',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ]);
    foreach ($venues as $venue) {
        $loc     = get_permalink($venue->ID);
        $lastmod = get_post_modified_time('c', true, $venue->ID);
        echo "<url><loc>" . esc_url($loc) . "</loc><lastmod>$lastmod</lastmod></url>";
    }

    echo '</urlset>';
    exit;
});

// Add Chatling to all pages except embeds
function gce_add_chatling() {
    // Get current URL path
    $current_path = $_SERVER['REQUEST_URI'];
    
    // Don't load on embed pages
    if (is_page(array('list-view-embed', 'week-view-embed', 'map-view-embed')) || 
        strpos($current_path, '/calendar-embed/') !== false) {
        return;
    }
    ?>
    <script>
    window.chtlConfig = { chatbotId: "9391787989" }
    </script>
    <script async data-id="9391787989" id="chtl-script" type="text/javascript" src="https://chatling.ai/js/embed.js"></script>
    <?php
}
add_action('wp_head', 'gce_add_chatling');

// Disable CF7 ReCaptcha on embed pages
function gce_disable_recaptcha_on_embeds() {
    // Get current URL path
    $current_path = $_SERVER['REQUEST_URI'];
    
    // Don't load on embed pages
    if (is_page(array('list-view-embed', 'week-view-embed', 'map-view-embed')) || 
        strpos($current_path, '/calendar-embed/') !== false) {
        
        // Remove CF7 ReCaptcha scripts
        remove_action('wp_enqueue_scripts', 'wpcf7_recaptcha_enqueue_scripts', 20);
        add_filter('wpcf7_load_js', '__return_false');
        add_filter('wpcf7_load_css', '__return_false');
    }
}
add_action('wp_enqueue_scripts', 'gce_disable_recaptcha_on_embeds', 1);

// Auto-resize script for embed pages
function gce_embed_resize_script() {
    $current_path = $_SERVER['REQUEST_URI'];
    
    if (is_page(array('list-view-embed', 'week-view-embed', 'map-view-embed')) || 
        strpos($current_path, '/calendar-embed/') !== false) {
        ?>
        <script>
        (function() {
            function sendHeight() {
                var height = document.body.scrollHeight;
                window.parent.postMessage({
                    type: 'gce-resize',
                    height: height
                }, '*');
            }
            
            // Send height on load
            window.addEventListener('load', sendHeight);
            
            // Send height when content changes
            setInterval(sendHeight, 500);
        })();
        </script>
        <?php
    }
}
add_action('wp_footer', 'gce_embed_resize_script');

// Hide social sharing on embed pages
function gce_hide_social_on_embeds() {
    $current_path = $_SERVER['REQUEST_URI'];
    
    if (is_page(array('list-view-embed', 'week-view-embed', 'map-view-embed')) || 
        strpos($current_path, '/calendar-embed/') !== false) {
        echo '<style>
            .et_social_sidebar_networks { display: none !important; }
        </style>';
    }
}
add_action('wp_head', 'gce_hide_social_on_embeds');

// Force event links to open in new tab on embed pages
function gce_force_links_new_tab() {
    $current_path = $_SERVER['REQUEST_URI'];
    
    if (is_page(array('list-view-embed', 'week-view-embed', 'map-view-embed'))) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find all event links
            var eventLinks = document.querySelectorAll('.tribe-events-calendar-list__event-title-link, .tribe-events-calendar-list__event-featured-image-link, a[href*="/event/"]');
            
            eventLinks.forEach(function(link) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
            });
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'gce_force_links_new_tab');

?>