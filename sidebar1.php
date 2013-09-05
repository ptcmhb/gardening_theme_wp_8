<div class="art-layout-cell art-sidebar1">      
<?php if (!art_sidebar(1)): ?>
<div class="art-block">
    <div class="art-block-tl"></div>
    <div class="art-block-tr"></div>
    <div class="art-block-bl"></div>
    <div class="art-block-br"></div>
    <div class="art-block-tc"></div>
    <div class="art-block-bc"></div>
    <div class="art-block-cl"></div>
    <div class="art-block-cr"></div>
    <div class="art-block-cc"></div>
    <div class="art-block-body">
<div class="art-blockheader">
    <div class="l"></div>
    <div class="r"></div>
     <div class="t"><?php _e('Search', 'kubrick'); ?></div>
</div>
<div class="art-blockcontent">
    <div class="art-blockcontent-tl"></div>
    <div class="art-blockcontent-tr"></div>
    <div class="art-blockcontent-bl"></div>
    <div class="art-blockcontent-br"></div>
    <div class="art-blockcontent-tc"></div>
    <div class="art-blockcontent-bc"></div>
    <div class="art-blockcontent-cl"></div>
    <div class="art-blockcontent-cr"></div>
    <div class="art-blockcontent-cc"></div>
    <div class="art-blockcontent-body">
<!-- block-content -->
<form method="get" name="searchform" action="<?php bloginfo('url'); ?>/">
<input type="text" value="<?php the_search_query(); ?>" name="s" style="width: 95%;" />
<span class="art-button-wrapper">
	<span class="l"> </span>
	<span class="r"> </span>
	<input class="art-button" type="submit" name="search" value="<?php _e('Search', 'kubrick'); ?>" />
</span>
</form>
<!-- /block-content -->

		<div class="cleared"></div>
    </div>
</div>

		<div class="cleared"></div>
    </div>
</div>
<div class="art-vmenublock">
    <div class="art-vmenublock-body">
<div class="art-vmenublockcontent">
    <div class="art-vmenublockcontent-body">
<!-- block-content -->
<ul class="art-vmenu">
<?php art_vmenu_items(); ?>
</ul>

<!-- /block-content -->

		<div class="cleared"></div>
    </div>
</div>

		<div class="cleared"></div>
    </div>
</div>

<center><?php $adsense_120 = get_option('grd_adsense_120'); echo stripslashes($adsense_120); ?></center>

<?php endif ?>
</div>
