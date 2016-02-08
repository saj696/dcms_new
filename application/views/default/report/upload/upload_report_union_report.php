<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link = "http://" . $_SERVER['HTTP_HOST'] . str_replace("/list", "/pdf", $_SERVER['REQUEST_URI']);
$numDays = 0;
?>

<?php
if (!empty($report)) {
    /* echo "<pre>";
     print_r($report);
     echo "</pre>";
     die;*/
    $count_union = array();
    $report_data = array();
    $unionid = 0;
    if ($report_status == '100') {
        foreach ($report as $row) {
            $start_date = date('Y-m-d', strtotime($from_date));
            $end_date = date('Y-m-d', strtotime($to_date));
            $day = 86400; // Day in seconds
            $format = 'Y-m-d'; // Output format (see PHP date funciton)
            $format_month = 'm'; // Output format (see PHP date funciton)
            $sTime = strtotime($start_date); // Start as time
            $eTime = strtotime($end_date); // End as time
            $numDays = round(($eTime - $sTime) / $day) + 1;
            $days = array();
            $date = '';
            $date_month = '';
            $upload_yes = '';
            $upload_no = '';

            if ($row['unionid'] != $unionid) {
                $count_union[$row['upazilaid']][] = $row['unionid'];
                $unionid = $row['unionid'];
            }


            for ($d = 0; $d < $numDays; $d++) {
                $date = date($format, ($sTime + ($d * $day)));
                $date_month = date($format_month, ($sTime + ($d * $day)));

                /*$report_data[$row['divid']]['division_id']=$row['divid'];
                $report_data[$row['divid']]['division_name']=$row['divname'];*/
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_id'] = $row['zillaid'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_name'] = $row['zillaname'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['upazilla_id'] = $row['upazilaid'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['upazilla_name'] = $row['upazilaname'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['union_id'] = $row['unionid'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['union_name'] = $row['unionname'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['uisc_id'] = $row['uisc_id'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['uisc_name'] = $row['uisc_name'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['invoice'][$date]['invoice_date'][] = $row['invoice_date'];
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['invoice'][$date]['increment_date'] = $date;
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['invoice'][$date]['invoice_month'] = $date_month;
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['invoice'][$date]['upload_yes'] = $upload_yes;
                $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['invoice'][$date]['upload_no'] = $upload_no;
            }
        }
    } else {
        foreach ($report as $row) {
            $start_date = date('Y-m-d', strtotime($from_date));
            $end_date = date('Y-m-d', strtotime($to_date));
            $day = 86400; // Day in seconds
            $format = 'Y-m-d'; // Output format (see PHP date funciton)
            $format_month = 'm'; // Output format (see PHP date funciton)
            $sTime = strtotime($start_date); // Start as time
            $eTime = strtotime($end_date); // End as time
            $numDays = round(($eTime - $sTime) / $day) + 1;
            $days = array();
            $date = '';
            $date_month = '';
            $upload_yes = '';
            $upload_no = '';


            $report_data[$row['divid']]['division_id'] = $row['divid'];
            $report_data[$row['divid']]['division_name'] = $row['divname'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_id'] = $row['zillaid'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_name'] = $row['zillaname'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['upazilla_id'] = $row['upazilaid'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['upazilla_name'] = $row['upazilaname'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['union_id'] = $row['unionid'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['union_name'] = $row['unionname'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['uisc_id'] = $row['uisc_id'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['uisc_name'] = $row['uisc_name'];
            $report_data[$row['divid']]['zilla'][$row['zillaid']]['upazilla'][$row['upazilaid']]['union'][$row['unionid']]['uisc'][$row['uisc_id']]['invoice'][] = $row['invoice_date'];
        }
    }
} ?>
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

            <table class="table table-responsive table-bordered">
                <?php
                if (!empty($report)){
                ?>
                <thead>
                <?php if (isset($upazilas)) { ?>
                    <tr>
                        <th colspan="<?= $numDays + 4 ?>" class="text-center">
                            <?= $report[0]['zillaname'] . $this->lang->line('ZILLA') ?> <br/>
                            <?= $this->config->item('month')[$month] . '-' . System_helper::Get_Eng_to_Bng($year) ?>
                            <br/>
                            <?= $this->lang->line('TOTAL_UPAZILLA') . System_helper::Get_Eng_to_Bng(sizeof($upazilas)) . ', ' . $this->lang->line('TOTAL_UNION') . System_helper::Get_Eng_to_Bng(sizeof($unions)); ?>
                            <br/>
                        </th>
                    </tr>
                <?php } ?>
                <?php
                foreach ($report_data as $division) {
                foreach ($division['zilla'] as $zilla) {
                foreach ($zilla['upazilla'] as $upazilla) { ?>
                <tr>
                    <th colspan="<?= $numDays + 4 ?>" class="text-center">
                        <?php echo $upazilla['upazilla_name'] . $this->lang->line('UPAZILLA_NAME') ?> <br>
                        <?= !isset($upazilas) ? $this->config->item('month')[$month] . '-' . System_helper::Get_Eng_to_Bng($year) . "<br/>" : "" ?>
                        <?= $this->lang->line('TOTAL_UNION') . ' ' . System_helper::Get_Eng_to_Bng(count(Query_helper::get_info($this->config->item('table_unions'), 'rowid', array('zillaid =' . $zilla['zilla_id'], 'upazilaid =' . $upazilla['upazilla_id'])))) ?>
                    </th>
                </tr>
                <tr>
                    <th><?= $this->lang->line('UNION') ?></th>
                    <th><?= $this->lang->line('CENTER') ?></th>
                    <?php for ($d = 1; $d <= $numDays; $d++) { ?>
                        <th><?php echo System_helper::Get_Eng_to_Bng($d); ?></th>
                    <?php } ?>
                    <th><?= $this->lang->line('NUMBER_OF_UPLOAD') ?></th>
                    <th><?= $this->lang->line('REMARKS') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($upazilla['union'] as $union) {
                    $center_no = 01;
                    $total_uplaod = 0;
                    foreach ($union['uisc'] as $center) {
                        ?>
                        <tr>
                            <td><?= $union['union_name']; ?></td>
                            <td><?= System_helper::Get_Eng_to_Bng($center_no++); ?></td>
                            <?php foreach ($center['invoice'] as $invoice) {

                            $upload_yes = '';
                            $upload_no = '';
                            if (in_array($invoice['increment_date'], $invoice['invoice_date'])) {
                                $total_uplaod++; ?>
                                <td><span style="color: #008800" class="glyphicon glyphicon-ok"></span>

                                </td>
                            <?php } else { ?>
                            <td><span style="color: #dd1144" class="glyphicon glyphicon-remove"></span>
                                <?php } ?>
                                <?php } ?>
                            <td><?= System_helper::Get_Eng_to_Bng($total_uplaod) ?></td>
                            <?php
                            $upload_percent = (($total_uplaod * 100) / $numDays);
                            if ($upload_percent >= 70) { ?>
                                <td><?= $this->lang->line('SATISFIED') ?></td>
                            <?php } elseif ($upload_percent >= 50 && $upload_percent < 70) { ?>
                                <td><?= $this->lang->line('FAIRLY_SATISFIED') ?></td>
                            <?php } elseif ($upload_percent > 0 && $upload_percent < 50) { ?>
                                <td><?= $this->lang->line('NOT_SATISFIED') ?></td>
                            <?php } else { ?>
                                <td><?= $this->lang->line('UNSATISFIED') ?></td>
                            <?php } ?>
                        </tr>
                    <?php }
                } ?>

                <?php }
                }
                } ?>
                <?php } else { ?>
                    <td colspan="<?= $numDays + 4 ?>"
                        style="color: red; text-align: center;"><?php echo $this->lang->line('DATA_NOT_FOUND'); ?></td>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>