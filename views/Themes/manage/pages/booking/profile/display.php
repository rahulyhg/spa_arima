<?php

require 'init.php';

?><div id="mainContainer" class="profile clearfix" data-plugins="main"><div id="customer-profile">
	<?php require 'left/display.php'; ?>

	<div role="content" class="has-toolbar" data-plugins="tab">
		
		<div role="toolbar"><?php include "toolbar/display.php"; ?></div>
		<!-- End: toolbar -->

		<div role="main"><div class="profile-content"><?php include "main/display.php"; ?></div></div>
		<!-- end: main -->

		<div role="footer" class="ProfileContent_footer">
			<div class="pvm phl mhm clearfix">
				<div class="lfloat">
					<div class="fsm fcg">
						<div>แก้ข้อมูลล่าสุด: <?=$this->fn->q('time')->live( $this->item['updated'] )?></div>
						<!-- <div>โดย..</div> -->
					</div>
				</div>
				<div class="rfloat hidden_elem">
					<div class="group-btn"><a class="btn"><i class="icon-print mrs"></i>Print</a><a class="btn" data-plugins="dropdown" data-options="<?=$this->fn->stringify( array(
                    'select' => array( 0=> 
                        //   array(
                        //     'text' => 'พิมพ์ใบสรุปค่าใช้จ่าย',
                        //     // 'href' => URL.'customers/status/'.$this->item['id'],
                        //     'attr' => array('data-plugins'=>'dialog'),
                        // ),
                         array(
                            'text' => 'พิมพ์ใบขออนุมัติเปิกป้ายแดง',
                            // 'href' => URL.'customers/status/'.$this->item['id'],
                            'attr' => array('data-plugins'=>'dialog'),
                        ) 
                        // , array( 'type' => 'separator')
                        

                    )
                    ) )?>"><i class="icon-ellipsis-v"></i></a></div>
				</div>
			</div>
		</div>

	</div>
	<!-- end: content -->

</div></div>