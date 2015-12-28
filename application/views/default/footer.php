<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 12/5/15
 * Time: 10:45 AM
 */
?>
<div class="col-sm-12">
    <footer style="width: 103.7%; margin-left: -24px;">
        <div id="footer-content">
            <div id="our-partners" style="margin-left: 20px;">
                <div id="our-parner-title"></div>
                <a id="undp" rel="http://www.undp.org.bd" title="UNDP" href="http://www.undp.org.bd">http://www.undp.org.bd</a>
                <a id="usaid" rel="http://www.usaid.gov/where-we-work/asia/bangladesh" title="USAID" href="http://www.usaid.gov/where-we-work/asia/bangladesh">http://www.usaid.gov/where-we-work/asia/bangladesh</a>
            </div>

            <div id="footeer-menu">
                <div class="region region-footer-menu">
                    <div class="block block-menu" id="block-menu-menu-footer-menu">
                        <div class="content">
                            <ul class="menu">
                                <?php
                                $user = User_helper::get_user();
                                if($user)
                                {
                                    $profile_status= User_helper::complete_user_profile_check();
                                    if(!$profile_status && $user->user_group_id==$this->config->item('UISC_GROUP_ID'))
                                    {
                                        ?>
                                        <li class="leaf menu" style="border-right: 0px;"><a class="active" title="" href="<?php echo base_url();?>home/logout/"> লগ আউট</a><div></div></li>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="leaf menu"><a class="active" title="" href="/">প্রথম পাতা</a></li>
                                        <li class="leaf menu"><a title="" href="<?php echo base_url();?>website/entrepreneur_registration">উদ্যোক্তা রেজিস্ট্রেশন</a><div></div></li>
                                        <li class="leaf menu"><a class="active" title="" href="<?php echo base_url();?>website/user_registration">ব্যবহারকারী রেজিস্ট্রেশন</a><div></div></li>
                                        <li class="leaf menu"><a class="active" title="" href="<?php echo base_url();?>home/login/"> লগ ইন</a><div></div></li>
                                        <li class="leaf menu"><a class="active" title="" href="<?php echo base_url();?>website/eservice_list/index/list">ই-সেবাসমূহ</a><div></div></li>
                                        <li class="last menu" style="border-right:none !important;"><a title="" href="<?php echo base_url();?>website/help_desk_contact/index/list">যোগাযোগ</a><div></div></li>
                                    <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <li class="leaf menu"><a class="active" title="" href="/">প্রথম পাতা</a></li>
                                    <li class="leaf menu"><a title="" href="<?php echo base_url();?>website/entrepreneur_registration">উদ্যোক্তা রেজিস্ট্রেশন</a><div></div></li>
                                    <li class="leaf menu"><a class="active" title="" href="<?php echo base_url();?>website/user_registration">ব্যবহারকারী রেজিস্ট্রেশন</a><div></div></li>
                                    <li class="leaf menu"><a class="active" title="" href="<?php echo base_url();?>home/login/"> লগ ইন</a><div></div></li>
                                    <li class="leaf menu"><a class="active" title="" href="<?php echo base_url();?>website/eservice_list/index/list">ই-সেবাসমূহ</a><div></div></li>
                                    <li class="last menu" style="border-right:none !important;"><a title="" href="<?php echo base_url();?>website/help_desk_contact/index/list">যোগাযোগ</a><div></div></li>
                                <?php
                                }
                                ?>
                            </ul>
                        <ul>
                            <li style="text-align: center;">
                                <span helvetica="" >
                                    কারিগরী সহযোগীতায় <a style="color:#fff; font-family: arial, sans-serif;" target="_blank" href="http://www.softbdltd.com"><img style="height: 30px;" src="<?php echo base_url()?>images/softbd.png" /></a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="social-networks" style="margin: 10px 20px 0 0;">
            <div id="social-network-title"></div>
            <a class="external" target="_blank" id="facebook" rel="https://www.facebook.com/groups/telecentrebd/" title="আমাদের ফেসবুকের পাতা" href="https://www.facebook.com/groups/telecentrebd/">https://www.facebook.com/A2IBangladesh</a>
            <a class="external"  target="_blank" id="twitter" rel="http://www.twitter.com" title="আমাদের টুইটারের পাতা" href="http://www.twitter.com">http://www.twitter.com</a>
            <a class="external" target="_blank" id="rss" rel="rss.xml" title="আমাদের RSS ফিডসমূহ" href="http://uiscbd.ning.com/">rss.xml</a>
        </div>
</div>
</footer>
</div>