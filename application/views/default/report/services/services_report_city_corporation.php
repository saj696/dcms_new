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
        <div class="col-lg-12" style="margin-top: 40px">
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td colspan="6" class="text-center">
                        <h4><?php echo $title; ?></h4>
                        <h5><?php echo $this->config->item('month')[$month] . '-' . System_helper::Get_Eng_to_Bng($year); ?></h5>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('DIVISION_NAME'); ?></th>
                    <th><?php echo $this->lang->line('ZILLA_NAME'); ?></th>
                    <th><?php echo $this->lang->line('CITY_CORPORATION'); ?></th>
                    <th><?php echo $this->lang->line('SERVICE_NAME'); ?></th>
                    <th><?php echo $this->lang->line('TOTAL_SERVICE_HOLDER'); ?></th>
                    <th><?php echo $this->lang->line('INCOME'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (empty($reports)) {
                    ?>
                    <tr>
                        <td colspan="21"
                            style="color: red; text-align: center;"><?php echo $this->lang->line('DATA_NOT_FOUND'); ?></td>
                    </tr>
                    <?php
                } else {
                    $division_name = '';
                    $zilla_name = '';
                    $service_name = '';


                    $total_service = 0;
                    $total_income = 0;

                    foreach ($reports as $report) { ?>
                        <tr>
                            <td><?= ($report['divname'] != $division_name) ? $report['divname'] : "" ?></td>
                            <td><?= ($report['zillaname'] != $zilla_name) ? $report['zillaname'] : "" ?></td>
                            <td><?= (!empty($report['citycorporationname'])) ? $report['citycorporationname'] : "" ?></td>
                            <td><?= ($report['service_name'] != $service_name) ? System_helper::Get_Eng_to_Bng($report['service_name']) : "" ?></td>
                            <td><?= (!empty($report['total_service'])) ? System_helper::Get_Eng_to_Bng($report['total_service']) : "০" ?></td>
                            <td><?= (!empty($report['total_income'])) ? System_helper::Get_Eng_to_Bng($report['total_income']) : "০" ?></td>
                        </tr>
                        <?php

                        $division_name = $report['divname'];
                        $zilla_name = $report['zillaname'];
                        $service_name = $report['service_name'];

                        $total_service += $report['total_service'];
                        $total_income += $report['total_income'];
                    }
                    ?>

                    <tr style="background: #EEEEEE">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><?php echo $this->lang->line('IN_TOTAL'); ?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_service); ?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_income); ?></td>
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