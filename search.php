<?php wp_get_header(); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
<div class="art-layout-cell art-content">


	<?php if (have_posts()) : ?>

<div class="art-post">
		    <div class="art-post-tl"></div>
		    <div class="art-post-tr"></div>
		    <div class="art-post-bl"></div>
		    <div class="art-post-br"></div>
		    <div class="art-post-tc"></div>
		    <div class="art-post-bc"></div>
		    <div class="art-post-cl"></div>
		    <div class="art-post-cr"></div>
		    <div class="art-post-cc"></div>
		    <div class="art-post-body">
		<div class="art-post-inner art-article">
		
<div class="art-postcontent">
            <!-- article-content -->
        
        
		<h2><?php _e('Search Results', 'kubrick'); ?></h2>

		<?php
		$prev_link = get_previous_posts_link(__('Newer Entries &raquo;', 'kubrick'));
		$next_link = get_next_posts_link(__('&laquo; Older Entries', 'kubrick'));
		?>

		<?php if ($prev_link || $next_link): ?>
<div class="navigation">
	<div class="alignleft"><?php echo $next_link; ?></div>
	<div class="alignright"><?php echo $prev_link; ?></div>
</div>
		<?php endif; ?>


		    <!-- /article-content -->
		</div>
		<div class="cleared"></div>
		

		</div>
		
				<div class="cleared"></div>
		    </div>
		</div>
		


		<?php while (have_posts()) : the_post(); ?>
<div class="art-post">
			    <div class="art-post-tl"></div>
			    <div class="art-post-tr"></div>
			    <div class="art-post-bl"></div>
			    <div class="art-post-br"></div>
			    <div class="art-post-tc"></div>
			    <div class="art-post-bc"></div>
			    <div class="art-post-cl"></div>
			    <div class="art-post-cr"></div>
			    <div class="art-post-cc"></div>
			    <div class="art-post-body">
			<div class="art-post-inner art-article">
			<?php $page_title = get_post_meta($post->ID, 'page_title', TRUE); ?>
			<?php if (!$page_title == 'No') { ?>
			<h2 class="art-postheader">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>">
			<?php the_title(); ?>
			</a>
			</h2>
			 <?php } ?>
			<?php $icons = array(); ?>
			<?php if (!is_page()): ?><?php ob_start(); ?><?php the_time(__('F jS, Y', 'kubrick')) ?>
			<?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (!is_page()): ?><?php ob_start(); ?><?php _e('Author', 'kubrick'); ?>: <?php the_author_posts_link() ?>
			<?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (0 != count($icons)): ?>
			<div class="art-postheadericons art-metadata-icons">
			<?php echo implode(' | ', $icons); ?>
			
			</div>
			<?php endif; ?>
			<div class="art-postcontent">
			    <!-- article-content -->
			
			          <?php if (is_search()) the_excerpt(); else the_content(__('Read the rest of this entry &raquo;', 'kubrick')); ?>
			          <?php if (is_page() or is_single()) wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			        
			    <!-- /article-content -->
			</div>
			<div class="cleared"></div>
			<?php ob_start(); ?>
			<?php $icons = array(); ?>
			<?php if (!is_page()): ?><?php ob_start(); ?><?php printf(__('Posted in %s', 'kubrick'), get_the_category_list(', ')); ?>
			<?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (!is_page() && get_the_tags()): ?><?php ob_start(); ?><?php the_tags(__('Tags:', 'kubrick') . ' ', ', ', ' '); ?>
			<?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (!is_page() && !is_single()): ?><?php ob_start(); ?><?php comments_popup_link(__('No Comments &#187;', 'kubrick'), __('1 Comment &#187;', 'kubrick'), __('% Comments &#187;', 'kubrick'), '', __('Comments Closed', 'kubrick') ); ?>
			<?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (0 != count($icons)): ?>
			<div class="art-postfootericons art-metadata-icons">
			<?php echo implode(' | ', $icons); ?>
			
			</div>
			<?php endif; ?>
			<?php $metadataContent = ob_get_clean(); ?>
			<?php if (trim($metadataContent) != ''): ?>
			<div class="art-postmetadatafooter">
			<?php echo $metadataContent; ?>
			
			</div>
			<?php endif; ?>
			
			</div>
			
					<div class="cleared"></div>
			    </div>
			</div>
			
		<?php endwhile; ?>

		<?php if ($prev_link || $next_link): ?>
		
<div class="art-post">
		    <div class="art-post-tl"></div>
		    <div class="art-post-tr"></div>
		    <div class="art-post-bl"></div>
		    <div class="art-post-br"></div>
		    <div class="art-post-tc"></div>
		    <div class="art-post-bc"></div>
		    <div class="art-post-cl"></div>
		    <div class="art-post-cr"></div>
		    <div class="art-post-cc"></div>
		    <div class="art-post-body">
		<div class="art-post-inner art-article">
		
<div class="art-postcontent">
            <!-- article-content -->
        
        
<div class="navigation">
	<div class="alignleft"><?php echo $next_link; ?></div>
	<div class="alignright"><?php echo $prev_link; ?></div>
</div>
		

		    <!-- /article-content -->
		</div>
		<div class="cleared"></div>
		

		</div>
		
				<div class="cleared"></div>
		    </div>
		</div>
		
		
		<?php endif; ?>

	<?php else : ?>
<div class="art-post">
		    <div class="art-post-tl"></div>
		    <div class="art-post-tr"></div>
		    <div class="art-post-bl"></div>
		    <div class="art-post-br"></div>
		    <div class="art-post-tc"></div>
		    <div class="art-post-bc"></div>
		    <div class="art-post-cl"></div>
		    <div class="art-post-cr"></div>
		    <div class="art-post-cc"></div>
		    <div class="art-post-body">
		<div class="art-post-inner art-article">
		
<div class="art-postcontent">
            <!-- article-content -->
        
        
        <h2><?php _e('Search Results', 'kubrick'); ?></h2>
		<h2 class="center"><?php _e('No posts found. Try a different search?', 'kubrick'); ?></h2>
		<?php if(function_exists('get_search_form')) get_search_form(); ?>
		

		    <!-- /article-content -->
		</div>
		<div class="cleared"></div>
		

		</div>
		
				<div class="cleared"></div>
		    </div>
		</div>
		

	<?php endif; ?>

</div>
<?php include (TEMPLATEPATH . '/sidebar1.php'); ?><?php include (TEMPLATEPATH . '/sidebar2.php'); ?>
    </div>
</div>
<div class="cleared"></div>

<?php wp_get_footer(); ?>