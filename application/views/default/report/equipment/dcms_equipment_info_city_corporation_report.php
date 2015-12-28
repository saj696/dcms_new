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
                <h5><?php echo $title;?></h5>
            </div>


            <table class="table table-responsive table-bordered">
            <thead>
            <!--            <tr>-->
            <!--                <th colspan="21" class="text-center">-->
            <!--                    --><?php //echo System_helper::Get_Eng_to_Bng($from_date);?><!-- --><?php //echo $this->lang->line('TO');?><!-- --><?php //echo System_helper::Get_Eng_to_Bng($to_date);?>
            <!--                </th>-->
            <!--            </tr>-->
            <tr>
                <th><?php echo $this->lang->line('DIVISION_NAME');?></th>
                <th><?php echo $this->lang->line('ZILLA_NAME');?></th>
                <th><?php echo $this->lang->line('CITY_CORPORATION_NAME');?></th>
                <th><?php echo $this->lang->line('CITY_CORPORATION_WARD_NAME');?></th>
                <th><?php echo $this->lang->line('UISC_NAME');?></th>
                <th><?php echo $this->lang->line('EQUIPMENT_NAME');?></th>
                <th><?php echo $this->lang->line('EQUIPMENT_DETAILS');?></th>
                <th><?php echo $this->lang->line('EQUIPMENT_QUANTITY');?></th>
                <th><?php echo $this->lang->line('EQUIPMENT_STATUS');?></th>
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
                $city_corporation_name='';
                $city_corporation_ward_name='';
                $uisc_name='';

                foreach($report as $division)
                {
                    foreach($division['zilla'] as $zilla)
                    {
                        foreach($zilla['city_corporation'] as $city_corporation)
                        {
                            foreach($city_corporation['city_corporation_ward'] as $city_corporation_ward)
                            {
                                foreach($city_corporation_ward['uisc'] as $uisc)
                                {
                                    for($i=0; $i<sizeof($uisc['equipment_info']); $i++)
                                    {
                                        if($uisc['equipment_info'][$i]['equipment_status']==0)
                                        {
                                            $equipment_status=$this->lang->line('EQUIPMENT_STATUS_GOOD');
                                        }
                                        elseif($uisc['equipment_info'][$i]['equipment_status']==1)
                                        {
                                            $equipment_status=$this->lang->line('EQUIPMENT_STATUS_BAD');
                                        }
                                        else
                                        {
                                            $equipment_status='';
                                        }

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
                                            <td><?php echo $uisc['equipment_info'][$i]['equipment_name'];?></td>
                                            <td><?php echo $uisc['equipment_info'][$i]['equipment_detail'];?></td>
                                            <td><?php echo $uisc['equipment_info'][$i]['equipment_quantity'];?></td>
                                            <td><?php echo $equipment_status;?></td>
                                        </tr>
                                    <?php
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