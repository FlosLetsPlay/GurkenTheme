<?php get_header(); ?>

<div class="main-content w3-main" style="margin-left:50px;">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="single-post">
      
      <!-- Beitragstitel -->
      <header class="single-header">
        <h1 class="single-title"><?php the_title(); ?></h1>
        <div class="single-meta" style="font-size:0.9rem;">
          <span class="post-date"><?php echo get_the_date('d.m.Y, H:i'); ?></span>
          <?php 
          $categories = get_the_category();
          if (!empty($categories)) {
            echo '<span class="post-category">in ' . esc_html($categories[0]->name) . '</span>';
          }
          ?>
			<span class="post-autor"><?php echo get_the_author(); ?></span>
        </div>
      </header>
      <!-- Textinhalt -->
      <div class="single-content">
        <?php 
        // Content ausgeben
        the_content();
        ?>
      </div>

      <!-- Navigation zu vorherigen/n�chsten Beitr�gen -->
      <nav class="post-navigation" style="font-size:0.9rem;">
        <div class="nav-links">
          <?php
          $prev_post = get_previous_post();
          $next_post = get_next_post();
          
          if ($prev_post) : ?>
            <div class="nav-previous">
              <a href="<?php echo get_permalink($prev_post->ID); ?>" rel="prev">
                <span class="nav-subtitle">Vorheriger Beitrag</span>
                <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
              </a>
            </div>
          <?php endif; ?>
          
          <?php if ($next_post) : ?>
            <div class="nav-next">
              <a href="<?php echo get_permalink($next_post->ID); ?>" rel="next">
                <span class="nav-subtitle">N&auml;chster Beitrag</span>
                <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
              </a>
            </div>
          <?php endif; ?>
        </div>
      </nav>

    </article>
  <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
