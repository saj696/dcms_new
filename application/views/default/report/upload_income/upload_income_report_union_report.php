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
                        <th><?php echo $this->lang->line('UPAZILLA_NAME');?></th>
                        <th><?php echo $this->lang->line('UNION_NAME');?></th>
                        <th><?php echo $this->lang->line('UISC_NAME');?></th>
                        <?php
                        if($report_status==1)
                        {
                            ?>
                            <th><?php echo $this->lang->line('DATE');?></th>
                        <?php
                        }
                        ?>
                        <th><?php echo $this->lang->line('INCOME');?></th>
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
                        $division_name='';
                        $zilla_name='';
                        $upazilla_name='';
                        $union_name='';
                        $uisc_name='';
                        $total=0;
                        foreach($report as $row)
                        {
                            $invoice_date=strtotime($row['invoice_date']);
                            $total+=$row['total_income'];
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    if ($division_name == '')
                                    {
                                        echo $row['divname'];
                                        $division_name = $row['divname'];
                                        //$currentDate = $preDate;
                                    }
                                    else if ($division_name == $row['divname'])
                                    {
                                        //exit;
                                        echo "&nbsp;";
                                    }
                                    else
                                    {
                                        echo $row['divname'];
                                        $division_name = $row['divname'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($zilla_name == '')
                                    {
                                        echo $row['zillaname'];
                                        $zilla_name = $row['zillaname'];
                                        //$currentDate = $preDate;
                                    }
                                    else if ($zilla_name == $row['zillaname'])
                                    {
                                        //exit;
                                        echo "&nbsp;";
                                    }
                                    else
                                    {
                                        echo $row['zillaname'];
                                        $zilla_name = $row['zillaname'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($upazilla_name == '')
                                    {
                                        echo $row['upazilaname'];
                                        $upazilla_name = $row['upazilaname'];
                                        //$currentDate = $preDate;
                                    }
                                    else if ($upazilla_name == $row['upazilaname'])
                                    {
                                        //exit;
                                        echo "&nbsp;";
                                    }
                                    else
                                    {
                                        echo $row['upazilaname'];
                                        $upazilla_name = $row['upazilaname'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($union_name == '')
                                    {
                                        echo $row['unionname'];
                                        $union_name = $row['unionname'];
                                        //$currentDate = $preDate;
                                    }
                                    else if ($union_name == $row['unionname'])
                                    {
                                        //exit;
                                        echo "&nbsp;";
                                    }
                                    else
                                    {
                                        echo $row['unionname'];
                                        $union_name = $row['unionname'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($uisc_name == '')
                                    {
                                        echo $row['uisc_name'];
                                        $uisc_name = $row['uisc_name'];
                                        //$currentDate = $preDate;
                                    }
                                    else if ($uisc_name == $row['uisc_name'])
                                    {
                                        //exit;
                                        echo "&nbsp;";
                                    }
                                    else
                                    {
                                        echo $row['uisc_name'];
                                        $uisc_name = $row['uisc_name'];
                                    }
                                    ?>
                                </td>
                                <?php
                                if($report_status==1)
                                {
                                    ?>
                                    <td><?php echo System_helper::Get_Eng_to_Bng(date('d-m-Y', $invoice_date));?></td>
                                <?php
                                }
                                ?>
                                <td><?php echo System_helper::Get_Eng_to_Bng($row['total_income']);?></td>
                            </tr>

                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="<?php if($report_status==1){echo 6;}else{echo 5;}?>" style="text-align: right"><?php echo $this->lang->line('TOTAL');?></th>
                        <th><?php echo System_helper::Get_Eng_to_Bng($total);?></th>
                    </tr>
                    </tfoot>
                    <?php
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
</body>
</html>