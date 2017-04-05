<?php

$types = array();
$types[] = array('id'=>'income','name'=>'ยอดขายรถยนต์');
$types[] = array('id'=>'booking','name'=>'ยอดจองรถยนต์');
// $types[] = array('id'=>'all','name'=>'สรุปยอด');
$types[] = array('id'=>'sales','name'=>'ยอดขาย Sales');
$types[] = array('id'=>'book_sale','name'=>'ยอดจอง Sales');


?><div class="ReportSummary">
    <div class="ReportSummary_desc">
        รายงาน 
        <!-- <span class="ReportSummary_desc-help">สามารถ export บิลการขายทั้งเดือนเป็นไฟล์ excel</span> -->
        <div class="ReportSummary_desc_filters"></div>
    </div>

    <!-- control -->
    <div class="ReportSummary_controlRows" role="control">
        <div class="ReportSummary_controlRow">

            <div class="ReportSummary_filter">
                <div class="ReportSummary_filterLabel">ประเภท</div>
                <div class="ReportSummary_filterContent">
                    <select selector="type" class="inputtext"><?php 

                    foreach ($types as $key => $value) {
                        
                        $selected = '';
                        if( isset($_GET['type']) ){
                            if( $_GET['type']==$value['id'] ){
                                $selected = ' selected';
                            }
                        }

                        echo '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
                    }

                    ?></select>
                </div>
            </div>

            <div class="ReportSummary_filter">
                <div class="ReportSummary_filterLabel">เลือกวันเดือนปีที่ต้องการ</div>
                <div class="ReportSummary_filterContent">
                    <select selector="closedate" name="closedate" class="inputtext">
                        <!-- <option value="daily">วันนี้</option> -->
                        <option value="weekly">สัปดาห์นี้</option>
                        <option selected value="monthly">เดือนนี้</option>
                        <option divider></option>
                        <option value="custom">กำหนดเอง</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <!-- end: control -->

    <!--  -->
    <div class="ReportSummary_numberList ">
        <div class="ReportSummary_numberItem subtotal-text">
            <div><span class="value">0</span></div>
            <div>รายการ</div>
        </div>
        
        <div class="ReportSummary_numberItem total-text">
            <div><span class="value">0</span></div>
            <div>จำนวนทั้งหมด</div>
        </div>

    </div>


</div>