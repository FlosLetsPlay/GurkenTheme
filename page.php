<?php get_header(); ?>

<div class="main-content w3-main" style="
	padding: 0;
    background: #fff;
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 30px;
    line-height: 1.6;">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="single-post">
      
      <!-- Beitragstitel -->
      <header class="single-header"style="
	margin-bottom: 30px;
    border-bottom: 2px solid var(--main-color);
    padding-bottom: 20px;">
        <h1 class="single-title" style=" font-size: 2.5rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 15px;
    line-height: 1.2;"><?php the_title(); ?></h1>
        <div class="single-meta" style="display: flex;
    gap: 15px;
    font-size: 0.9rem;
    color: #666;font-weight: 600">
          <span class="post-date"><?php echo get_the_date('d.m.Y, H:i'); ?></span>
          <?php 
          $categories = get_the_category();
          if (!empty($categories)) {
            echo '<span class="post-category">in ' . esc_html($categories[0]->name) . '</span>';
          }
          ?>
		
        </div>
      </header>
      <!-- Textinhalt -->
      <div class="single-content" style="
    font-size: 1.1rem;
    line-height: 1.7;
    margin-top: 30px;
	color:#000;
    margin-bottom: 20px;
    margin-top: 35px;
    margin-bottom: 15px;
    color: #222;
    font-size: 1.8rem;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
    font-size: 1.5rem;
    font-size: 1.3rem;
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    margin: 20px 0;
">
        <?php 
        // Content ausgeben
        the_content();
        ?>
      </div>
    </article>
  <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
