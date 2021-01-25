<?php
/**
 * The template for displaying the "Schedule" page
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

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>
		<table class="schedule">
		<?php 
			// Show Table Heading
			if(has_sub_field('schedule')) {
				echo '<tr>';
				echo '<th>Date</th>';
				echo '<th>Course</th>';
				echo '<th>Instructor</th>';
				echo '</tr>';
			}
			// Show Table Contents
			while(has_sub_field('schedule')) {
				echo '<tr>';
				echo '<td>' . the_sub_field(''); '</td>';
				echo '<td>' . the_sub_field('date'); '</td>';
				echo '<td>' . the_sub_field('course'); '</td>';
				echo '<td>' . the_sub_field('instructor'); '</td>';
				echo '</tr>';
			}
		?>
		</table>
		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
