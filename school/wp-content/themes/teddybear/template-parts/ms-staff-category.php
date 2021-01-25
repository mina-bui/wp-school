<?php
/**
 * Template part for displaying Staff Categories
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Teddybear
 */

get_header();
?>

	<?php
		$taxonomy = 'ms-staff-category';
		$terms = get_terms(
			array(
				'taxonomy' => $taxonomy
			)
		);
		
		if($terms && ! is_wp_error($terms) ){
			foreach($terms as $term){
				$term_args = array(
					'post_type'      => 'ms-staff',
					'posts_per_page' => -1,
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
					
					//display the term name 
					echo '<h2>' . $term->name . '</h2>';
					echo '<section class="staff-wrapper">';

					while($term_query->have_posts()){
						$term_query->the_post();
						if (function_exists ('get_field')){
							echo '<article class="staff-item">';
							// "Staff Name"
							if(get_field('staff_name')){
								echo '<h3>' . get_field('staff_name') . '</h3>';
							}//end if

							// "Staff Content / Description"
							if(get_field('staff_content')){
								echo '<p>' . get_field('staff_content') . '</p>';
							}//end if

							// "Instructor Courses"
							if(get_field('staff_courses')){
								echo '<p>Courses: ' . get_field('staff_courses') . '</p>';
							}//end if

							// "Instructor Website"
							if(get_field('staff_website')){
								echo '<p><a href="' . esc_url( get_field('staff_website') ) . '">' . 'Instructor Website</a></p>';
							}//end if
							echo '</article>';
							
						}//end if
					}//end while
					
					echo '</section>';
					wp_reset_postdata();
				}// end if
			}//end foreach
		}//end if
	?>

<?php
get_footer();
