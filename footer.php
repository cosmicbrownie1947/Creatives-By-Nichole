<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Your Blog
 */

?>

</div>

<?php

if ( is_singular( 'post' ) ) {
	$args = array(
		'posts_per_page' =>absint( 3 ),
		'post__not_in'   => array( $post->ID ),
		'orderby'        => 'rand',
	);

	$cat_content_id = get_the_category( $post->ID );
	if ( ! empty( $cat_content_id ) ) {
		$args['cat'] = $cat_content_id[0]->term_id;
	}

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) :
		$related_title = get_theme_mod( 'your_blog_related_posts_title', __( 'Related Posts', 'your-blog' ) );
		?>
		<div class="related-posts">
			<?php if ( ! empty( $related_title ) ) : ?>
				<h2><?php echo esc_html( $related_title ); ?></h2>
			<?php endif; ?>
			<div class="theme-archive-layout grid-layout grid-column-3">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="post-item post-grid">
							<div class="post-item-image">
								<a href="<?php the_permalink(); ?>"><?php your_blog_post_thumbnail(); ?></a>
							</div>
							<div class="post-item-content">
								
								<div class="entry-cat">
									<?php the_category( '', '', get_the_ID() ); ?>
								</div>
								<?php
								the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
								?>
								<ul class="entry-meta">
									<li class="post-author"> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><i class="far fa-user"></i><?php echo esc_html( get_the_author() ); ?></a></li>
									<li class="post-date"><i class="far fa-calendar-alt"></i><?php echo esc_html( get_the_date() ); ?></li>

									<li class="read-time">
										<i class="far fa-clock"></i>
										<?php
										echo your_blog_time_interval( get_the_content() );
										echo esc_html__( ' min read', 'your-blog' );
										?>
									</li>
									<li class="comment">
										<i class="far fa-comment"></i>
										<?php echo absint( get_comments_number( get_the_ID() ) ); ?>
									</li>
								</ul>
								<?php get_template_part( 'template-parts/card-corner' ); ?>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
		<?php
	endif;
}

?>
<?php if ( ! is_front_page() || is_home() ) { ?>
</div>
</div><!-- #content -->

	<?php
	if ( is_front_page() ) {

		require get_template_directory() . '/inc/frontpage-sections/posts-grid.php';

	}
}

?>
<footer id="colophon" class="site-footer">
	<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
	<div class="top-footer">
		<div class="theme-wrapper">
			<div class="top-footer-widgets">

				<?php for ( $i = 1; $i <= 3; $i++ ) { ?>
					<div class="footer-widget">
						<div class="widget-inner">
							<?php dynamic_sidebar( 'footer-' . $i ); ?>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
<?php endif; ?>
<?php
$your_blog_search  = array( '[the-year]', '[site-link]' );
$replace           = array( date( 'Y' ), '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );
$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'your-blog' ), '[the-year]', '[site-link]' );
$copyright_text    = get_theme_mod( 'your_blog_copyright_txt', $copyright_default );
$copyright_text    = str_replace( $your_blog_search, $replace, $copyright_text );

?>
<div class="bottom-footer">
	<div class="theme-wrapper">
		<div class="bottom-footer-info">
				<div class="site-info">
					<span>
						<?php echo wp_kses_post( $copyright_text ); ?>
						<?php echo sprintf( esc_html__( 'Theme: %1$s By %2$s.', 'your-blog' ), wp_get_theme()->get( 'Name' ), '<a href="' . wp_get_theme()->get( 'AuthorURI' ) . '">' . wp_get_theme()->get( 'Author' ) . '</a>' ); ?>		
					</span>	
				</div><!-- .site-info -->
				<div class="social-icons">
					<?php
					if ( has_nav_menu( 'social' ) ) {
						wp_nav_menu(
							array(
								'menu_class'     => 'menu social-links',
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>',
								'theme_location' => 'social',
							)
						);
					}
					?>
				</div>
		</div>
	</div>
</div>

</footer><!-- #colophon -->

<a href="#" id="scroll-to-top" class="your-blog-scroll-to-top"><i class="fas fa-chevron-up"></i></a>		

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
