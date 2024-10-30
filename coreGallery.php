<?php if ( ! defined( 'ABSPATH' ) ) exit; ?><?php function modrenPhotoGallery_funct_prefix_mpg(){ ?><?php 
    global $wpdb; 
    $cat_q = "SELECT * FROM ".$wpdb->prefix."akpk_mpg_cat";
    $cat_result = $wpdb->get_results($cat_q,ARRAY_A);
?>
<div class="demo" id="filtering-demo">
<div class="button-group js-radio-button-group" id="filters">
<button class="button is-checked" data-filter="*">ALL</button>
<?php
$i=0;
$code_array = array();
foreach($cat_result as $data)
{
?><button class="button" data-filter=".<?php echo $data['code']; ?>"><?php echo $data['name']; ?></button>
<?php 
$code_array[] = $data['code']; } ?>
</div>
<div class="isotope" style="min-height: 100%; position: relative;">
<?php 
	$pic_q = "SELECT * FROM ".$wpdb->prefix."akpk_mpg";
	$pic_result = $wpdb->get_results($pic_q,ARRAY_A);

foreach($pic_result as $data_pic)
{
?>

<!-- copy start -->
<div class="grayscale element-item <?php echo $data_pic['pic_ccode']; ?>" style="left: 0px; position: absolute; top: 0px;">
<div>
<!-- change here for image url -->
<a data-lightbox="image-1" href="<?php echo esc_url($data_pic['pic_path']); ?>" ><img src="<?php echo esc_url($data_pic['pic_path']); ?>"  /></a>
</div>
<!-- <div class="side-popular" id="title-name">
<div class="popular-text" id="title-background" style="padding-left: 0px; padding-right: 0px;">
<h3 id="title-background" style="padding-left: 10px;"> -->
<!-- change here for  title -->

<!-- </h3>
</div>
</div> -->
</div>
<!-- copy end -->

<?php } ?>



</div>
</div>
<?php } ?><?php add_action('wp_enqueue_scripts','modrenPhotoGallery_funct_prefix_lightboxjs'); add_shortcode( 'Modern_Photo_Gallery_ShortCode', 'modrenPhotoGallery_funct_prefix_mpg' ); ?><?php 
function modrenPhotoGallery_funct_prefix_lightboxjs (){
} 
?>