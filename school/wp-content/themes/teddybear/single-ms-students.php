<?php
/**
 * The template for displaying all single posts for Students
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Teddybear
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			echo '<article>';
			/* Student Name */
			echo '<a href="' . get_permalink() . '">' . '<h3>' . get_the_title() . '</h3></a>';
			/* Student Thumbnail */
			the_post_thumbnail( 'student-thumbnails', array( 'class' => 'alignright' ) );
			// "Student Profile Content"
			if(get_field('student_profile_content')){
				echo '<p>' . get_field('student_profile_content') . '</p>';
			}
			/* Student Portfolio Button */
			echo '<a href="' . get_field('student_profile_button') . '"><button class="student-profile-button">' . get_the_title() . ' Portfolio</button></a>';
			echo '</article>';
			echo '<h3>Meet other ' . single_term_title() . ' students</h3>';
			the_post_navigation(
				array(
					'prev_text' => '<p class="nav-title">%title</p>',
					'next_text' => '<p class="nav-title">%title</p>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
