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
                        <?php echo System_helper::Get_Bangla_Month($month)." ".$this->lang->line('MONTH');?>,
                        <?php echo System_helper::Get_Eng_to_Bng($year);?>
                    </th>
                </tr>
                <tr>
                    <!--                    <th>--><?php //echo $this->lang->line('DIVISION_NAME');?><!--</th>-->
                    <!--                    <th>--><?php //echo $this->lang->line('ZILLA_NAME');?><!--</th>-->
                    <!--                    <th>--><?php //echo $this->lang->line('UPAZILLA_NAME');?><!--</th>-->
                    <!--                    <th>--><?php //echo $this->lang->line('UNION_NAME');?><!--</th>-->
                    <th><?php echo $this->lang->line('UPAZILLA');?></th>
                    <th><?php echo $this->lang->line('TEN_DAYS');?></th>
                    <th><?php echo $this->lang->line('TWENTY_DAYS');?></th>
                    <th><?php echo $this->lang->line('THIRTY_DAYS');?></th>
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
                    $ten_days_status='';
                    $twenty_days_status='';
                    $thirty_days_status='';
                    foreach($report as $row)
                    {
                        if($row['ten_days']>0)
                        {
                            $ten_days_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $ten_days_status=$this->lang->line('NO');
                        }

                        if($row['twenty_days']>0)
                        {
                            $twenty_days_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $twenty_days_status=$this->lang->line('NO');
                        }

                        if($row['thirty_days']>0)
                        {
                            $thirty_days_status=$this->lang->line('YES');
                        }
                        else
                        {
                            $thirty_days_status=$this->lang->line('NO');
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['upazilaname'];?></td>
                            <td><?php echo $ten_days_status;?></td>
                            <td><?php echo $twenty_days_status;?></td>
                            <td><?php echo $thirty_days_status;?></td>
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