<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
?>
<div id="system_content" class="system_content_margin">
    <div id="system_action_button_container" class="system_action_button_container">
        <?php
        $CI->load_view('system_action_buttons');
        ?>
    </div>
    <div id="system_dataTable">
    </div>
</div>



<script type="text/javascript">
    // onload function
    $(document).ready(function ()
    {
        turn_off_triggers();
        var url = "<?php echo $CI->get_encoded_url('basic_setup/services/get_list');?>";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'edit_link', type: 'string' },
                { name: 'name', type: 'string' },
                { name: 'description', type: 'string' },
                { name: 'service_url', type: 'string' },
                { name: 'service_logo', type: 'string' },
                { name: 'status_text', type: 'string' }
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#system_dataTable").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize:10,
                pagesizeoptions: ['10', '20', '30', '50','100','150'],
                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,

                columns: [
                    { text: '<?php echo $CI->lang->line('SERVICE_NAME'); ?>', dataField: 'name', width:'400'},
                    { text: '<?php echo $CI->lang->line('SERVICE_TYPE'); ?>', dataField: 'description', width:'300'},
                    { text: '<?php echo $CI->lang->line('SERVICE_URL'); ?>', dataField: 'service_url', width:'200'},
                    { text: '<?php echo $CI->lang->line('SERVICE_LOGO'); ?>', dataField: 'service_logo', width:'100'},
                    { text: '<?php echo $CI->lang->line('STATUS'); ?>', dataField: 'status_text',cellsalign: 'right',width:'117'}
                ]
            });
        //for Double Click to edit
        <?php
            if($CI->permissions['edit'])
            {
                ?>
            $('#system_dataTable').on('rowDoubleClick', function (event)
            {

                var edit_link=$('#system_dataTable').jqxGrid('getrows')[event.args.rowindex].edit_link;

                $.ajax({
                    url: edit_link,
                    type: 'POST',
                    dataType: "JSON",
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            });
            <?php
        }
    ?>
    });
</script>