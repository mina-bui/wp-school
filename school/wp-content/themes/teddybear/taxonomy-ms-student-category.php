<?php
/**
 * The template for displaying Student Category page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Teddybear
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h2><?php single_term_title(); ?> Students</h2>
			</header><!-- .page-header -->

		<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				
				echo '<article>';
				/* Student Name */
				echo '<a href="' . get_permalink() . '">' . '<h3>' . get_the_title() . '</h3></a>';
				/* Student Thumbnail */
				the_post_thumbnail( 'student-thumbnails', array( 'class' => 'alignleft' ) );
				// "Student Profile Content"
				if(get_field('student_profile_content')){
					echo '<p>' . get_field('student_profile_content') . '</p>';
				}
				/* Student Portfolio Button */
				echo '<a href="' . get_field('student_profile_button') . '"><button class="student-profile-button">' . get_the_title() . ' Portfolio</button></a>';
				echo '</article>';

			endwhile;
			the_posts_navigation();
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
