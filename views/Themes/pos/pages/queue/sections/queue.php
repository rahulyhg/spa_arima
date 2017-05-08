
<div class="queue-wrap pal" style="padding-top:90px" data-plugins="jopQueue">

<div style="position: fixed;top: 53px;
left: 0;right: 16px;background-color: rgba(245,248,250,.98);z-index: 100;"><div class="ptl pbs clearfix" style="padding-left: 50px;padding-right: 50px">

		<form action="<?=URL?>job_queue">
			<table>
				<tr>
					<td>
						<input type="text" class="inputtext input-search" maxlength="100" placeholder="Check In" style="background-color: #fff">
					</td>
					<td>
						<button class="btn btn-blue">Check In</button>
					</td>
					<td style="width: 100%"></td>
				</tr>
			</table>
		</form>


	</div>
</div>
<div class="tac">
<ul class="ui-list ui-list-queue" ref="listsbox"><?php 

	foreach ($this->lists['lists'] as $key => $value) { 

		$code = is_numeric($value['code'])
			? round($value['code'])
			: $value['code'];

		$name = !empty($value['nickname'])
			? $value['nickname']
			: $value['first_name'];

	?><li><div class="inner">
		<div class="number"><?= $code ?></div>
		<div class="box"><div class="box-inner">
			<div class="avatar no-avatar"><div class="initials"><?=$code?></div></div>

			<div class="box-content">
				<!-- <h3>101</h3> -->
				<div class="name"><?=$name?></div>
			</div>
			
		</div></div>
	</div></li><?php 
	} 
?></ul>
</div>
</div>