<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
?>
<div id="system_action_button_container" class="system_action_button_container">
    <?php
    //$CI->load_view('system_action_buttons');

    ?>
</div>
<link rel="stylesheet"
      href="<?php echo base_url().'assets/templates/'.$CI->get_template();  ?>/light-gallery/css/lightGallery.css"/>
<script
    src="<?php echo base_url().'assets/templates/'.$CI->get_template();  ?>/light-gallery/js/lightGallery.js"></script>
<style>
    body {
        background: #e9e9e9;
        font-family: 'Roboto', sans-serif;
        text-align: center;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    ul {
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

    .gallery-print-media li {
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

    .gallery-print-media li a:hover {
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
                    <li class="active"><a class="external" href="#print_media" data-toggle="tab" style="color: #000">
                            <h3><?php echo $this->lang->line('MEDIA_PRINT_CORNER'); ?></h3></a></li>
                </ul>
            </div>
            <div class="panel-body " style="padding-top: 0px !important;">
                <div class="tab-content">

                    <div class="tab-pane fade in active" id="print_media">
                        <div class="col-sm-offset-3 col-sm-3">
                            <input class="form-control" type="text" name="title" id="title"
                                   placeholder="<?= $CI->lang->line('MEDIA_TITLE') ?>">
                        </div>
                        <div class="col-sm-3 text-left">
                            <button type="button"
                                    class="btn btn-primary search_title"><?= $CI->lang->line('SEARCH') ?></button>
                            <a class="btn btn-warning" href="<?php echo $CI->get_encoded_url('media/media_corner_print/index/edit');?>"><?= $CI->lang->line('RESET') ?></a>
                        </div>

                        <?php
                        if (empty($arranged_array)) { ?>
                            <div class="well col-lg-12">
                                <?= $CI->lang->line('DATA_NOT_FOUND') ?>
                            </div>
                            <?php
                        } else {
                            foreach ($arranged_array as $year => $print_array) {
                                ?>
                                <div class="well col-lg-12">
                                    <h4>
                                        == <u>
                                            <?php echo $year; ?>
                                        </u> ==
                                    </h4>
                                    <hr/>
                                    <ul id="print_media" class="gallery-print-media">
                                        <?php
                                        $dir_config = $CI->config->item('dcms_upload');
                                        $directory = $dir_config['media_print'];

                                        foreach ($print_array as $print_info) {
                                            ?>
                                            <li class="list_class">
                                                <?php
                                                if (strlen($print_info['external_link']) > 1) {
                                                    ?>

                                                    <div class="media_title" style="cursor: pointer;"><?php echo $print_info['media_title']; ?></div>
                                                    <div class="row show-grid popContainer" id="show_data" style="display: none; overflow-y: auto;">
                                                        <span class="crossSpan">
                                                            <img src="<?php echo base_url()
                                                            ?>images/xmark.png" style="cursor: pointer;" width="26px"
                                                                 height="26px"/>
                                                        </span>
                                                        <div id="modal_data">
                                                            <iframe
                                                                src="https://drive.google.com/viewer?srcid=<?php echo $print_info['external_link']
                                                                ?>&pid=explorer&efh=false&a=v&chrome=false&embedded=true"
                                                                width="1020px" height="400px"></iframe>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } elseif (strlen($print_info['file_name']) > 1) {
                                                    ?>
                                                    <!--                                                    <a class="external" target="_blank"-->
                                                    <!--                                                       href="--><?php //echo base_url() . $directory . '/' . $print_info['file_name']; ?><!--">-->
                                                    <!--                                                        <img src="--><?php //echo base_url() ?><!--images/download-icon.png"-->
                                                    <!--                                                             style="width: 20px;"/>-->
                                                    <!--                                                        --><?php //echo $print_info['media_title']; ?>
                                                    <!--                                                    </a>-->
                                                    <div class="media_title" style="cursor: pointer;"><?php echo $print_info['media_title']; ?></div>
                                                    <div class="row show-grid popContainer" id="show_data" style="display: none; overflow-y: auto;">
                                                        <span class="crossSpan">
                                                            <img src="<?php echo base_url()
                                                            ?>images/xmark.png" style="cursor: pointer;" width="26px"
                                                                 height="26px"/>
                                                        </span>
                                                        <div id="modal_data">
                                                            <iframe
                                                                src="https://drive.google.com/viewer?srcid=<?php echo  urlencode(base_url() . $directory . '/' . $print_info['file_name']); ?>&pid=explorer&efh=false&a=v&chrome=false&embedded=true"
                                                                width="1020px" height="400px"></iframe>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <div style="line-height:15px;">&nbsp;</div>
</div>

<script>
    $(document).ready(function () {
        turn_off_triggers();
        $(document).on("click", ".crossSpan", function () {
            $(".popContainer").hide();
            $("#bgBlack").hide();
        });

        $(document).on("click", ".media_title", function () {
            $(this).closest(".list_class").find(".popContainer").show();
        });

        $(document).on('click', '.search_title', function () {
            var title = $('#title').val();

            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: '<?php echo $CI->get_encoded_url('media/media_corner_print/get_result');?>',
                data: {title: title},
                success: function (data, status) {

                },
                error: function (xhr, desc, err) {
                    console.log("error");
                }

            })
        });
    });
</script>