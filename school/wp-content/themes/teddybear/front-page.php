<?php
/**
 * The template for displaying the front page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Teddybear
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			?>

			<h1><?php the_title(); ?></h1>

			<section class="home-intro">
			
				<?php
					// Load the intro section from a separate page using WP_query
					// The page+id is the ID of the about page, where we added the text

					$args = array( 'page_id' => 5 ); // list of parameters
					$intro_query = new WP_Query( $args );
					if ( $intro_query -> have_posts() ){
						while ( $intro_query -> have_posts() ) {
							$intro_query -> the_post();
							the_content();
						}
						wp_reset_postdata();
					} 
				?>

			</section><!-- .home-intro -->
			
			<section class="alignwide-image">
				<?php
					$image = get_field('align_wide_image');
					$size = 'full'; // (thumbnail, medium, large, full or custom size)
					if( $image ) {
						echo "<figure class='alignwide'>";
						echo wp_get_attachment_image( $image, $size );
						echo "</figure>";
					}
				?>
			</section><!--.alignwide-image -->

			<section class="home-left-right-flex-box">
				<section class="home-left">

					<?php
						if ( function_exists( 'get_field' ) ) {
							if ( get_field( 'left_section_title' ) ) {
								echo '<h2>';
								the_field( 'left_section_title' );
								echo '</h2>';
							}
							if ( get_field( 'left_section_text' ) ) {
								echo '<p>';
								the_field( 'left_section_text' );
								echo '</p>';
							}
						}
					?>

				</section><!-- .home-left -->
				
				<section class="home-right">

					<?php
						if ( function_exists( 'get_field' ) ) {
							if ( get_field( 'right_section_title' ) ) {
								echo '<h2>';
								the_field( 'right_section_title' );
								echo '</h2>';
							}
							if ( get_field( 'right_section_text' ) ) {
								echo '<p>';
								the_field( 'right_section_text' );
								echo '</p>';
							}
						}
					?>

				</section><!-- .home-right -->
			</section>

			<section class="alignfull-image">
				<?php
					$image = get_field('align_full_image');
					$size = 'full'; // (thumbnail, medium, large, full or custom size)
					if( $image ) {
						echo "<figure class='alignfull'>";
						echo wp_get_attachment_image( $image, $size );
						echo "</figure>";
					}
					the_field('align_full_content');
				?>
			</section><!--.alignfull-image -->
			
			<section class="blog-posts">
				<h2>Recent News</h2>
				<?php
					$args = array( 
						'post_type'      => 'post',
						'posts_per_page' => 3 
					);
					$blog_query = new WP_Query( $args );
					echo '<div class=blog-posts-wrapper>';
					if ( $blog_query -> have_posts() ){
						while ( $blog_query -> have_posts() ) {
							$blog_query -> the_post();
							echo '<article class="fp-blog-posts-image">';
							// Latest Blog Post Thumbnail
							the_post_thumbnail( 'medium' );
							// Title of Latest Blog Post
							echo '<a href="' . get_permalink() . '">' . '<h4>' . get_the_title() . '</h4>' . '</a>';
							echo '</article>';
						}
						wp_reset_postdata();
					} 
					echo '</div>';

					// Link to Blog
					echo '<div class="front-page-button-wrapper">';
					echo '<button><a href="' . site_url('/news') . '">See All News</a></button>';
					echo '</div>';
				?>

			</section><!-- .blog-posts -->

		<?php
			endwhile; // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_footer();
