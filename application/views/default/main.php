<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
$user=User_helper::get_user();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $CI->lang->line('WEBSITE_TITLE');?></title>
        <link rel="icon" type="image/ico" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/images/ico.ico" />

        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/jquery-ui/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/ui.multiselect.css">
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/simple-sidebar.css">
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/style.css">
        <!--  ADDING -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/animate.css">
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/timeline.css">
        <link rel='stylesheet' href='<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/google_fonts.css'>

        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/jq/jqx.base.css">
        <!-- ZEBRA_DATEPICKER -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/zebra_datepicker/default.css">

        <!-- DCMS CSS  -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/elemental-slices/engine1/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/box_best_data.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/report_menu.css" />


		<link rel="stylesheet" href="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/css/camera.css">

    </head>

<body>
    <script src="<?php echo base_url().'assets/'; ?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/bootstrap-filestyle.min.js"></script>
    <script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/ui.multiselect.js"></script>
<!--    not jquery ui multiselect-->
    <script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/sidebar.js"></script>

    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq//jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq//jqxdropdownlist.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq//jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxgrid.filter.js"></script>

    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxgrid.columnsresize.js"></script>

    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/jq/jqxdatatable.js"></script>

    <!--  zebra_datepicker -->
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/zebra_datepicker/zebra_datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/zebra_datepicker/core.js"></script>
    <!--    //for chart libray -->

                <script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/highcharts.js"></script>
                <script src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/jquery.highchartTable-min.js"></script>
    <!--    <script type="text/javascript" src="--><?php //echo base_url().'assets/'; ?>
    
<!--       PHOTO SLIDER HOME PAGE -->


    <script type='text/javascript' src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/jquery.mobile.customized.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/jquery.easing.1.3.js"></script> 
    <script type='text/javascript' src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/js/camera.min.js"></script> 
    
    <!--js/jq/jqxgrid.grouping.js"></script>-->
    <!--    DCMS JS -->
    <!--    FOR SLIDER-->
    <!--    <script type="text/javascript" src="--><?php //echo base_url().'assets/templates/'.$CI->get_template(); ?><!--/js/elemental-slices/engine1/wowslider.js"></script>-->
    <!--    <script type="text/javascript" src="--><?php //echo base_url().'assets/templates/'.$CI->get_template(); ?><!--/js/elemental-slices/engine1/script.js"></script>-->


    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
        var site_url = "<?php echo site_url(); ?>";
        var display_date_format = "yy-mm-dd";
        var SELCET_ONE_ITEM = "<?php echo $CI->lang->line('SELECT_ONE_ITEM'); ?>";
        var DELETE_CONFIRM = "<?php echo $CI->lang->line('DELETE_CONFIRM'); ?>";

    </script>
    <div class="color-line"></div>

    <div class="container-fluid">
        <div id="top_header">
            <?php
            //$CI->load_view('header');
            ?>
        </div>
        <div id="system_wrapper_top_menu" class="wrapper">

            <?php
            //$CI->load_view('top_menu');
        ?>
        </div>
        <div id="system_wrapper" class="wrapper">
            <div class="clearfix"></div>
        </div>
        
        <!--footer Start-->
        <div id="system_wrapper_footer" class="wrapper">
            <div class="clearfix"></div>
            <?php
            $CI->load_view("footer");
            ?>
        </div>


        <!--footer end-->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->

    <!-- Menu Toggle Script -->
    <div id="system_loading"><img src="<?php echo base_url().'assets/templates/'.$CI->get_template(); ?>/images/spinner.gif"></div>
    <div id="system_message"></div>
    <script type="text/javascript" src="<?php echo base_url().'assets/'; ?>js/system_common.js"></script>
    <!--    <script src="--><?php //echo base_url().'assets/templates/'.$CI->get_template(); ?><!--/js/time_show.js"></script>-->

</body>

</html>
