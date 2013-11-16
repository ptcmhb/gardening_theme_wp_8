<?php
$categories = get_categories('parent=0&orderby=id&include=');
foreach ($categories as $cat) {
  query_posts('&cat='.$cat->cat_ID.'&posts_per_page=1');
  $postcount = 0;
  while (have_posts()) : the_post();
    global $post;
  ?>
<div class="art-block art-postblock">
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
      <div class="t"><?php echo $cat->cat_name ?></div>
    </div>

    <div class="art-blockcontent light">
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
        <!-- /article-block -->
        <div class="art-post-body">
          <div class="art-post-inner art-article">
            <h4>
              <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>">
              <?php the_title(); ?>
              </a>
            </h4>
         
            <div class="art-postcontent">
              <!-- article-content -->
              <div class="art-postheadericons art-metadata-icons">
                <?php the_time(__('F jS, Y', 'kubrick')) ?>
              </div>
              <?php the_excerpt(__('Read the rest of this entry &raquo;', 'kubrick')); ?>
              <div class="cleared">
              </div><a href="<?php echo get_permalink( get_the_ID() ) ?>">
                <?php echo __('Read more', 'kubrick') ?></a>
              <!-- /article-content -->
            </div>
            <div class="cleared"></div>
          </div>

          <div class="cleared"></div>
        </div>
        <!-- /article-block -->
        <!-- /block-content -->
        <div class="cleared"></div>
      </div>
    </div>

  <div class="cleared"></div>
  </div>
</div>
<?php endwhile; } ?>
