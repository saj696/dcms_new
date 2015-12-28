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
<?php
if(empty($report) || empty($report_type) || empty($report_status))
{
    ?>
<table class="table table-responsive table-bordered">
    <thead>
    <tr>
        <td colspan="21" style="color: red; text-align: center;"><?php echo $this->lang->line('PLEASE_INPUT_REQUIRE_FIELD');?></td>
    </tr>
    </thead>
</table>
<?php
}
?>
</body>
</html>