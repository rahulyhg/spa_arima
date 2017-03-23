<div class="profile-resume">
    <?php

    $a = array();
    $a[] = array('label'=>'รุ่น', 'key' => 'name');
    // $a[] = array('label'=>'คงเหลือ', 'key' =>'balance');
    ?>
    <section class="mbl">
        <header class="clearfix">
            <h2 class="title">ข้อมูลสินค้า</h2>
            <a class="btn-icon btn-edit" data-plugins="dialog" href="<?=URL?>models/edit/<?=$this->item['id']?>"><i class="icon-pencil"></i></a>
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

            echo '<tr>'.
                    '<td class="label">สี</td>'.
                    '<td class="data"><ul class="ui-lists-color">';

            foreach ($this->color as $val) {
                echo '<li data-plugins="tooltip" data-options="'.$this->fn->stringify(array('text'=>$val['name'], 'reload'=>1)).'" style="background-color:'.$val['primary'].'"></li>';
            }

            echo '</td></ul>';
            echo '</tr>';
            ?>
        </tbody></table>

    </section>
</div>