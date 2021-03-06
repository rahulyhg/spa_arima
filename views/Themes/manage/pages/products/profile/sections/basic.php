<div class="profile-resume">
    <?php

    $a = array();
    $a[] = array('label'=>'Model', 'key'=> 'model_name');
    $a[] = array('label'=>'รุ่น', 'key' => 'name');
    $a[] = array('label'=>'ขนาดเครื่องยนต์', 'key' => 'cc', 'unit'=>'cc');
    $a[] = array('label'=>'ปีที่ผลิต', 'key' => 'mfy');
    $a[] = array('label'=>'ราคาขาย', 'key' => 'price', 'type'=>'price', 'unit'=>'บาท');
    // $a[] = array('label'=>'คงเหลือ', 'key' =>'balance');

    ?>
    <section class="mbl">
        <header class="clearfix">
            <h2 class="title">ข้อมูลสินค้า</h2>
            <?php if( !empty($this->permit['stocks']['edit']) ) { ?>
            <a class="btn-icon btn-edit" data-plugins="dialog" href="<?=URL?>products/edit/<?=$this->item['id']?>"><i class="icon-pencil"></i></a>
            <?php } ?>
        </header>

        <table cellspacing="0"><tbody><?php

            foreach ($a as $key => $value) {

                if( empty($this->item[ $value['key'] ]) ) continue;

                $type = !empty($value['type']) ? $value['type']:'text';
                $unit = !empty($value['unit']) ?' <span class="mls fcg">'.$value['unit'].'</span>':'';

                $val = trim($this->item[ $value['key'] ]);

                if( $type=='price' ){
                    $val = number_format($val, 0);
                }

                echo '<tr>'.
                    '<td class="label">'.$value['label'].'</td>'.
                    '<td class="data">'.$val.$unit.'</td>'.
                '</tr>';
            }
            ?>
        </tbody></table>

    </section>
</div>