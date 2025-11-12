<?php get_header(); ?>
<div class="main-content w3-main" style="margin-left:75px">
  <?php
  // Header: Neuester Artikel-Beitrag
  $header_query = new WP_Query([
    'posts_per_page' => 1,
    'category_name'  => 'artikel, sendung',
    'post_status'    => 'publish'
  ]);

  $header_post_id = null;
  if ($header_query->have_posts()) :
    $header_query->the_post();
    $header_post_id = get_the_ID();
    $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $fade_hex = get_theme_mod('gurkenschau_header_bg_color', '#0c7ea4');
  ?>
    <header class="header"
      style="
        --fade-color: <?php echo esc_attr($fade_hex); ?>;
        <?php if ($img): ?>
          background-image: url('<?php echo esc_url($img); ?>');
          background-size: auto 100%;
          background-position: left center;
          background-repeat: no-repeat;
        <?php endif; ?>
      ">
      <div class="header-text">
        <h1><?php the_title(); ?></h1>
        <a href="<?php the_permalink(); ?>" class="header-button">
          <button><?php echo esc_html(get_theme_mod('gurkenschau_header_button_text', 'Weitere Informationen')); ?></button>
        </a>
      </div>
    </header>
  <?php
    wp_reset_postdata();
  endif;
  ?>

  <section class="news-section">
    <h2><?php echo esc_html(get_theme_mod('gurkenschau_news_title', 'Weitere aktuelle Meldungen:')); ?></h2>
    
    <!-- Obere Reihe: Artikel (ohne Header-Beitrag) -->
    <div class="news-row">
      <h3 class="row-title">Artikel</h3>
      <div class="news-cards-row">
        <?php
        $articles_query = new WP_Query([
          'posts_per_page' => 999,
          'category_name'  => 'artikel',
          'post_status'    => 'publish',
          'post__not_in'   => $header_post_id ? [$header_post_id] : []
        ]);

        if ($articles_query->have_posts()) :
          while ($articles_query->have_posts()) : $articles_query->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="news-card news-card--artikel">
              <div class="card-image">
                <?php if (has_post_thumbnail()) {
                  the_post_thumbnail('medium', ['loading' => 'lazy']);
                } else {
                  echo '<img src="'.get_template_directory_uri().'/assets/img/default.png" alt="default">';
                } ?>
              </div>
              <h4><?php the_title(); ?></h4>
              <span><?php echo get_the_date('d.m.Y, H:i'); ?></span>
            </a>
          <?php endwhile;
        else: ?>
          <p></p>
        <?php endif;
        wp_reset_postdata(); ?>
      </div>
    </div>

    <!-- Untere Reihe: Sendungen -->
    <div class="news-row">
      <h3 class="row-title">Sendungen</h3>
      <div class="news-cards-row">
        <?php
        $shows_query = new WP_Query([
          'posts_per_page' => 999,
          'category_name'  => 'sendung',
          'post_status'    => 'publish'
        ]);

        if ($shows_query->have_posts()) :
          while ($shows_query->have_posts()) : $shows_query->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="news-card news-card--sendung">
              <div class="card-image">
                <?php if (has_post_thumbnail()) {
                  the_post_thumbnail('medium', ['loading' => 'lazy']);
                } else {
                  echo '<img src="'.get_template_directory_uri().'/assets/img/default-img.webp" alt="default">';
                } ?>
              </div>
              <h4><?php the_title(); ?></h4>
              <span><?php echo get_the_date('d.m.Y, H:i'); ?></span>
            </a>
          <?php endwhile;
        else: ?>
          <p><b>Bald...</b><i> Psst</i></p>
        <?php endif;
        wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
</div>

<?php get_footer(); ?>
