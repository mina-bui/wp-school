<?php
/**
 * The template for displaying the "Student" archive page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Teddybear
 */

get_header();
?>

	<main id="primary" class="site-main">
	<section class="students">
	<h2>The Class</h2>

	<?php
		$taxonomy = 'ms-student-category';
		$terms = get_terms(
			array(
				'taxonomy' => $taxonomy
			)
		);
		if($terms && ! is_wp_error($terms) ){
			foreach($terms as $term){
				$term_args = array(
					'post_type'      => 'ms-students',
					'posts_per_page' => -1,
					'order' 		 => 'ASC',
					'orderby' 		 => 'title',
					'tax_query'      => array(
							array(
								'taxonomy' => $taxonomy,
								'field'    => 'slug',
								'terms'    => $term->slug,
							)
					),
				);
				$term_query = new WP_Query ($term_args);

				if ( $term_query->have_posts() ) {
					echo '<section class="students-wrapper">';
					while($term_query->have_posts()){
						$term_query->the_post();
						if (function_exists ('get_field')){
							echo '<article class="student-item">';

							/* Student Name */
							echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
							/* Student Thumbnail */
							the_post_thumbnail( 'thumbnail' );
							// "Student Profile Content"
							echo '<p>' . custom_field_excerpt() . 'Read more about the student...</a></p>';
							/* Student Specialty */
							echo '<p>Specialty: <a href="' . site_url('student-categories/' . $term->name) . '">' . $term->name . '</a></p>';

							echo '</article>';
						}//end if
					}//end while
					
					echo '</section>';
					wp_reset_postdata();
				}// end if
			}//end foreach
		}//end if
	?>
	</section>
	</main><!-- #main -->

<?php
get_footer();
