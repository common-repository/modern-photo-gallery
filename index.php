<?php 
/*
Plugin Name: Modern Photo Gallery
Plugin URI: http://theprogrammings.com
Description: This Plugin Allow You To Create Category Based Photo gallery
Version: 1.0
Author: Ahmed Haseeb
Author URI: http://facebook.com/akpk127.0.0.1
*/

/*
This plugin is Using Lightbox v2
License
Lightbox2 is licensed under The MIT License.
100% Free. Lightbox is free to use in both commercial and non-commercial work.
Attribution is required.This means you must leave my name, my homepage link, and the license info intact. None of these items have to be user-facing and can remain within the code.
Link To Lightbox
http://lokeshdhakar.com/projects/lightbox2/#license
*/
?><?php if ( ! defined( 'ABSPATH' ) ) exit;include_once('functions.php');include_once('coreGallery.php');
function modrenPhotoGallery_funct_prefix_install_plugin()
{
  global $wpdb;
  $create_table1 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."akpk_mpg (id INT(255) AUTO_INCREMENT NOT NULL,
    pic_path VARCHAR(255) ,
    pic_title VARCHAR(255),
    gitem_code int(255),
    pic_ccode int(255),
    f1 VARCHAR(200),
    f2 VARCHAR(200),
    PRIMARY KEY (id)
    );";
  $t1 = $wpdb->query($create_table1);
  $create_table2 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."akpk_mpg_setting (id INT(255) AUTO_INCREMENT NOT NULL,
    option_name VARCHAR(255),
    option_value VARCHAR(255),
    option_type VARCHAR(255),
    PRIMARY KEY (id)
  );";
  $t2 = $wpdb->query($create_table2);
  $d1 = $wpdb->query($wpdb->prepare("
  INSERT INTO ".$wpdb->prefix."akpk_mpg_setting (option_name,option_value,option_type) VALUES(%s,%s,%s)
  ",array('db_ok','1','general_setting')));
  $create_table3 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."akpk_mpg_cat (id INT(255) AUTO_INCREMENT NOT NULL,
    name VARCHAR(255),
    code int(255),
    PRIMARY KEY (id)
  );";
  $t3 = $wpdb->query($create_table3);
}
//Check if plugin is installed or not.
function modrenPhotoGallery_funct_prefix_check_install_on_activate() {
  global $wpdb;
  $check_db = "SELECT * From ".$wpdb->prefix."akpk_mpg_setting where option_name='db_ok' AND option_value='1'";
  $installed = $wpdb->query($check_db);
  if($installed===false){modrenPhotoGallery_funct_prefix_install_plugin();}
}
register_activation_hook( __FILE__, 'modrenPhotoGallery_funct_prefix_check_install_on_activate' );
function modrenPhotoGallery_funct_prefix_ModrenGalleryContent(){ 
if (is_admin ()){
  wp_enqueue_media ();
}
?>
<style type="text/css">
    .media-frame-menu{
      display: none;
    }
    .media-frame-title,.media-frame-router,.media-frame-content,.media-frame-toolbar{
      left: 0 !important;
    }
    .border-bottom{
      border-bottom: 2px solid #000;
    }
    
  </style><?php
  global $pic_msg;
if($pic_msg){
echo $pic_msg;
} 
echo'<div class="main-mpg-container container-fluid">';
global $wpdb;
?>
<style>
.table{width: 80%;}
.main-body-public{
  font-family: calibri;
}
.main-body-public a{
  text-decoration: none;
}
</style>
<section class="main-body-public">
<div class="container">

  <div align="center" style="min-height:auto;">
  <h1 align='center'>Short Code</h1>
  <p class="lead" style="color:red;">[Modern_Photo_Gallery_ShortCode]</p>
  <p>Use this short code to display photo gallery any where in the post or in any page</p>
    <center style="background-color:#333;width:300px;padding:5px;";>
      <h4><a href="<?php print esc_url(wp_nonce_url(admin_url('admin.php?page=akpk_m-p-g&pic_cat=1'))); ?>">Add Photo Categories</a></h4>
      <h4><a href="<?php print esc_url(wp_nonce_url(admin_url('admin.php?page=akpk_m-p-g&pic_cat=0'))); ?>">Delete Photo Categories</a></h4>
      <h4><a href="<?php print esc_url(wp_nonce_url(admin_url('admin.php?page=akpk_m-p-g&pg=1'))); ?>">Add Photos To Gallery</a></h4>
      <h4><a href="<?php print esc_url(wp_nonce_url(admin_url('admin.php?page=akpk_m-p-g&pg=0'))); ?>">Delete Photos From Gallery</a></h4>
    </center>
  </div>
<br>

<!--  Adding Photo To gallery -->
<?php if(isset($_GET['pg']) AND $_GET['pg'] == "1") { ?><div class="container-fluid" align="center">
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4">
      <form method="post" action="">
        <?php wp_nonce_field( 'akpk_add_pic_check_action', 'akpk_add_pic_check_field' ); ?>
        <label class="label-primary" for="_unique_name_button">Upload gallery Pic</label>
        <br><small>Please Enter Image Url Or Choose</small>
        <div class="uploader">
          <input id="_unique_name" name="akpk_gpic_link" type="text" readonly required/>
          <input id="_unique_name_button" class="button" name="_unique_name_button" type="button" value="Choose" />
        </div>
        <br>
        <select name="akpk_pic_ccode" class="form-control" required><option value="">Select Category</option><?php modrenPhotoGallery_funct_prefix_show_gallery_categories(); ?></select><br><br>
        <input class="btn btn-primary" type="submit" value="Save Item"/>
        <input type="hidden" name="akpk_action" value="akpk_add_photo">
        <br>
      </form>
<script>
  jQuery(document).ready(function($){
  var _custom_media = true;
  _orig_send_attachment = wp.media.editor.send.attachment;

  $('.button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url);
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });

  $('.add_media').on('click', function(){
    _custom_media = false;
  });
});
</script>
    </div>
  </div>

</div><?php } ?>
<!-- Adding Photo Category -->
<?php if(isset($_GET['pic_cat']) AND $_GET['pic_cat'] =="1") { ?><div class="col-sm-4 col-sm-offset-4" align="center">
    <form method="post" action="">
      <?php wp_nonce_field( 'akpk_add_pic_cat_check_action', 'akpk_add_pic_cat_check_field' ); ?>
      <br>
      <input class="form-control" type="text" required name="akpk_cname" placeholder="Enter Category name"/>
      <br>
      <input class="btn btn-primary" type="submit" value="Save Picture Category"/>
      <input type="hidden" name="akpk_action" value="add_cat">
      <br>
    </form>
</div><?php } ?>
<!-- Deleting Photo Category -->
<?php if(isset($_GET['pic_cat']) AND $_GET['pic_cat'] == "0") { ?><table class="table table-hover table-responsive" border="3">
<tr><th class="border-bottom"><big>Sr#</big></th><th class="border-bottom"><big>Category Name</big></th> <th class="border-bottom"><big>Edit</big></th> </tr><?php
$count = 0;
$query = "SELECT * FROM ".$wpdb->prefix."akpk_mpg_cat";
$result = $wpdb->get_results($query,ARRAY_A);
foreach ($result as $data)
{
	$count = $count +1;
?>
<form method="post" action="">
<tr>
<?php wp_nonce_field( 'akpk_del_pic_cat_check_action', 'akpk_del_pic_cat_check_field' ); ?>
<td><?php echo $count; ?> </td>
<td><?php echo $data['name']; ?></td>
<td>
  <input class="btn btn-danger" name="akpk_dcat" type="submit" value="Delete" /> 
  <input type="hidden" value="<?php echo $data['id']; ?>" name="akpk_id"/>
  <input type="hidden" name="akpk_action" value="akpk_del_cat">
</td>
</tr>
</form>
<?php
}
?></table><?php } 
?><!--  Deleting picture from gallery --><?php if(isset($_GET['pg']) AND $_GET['pg'] == "0") { ?><table class="table table-hover table-responsive" border="3">
<tr><th class="border-bottom"><big>Sr#</big></th><th class="border-bottom"><big>Picture</big></th> <th class="border-bottom"><big>Picture Category</big></th> <th class="border-bottom"><big>Edit</big></th> </tr><?php
$count = 0;
//$upload_dir = wp_upload_dir();
$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akpk_mpg",ARRAY_A);
foreach($result as $data)
{
  $cat_query = "SELECT * FROM ".$wpdb->prefix."akpk_mpg_cat where code=".$data['pic_ccode'];
  $cdata = $wpdb->get_row($cat_query);
  $count = $count +1;
?>
<form method="post" action="">
<?php wp_nonce_field( 'akpk_del_pic_check_action', 'akpk_del_pic_check_field' ); ?> 
<tr>
<td><?php echo $count; ?></td>
<td><?php echo '<img src="'.$data['pic_path'].'" height="70" width="70"/>';  ?></td>
<td><h4><?php echo @$cdata->name; ?></h4></td>
<td>
  <input class="btn btn-danger" name="akpk_dpic" type="submit" value="Delete" />
  <input type="hidden" value="<?php echo $data['id']; ?>" name="akpk_id"/>
  <input type="hidden" name="akpk_action" value="akpk_del_pic">
</td>
</tr>
</form><?php
}
?></table><?php } ?></div>
</section>
</div><?php
} 
function modrenPhotoGallery_funct_prefix_my_admin_custom_css_js(){
  wp_register_style( 'admin-stylesheet-mpg', plugins_url( '/assets/bootstrap/css/bootstrap.min.css',__FILE__ ) );
  wp_enqueue_style( 'admin-stylesheet-mpg' );
//admin_print_styles(plugins_url('/assets/js/isotope.pkgd.min.js', __FILE__ ));
}
add_action( 'admin_menu', 'modrenPhotoGallery_funct_prefix_RegisterAdminMenu' );
add_action( 'admin_enqueue_scripts', 'modrenPhotoGallery_funct_prefix_my_admin_custom_css_js');
add_action( 'wp_enqueue_scripts', 'modrenPhotoGallery_funct_prefix_my_custom_css_js');
?>