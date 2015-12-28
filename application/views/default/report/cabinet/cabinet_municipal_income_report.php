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
                    <th><?php echo $this->lang->line('MUNICIPAL_NAME');?></th>
                    <th><?php echo $this->lang->line('MUNICIPAL_WARD_NAME');?></th>
                    <th><?php echo $this->lang->line('UISC_NAME');?></th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
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
                    $municipal_name='';
                    $uisc_name='';
                    foreach($report as $division)
                    {
                        foreach($division['zilla'] as $zilla)
                        {
                            foreach($zilla['municipal'] as $municipal)
                            {
                                ?>
                                <tr style="background: #cccccc">
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
                                        if ($municipal_name == '')
                                        {
                                            echo $municipal['municipal_name'];
                                            $municipal_name = $municipal['municipal_name'];
                                            //$currentDate = $preDate;
                                        }
                                        else if ($municipal_name == $municipal['municipal_name'])
                                        {
                                            //exit;
                                            echo "&nbsp;";
                                        }
                                        else
                                        {
                                            echo $municipal['municipal_name'];
                                            $municipal_name = $municipal['municipal_name'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo System_helper::Get_Eng_to_Bng($municipal['number_of_municipal']);?></td>
                                    <td><?php echo System_helper::Get_Eng_to_Bng($municipal['number_of_uisc']);?></td>
                                    <th><?php if(isset($upazilla['invoice'])){echo $this->lang->line('DATE');}?></th>
                                    <th><?php if(isset($upazilla['invoice'])){echo $this->lang->line('INCOME');}?></th>
                                </tr>

                                <?php
                                $invoice_date='';
                                $invoice_amount='';
                                if(isset($municipal['invoice']))
                                {
                                    for($i=0; $i<sizeof($municipal['invoice']); $i++)
                                    {
                                        if(isset($municipal['invoice'][$i]['invoice_date']))
                                        {
                                            $invoice_date = strtotime($municipal['invoice'][$i]['invoice_date']);
                                            $invoice_amount = $municipal['invoice'][$i]['invoice_amount'];
                                        }
                                        else
                                        {
                                            $invoice_date='';
                                            $invoice_amount='';
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="5">&nbsp;</td>
                                            <td><?php echo System_helper::Get_Eng_to_Bng(date('d-m-Y', $invoice_date));?></td>
                                            <td><?php echo System_helper::Get_Eng_to_Bng($invoice_amount);?></td>
                                        </tr>
                                    <?php
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