

<div style="top: 80px;left: 40px;bottom: 40px; position: fixed;background-color: #fff;border:2px solid #000;width: 950px;height: 600px">
	
	<div style="height: 100%;border-left: 2px solid #000;top: 0;position: absolute;left: 15%;width: 378px">
		
		<?php for ($i=0; $i < 8; $i++) { 

			$top = (60*$i) + 50;
			?>
			
			<div style="position: absolute;top:<?=$top?>px;left: 0;background-color: #eee;height: 50px;width: 60px;border: 1px solid #111;border-left: none;"></div>
		<?php } ?>

		<div style="position: absolute;top: 6px;right: 0;">
		<?php for ($i=0; $i < 8; $i++) { 

			$top = (60*$i);
			?>
			
			<div style="position: absolute;top:<?=$top?>px;right: 0;background-color: #eee;height: 50px;width: 60px;border: 1px solid #111;border-right: none;"></div>
		<?php } ?>
		</div>

		<div style="border-bottom: 2px solid #000;position: absolute;height: 80%;top: 0;right: 0;width: 230px">
			
			<div style="position: absolute;bottom: 0;left: 10px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;border-bottom: none;"></div>

			<div style="position: absolute;bottom: 0;left: 85px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;border-bottom: none;"></div>
		</div>


		<div style="position: absolute;top: 20%;left: 30%;width: 150px;height: 150px">
			
			<div style="position: absolute;top: 0;left: 10px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>

			<div style="position: absolute;top: 0;left: 85px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>

			<div style="position: absolute;bottom: 0;left: 10px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>

			<div style="position: absolute;bottom: 0;left: 85px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>
		</div>

	</div>


	<div style="width: 200px; height: 80%;border:2px solid #000;border-top:none;  top: 0;position: absolute;left: 55%">
		
		<div style="height: 50%;border-bottom: 2px solid #000;top: 0;position: absolute;left: 0;right: 0">
			
			
			<div style="position: absolute;top: 5px;left: 20px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>

			<div style="position: absolute;top: 5px;right: 20px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>

			<div style="position: absolute;bottom: 5px;left: 20px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>

			<div style="position: absolute;bottom: 5px;right: 20px;background-color: #eee;height: 60px;width: 50px;border: 1px solid #111;"></div>
		


		</div>

	</div>


	<div style="width: 100px; height: 80%;border:2px solid #000;border-top:none; border-right: none; top: 0;position: absolute;right: 0"></div>
</div>