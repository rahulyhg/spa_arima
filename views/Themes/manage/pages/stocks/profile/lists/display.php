<?php

require 'init.php';

?><div data-load="<?=$this->getURL?>" class="SettingCol offline">

<?php require 'head.php'; ?>

<div class="SettingCol-main">
	<div class="SettingCol-tableHeader"><div class="SettingCol-contentInner">
	<?php require 'tableHeader.php'; echo $tabletitle; ?>
	</div></div>
	<div class="SettingCol-contentInner">
	<div class="SettingCol-tableBody"></div>
	<div class="SettingCol-tableEmpty empty">
		<div class="empty-loader">
			<div class="empty-loader-icon loader-spin-wrap"><div class="loader-spin"></div></div>
			<div class="empty-loader-text">กำลังโหลด...</div>
		</div>
		<div class="empty-error">
			<div class="empty-icon"><i class="icon-link"></i></div>
			<div class="empty-title">การเชื่อมต่อเกิดข้อผิดพลาด</div>
		</div>

		<div class="empty-text">
			<div class="empty-icon"><i class="icon-car"></i></div>
			<div class="empty-title">ไม่พบผลลัพธ์</div>
		</div>
	</div>
	</div>
</div>

</div>