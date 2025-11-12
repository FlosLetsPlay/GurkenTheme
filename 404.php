<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package GurkenThme_V2
 */

get_header();
?>
 <style>
    body {font-family:"Poppins",sans-serif;background:#f8f8f8;color:#333;padding:50px 20px;}
    h1 {font-size:3rem;color:var(--main-color);margin-bottom:20px;}
    p {font-size:1.2rem;margin-bottom:30px;}
    a.button {display:inline-block;padding:12px 24px;font-size:1rem;color:#fff;background:#d5451b;border-radius:8px;text-decoration:none;transition:background .3s;}
    a.button:hover {background:#a83415;}
  </style>
	<main id="primary" class="site-main"  style="margin-left:75px">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><h1>Fehler 404 – Seite nicht gefunden</h1></h1>
			</header><!-- .page-header -->

			<div class="page-content">
  				<p>Die von Ihnen angeforderte Seite konnte leider nicht gefunden werden.<br>Bitte überprüfen Sie die Adresse oder suchen Sie in unseren Artikeln.</p>

					<?php
					get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title">Am h&auml;ufigsten verwendete Kategorien</h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!-- .widget -->


			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
