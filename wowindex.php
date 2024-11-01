<?php
/*
Plugin Name: WOW Index
Plugin URI: http://algofutures.com/wow-indices-learn-more/put-a-wow-index-widget-on-your-site/
Description: This plugin displays the Weiss-Order-Weighted (WOW) Index widget from http://algofutures.com
Version: 1.0.0
Author: Algo Futures
Author URI: http://algofutures.com
License: GPL2
*/

/*  Copyright (C) 2010 Emir Sakic, http://www.sakic.net. All rights reserved.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_option('width', 600);
add_option('height', 400);
add_option('market', 'sp-500-day');
add_option('link', 0);

add_filter ( 'the_content', 'wowindex_filter' );

add_action('admin_menu', 'wowindex_menu');

function wowindex_menu() {
	add_options_page('WOW Index Options', 'WOW Index', 'manage_options', 'wowindex-options', 'wowindex_options');
}

function wowindex_options() {

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>

	<div class="wrap">
	<div id="icon-options-general" class="icon32">&nbsp;</div>
	<h2>WOW Index Options</h2>
	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>
	<table class="form-table">
	<tr valign="top">
	<th scope="row"><label for="wow-width">Width</label></th>
	<td><input type="text" name="width" id="wow-width" value="<?php echo get_option('width'); ?>" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="wow-height">Height</label></th>
	<td><input type="text" name="height" id="wow-height" value="<?php echo get_option('height'); ?>" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="wow-market">Market</label></th>
	<td>
	<select name="market" id="wow-market">
		<option value="sp-500-day"<?php echo get_option('market')=='sp-500-day' ? ' selected=selected' : ''; ?>>WOW Index | e-mini S&amp;P 500 | Day Trader</option>
		<option value="sp-500-swing"<?php echo get_option('market')=='sp-500-swing' ? ' selected=selected' : ''; ?>>WOW Index | e-mini S&amp;P 500 | Swing Trader</option>
		<option value="crude-day"<?php echo get_option('market')=='crude-day' ? ' selected=selected' : ''; ?>>WOW Index | Crude | Day Trader</option>
		<option value="crude-swing"<?php echo get_option('market')=='crude-swing' ? ' selected=selected' : ''; ?>>WOW Index | Crude | Swing Trader</option>
		<option value="euro-stoxx-50-day"<?php echo get_option('market')=='euro-stoxx-50-day' ? ' selected=selected' : ''; ?>>WOW Index | Euro STOXX 50 | Day Trader</option>
		<option value="euro-stoxx-50-swing"<?php echo get_option('market')=='euro-stoxx-50-swing' ? ' selected=selected' : ''; ?>>WOW Index | Euro STOXX 50 | Swing Trader</option>
		<option value="dow-30-day"<?php echo get_option('market')=='dow-30-day' ? ' selected=selected' : ''; ?>>WOW Index | Dow 30 | Day Trader</option>
		<option value="dow-30-swing"<?php echo get_option('market')=='dow-30-swing' ? ' selected=selected' : ''; ?>>WOW Index | Dow 30 | Swing Trader</option>
	</select>
	</td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="wow-link">Display link</label></th>
	<td>
	<input type="radio" name="link" id="link0" value="0"<?php echo get_option('link')==0 ? ' checked=checked' : ''; ?>>
	<label for="link0">No</label>
	<input type="radio" name="link" id="link1" value="1"<?php echo get_option('link')==1 ? ' checked=checked' : ''; ?>>
	<label for="link1">Yes</label>
	</td>
	</tr>
	</table>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="width,height,market,link" />
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	</form>
	To display the WOW Index chart on your site place [wowindex] in a page or post
	</div>
	
<?php
}

function wowindex_filter($content) {
	$market = get_option('market');
	$width = get_option('width');
	$height = get_option('height');
	$link = get_option('link');
	$fwidth = $width + 20;
	$fheight = $height + 20;
	if ($link) {
		$fheight += 10;
	}
	$src = 'http://algofutures.com/wow-index-'.$market.'?tmpl=component&amp;width='.$width.'&amp;height='.$height;
	if (!$link) {
		$src .= '&amp;nl=1';
	}
	$iframe = '
	<iframe src="'.$src.'" width="'.$fwidth.'" height="'.$fheight.'" frameborder="0" scrolling="no">WOW Index</iframe>
	';
    $content = str_replace('[wowindex]', $iframe, $content);
    return $content;
}

?>