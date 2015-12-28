<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link="http://".$_SERVER['HTTP_HOST'].str_replace("/list","/pdf",$_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($report);
//echo "</pre>";

?>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/templates/default/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="main_container">
            <div class="row show-grid hidden-print">
                <a class="btn btn-primary btn-rect pull-right" href="<?php echo $pdf_link;?>"><?php echo $this->lang->line("BUTTON_PDF"); ?></a>
                <a class="btn btn-primary btn-rect pull-right" style="margin-right: 10px;" href="javascript:window.print();"><?php echo $this->lang->line("BUTTON_PRINT"); ?></a>
                <div class="clearfix"></div>
                <span class="pull-right"><?php echo $this->lang->line('REPORT_CURRENT_DATE_VIEW');?></span>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-12 text-center">
                    <h4><?php echo $this->lang->line('REPORT_HEADER_TITLE');?></h4>
                    <h5><?php echo $title;?></h5>
                </div>

                <table class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th colspan="21" class="text-center">
                            <?php echo System_helper::Get_Eng_to_Bng($from_date);?> <?php echo $this->lang->line('TO');?> <?php echo System_helper::Get_Eng_to_Bng($to_date);?>
                        </th>
                    </tr>
                    <tr>

                        <th><?php echo $this->lang->line('DIVISION_NAME');?></th>
                        <th><?php echo $this->lang->line('ZILLA_NAME');?></th>
                        <th><?php echo $this->lang->line('CITY_CORPORATION_NAME');?></th>
                        <th><?php echo $this->lang->line('CITY_CORPORATION_WARD_NAME');?></th>
                        <th><?php echo $this->lang->line('UISC_NAME');?></th>
                        <!--   <th>--><?php //echo $this->lang->line('MONTH_NAME');?><!--</th>-->
                        <?php
                        if($report_status=='100')
                        {
                            ?>
                            <th><?php echo $this->lang->line('DATE');?></th>
                            <th><?php echo $this->lang->line('CENTER_STATUS');?></th>
                        <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(empty($report))
                    {
                        ?>
                        <tr>
                            <td colspan="21" style="color: red; text-align: center;"><?php echo $this->lang->line('DATA_NOT_FOUND');?></td>
                        </tr>
                    <?php
                    }
                    else
                    {
                        $report_data=array();
                        if($report_status=='100')
                        {
                            foreach($report as $row)
                            {
                                $start_date = date('Y-m-d', strtotime($from_date));
                                $end_date =  date('Y-m-d', strtotime($to_date));
                                $day = 86400; // Day in seconds
                                $format = 'Y-m-d'; // Output format (see PHP date funciton)
                                $format_month = 'm'; // Output format (see PHP date funciton)
                                $sTime = strtotime($start_date); // Start as time
                                $eTime = strtotime($end_date); // End as time
                                $numDays = round(($eTime - $sTime) / $day) + 1;
                                $days = array();
                                $date='';
                                $date_month='';
                                $upload_yes='';
                                $upload_no='';
                                for ($d = 0; $d < $numDays; $d++)
                                {
                                    $date= date($format, ($sTime + ($d * $day)));
                                    $date_month= date($format_month, ($sTime + ($d * $day)));

                                    $report_data[$row['divid']]['division_id']=$row['divid'];
                                    $report_data[$row['divid']]['division_name']=$row['divname'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_id']=$row['zillaid'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_name']=$row['zillaname'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_id']=$row['citycorporation'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_name']=$row['citycorporationname'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['city_corporation_ward_id']=$row['citycorporationward'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['city_corporation_ward_name']=$row['wardname'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['uisc_id']=$row['uisc_id'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['uisc_name']=$row['uisc_name'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['invoice'][$date]['invoice_date'][]=$row['invoice_date'];
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['invoice'][$date]['increment_date']=$date;
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['invoice'][$date]['invoice_month']=$date_month;
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['invoice'][$date]['upload_yes']=$upload_yes;
                                    $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['invoice'][$date]['upload_no']=$upload_no;
                                }
                            }
                        }
                        else
                        {
                            foreach($report as $row)
                            {
                                $start_date = date('Y-m-d', strtotime($from_date));
                                $end_date =  date('Y-m-d', strtotime($to_date));
                                $day = 86400; // Day in seconds
                                $format = 'Y-m-d'; // Output format (see PHP date funciton)
                                $format_month = 'm'; // Output format (see PHP date funciton)
                                $sTime = strtotime($start_date); // Start as time
                                $eTime = strtotime($end_date); // End as time
                                $numDays = round(($eTime - $sTime) / $day) + 1;
                                $days = array();
                                $date='';
                                $date_month='';
                                $upload_yes='';
                                $upload_no='';


                                $report_data[$row['divid']]['division_id']=$row['divid'];
                                $report_data[$row['divid']]['division_name']=$row['divname'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_id']=$row['zillaid'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['zilla_name']=$row['zillaname'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_id']=$row['citycorporation'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_name']=$row['citycorporationname'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['city_corporation_ward_id']=$row['citycorporationward'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['city_corporation_ward_name']=$row['wardname'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['uisc_id']=$row['uisc_id'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['uisc_name']=$row['uisc_name'];
                                $report_data[$row['divid']]['zilla'][$row['zillaid']]['city_corporation'][$row['citycorporation']]['city_corporation_ward'][$row['citycorporationward']]['uisc'][$row['uisc_id']]['invoice'][]=$row['invoice_date'];
                            }
                        }
                        $division_name='';
                        $zilla_name='';
                        $city_corporation_name='';
                        $city_corporation_ward_name='';
                        $uisc_name='';
                        foreach($report_data as $division)
                        {
                            //echo $division['division_name'];
                            foreach($division['zilla'] as $zilla)
                            {
                                foreach($zilla['city_corporation'] as $city_corporation)
                                {
                                    foreach($city_corporation['city_corporation_ward'] as $city_corporation_ward)
                                    {
                                        foreach($city_corporation_ward['uisc'] as $uisc)
                                        {
                                            if($report_status=='100')
                                            {
                                                foreach($uisc['invoice'] as $invoice)
                                                {
                                                    if($report_status=='100')
                                                    {
                                                        $upload_yes='';
                                                        $upload_no='';
                                                        if (in_array($invoice['increment_date'], $invoice['invoice_date']))
                                                        {
                                                            $upload_yes="<span style='color: green'>".$this->lang->line('UPLOAD_YES')."</div>";
                                                        }
                                                        else
                                                        {
                                                            $upload_no="<span style='color: red'>".$this->lang->line('UPLOAD_NO')."</div>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $upload_yes='';
                                                        $upload_no='';
                                                    }

                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            if ($division_name == '')
                                                            {
                                                                echo $division['division_name'];
                                                                $division_name = $division['division_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($division_name == $division['division_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $division['division_name'];
                                                                $division_name = $division['division_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($zilla_name == '')
                                                            {
                                                                echo $zilla['zilla_name'];
                                                                $zilla_name = $zilla['zilla_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($zilla_name == $zilla['zilla_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $zilla['zilla_name'];
                                                                $zilla_name = $zilla['zilla_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($city_corporation_name == '')
                                                            {
                                                                echo $city_corporation['city_corporation_name'];
                                                                $city_corporation_name = $city_corporation['city_corporation_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($city_corporation_name == $city_corporation['city_corporation_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $city_corporation['city_corporation_name'];
                                                                $city_corporation_name = $city_corporation['city_corporation_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($city_corporation_ward_name == '')
                                                            {
                                                                echo $city_corporation_ward['city_corporation_ward_name'];
                                                                $city_corporation_ward_name = $city_corporation_ward['city_corporation_ward_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($city_corporation_ward_name == $city_corporation_ward['city_corporation_ward_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $city_corporation_ward['city_corporation_ward_name'];
                                                                $city_corporation_ward_name = $city_corporation_ward['city_corporation_ward_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($uisc_name == '')
                                                            {
                                                                echo $uisc['uisc_name'];
                                                                $uisc_name = $uisc['uisc_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($uisc_name == $uisc['uisc_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $uisc['uisc_name'];
                                                                $uisc_name = $uisc['uisc_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php
                                                        if($report_status=='100')
                                                        {
                                                            ?>
                                                            <td><?php echo System_helper::Get_Eng_to_Bng($invoice['increment_date']);?></td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <td><?php echo $upload_yes;?><?php echo $upload_no;?></td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                            else
                                            {
                                                $total_days = $numDays;
                                                $result_days=count($uisc['invoice']);
                                                $date_between_percentage =  (($report_status/100)*$total_days);
                                                if($date_between_percentage<=$result_days)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            if ($division_name == '')
                                                            {
                                                                echo $division['division_name'];
                                                                $division_name = $division['division_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($division_name == $division['division_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $division['division_name'];
                                                                $division_name = $division['division_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($zilla_name == '')
                                                            {
                                                                echo $zilla['zilla_name'];
                                                                $zilla_name = $zilla['zilla_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($zilla_name == $zilla['zilla_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $zilla['zilla_name'];
                                                                $zilla_name = $zilla['zilla_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($city_corporation_name == '')
                                                            {
                                                                echo $city_corporation['city_corporation_name'];
                                                                $city_corporation_name = $city_corporation['city_corporation_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($city_corporation_name == $city_corporation['city_corporation_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $city_corporation['city_corporation_name'];
                                                                $city_corporation_name = $city_corporation['city_corporation_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($city_corporation_ward_name == '')
                                                            {
                                                                echo $city_corporation_ward['city_corporation_ward_name'];
                                                                $city_corporation_ward_name = $city_corporation_ward['city_corporation_ward_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($city_corporation_ward_name == $city_corporation_ward['city_corporation_ward_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $city_corporation_ward['city_corporation_ward_name'];
                                                                $city_corporation_ward_name = $city_corporation_ward['city_corporation_ward_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($uisc_name == '')
                                                            {
                                                                echo $uisc['uisc_name'];
                                                                $uisc_name = $uisc['uisc_name'];
                                                                //$currentDate = $preDate;
                                                            }
                                                            else if ($uisc_name == $uisc['uisc_name'])
                                                            {
                                                                //exit;
                                                                echo "&nbsp;";
                                                            }
                                                            else
                                                            {
                                                                echo $uisc['uisc_name'];
                                                                $uisc_name = $uisc['uisc_name'];
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>