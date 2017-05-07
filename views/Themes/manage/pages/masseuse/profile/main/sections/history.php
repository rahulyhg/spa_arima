<div class="duration-wrap">

    <div class="duration-tubes">
        <ul class="ui-list ui-list-duration" ref="listsbox">
        <?php for ($i=0; $i < 30; $i++) { ?>
            <li class="ui-item ui-item-topBorder">
                <div class="clearfix ui-item-inner" href="#">

                    <ul class="disc ui-list-meta">
                        
                        <li>
                            <i class="icon-clock-o"></i> <label>Time:</label> <strong><?=date('Y-m-d')?></strong> <span class="fcg">-</span> <strong><?=date('Y-m-d')?></strong>
                        </li>
                        <li>
                            <i class="icon-user-circle-o"></i> <label>Create By:</label> <i class="icon"></i><strong>ภุชงค์ สวนแจ้ง</strong> <?=$this->fn->q('time')->live( date('Y-m-d') )?>
                        </li>
                    </ul>


                </div>

                <div class="status-wrap"><a class="ui-status" style="background-color: rgb(219, 21, 6);">RUN</a></div>


            </li>
        <?php } ?>
        </ul>
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