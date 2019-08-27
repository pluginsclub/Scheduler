<div id="post-404-no-content" class="no-content">
    <article class="entry">
        
        <header class="postmetadata" role="content info">
        <?php 
        if( is_search() ) : ?>
        
            <h2><?php esc_html_e( 'No content found. Please try another search.', 'scheduler' ); ?></h2>
        <?php 
        else: ?>

            <h2><?php esc_html_e( 'No content found. Please try a search.', 'scheduler' ); ?></h2>

        <?php 
        endif; ?>
        </header>

        <div class="content">
            <p><?php get_search_form(); ?></p>
            <hr>
            <section class="block">
            
                <?php do_action( 'scheduler_category_list' ); ?>

            </section>

        </div>
        
    </article>
</div><!-- Ends 404 section -->
