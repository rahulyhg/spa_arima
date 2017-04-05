<?php

$url = URL .'models/';


?><div class="pal"><div class="setting-header cleafix">

<div class="rfloat">
	<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span>Add New</span></a></span>
</div>

<div class="setting-title">Models</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name">Model</th>
			<th class="email tal">สี</th>
			<th class="status">คงเหลือ</th>
			<th class="actions"></th>
		</tr>

		<?php foreach ($this->data['lists'] as $key => $item) {
    //print_r($item); die;
                     $image = '';
        if( !empty($item['image_url']) ){
            $image = '<div class="lfloat mrm"><img class="img" src="'.$item['image_url'].'"style="width: 114px;margin-top:-9px"></div>';
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-car"></i></div></div>';
        }

                    
                    ?>
		<tr>

			<td class="name">
                             <?=$image ?>
				<h3><?=$item['name']?></h3>
				<div class="fsm fcg">
                                   
					<span><?=$item['brand_name']?></span> · <span><?=$item['dealer_name']?></span>
				</div>
			</td>

			<td class="email whitespace"><?php 

			echo '<ul class="ui-lists-color">';

			foreach ($item['colors'] as $val) {
				echo '<li data-plugins="tooltip" data-options="'.$this->fn->stringify(array('text'=>$val['name'], 'reload'=>1)).'" style="background-color:'.$val['primary'].'"></li>';
			}

			echo '</ul>';

			?></td>

			<td class="status"><?= $item['amount_balance']==0 ? '-': $item['amount_balance']?></td>
			
			<td class="actions whitespace">
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a>
				</span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>
</div>