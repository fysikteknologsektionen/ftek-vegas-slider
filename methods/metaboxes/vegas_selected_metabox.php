<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
        global $post;
        $enabled = get_post_meta( get_the_ID(), 'vegas-enabled', true );
 ?>
<form name="post" method="post">
        <input type="checkbox" name="vegas_selected_checkbox" id="vegas_selected_checkbox" <?= $enabled?'checked':'' ?> />
        <label for="vegas_selected_checkbox">Select as default</label>
</form>