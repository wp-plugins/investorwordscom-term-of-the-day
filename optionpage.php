<?php
        load_plugin_textdomain('iw_tod', 'wp-content/plugins/investorword-term-of-the-day');
        include_once('iw-tod.php');
        wp_nonce_field('update-options') ;

        if ('process' == $_POST['stage']) {
                 update_option('iw_tod_words_count', $_POST['tod_words_count']);
                 update_option('iw_tod_style', $_POST['tod_style']);
                 update_option('iw_tod_heading', $_POST['tod_heading']);

        }

        /* Get options for form fields */
        $tod_words_count = get_option('iw_tod_words_count');
        $tod_style = get_option('iw_tod_style');
	$tod_heading = get_option('iw_tod_heading');


?>

<div class="wrap">
  <h2>InvestorWords.com Investing Term of the Day</h2>
  <form name="form" method="post" >

    <input type="hidden" name="stage" value="process" />

    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Options') ?> &raquo;" />
    </p>

    <strong>Number of words in definition (optional)</strong><br />
    <input type="text" name="tod_words_count" value="<?php echo $tod_words_count; ?>" size="60" />

    <p><strong>Section heading (optional)</strong></p>
    <input type="text" name="tod_heading" value="<?php echo $tod_heading; ?>" size="60" />

    <p><strong>Stylize output (optional)</strong></p>
    <p>Use CSS to define .tod, .todterm, and .toddefinition </p>
    <textarea id="tod_style" name="tod_style" rows="10" cols="54"><?php echo $tod_style; ?></textarea>
	
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Options') ?> &raquo;" />
    </p>
  </form>

</div>
