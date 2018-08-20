<?php
if ( ! defined( 'ABSPATH' ) ) exit;

    $id = '';
    $posts = get_posts([
        'post_type' => 'vegas',
        'post_status' => 'publish',
        'numberposts' => -1,
    ]);
    foreach ($posts as $p) {
        if ( get_post_meta( $p->ID, 'vegas-enabled', true ) ) {
            $id = $p->ID;
        }
    }
    $atts = shortcode_atts(array(
        'id' => $id,
        'fade' => '2000',
        'overlay' => '',
        'arrows' => 'yes',
        'poster' => 'yes',
        'delay' => '4000',
        'autoplay' => 'yes',
        'random' => ''),
    $atts);
    $images = get_post_meta( $atts['id'], 'imgIDs', true );
    //Variables
    $fade = $atts['fade'];
    $delay = $atts['delay'];
    $overlay = $atts['overlay'];
    $autoplay = $atts['autoplay'];
    $poster = $atts['poster'];
    $arrows = $atts['arrows']; 

    //Randomize
    if($atts['random'] == 'yes'){

    $array=explode(",",$images);  
    shuffle($array);  
    $images = implode($array,",");  
        
    }

    $image = explode(",", $images);
    $imagenum = count($image);
    $replacement = '';

    if($imagenum > 1 && $arrows == "yes"){
    $replacement .= <<<HEREDOC
<nav id="nav-arrows" class="nav-arrows">
		<span id="nav-arrow-prev">Previous</span>
		<span id="nav-arrow-next">Next</span>
	</nav>

HEREDOC;

    $replacement .= <<<HEREDOC
	<script> 
		jQuery( '#nav-arrow-prev' ).click( function() { jQuery('body').vegas('previous'); }); 
		jQuery( '#nav-arrow-next' ).click( function() { jQuery('body').vegas('next'); });
	</script>
HEREDOC;
    }

    $replacement .= <<<HEREDOC

<script>
    jQuery( function() {
    jQuery('body').vegas({
    delay:$delay,
    transition: $fade,
    slides:[
HEREDOC;

    for($i = 0;$i < $imagenum;$i++){
        $image_metadata = wp_get_attachment_metadata($image[$i]);
        if ( explode('/', $image_metadata['mime_type'])[0] == 'video' ) {
            $image_attributes = wp_get_attachment_image_src( $image[0], "full" ); // Get first image as fallback
            $video_attributes = wp_get_attachment_url( $image[$i] );
            $replacement .= "{ src:'" . $image_attributes[0] . "', delay: ".(wp_get_attachment_metadata($image[$i])['length']*1000).",  video: {src:['".$video_attributes."'], loop:false, mute:true}}";
        } else {
            $image_attributes = wp_get_attachment_image_src( $image[$i], "full" );
            $replacement .= "{ src:'" . $image_attributes[0] . "'},";
        }
    }
    $replacement .= <<<HEREDOC
] 
}) 
HEREDOC;
//NOTE If there is no overlay, don't print the 'overlay' option with an empty source into the javascript. It gives you a 404 for the overlay image.
    if( $overlay ){ $replacement .= <<<HEREDOC
    ('overlay', {src:'$overlay'}) 
HEREDOC;
    }
    $replacement .= <<<HEREDOC
}); 
</script>

HEREDOC;
  
    if($autoplay == "no"){
          $replacement .= "<script>jQuery( function() {jQuery('body').vegas('pause'); });</script>";
      }

    if($poster == "yes" && $autoplay == "yes"){
	  $vegastimeout = $delay * $imagenum;
	  $replacement .= "<script>jQuery(document).ready(function(){ setTimeout(function(){ jQuery( function(){ jQuery('body').vegas('pause'); } )},  $vegastimeout ); });</script>";
    }
