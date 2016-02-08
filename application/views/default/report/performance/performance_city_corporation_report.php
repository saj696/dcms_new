<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link = "http://" . $_SERVER['HTTP_HOST'] . str_replace("/list", "/pdf", $_SERVER['REQUEST_URI']);
$numDays = 0;
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
                    <th colspan="7" class="text-center">
                        <?= $title; ?><br>
                        <?= $this->config->item('month')[$month] . '-' . System_helper::Get_Eng_to_Bng($year) ?>
                    </th>
                </tr>

                <tr>
                    <th><?= $this->lang->line('SL_NO') ?></th>
                    <th><?= $this->lang->line('ENTREPRENEUR_NAME') ?></th>
                    <?php if (isset($reports[0]['total_income'])) { ?>
                        <th><?= $this->lang->line('INCOME') ?></th>
                    <?php } ?>

                    <?php if (isset($reports[0]['total_service'])) { ?>
                        <th><?= $this->lang->line('সেবাগ্রহীতার সংখ্যা') ?></th>
                    <?php } ?>

                    <?php if (isset($reports[0]['total_upload'])) { ?>
                        <th><?= $this->lang->line('আপলোড সংখ্যা') ?></th>
                    <?php } ?>
                    <th><?= $this->lang->line('CDC') ?></th>
                    <th><?= $this->lang->line('CITY_CORPORATION') ?></th>
                    <th><?= $this->lang->line('ZILLA') ?></th>
                    <th><?= $this->lang->line('DIVISION') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($reports)) { ?>
                <?php
                $i = 1;
                $total = 0;
                foreach ($reports as $report) { ?>

                    <tr>
                        <td><?= System_helper::Get_Eng_to_Bng($i++); ?></td>
                        <td><?= $report['uisc_name'] ?></td>
                        <?php if (isset($report['total_income'])) { ?>
                            <td><?= System_helper::Get_Eng_to_Bng($report['total_income']) ?></td>
                            <?php $total += $report['total_income']; ?>
                        <?php } ?>

                        <?php if (isset($report['total_service'])) { ?>
                            <td><?= System_helper::Get_Eng_to_Bng($report['total_service']) ?></td>
                            <?php $total += $report['total_service']; ?>
                        <?php } ?>

                        <?php if (isset($report['total_upload'])) { ?>
                            <td><?= System_helper::Get_Eng_to_Bng($report['total_upload']) ?></td>
                            <?php $total += $report['total_upload']; ?>
                        <?php } ?>
                        <td><?= $report['wardname'] ?></td>
                        <td><?= $report['citycorporationname'] ?></td>
                        <td><?= $report['zillaname'] ?></td>
                        <td><?= $report['divname'] ?></td>
                    </tr>

                <?php } ?>
                <tr style="background: #8CCA33">
                    <td>&nbsp;</td>
                    <td><?= $this->lang->line('TOTAL') ?></td>
                    <td><?= System_helper::Get_Eng_to_Bng($total) ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="7" style="color: red"><?= $this->lang->line('DATA_NOT_FOUND') ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>