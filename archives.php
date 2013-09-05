<?php wp_get_header(); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
<div class="art-layout-cell art-content">

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

<h2><?php _e('Archives by Month:', 'kubrick'); ?></h2>
<ul><?php wp_get_archives('type=monthly'); ?></ul>
<h2><?php _e('Archives by Subject:', 'kubrick'); ?></h2>
<ul><?php wp_list_categories(); ?></ul>

<!-- /block-content -->

		<div class="cleared"></div>
    </div>
</div>


		<div class="cleared"></div>
    </div>
</div>


</div>
<?php include (TEMPLATEPATH . '/sidebar1.php'); ?>
    </div>
</div>
<div class="cleared"></div>

<?php wp_get_footer(); ?>
