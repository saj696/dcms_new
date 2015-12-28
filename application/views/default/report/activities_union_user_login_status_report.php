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
            <?php
            $month_name=System_helper::Get_Bangla_Month($month);
            $s_date=$year.'-'.$month.'-'.date('d');
            $date = date($s_date);// current date
            $date_one = strtotime(date("Y-m-d", strtotime($date)) . " -1 day");
            $date_two = strtotime(date("Y-m-d", strtotime($date)) . " -2 days");
            $date_three = strtotime(date("Y-m-d", strtotime($date)) . " -3 days");
            $date_four = strtotime(date("Y-m-d", strtotime($date)) . " -4 days");
            $date_five = strtotime(date("Y-m-d", strtotime($date)) . " -5 days");
            $date_six = strtotime(date("Y-m-d", strtotime($date)) . " -6 days");
            $date_seven = strtotime(date("Y-m-d", strtotime($date)) . " -7 days");
            ?>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th colspan="21" class="text-center">
                        <?php echo $month_name." ".$this->lang->line('MONTH');?>,
                        <?php echo System_helper::Get_Eng_to_Bng($year);?>
                    </th>
                </tr>
                <tr>

                    <th><?php echo $this->lang->line('UISC_NAME');?></th>
                    <th><?php echo $this->lang->line('ENTREPRENEUR_NAME');?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(date('d', $date_one).' '.$month_name)?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(date('d', $date_two).' '.$month_name)?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(date('d', $date_three).' '.$month_name)?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(date('d', $date_four).' '.$month_name)?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(date('d', $date_five).' '.$month_name)?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(date('d', $date_six).' '.$month_name)?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(date('d', $date_seven).' '.$month_name)?></th>
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
                    $day_one_status='';
                    $day_two_status='';
                    $day_three_status='';
                    $day_four_status='';
                    $day_five_status='';
                    $day_six_status='';
                    $day_seven_status='';
                    foreach($report as $row)
                    {
                        if($row['one_day']>0)
                        {
                            $day_one_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $day_one_status=$this->lang->line('NO');
                        }

                        if($row['two_day']>0)
                        {
                            $day_two_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $day_two_status=$this->lang->line('NO');
                        }

                        if($row['three_day']>0)
                        {
                            $day_three_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $day_three_status=$this->lang->line('NO');
                        }

                        if($row['four_day']>0)
                        {
                            $day_four_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $day_four_status=$this->lang->line('NO');
                        }

                        if($row['five_day']>0)
                        {
                            $day_five_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $day_five_status=$this->lang->line('NO');
                        }

                        if($row['six_day']>0)
                        {
                            $day_six_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $day_six_status=$this->lang->line('NO');
                        }

                        if($row['seven_day']>0)
                        {
                            $day_seven_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $day_seven_status=$this->lang->line('NO');
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['uisc_name'];?></td>
                            <td><?php echo $row['name_bn'];?></td>
                            <td><?php echo $day_one_status;?></td>
                            <td><?php echo $day_two_status;?></td>
                            <td><?php echo $day_three_status;?></td>
                            <td><?php echo $day_four_status;?></td>
                            <td><?php echo $day_five_status;?></td>
                            <td><?php echo $day_six_status;?></td>
                            <td><?php echo $day_seven_status;?></td>
                        </tr>
                    <?php
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