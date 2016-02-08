<?php
/**
 * Created by Rana ranabd36@gmail.com.
 * Date: 28-01-16
 * Time: 03.22
 */

?>


<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link = "http://" . $_SERVER['HTTP_HOST'] . str_replace("/list", "/pdf", $_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($report);
//echo "</pre>";
//die();
?>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/templates/default/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="main_container">
        <div class="row show-grid hidden-print">
            <a class="btn btn-primary btn-rect pull-right"
               href="<?php echo $pdf_link; ?>"><?php echo $this->lang->line("BUTTON_PDF"); ?></a>
            <a class="btn btn-primary btn-rect pull-right" style="margin-right: 10px;"
               href="javascript:window.print();"><?php echo $this->lang->line("BUTTON_PRINT"); ?></a>
            <div class="clearfix"></div>
            <span class="pull-right"><?php echo $this->lang->line('REPORT_CURRENT_DATE_VIEW'); ?></span>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-12 text-center">
                <h4><?php echo $this->lang->line('REPORT_HEADER_TITLE'); ?></h4>
                <h5><?php echo $title; ?></h5>
            </div>


            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('DIVISION_NAME'); ?></th>
                    <th><?php echo $this->lang->line('ZILLA_NAME'); ?></th>
                    <th><?php echo $this->lang->line('UPAZILLA_NAME'); ?></th>
                    <th><?php echo $this->lang->line('UNION_NAME'); ?></th>
                    <th><?php echo $this->lang->line('UISC_NAME'); ?></th>
                    <th><?php echo $this->lang->line('USER_NAME'); ?></th>
                    <th><?php echo $this->lang->line('ENTREPRENEUR_NAME'); ?></th>
                    <th><?php echo $this->lang->line('FATHERS_NAME'); ?></th>
                    <th><?php echo $this->lang->line('PHOTO'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (empty($user_info)) {
                    ?>
                    <tr>
                        <td colspan="21"
                            style="color: red; text-align: center;"><?php echo $this->lang->line('DATA_NOT_FOUND'); ?></td>
                    </tr>
                    <?php
                } else {
                    $division = "";
                    $zilla = "";
                    $upazila = "";
                    $union = "";
                    $i = 0;
                    $z=0;
                    $d=0;
                    foreach ($user_info as $item) {

                        if ($item['upazila'] != $upazila && $i > 0) {
                            ?>
                            <tr style="background: #E38585">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?= $this->lang->line('UPAZILLA').' '.$this->lang->line('TOTAL_ENTREPRENEUR') ?></td>
                                <td><?= $i; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php
                            $i = 0;
                        }
                        if ($item['zilla'] != $zilla && $z > 0) {
                            ?>
                            <tr style="background: #8CCA33">
                                <td>&nbsp;</td>
                                <td><?= $this->lang->line('ZILLA').' '.$this->lang->line('TOTAL_ENTREPRENEUR') ?></td>
                                <td><?= $z; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php
                            $z = 0;
                        }
                        if ($item['division'] != $division && $d > 0) {
                            ?>
                            <tr style="background: #AAAAFF">
                                <td><?= $this->lang->line('DIVISION').' '.$this->lang->line('TOTAL_ENTREPRENEUR') ?></td>
                                <td><?= $d; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php
                            $d = 0;
                        }
                        ?>
                        <tr>
                            <td><?= ($item['division'] != $division) ? $item['division'] : "" ?></td>
                            <td><?= ($item['zilla'] != $zilla) ? $item['zilla'] : "" ?></td>
                            <td><?= ($item['upazila'] != $upazila) ? $item['upazila'] : "" ?></td>
                            <td><?= ($item['unioun'] != $union) ? $item['unioun'] : "" ?></td>
                            <td><?= $item['uisc_name'] ?></td>
                            <td><?= $item['username'] ?></td>
                            <td><?= $item['entrepreneur_name'] ?></td>
                            <td><?= $item['entrepreneur_father_name'] ?></td>
                            <td><?php if (!empty($item['picture_name'])) { ?><img width="60" height="60"
                                                                                  src="<?= base_url() . 'images/entrepreneur/' . $item['picture_name'] ?>"
                                                                                  alt=""><?php } else {
                                    echo "";
                                } ?>
                            </td>
                        </tr>
                        <?php
                        $division = $item['division'];
                        $zilla = $item['zilla'];
                        $upazila = $item['upazila'];
                        $union = $item['unioun'];
                        $i++;
                        $z++;
                        $d++;

                    } ?>
                    <tr style="background: #E38585">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><?= $this->lang->line('UPAZILLA').' '.$this->lang->line('TOTAL_ENTREPRENEUR') ?></td>
                        <td><?= $i; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr style="background: #8CCA33">
                        <td>&nbsp;</td>
                        <td><?= $this->lang->line('ZILLA').' '.$this->lang->line('TOTAL_ENTREPRENEUR') ?></td>
                        <td><?= $z; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr style="background: #AAAAFF">
                        <td><?= $this->lang->line('DIVISION').' '.$this->lang->line('TOTAL_ENTREPRENEUR') ?></td>
                        <td><?= $d; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>


                    <?php

                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
