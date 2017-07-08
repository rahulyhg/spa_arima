<div class="pll mhl mtl">
<ul class="uiList settingsList">
    <?php foreach ($list as $key => $value) {

        $class = '';
        
        if( $this->section == $value['section'] ){
            $class .= !empty($class) ? ' ':'';
            $class .= 'openPanel';
        }
        
     ?>
    <li class="<?=$class?>">
        <div class="clearfix settingsListLink hidden_elem">
            <div class="label"><?=$value['label']?></div>
        </div>
        <div class="content">
            <?php 
                if( $this->section == 'masseuse' && !empty($this->id) ){
                    require "sections/position.php";
                }
                else{
                	require "sections/{$value['section']}.php";
                }
            ?>
        </div>
    </li>
    <?php } ?>
</ul>
</div>