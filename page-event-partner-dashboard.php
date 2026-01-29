<?php
/*
Template Name: Event Partner Dashboard
Template Post Type: page
*/

get_header();
?>

<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="ep-sidebar">
            <div class="sidebar-header">
                <h3>Event Partner</h3>
                <p>Welcome back!</p>
            </div>

            <div class="quick-actions">
                <h4>Quick Actions</h4>
                <a href="<?php echo home_url('/submit-an-event/'); ?>" class="action-btn">
                    ➕ Submit Event
                </a>
                <a href="<?php echo home_url('/my-events/'); ?>" class="action-btn secondary">
                    📋 View My Events
                </a>
            </div>

            <div class="upgrade-prompt">
                <h4>⭐ Boost Your Events</h4>
                <p>Get featured placement and reach even more people</p>
                <a href="<?php echo home_url('/advertising/'); ?>" class="upgrade-btn">View Options</a>
            </div>

            <div class="help-links">
                <h4>Need Help?</h4>
                <a href="<?php echo home_url('/contact/'); ?>" class="help-link">📧 Contact Support</a>
                <a href="#" class="help-link">📚 Help Docs</a>
                <a href="#" class="help-link">💬 Community</a>
            </div>
        </aside>

        <!-- Main Content Area (Divi Builder Content) -->
        <div class="ep-main-content">
            <div id="main-content">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php
                                the_content();
                            ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
