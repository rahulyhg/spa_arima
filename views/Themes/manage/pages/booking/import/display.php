<div class="mal pal">
<form rel="async" action="<?=URL?>booking/import" method="post" enctype="multipart/form-data">
	<input type="file" name="file1">
	<button type="submit" class="btn">Import</button> 
</form>
</div>

<?php 

if( !empty( $this->data ) ) { 

	print_r($this->data);
} ?>