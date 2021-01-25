<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Teddybear
 */

?>

	<footer id="colophon" class="site-footer">

		<div class="site-info">
			<?php esc_html_e( 'Created by ', 'twd' ); ?>
			<a href="<?php echo esc_url( __( 'http://mbui.bcitwebdeveloper.ca/', 'twd' ) ); ?>">
			<?php esc_html_e( 'Mina Bui. ', 'twd' ); ?>
			</a>
		</div><!-- .site-info -->
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
