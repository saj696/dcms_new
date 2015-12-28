<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
?>
<div id="system_action_button_container" class="system_action_button_container">
    <?php
    //$CI->load_view('system_action_buttons');

    ?>
</div>
<link rel="stylesheet"  href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/light-gallery/css/lightGallery.css"/>
<script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/light-gallery/js/lightGallery.js"></script>
<style>
    body {
        background: #e9e9e9;
        font-family: 'Roboto', sans-serif;
        text-align: center;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    	ul{
			list-style: none outside none;
		    padding-left: 0;
		}
		.gallery li {
			display: block;
			float: left;
			height: 100px;
			margin-bottom: 6px;
			margin-right: 6px;
			width: 100px;
		}
		.gallery li a {
			height: 100px;
			width: 100px;
		}
		.gallery li a img {
			max-width: 100px;
            border: 5px solid #cccccc;
            height: 80px;
		}
		.gallery-print-media li
        {
			display: block;
			float: left;
			height: 55px;
			margin-bottom: 6px;
			margin-right: 6px;
            width: 32%;
            text-align: left;

            background: #fff0cc none repeat scroll 0 0;
            border: 1px solid #ffda80;
            border-radius: 3px;
            color: #996c00;

            padding: 8px 35px 8px 14px;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.2);
		}
		.gallery-print-media li a:hover
        {
			color: green;
		}
		.gallery-print-media li a img {
			max-width: 20px;
		}

</style>
    
    <script type="text/javascript">
  $(document).ready(function() {
    $('#light-gallery').lightGallery({
        showThumbByDefault:true,
        addClass:'showThumbByDefault'
    }); 
  });
  
  
  $(document).ready(function()
  {
    $("#video").lightGallery(); 
  });
</script>

<div class="clearfix"></div>

<div id="system_content" class="dashboard-wrapper" style="height: 1200px !important;">
    <div class="col-lg-12">
    <div class="panel with-nav-tabs ">
        <div class="panel-heading" style="padding-bottom: 0px !important;">
            <ul class="nav nav-tabs" style="margin-bottom: 0px !important;">
                <li class="active"><a class="external" href="#video_corner" data-toggle="tab" style="color: #000"><h3><?php echo $this->lang->line('MEDIA_VIDEO_CORNER');?></h3></a></li>
            </ul>
        </div>
        <div class="panel-body " style="padding-top: 0px !important;">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="video_corner">
                    <div class="well col-lg-12">
                        <ul id="video" class="gallery">
                            <?php
                            $dir_config = $CI->config->item('dcms_upload');
                            $directory = $dir_config['media_photo'];
                            if(is_array($videos) && sizeof($videos)>0)
                            {
                                foreach($videos as $video)
                                {
                            ?>
                                <li data-src="<?php echo $video['video_link'];?>">
                                    <a href="#" target="_blank">
                                        <img src="<?php echo base_url().'/'.$directory.'/'. $video['file_name'];?>" />
                                    </a>
                                </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clear"></div>
<div style="line-height:15px;">&nbsp;</div>
</div>
