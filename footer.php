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
</div><h2 style="position: absolute;display:block; text-indent:-9999px; top: -100px; overflow: auto"><strong><em>
<a href="http://mualanhay.com/news/Dich-vu-mua-lan/">dịch vụ múa lân</a> 
</em></strong></h2>
    </div>
    <div class="art-footer-background">
    </div>
</div>

		<div class="cleared"></div>
    </div>
</div><h2 style="position: absolute;display:block; text-indent:-9999px; top: -100px; overflow: auto"><strong><em>
<a href="http://mualanhay.com/news/Mua-lan-su-rong/Mua-lan-su-rong-la-gi-229/">múa lân sư rồng</a> 
</em></strong></h2>
<div class="cleared"></div>
<p class="art-page-footer">Design: <a href="http://www.free-wordpress-theme.net" target="_blank">Free Wordpress Themes</a> | <?php 
/* This theme is powered by free-wordpress-theme.net, please do NOT remove the comment or anything below. */
			wp_theme_GPL_credits();
/* This theme is powered by free-wordpress-theme.net, please do NOT remove the comment or anything below. */ ?></p>

<!-- <?php printf(__('%d queries. %s seconds.', 'kubrick'), get_num_queries(), timer_stop(0, 3)); ?> -->
<?php ob_start(); wp_footer(); $content = ob_get_clean(); if (strlen($content)) echo '<div>' . $content . '</div>'; ?>
</body>
</html>