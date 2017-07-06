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
                if( $this->section == $value['section'] && empty($this->id) ){
                    require "sections/{$value['section']}.php";
                }
                elseif( $this->section == 'masseuse' ){
                	require "sections/lists.php";
                }
            ?>
        </div>
    </li>
    <?php } ?>
</ul>
</div>