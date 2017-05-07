<div class="duration-wrap" ref="listsbox">
    <div class="duration-tubes">
        <?php for ($j=0; $j < 5; $j++) { ?>
        <div data-id="2017-4">

            <h4 class="duration-wrap-header">เมษายน 2017</h4>
            <ul class="ui-list ui-list-duration">
             <?php for ($i=0; $i < 5; $i++) { ?>
                <li class="ui-item noCoverImage">
                    <a class="anchor clearfix ui-item-inner" href="#">
                        <div class="avatar-date lfloat mrm"><div>17</div><div class="label">เม.ย.</div></div>

                        <div class="content"><div class="spacer"></div><div class="massages">

                        <ul class="disc ui-list-meta">
                            <li>
                                <i class="icon-cube"></i> <label>Package:</label> <strong>AKASURI</strong>
                                , <label>Room:</label> <strong>101</strong>
                            </li>
                            <li>
                                <i class="icon-clock-o"></i> <label>Time:</label> <strong>10.00 - 11.00 PM</strong>
                            </li>
                            <li>
                                <i class="icon-user-circle-o"></i> <label>Service By:</label> <i class="icon"></i><strong>ภุชงค์ สวนแจ้ง</strong>
                            </li>
                        </ul>

                        </div></div>

                    </a>

                    <div class="status-wrap"><a class="ui-status" style="background-color: rgb(219, 21, 6);">Booking</a></div>


                </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>

    <a class="ui-more btn" role="more">โหลดเพิ่มเติม</a>
    <div class="ui-alert">
        <div class="ui-alert-loader">
            <div class="ui-alert-loader-icon loader-spin-wrap"><div class="loader-spin"></div></div>
            <div class="ui-alert-loader-text">กำลังโหลด...</div> 
        </div>

        <div class="ui-alert-error">
            <div class="ui-alert-error-icon"><i class="icon-exclamation-triangle"></i></div>
            <div class="ui-alert-error-text">ไม่สามารถเชื่อมต่อได้</div> 
        </div>

        <div class="ui-alert-empty">
            <div class="ui-alert-empty-text">No Result</div> 
        </div>
    </div>
</div>