<div class="art-footer">
    <div class="art-footer-inner">
        <a href="<?php bloginfo('rss2_url'); ?>" class="art-rss-tag-icon" title="RSS"></a>
        <div class="art-footer-text">
<p>
<?php
 global $default_footer_content;
 $footer_content = get_option('art_footer_content'); 
 if ($footer_content === false) $footer_content = $default_footer_content;
 echo stripslashes($footer_content);
?>
</p>
</div>
    </div>
    <div class="art-footer-background">
    </div>
</div>

		<div class="cleared"></div>
    </div>
</div>
<div class="cleared"></div>
<?php 
/* This theme is powered by free-wordpress-theme.net, please do NOT remove the comment or anything below. */
			//wp_theme_GPL_credits();
/* This theme is powered by free-wordpress-theme.net, please do NOT remove the comment or anything below. */ ?></p>

<!-- <?php printf(__('%d queries. %s seconds.', 'kubrick'), get_num_queries(), timer_stop(0, 3)); ?> -->
<?php ob_start(); wp_footer(); $content = ob_get_clean(); if (strlen($content)) echo '<div>' . $content . '</div>'; ?>
</body>
</html>
