<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
        global $post;
        $enabled = get_post_meta( get_the_ID(), 'vegas-enabled', true );
        $events_enabled = get_post_meta( get_the_ID(), 'vegas-events-enabled', true );
 ?>
<form name="post" method="post">
        <input type="checkbox" name="vegas_selected_checkbox" id="vegas_selected_checkbox" <?= $enabled?'checked':'' ?> />
        <label for="vegas_selected_checkbox">Select as default</label>
        <input type="checkbox" name="vegas_events_checkbox" id="vegas_events_checkbox" <?= $events_enabled?'checked':'' ?> />
        <label for="vegas_events_checkbox">Include event images</label>
</form>
