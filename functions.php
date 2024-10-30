<?php if ( ! defined( 'ABSPATH' ) ) exit; require_once(ABSPATH .'wp-includes/pluggable.php'); ?><?php 
function modrenPhotoGallery_funct_prefix_show_gallery_categories(){
	global $wpdb;
	$query = "SELECT * FROM  ".$wpdb->prefix."akpk_mpg_cat";
	$result = $wpdb->get_results($query,ARRAY_A);
	foreach ($result as $key => $value) {
	?><option value="<?php echo $value['code']; ?>"><?php echo $value['name']; ?></option><?php
	}
}

if(isset($_POST['akpk_action']) AND $_POST['akpk_action'] == 'akpk_del_pic' AND isset( $_POST['akpk_del_pic_check_field'] )  AND check_admin_referer( 'akpk_del_pic_check_action', 'akpk_del_pic_check_field' )){
	//$x = check_admin_referer();
	//echo $x;
	$id = sanitize_text_field($_POST['akpk_id']);
	$q = "DELETE FROM ".$wpdb->prefix."akpk_mpg WHERE id = %d";
	$pic_path = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."akpk_mpg");
	$upload_dir = wp_upload_dir();
	$file_to_delete = $upload_dir['basedir'].''.$pic_path->pic_path;
	if(file_exists($file_to_delete)){
		//unlink($file_to_delete);
	}
	$wpdb->query($wpdb->prepare($q,array($id)));
	
}
if(isset($_POST['akpk_action']) AND $_POST['akpk_action'] == 'add_cat' AND isset( $_POST['akpk_add_pic_cat_check_field'] )  AND check_admin_referer( 'akpk_add_pic_cat_check_action', 'akpk_add_pic_cat_check_field' )){
	$query = "SELECT MAX(code) as new_cat_code FROM  ".$wpdb->prefix."akpk_mpg_cat";
	$result = $wpdb->get_row($query);
	$ccode = $result->new_cat_code+1;
	//echo "<h1 align='center'>".$ccode."</h1>";
	$cname = sanitize_text_field($_POST['akpk_cname']);
	$wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."akpk_mpg_cat (name,code) VALUES(%s,%d) ",array($cname,$ccode)));	
	echo '<script>alert("Added");</script>';
}


if(isset($_POST['akpk_action']) AND $_POST['akpk_action'] == 'akpk_del_cat' AND isset( $_POST['akpk_del_pic_cat_check_field'] ) AND check_admin_referer( 'akpk_del_pic_cat_check_action', 'akpk_del_pic_cat_check_field' )){

	$id = sanitize_text_field($_POST['akpk_id']);
	$q = "DELETE FROM ".$wpdb->prefix."akpk_mpg_cat WHERE id = %d";
	$wpdb->query($wpdb->prepare($q,array($id)));
}


if(isset($_POST['akpk_action']) AND $_POST['akpk_action'] == 'akpk_add_photo' AND isset( $_POST['akpk_add_pic_check_field'] ) AND check_admin_referer('akpk_add_pic_check_action','akpk_add_pic_check_field')){
	global $pic_msg;$pic_msg = '';global $wpdb;
	if (isset($_POST['akpk_gpic_link']) AND $_POST['akpk_gpic_link'] !="" AND isset($_POST['akpk_pic_ccode']) AND is_numeric($_POST['akpk_pic_ccode'])) {
		$upload_dir = wp_upload_dir();
		$q = "INSERT INTO ".$wpdb->prefix."akpk_mpg(pic_path,gitem_code,pic_ccode) VALUES(%s,%d,%d)";
		$wpdb->query($wpdb->prepare($q,array(sanitize_text_field($_POST['akpk_gpic_link']),0,sanitize_text_field($_POST['akpk_pic_ccode']))));
		$pic_msg = "<div align='center' class='btn btn-success' onclick='jQuery(this).hide();' style='width:98%;margin-top: 2px;'>Saved</div>";
	}

}

function modrenPhotoGallery_funct_prefix_my_custom_css_js()
{
  wp_enqueue_script( 'modrenPhotoGallery_funct_prefix_my-js-isotope', plugins_url('/assets/js/isotope.pkgd.min.js', __FILE__ ), array('jquery'),'2.2.2');
  wp_enqueue_style( 'modrenPhotoGallery_funct_prefix_my-custom-core', plugins_url('/assets/lightbox/css/lightbox.css' ,__FILE__ ), false, '2.8.2' );
  wp_enqueue_style( 'modrenPhotoGallery_funct_prefix_my-custom-core-style', plugins_url('/assets/css/custom.css' ,__FILE__ ), false, '2.8.2' );
  wp_enqueue_script( 'modrenPhotoGallery_funct_prefix_my-js-lightbox',plugins_url('/assets/lightbox/js/lightbox.min.js',__FILE__), false ,'2.8.2',true);
}


function modrenPhotoGallery_funct_prefix_RegisterAdminMenu() {
	add_menu_page( 'Modern Photo Gallery', 'Photo Gallery', 'manage_options', 'akpk_m-p-g', 'modrenPhotoGallery_funct_prefix_ModrenGalleryContent', plugins_url( '/assets/icon.png',__FILE__ ), 7);
}
?>