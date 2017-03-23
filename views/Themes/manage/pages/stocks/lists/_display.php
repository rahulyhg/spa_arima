<div id="mainContainer" class="clearfix" data-plugins="main">

    <div role="content">

        <div role="toolbar">
            <div class="pvm phl">

                <ul class="ui-steps clearfix">
                    <li class="anchor clearfix mg-anchor">
                        <div class="lfloat mrm top-doc-logo"><div class="initials">MG</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">Car model</div></div></div>
                    </li>

                    <li>
                        <a href="<?= URL ?>products/create" class="btn btn-primary"><i class="icon-plus mrs"></i><span class="btn-text">Add New</span></a>
                    </li>
                    <!-- <li>
                            <a href="<?= URL ?>products/create_event" data-plugins="dialog" class="btn btn-orange"><i class="icon-plus mrs"></i><span class="btn-text">Add Events</span></a>
                    </li> -->
                </ul>

            </div>
        </div>

        <div role="main">


          

                <div id="featured-products" class="featured-products">
                    <table class="featured-products_table ">
                        <thead >
                            <tr>
                                <th class="text-stock">รถยนต์รุ่น/Model</th>
                                <th class="nubmer text-stock">จอง</th>
                                <th class="nubmer text-stock">คงเหลือ</th>
                                <th class="nubmer text-stock">รอสั่งเพิ่ม</th>
                                <th class="nubmer text-stock">รวมทั้งหมด</th>
                                <!-- <th class="actions">จัดการ</th> -->
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($this->model['lists'] as $key => $value) {
                                ?>
                                <tr>
                                    <td><a href="<?= URL ?>products/<?= $value['id'] ?>"><?= $value['name'] ?></a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>


                                </tr>
<?php } ?>
                        </tbody>



                    </table>
            
            </div>
        </div>

    </div>

</div>