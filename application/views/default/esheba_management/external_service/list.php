<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user = User_helper::get_user();

?>
<div id="system_content" class="system_content_margin">
    <div class="col-sm-12" style="margin: 20px 0">
        <?php
        if (sizeof($services) > 0) {
            ?>
            <ul id="service_list">
                <?php
                foreach ($services as $service) {
                    ?>
                    <a class="external" target="_blank"
                       href="<?php echo site_url('esheba_management/Auth_token/index/' . $service['id']); ?>">
                        <li>
                            <img id="service_img"
                                 src="<?= base_url() . 'images/service_logo/' . $service['service_logo'] ?>" alt="logo"
                                 width="50" height="50"> <?php echo $service['name']; ?>

                        </li>
                    </a>
                    <?php
                }
                ?>
            </ul>
            <?php

        } else {
            echo $CI->lang->line('NO_SERVICE_AVAILABLE');
        }
        ?>
    </div>
</div>

<style>
    #service_img {
        float: left;
        margin-right: 10px
    }

    #service_list li {
        float: left;
        padding: 10px;
        background: #0a86a3;
        border-radius: 5px;
        width: 230px;
        margin: 20px
    }
</style>