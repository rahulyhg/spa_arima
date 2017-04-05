<div ref="header" class="listpage2-header clearfix">

    <div ref="actions" class="listpage2-actions">
        <div class="clearfix ptm mbs">
            <ul class="lfloat" ref="actions">
                <li class="anchor clearfix mg-anchor">
                    <div class="lfloat mrm top-doc-logo"><?=!empty( $this->system['title'] ) ? $this->system['title']:'';?></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">Model</div></div></div>
                </li>

                <ul class="lfloat listpage2-actions_status">
                    <li class="item"><label class="label">ยอดจอง</label><div class="data"><?=$this->sum['total_reservation']==0 ? '-' : $this->sum['total_reservation']?></div></li>
                    
                    <li class="item"><label class="label">คงเหลือ</label><div class="data"><?=$this->sum['total_balance']==0 ? '-' : $this->sum['total_balance']?></div></li>

                    <li class="item"><label class="label">รวม</label><div class="data"><?=$this->sum['total_total']==0 ? '-' : $this->sum['total_total']?></div></li>

                    <li class="item"><label class="label"><span class="fcr">ต้องสั่งเพิ่ม</span></label><div class="data"><?=$this->sum['total_order']==0 ? '-' : $this->sum['total_order']?></div></li>

                </ul>

            </ul>

            <?php if( !empty($this->permit['stocks']['add']) ) { ?>
            <ul class="rfloat" ref="control">
                <li class="mt"><a class="btn btn-blue" href="<?=URL?>products/create"><i class="icon-plus mrs"></i><span>เพิ่มสินค้าใหม่</span></a></li>
                
            </ul>
            <?php } ?>
        </div>

        <div class="clearfix pbm">
            <ul class="lfloat" ref="actions">
                
                <li><a class="btn js-refresh" data-plugins="tooltip" data-options="<?= $this->fn->stringify(array('text' => 'refresh')) ?>"><i class="icon-refresh"></i></a></li>

            </ul>

            <ul class="lfloat selection hidden_elem" ref="selection">
                <li><span class="count-value"></span></li>
                <li><a class="btn-icon"><i class="icon-download"></i></a></li>
                <li><a class="btn-icon"><i class="icon-trash"></i></a></li>
            </ul>

            <ul class="rfloat" ref="control">
                <li><form class="form-search" action="#">
                    <input class="inputtext search-input" type="text" id="search-query" placeholder="ค้นหา" name="q" autocomplete="off">
                    <span class="search-icon">
                        <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
                    </span>

                </form></li>
                <li id="more-link"></li>
            </ul>
        </div>
    </div>

</div>