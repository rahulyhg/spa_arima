<?php if( empty($this->item['is_unlimit']) ) { ?>
<div class="duration-wrap" style="max-width:100%;">

    <div class="duration-tubes">
        <ul class="ui-list ui-list-duration" ref="listsbox">
        <?php foreach ($this->item['expired'] as $key => $value) {

            $start_day = date("d");
            $start_month = date("n");
            $start_year = date("Y")+543;
            $startDate = "{$start_day} {$this->fn->q('time')->month( $start_month, true )} {$start_year}";

            $end_day = date("d");
            $end_month = date("n");
            $end_year = date("Y")+543;
            $endDate = "{$end_day} {$this->fn->q('time')->month( $end_month, true )} {$end_year}";
            ?>

            <li class="ui-item ui-item-topBorder uiBoxWhite">
                <div class="clearfix ui-item-inner" href="#">

                    <ul class="disc ui-list-meta">
                        
                        <li>
                            <i class="icon-clock-o"></i> <label>Time:</label> <strong><?=$startDate?></strong> <span class="fcg">-</span> <strong><?=$endDate?></strong>
                        </li>
                        <li>
                            <i class="icon-user-circle-o"></i> <label>Create By:</label> <i class="icon"></i><strong><?=$value['emp']['text']?></strong> <?=$this->fn->q('time')->live( $value['updated'] )?>
                        </li>
                    </ul>


                </div>
                <?php if( $value['status'] == 'run' ) { ?>
                <div class="status-wrap"><a class="ui-status" style="background-color: rgb(11, 195, 57);">RUN</a></div>
                <?php }else{ ?>
                <div class="status-wrap"><a class="ui-status" style="background-color: rgb(219, 21, 6);">EXPIRED</a></div>
                <?php } ?>

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
<?php }
else{
    echo '<table class="mtl table-accessory"><tbody><tr><td colspan="3" class="td-empty"><span class="fwb">ไม่มีวันหมดอายุ</span></td></tr></tbody></table>';
    } ?>