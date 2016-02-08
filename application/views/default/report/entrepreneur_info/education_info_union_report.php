<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link="http://".$_SERVER['HTTP_HOST'].str_replace("/list","/pdf",$_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($report);
//echo "</pre>";
//die();
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
                <h5>
                    <?php
                    echo $title;
                    $latest_academic_info=$this->config->item('latest_academic_info');
                    ?>
                </h5>
            </div>


            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th><?php echo $element_caption;?></th>
                    <th><?php echo $this->lang->line('TOTAL_ENTREPRENEUR');?></th>
                    <th><?php echo $latest_academic_info[1];?></th>
                    <th><?php echo $latest_academic_info[2];?></th>
                    <th><?php echo $latest_academic_info[3];?></th>
                    <th><?php echo $latest_academic_info[4];?></th>
                    <th><?php echo $latest_academic_info[5];?></th>
                    <th><?php echo $latest_academic_info[6];?></th>

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
                    $total_entrepreneur=0;
                    $total_secondary=0;
                    $total_higher_secondary=0;
                    $total_diploma=0;
                    $total_graduate=0;
                    $total_postgraduate=0;
                    $total_other=0;


                    $total_percentage_secondary=0;
                    $total_percentage_higher_secondary=0;
                    $total_percentage_diploma=0;
                    $total_percentage_graduate=0;
                    $total_percentage_postgraduate=0;
                    $total_percentage_other=0;
                    foreach($report as $element)
                    {
                        $total_entrepreneur+=$element['total_entrepreneur'];
                        $total_secondary+=$element[1];
                        $total_higher_secondary+=$element[2];
                        $total_diploma+=$element[3];
                        $total_graduate+=$element[4];
                        $total_postgraduate+=$element[5];
                        $total_other+=$element[6];

                        ?>
                        <tr>
                            <td><?php echo $element['elm_name'];?></td>
                            <td><?php echo System_helper::Get_Eng_to_Bng($element['total_entrepreneur']);?></td>
                            <td><?php echo System_helper::Get_Eng_to_Bng($element[1]);?></td>
                            <td><?php echo System_helper::Get_Eng_to_Bng($element[2]);?></td>
                            <td><?php echo System_helper::Get_Eng_to_Bng($element[3]);?></td>
                            <td><?php echo System_helper::Get_Eng_to_Bng($element[4]);?></td>
                            <td><?php echo System_helper::Get_Eng_to_Bng($element[5]);?></td>
                            <td><?php echo System_helper::Get_Eng_to_Bng($element[6]);?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td style="text-align: right"><?php echo $this->lang->line('TOTAL_NUMBER');?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_entrepreneur);?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_secondary);?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_higher_secondary);?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_diploma);?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_graduate);?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_postgraduate);?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng($total_other);?></td>
                    </tr>
                    <tr>
                        <?php
                        $total_percentage_secondary=(100*$total_secondary)/$total_entrepreneur;
                        $total_percentage_higher_secondary=(100*$total_higher_secondary)/$total_entrepreneur;
                        $total_percentage_diploma=(100*$total_diploma)/$total_entrepreneur;
                        $total_percentage_graduate=(100*$total_graduate)/$total_entrepreneur;
                        $total_percentage_postgraduate=(100*$total_postgraduate)/$total_entrepreneur;
                        $total_percentage_other=(100*$total_other)/$total_entrepreneur;
                        ?>
                        <td style="text-align: right"><?php echo $this->lang->line('TOTAL_PERCENTAGE');?></td>
                        <td><?php //echo System_helper::Get_Eng_to_Bng($total_entrepreneur);?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng(round($total_percentage_secondary,2));?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng(round($total_percentage_higher_secondary,2));?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng(round($total_percentage_diploma,2));?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng(round($total_percentage_graduate,2));?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng(round($total_percentage_postgraduate,2));?></td>
                        <td><?php echo System_helper::Get_Eng_to_Bng(round($total_percentage_other,2));?></td>
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