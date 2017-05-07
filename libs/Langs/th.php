<?php

class th extends Langs {
	public $data = array();
	
	public function basics($text=null) {

		$data['home'] = 'บ้าน';
		$data['help'] = 'ช่วยเหลือ';
		$data['learn more'] = 'เพิ่มเติม';

		$data['who we are'] = 'เกี่ยวกับเรา';
		$data['products'] = 'สินค้า';
		$data['what we do'] = 'เราทำอะไร';
		$data['where we work'] = 'สินค้าของเรา';
		$data['vision & mission'] = 'วิสัยทัศน์และเป้าหมาย';

		$data['our customers'] = 'ลูกค้า';

		$data['employees'] = 'พนักงาน';

		$data['mr.'] = 'นาย';
		$data['mrs.'] = 'นาง';
		$data['ms.'] = 'น.ส.';

		$str = strtolower($text);
		return !empty($data[$str]) ? $data[$str]: $text;
	}

	
	public function menu($text=null)
	{
		$data['home'] = 'หน้าแรก';
		$data['store'] = 'สินค้า';
		$data['trainer'] = 'เทรนเนอร์';
		$data['catalog'] = 'แค็ตตาล็อก';
		$data['articles'] = 'บทความ';
		$data['products'] = 'สินค้า';
		$data['who we are'] = 'เกี่ยวกับเรา';
		$data['what we do'] = 'เราทำอะไร';
		$data['our customers'] = 'ลูกค้า';
		$data['contact us'] = 'ติดต่อเรา';

		$text = strtolower($text);

		return !empty($data[$text]) ? $data[$text]: $text;
	}

	public function translations()
	{

		$this->_default();
		$this->locations();

		return $this->data;

	}

	private function _default()
	{
		// Button
		$this->data['button'] = array(
			"save"=>"บันทึก",
			"cacel"=>"ยกเลิก",
			"create"=>"สร้าง",
			"login"=>"เข้าสู่ระบบ",
			"post"=>'โพสต์',
			'search' =>'ค้นหา',
			'save' => 'ส่ง'
		);

		// navigation
		$this->data['nav'] = array(
			"home"=> "หน้าแรก",
			"property"=>"อสังหาริมทรัพย์",
			"news"=>"ข่าว/บทความ",
			'help'=>'ช่วยเหลือ',
			"contact_us"=>"ติดต่อเรา",
			"about_us"=>"เกี่ยวกับเรา",
			"place_an_ad"=>"ลงประกาศฟรี",
			'notable' =>'ทำเลเด่น'
		);

		$this->data['logged'] = array(
			"login"=>"เข้าสู่ระบบ",
			"logout"=>"ออกจากระบบ",
			"remember"=>"จำรหัสผ่าน",
			"forgot_your_password?"=>"ลืมรหัสผ่าน", 
			"signup"=>"ลงทะเบียน",
			'email'=>'อีเมล์',
			'password'=>'รหัสผ่าน',
			'first_name'=>'ชื่ิ',
			'last_name'=>'นามสกุล',
			'connect_with_facebook'=>'ดำเนินการต่อด้วย Facebook',
			'log_in_with_facebook'=>'เข้าสู่ระบบผ่านทาง Facebook',
		);

		$this->data['text'] = array(
			'search' =>'ค้นหา',
			'tel'=>"โทรศัพท์",
			'mobile'=>'มือถือ',
			'email'=>'อีเมล์',
			'or'=>'หรือ',
			'share' =>'แชร์',
			'contact_us_at' =>'ติดต่อสอบถาม ได้ที่',
			'audience' =>'จำนวนผู้เข้าชม',
			'now' =>'ตอนนี้',
			'suggest'=>'แนะนำ',
			'more'=>'เพิ่มเติม'
		);

		$this->data['link'] = array(
			'settings' =>'ตั้งค่าบัญชีผู้ใช้',
			'manage' =>'จัดการระบบ',
			'share_to_facebook' =>'',
			
		);

		$this->data['property'] = array(
			'price' =>'ราคา',
			'sale'=>'ขาย',
			'rent'=>'ให้เช่า',
			'details' =>'Details',
			'nearby_places' =>'Nearby Places',
			'features'=>'Features',
			'service'=>'Service',

			'inputtextSearch' => 'รหัสสินทรัพย์, ชื่อโครงการ...', 

			'select' => array(
				'prices' => array(
					0 => 'ทุกช่วงราคา',
					'ต่ำกว่า 1 ล้านบาท',
					'1-2 ล้านบาท',
					'2-3 ล้านบาท',
					'3-5 ล้านบาท',
					'5-7 ล้านบาท',
					'7-10 ล้านบาท',
					'10-15 ล้านบาท',
					'มากกว่า 15 ล้านบาท',
				),
				'area' => array(
					0=> 'ขนาดพื้นที่: ทั้งหมด',
					'1-50 ตร.ว.',
					'51-100 ตร.ว.',
					'101-200 ตร.ว.',
					'201-400 ตร.ว.',
					'401-1,000 ตร.ว.',
					'1,001-5,000 ตร.ว.',
				)
			),

			'category' => array(
				'choose'=>'เลือกประเภท: ทั้งหมด',

				'residence' => 'ที่อยู่อาศัย',
					'condominium'=> 'คอนโดมิเนียม',
					'detached_house' => 'บ้านเดี่ยว',
					'detached_houses'=> 'บ้านแฝด',
					'townhomes'=> 'ทาวน์เฮ้าส์, ทาวน์โฮม',
					'apartments'=> 'อพาร์ตเมนท์',
					'hotel' => 'โรงแรม',
					'dorm'=> 'หอพัก',
					'land'=> 'ที่ดินเปล่า',

				'commercial' => 'เชิงพาณิชย์',
					'commercial_building' => 'ตึกแถว/อาคารพาณิชย์',
					'agricultural_garden'=> 'สวนเกษตร',
					'factory'=> 'โรงงาน/โกดัง',
					'office'=> 'สำนักงาน',
					'office_building'=> 'อาคารสำนักงาน',
			)
		);

		$this->data['breadcrumps'] = array(

		);

		$this->data['user'] = array(
			
		);
		
	}

	public function locations()
	{
		
		$locations = array();

		$locations['geography'] = array(
			'north' => 'ภาคเหนือ',
			'central_region' => 'ภาคกลาง',
			'north_east' => 'ภาคตะวันออกเฉียงเหนือ',
			'west' => 'ภาคตะวันตก',
			'east' => 'ภาคตะวันออก',
			'south' => 'ภาคใต้'
		);

		$locations['province'] = array(
			'bangkok' => 'กรุงเทพมหานคร ',
			'samut_prakan' => 'สมุทรปราการ ',
			'nonthaburi' => 'นนทบุรี ',
			'pathum_thani' => 'ปทุมธานี ',
			'phra_nakhon_si_ayutthaya' => 'พระนครศรีอยุธยา ',
			'ang_thong' => 'อ่างทอง ',
			'loburi' => 'ลพบุรี ',
			'sing_buri' => 'สิงห์บุรี ',
			'chai_nat' => 'ชัยนาท ',
			'saraburi' => 'สระบุรี',
			'chon_buri' => 'ชลบุรี ',
			'rayong' => 'ระยอง ',
			'chanthaburi' => 'จันทบุรี ',
			'trat' => 'ตราด ',
			'chachoengsao' => 'ฉะเชิงเทรา ',
			'prachin_buri' => 'ปราจีนบุรี ',
			'nakhon_nayok' => 'นครนายก ',
			'sa_kaeo' => 'สระแก้ว ',
			'nakhon_ratchasima' => 'นครราชสีมา ',
			'buri_ram' => 'บุรีรัมย์ ',
			'surin' => 'สุรินทร์ ',
			'si_sa_ket' => 'ศรีสะเกษ ',
			'ubon_ratchathani' => 'อุบลราชธานี ',
			'yasothon' => 'ยโสธร ',
			'chaiyaphum' => 'ชัยภูมิ ',
			'amnat_charoen' => 'อำนาจเจริญ ',
			'nong_bua_lam_phu' => 'หนองบัวลำภู ',
			'khon_kaen' => 'ขอนแก่น ',
			'udon_thani' => 'อุดรธานี ',
			'loei' => 'เลย ',
			'nong_khai' => 'หนองคาย ',
			'maha_sarakham' => 'มหาสารคาม ',
			'roi_et' => 'ร้อยเอ็ด ',
			'kalasin' => 'กาฬสินธุ์ ',
			'sakon_nakhon' => 'สกลนคร ',
			'nakhon_phanom' => 'นครพนม ',
			'mukdahan' => 'มุกดาหาร ',
			'chiang_mai' => 'เชียงใหม่ ',
			'lamphun' => 'ลำพูน ',
			'lampang' => 'ลำปาง ',
			'uttaradit' => 'อุตรดิตถ์ ',
			'phrae' => 'แพร่ ',
			'nan' => 'น่าน ',
			'phayao' => 'พะเยา ',
			'chiang_rai' => 'เชียงราย ',
			'mae_hong_son' => 'แม่ฮ่องสอน ',
			'nakhon_sawan' => 'นครสวรรค์ ',
			'uthai_thani' => 'อุทัยธานี ',
			'kamphaeng_phet' => 'กำแพงเพชร ',
			'tak' => 'ตาก ',
			'sukhothai' => 'สุโขทัย ',
			'phitsanulok' => 'พิษณุโลก ',
			'phichit' => 'พิจิตร ',
			'phetchabun' => 'เพชรบูรณ์ ',
			'ratchaburi' => 'ราชบุรี ',
			'kanchanaburi' => 'กาญจนบุรี ',
			'suphan_buri' => 'สุพรรณบุรี ',
			'nakhon_pathom' => 'นครปฐม ',
			'samut_sakhon' => 'สมุทรสาคร ',
			'samut_songkhram' => 'สมุทรสงคราม ',
			'phetchaburi' => 'เพชรบุรี ',
			'prachuap_khiri_khan' => 'ประจวบคีรีขันธ์ ',
			'nakhon_si_thammarat' => 'นครศรีธรรมราช ',
			'krabi' => 'กระบี่ ',
			'phangnga' => 'พังงา ',
			'phuket' => 'ภูเก็ต ',
			'surat_thani' => 'สุราษฎร์ธานี ',
			'ranong' => 'ระนอง ',
			'chumphon' => 'ชุมพร ',
			'songkhla' => 'สงขลา ',
			'satun' => 'สตูล ',
			'trang' => 'ตรัง ',
			'phatthalung' => 'พัทลุง ',
			'pattani' => 'ปัตตานี ',
			'yala' => 'ยะลา ',
			'narathiwat' => 'นราธิวาส ',
			'buogkan' => 'บึงกาฬ',
		);


		$locations['amphur'] = array(
			'khet_phra_nakhon' => 'เขตพระนคร',
			'khet_dusit' =>'เขตดุสิต',
			'khet_nong_chok' =>'เขตหนองจอก',
			'khet_bang_rak' =>'เขตบางรัก',
			'khet_bang_khen' =>'เขตบางเขน',
			'khet_bang_kapi' =>'เขตบางกะปิ',
			'khet_pathum_wan' =>'เขตปทุมวัน',
			'khet_pom_prap_sattru_phai' =>'เขตป้อมปราบศัตรูพ่าย',
			'khet_phra_khanong' =>'เขตพระโขนง',
			'khet_min_buri' =>'เขตมีนบุรี',
			'khet_lat_krabang' =>'เขตลาดกระบัง',
			'khet_yan_nawa' =>'เขตยานนาวา',
			'khet_samphanthawong' =>'เขตสัมพันธวงศ์',
			'khet_phaya_thai' =>'เขตพญาไท',
			'khet_thon_buri' =>'เขตธนบุรี',
			'khet_bangkok_yai' =>'เขตบางกอกใหญ่',
			'khet_huai_khwang' =>'เขตห้วยขวาง',
			'khet_khlong_san' =>'เขตคลองสาน',
			'khet_taling_chan' =>'เขตตลิ่งชัน',
			'khet_bangkok_noi' =>'เขตบางกอกน้อย',
			'khet_bang_khun_thian' =>'เขตบางขุนเทียน',
			'khet_phasi_charoen' =>'เขตภาษีเจริญ',
			'khet_nong_khaem' =>'เขตหนองแขม',
			'khet_rat_burana' =>'เขตราษฎร์บูรณะ',
			'khet_bang_phlat' =>'เขตบางพลัด',
			'khet_din_daeng' =>'เขตดินแดง',
			'khet_bueng_kum' =>'เขตบึงกุ่ม',
			'khet_sathon' =>'เขตสาทร',
			'khet_bang_sue' =>'เขตบางซื่อ',
			'khet_chatuchak' =>'เขตจตุจักร',
			'khet_bang_kho_laem' =>'เขตบางคอแหลม',
			'khet_prawet' =>'เขตประเวศ',
			'khet_khlong_toei' =>'เขตคลองเตย',
			'khet_suan_luang' =>'เขตสวนหลวง',
			'khet_chom_thong' =>'เขตจอมทอง',
			'khet_don_mueang' =>'เขตดอนเมือง',
			'khet_ratchathewi' =>'เขตราชเทวี',
			'khet_lat_phrao' =>'เขตลาดพร้าว',
			'khet_watthana' =>'เขตวัฒนา',
			'khet_bang_khae' =>'เขตบางแค',
			'khet_lak_si' =>'เขตหลักสี่',
			'khet_sai_mai' =>'เขตสายไหม',
			'khet_khan_na_yao' =>'เขตคันนายาว',
			'khet_saphan_sung' =>'เขตสะพานสูง',
			'khet_wang_thonglang' =>'เขตวังทองหลาง',
			'khet_khlong_sam_wa' =>'เขตคลองสามวา',
			'khet_bang_na' =>'เขตบางนา',
			'khet_thawi_watthana' =>'เขตทวีวัฒนา',
			'khet_thung_khru' =>'เขตทุ่งครุ',
			'khet_bang_bon' =>'เขตบางบอน',
			'mueang_samut_prakan' =>'เมืองสมุทรปราการ',
			'bang_bo' =>'บางบ่อ',
			'bang_phli' =>'บางพลี',
			'phra_pradaeng' =>'พระประแดง',
			'phra_samut_chedi' =>'พระสมุทรเจดีย์',
			'bang_sao_thong' =>'บางเสาธง',
			'mueang_nonthaburi' =>'เมืองนนทบุรี',
			'bang_kruai' =>'บางกรวย',
			'bang_yai' =>'บางใหญ่',
			'bang_bua_thong' =>'บางบัวทอง',
			'sai_noi' =>'ไทรน้อย',
			'pak_kret' =>'ปากเกร็ด',
			'mueang_pathum_thani' =>'เมืองปทุมธานี',
			'khlong_luang' =>'คลองหลวง',
			'thanyaburi' =>'ธัญบุรี',
			'nong_suea' =>'หนองเสือ',
			'lat_lum_kaeo' =>'ลาดหลุมแก้ว',
			'lam_luk_ka' =>'ลำลูกกา',
			'sam_khok' =>'สามโคก',
			'phra_nakhon_si_ayutthaya' =>'พระนครศรีอยุธยา',
			'tha_ruea' =>'ท่าเรือ',
			'nakhon_luang' =>'นครหลวง',
			'bang_sai' =>'บางไทร',
			'bang_ban' =>'บางบาล',
			'bang_pa_in' =>'บางปะอิน',
			'bang_pahan' =>'บางปะหัน',
			'phak_hai' =>'ผักไห่',
			'phachi' =>'ภาชี',
			'lat_bua_luang' =>'ลาดบัวหลวง',
			'wang_noi' =>'วังน้อย',
			'sena' =>'เสนา',
			'bang_sai' =>'บางซ้าย',
			'uthai' =>'อุทัย',
			'maha_rat' =>'มหาราช',
			'ban_phraek' =>'บ้านแพรก',
			'mueang_ang_thong' =>'เมืองอ่างทอง',
			'chaiyo' =>'ไชโย',
			'pa_mok' =>'ป่าโมก',
			'pho_thong' =>'โพธิ์ทอง',
			'sawaeng_ha' =>'แสวงหา',
			'wiset_chai_chan' =>'วิเศษชัยชาญ',
			'samko' =>'สามโก้',
			'mueang_lop_buri' =>'เมืองลพบุรี',
			'phatthana_nikhom' =>'พัฒนานิคม',
			'khok_samrong' =>'โคกสำโรง',
			'chai_badan' =>'ชัยบาดาล',
			'tha_wung' =>'ท่าวุ้ง',
			'ban_mi' =>'บ้านหมี่',
			'tha_luang' =>'ท่าหลวง',
			'sa_bot' =>'สระโบสถ์',
			'khok_charoen' =>'โคกเจริญ',
			'lam_sonthi' =>'ลำสนธิ',
			'nong_muang' =>'หนองม่วง',
			'mueang_sing_buri' =>'เมืองสิงห์บุรี',
			'bang_rachan' =>'บางระจัน',
			'khai_bang_rachan' =>'ค่ายบางระจัน',
			'phrom_buri' =>'พรหมบุรี',
			'tha_chang' =>'ท่าช้าง',
			'in_buri' =>'อินทร์บุรี',
			'mueang_chai_nat' =>'เมืองชัยนาท',
			'manorom' =>'มโนรมย์',
			'wat_sing' =>'วัดสิงห์',
			'sapphaya' =>'สรรพยา',
			'sankhaburi' =>'สรรคบุรี',
			'hankha' =>'หันคา',
			'nong_mamong' =>'หนองมะโมง',
			'noen_kham' =>'เนินขาม',
			'mueang_saraburi' =>'เมืองสระบุรี',
			'kaeng_khoi' =>'แก่งคอย',
			'nong_khae' =>'หนองแค',
			'wihan_daeng' =>'วิหารแดง',
			'nong_saeng' =>'หนองแซง',
			'ban_mo' =>'บ้านหมอ',
			'don_phut' =>'ดอนพุด',
			'nong_don' =>'หนองโดน',
			'phra_phutthabat' =>'พระพุทธบาท',
			'sao_hai' =>'เสาไห้',
			'muak_lek' =>'มวกเหล็ก',
			'wang_muang' =>'วังม่วง',
			'chaloem_phra_kiat' =>'เฉลิมพระเกียรติ(10-กทม.)',
			'mueang_chon_buri' =>'เมืองชลบุรี',
			'ban_bueng' =>'บ้านบึง',
			'nong_yai' =>'หนองใหญ่',
			'bang_lamung' =>'บางละมุง',
			'phan_thong' =>'พานทอง',
			'phanat_nikhom' =>'พนัสนิคม',
			'si_racha' =>'ศรีราชา',
			'ko_sichang' =>'เกาะสีชัง',
			'sattahip' =>'สัตหีบ',
			'bo_thong' =>'บ่อทอง',
			'ko_chan' =>'เกาะจันทร์',
			'sattahip(bang_sre)' =>'สัตหีบ (สาขาตำบลบางเสร่)',
			'tong_tin_tetsaban_mueang_nong_prue' =>'ท้องถิ่นเทศบาลเมืองหนองปรือ',
			'tetsaban_tambon_lamsabang' =>'เทศบาลตำบลแหลมฉบัง',
			'mueang_chon_buri' =>'เทศบาลเมืองชลบุรี',
			'mueang_rayong' =>'เมืองระยอง',
			'ban_chang' =>'บ้านฉาง',
			'klaeng' =>'แกลง',
			'wang_chan' =>'วังจันทร์',
			'ban_khai' =>'บ้านค่าย',
			'pluak_daeng' =>'ปลวกแดง',
			'khao_chamao' =>'เขาชะเมา',
			'nikhom_phatthana' =>'นิคมพัฒนา',
			'saka_tambon_mabka' =>'สาขาตำบลมาบข่า',
			'mueang_chanthaburi' =>'เมืองจันทบุรี',
			'khlung' =>'ขลุง',
			'tha_mai' =>'ท่าใหม่',
			'pong_nam_ron' =>'โป่งน้ำร้อน',
			'makham' =>'มะขาม',
			'laem_sing' =>'แหลมสิงห์',
			'soi_dao' =>'สอยดาว',
			'kaeng_hang_maeo' =>'แก่งหางแมว',
			'na_yai_am' =>'นายายอาม',
			'khoa_khitchakut' =>'เขาคิชฌกูฏ',
			'king_amphoe_kampud' =>'กิ่ง อ.กำพุธ จ.จันทบุรี',
			'mueang_trat' =>'เมืองตราด',
			'khlong_yai' =>'คลองใหญ่',
			'khao_saming' =>'เขาสมิง',
			'bo_rai' =>'บ่อไร่',
			'laem_ngop' =>'แหลมงอบ',
			'ko_kut' =>'เกาะกูด',
			'ko_chang' =>'เกาะช้าง',
			'mueang_chachoengsao' =>'เมืองฉะเชิงเทรา',
			'bang_khla' =>'บางคล้า',
			'bang_nam_priao' =>'บางน้ำเปรี้ยว',
			'bang_pakong' =>'บางปะกง',
			'ban_pho' =>'บ้านโพธิ์',
			'phanom_sarakham' =>'พนมสารคาม',
			'ratchasan' =>'ราชสาส์น',
			'sanam_chai_khet' =>'สนามชัยเขต',
			'plaeng_yao' =>'แปลงยาว',
			'tha_takiap' =>'ท่าตะเกียบ',
			'khlong_khuean' =>'คลองเขื่อน',
			'mueang_prachin_buri' =>'เมืองปราจีนบุรี',
			'kabin_buri' =>'กบินทร์บุรี',
			'na_di' =>'นาดี',
			'sa_kaeo' =>'สระแก้ว',
			'wang_nam_yen' =>'วังน้ำเย็น',
			'ban_sang' =>'บ้านสร้าง',
			'prachantakham' =>'ประจันตคาม',
			'si_maha_phot' =>'ศรีมหาโพธิ',
			'si_mahosot' =>'ศรีมโหสถ',
			'aranyaprathet' =>'อรัญประเทศ',
			'ta_phraya' =>'ตาพระยา',
			'watthana_nakhon' =>'วัฒนานคร',
			'khlong_hat' =>'คลองหาด',
			'mueang_nakhon_nayok' =>'เมืองนครนายก',
			'pak_phli' =>'ปากพลี',
			'ban_na' =>'บ้านนา',
			'ongkharak' =>'องครักษ์',
			'mueang_sa_kaeo' =>'เมืองสระแก้ว',
			'khlong_hat' =>'คลองหาด',
			'ta_phraya' =>'ตาพระยา',
			'wang_nam_yen' =>'วังน้ำเย็น',
			'watthana_nakhon' =>'วัฒนานคร',
			'aranyaprathet' =>'อรัญประเทศ',
			'khao_chakan' =>'เขาฉกรรจ์',
			'khok_sung' =>'โคกสูง',
			'wang_sombun' =>'วังสมบูรณ์',
			'mueang_nakhon_ratchasima' =>'เมืองนครราชสีมา',
			'khon_buri' =>'ครบุรี',
			'soeng_sang' =>'เสิงสาง',
			'khong' =>'คง',
			'ban_lueam' =>'บ้านเหลื่อม',
			'chakkarat' =>'จักราช',
			'chok_chai' =>'โชคชัย',
			'dan_khun_thot' =>'ด่านขุนทด',
			'non_thai' =>'โนนไทย',
			'non_sung' =>'โนนสูง',
			'kham_sakaesaeng' =>'ขามสะแกแสง',
			'bua_yai' =>'บัวใหญ่',
			'prathai' =>'ประทาย',
			'pak_thong_chai' =>'ปักธงชัย',
			'phimai' =>'พิมาย',
			'huai_thalaeng' =>'ห้วยแถลง',
			'chum_phuang' =>'ชุมพวง',
			'sung_noen' =>'สูงเนิน',
			'kham_thale_so' =>'ขามทะเลสอ',
			'sikhio' =>'สีคิ้ว',
			'pak_chong' =>'ปากช่อง',
			'nong_bunnak' =>'หนองบุญมาก',
			'kaeng_sanam_nang' =>'แก้งสนามนาง',
			'non_daeng' =>'โนนแดง',
			'wang_nam_khiao' =>'วังน้ำเขียว',
			'thepharak' =>'เทพารักษ์',
			'mueang_yang' =>'เมืองยาง',
			'phra_thong_kham' =>'พระทองคำ',
			'lam_thamenchai' =>'ลำทะเมนชัย',
			'bua_lai' =>'บัวลาย',
			'sida' =>'สีดา',
			'chaloem_phra_kiat' =>'เฉลิมพระเกียรติ(สระบุรี)',
			'pho_krang' =>'ท้องถิ่นเทศบาลตำบลโพธิ์กลาง',
			'ma_ka_pon_songkram' =>'สาขาตำบลมะค่า-พลสงคราม',
			'non_lao' =>'โนนลาว',
			'mueang_buri_ram' =>'เมืองบุรีรัมย์',
			'khu_mueang' =>'คูเมือง',
			'krasang' =>'กระสัง',
			'nang_rong' =>'นางรอง',
			'nong_ki' =>'หนองกี่',
			'lahan_sai' =>'ละหานทราย',
			'prakhon_chai' =>'ประโคนชัย',
			'ban_kruat' =>'บ้านกรวด',
			'phutthaisong' =>'พุทไธสง',
			'lam_plai_mat' =>'ลำปลายมาศ',
			'satuek' =>'สตึก',
			'pakham' =>'ปะคำ',
			'na_pho' =>'นาโพธิ์',
			'nong_hong' =>'หนองหงส์',
			'phlapphla_chai' =>'พลับพลาชัย',
			'huai_rat' =>'ห้วยราช',
			'non_suwan' =>'โนนสุวรรณ',
			'chamni' =>'ชำนิ',
			'ban_mai_chaiyaphot' =>'บ้านใหม่ไชยพจน์',
			'din_daeng' =>'โนนดินแดง',
			'ban_dan' =>'บ้านด่าน',
			'khaen_dong' =>'แคนดง',
			'chaloem_phra_kiat' =>'เฉลิมพระเกียรติ(20-ชลบุรี)',
			'mueang_surin' =>'เมืองสุรินทร์',
			'chumphon_buri' =>'ชุมพลบุรี',
			'tha_tum' =>'ท่าตูม',
			'chom_phra' =>'จอมพระ',
			'prasat' =>'ปราสาท',
			'kap_choeng' =>'กาบเชิง',
			'rattanaburi' =>'รัตนบุรี',
			'sanom' =>'สนม',
			'sikhoraphum' =>'ศีขรภูมิ',
			'sangkha' =>'สังขะ',
			'lamduan' =>'ลำดวน',
			'samrong_thap' =>'สำโรงทาบ',
			'buachet' =>'บัวเชด',
			'phanom_dong_rak' =>'พนมดงรัก',
			'si_narong' =>'ศรีณรงค์',
			'khwao_sinarin' =>'เขวาสินรินทร์',
			'non_narai' =>'โนนนารายณ์',
			'mueang_si_sa_ket' =>'เมืองศรีสะเกษ',
			'yang_chum_noi' =>'ยางชุมน้อย',
			'kanthararom' =>'กันทรารมย์',
			'kantharalak' =>'กันทรลักษ์',
			'khukhan' =>'ขุขันธ์',
			'phrai_bueng' =>'ไพรบึง',
			'prang_ku' =>'ปรางค์กู่',
			'khun_han' =>'ขุนหาญ',
			'rasi_salai' =>'ราษีไศล',
			'uthumphon_phisai' =>'อุทุมพรพิสัย',
			'bueng_bun' =>'บึงบูรพ์',
			'huai_thap_than' =>'ห้วยทับทัน',
			'non_khun' =>'โนนคูณ',
			'si_rattana' =>'ศรีรัตนะ',
			'si_rattana' =>'น้ำเกลี้ยง',
			'wang_hin' =>'วังหิน',
			'phu_sing' =>'ภูสิงห์',
			'mueang_chan' =>'เมืองจันทร์',
			'benchalak' =>'เบญจลักษ์',
			'phayu' =>'พยุห์',
			'pho_si_suwan' =>'โพธิ์ศรีสุวรรณ',
			'sila_lat' =>'ศิลาลาด',
			'mueang_ubon_ratchathani' =>'เมืองอุบลราชธานี',
			'si_mueang_mai' =>'ศรีเมืองใหม่',
			'khong_chiam' =>'โขงเจียม',
			'khueang_nai' =>'เขื่องใน',
			'khemarat' =>'เขมราฐ',
			'shanuman' =>'ชานุมาน',
			'det_udom' =>'เดชอุดม',
			'na_chaluai' =>'นาจะหลวย',
			'nam_yuen' =>'น้ำยืน',
			'buntharik' =>'บุณฑริก',
			'trakan_phuet_phon' =>'ตระการพืชผล',
			'kut_khaopun' =>'กุดข้าวปุ้น',
			'phana' =>'พนา',
			'muang_sam_sip' =>'ม่วงสามสิบ',
			'warin_chamrap' =>'วารินชำราบ',
			'amnat_charoen' =>'อำนาจเจริญ',
			'senangkhanikhom' =>'เสนางคนิคม',
			'hua_taphan' =>'หัวตะพาน',
			'phibun_mangsahan' =>'พิบูลมังสาหาร',
			'tan_sum' =>'ตาลสุม',
			'pho_sai' =>'โพธิ์ไทร',
			'samrong' =>'สำโรง',
			'king_amphoe_lue_amnat' =>'กิ่งอำเภอลืออำนาจ',
			'don_mot_daeng' =>'ดอนมดแดง',
			'sirindhorn' =>'สิรินธร',
			'thung_si_udom' =>'ทุ่งศรีอุดม',
			'pathum_ratchawongsa' =>'ปทุมราชวงศา',
			'king_amphoe_sri_lunk_chai' =>'กิ่งอำเภอศรีหลักชัย',
			'na_yia' =>'นาเยีย',
			'na_tan' =>'นาตาล',
			'lao_suea_kok' =>'เหล่าเสือโก้ก',
			'sawang_wirawong' =>'สว่างวีระวงศ์',
			'nam_khun' =>'น้ำขุ่น',
			'suwan_wari' =>'อ.สุวรรณวารี จ.อุบลราชธานี',
			'mueang_yasothon' =>'เมืองยโสธร',
			'sai_mun' =>'ทรายมูล',
			'kut_chum' =>'กุดชุม',
			'kham_khuean_kaeo' =>'คำเขื่อนแก้ว',
			'pa_tio' =>'ป่าติ้ว',
			'maha_chana_chai' =>'มหาชนะชัย',
			'kho_wang' =>'ค้อวัง',
			'loeng_nok_tha' =>'เลิงนกทา',
			'thai_charoen' =>'ไทยเจริญ',
			'mueang_chaiyaphum' =>'เมืองชัยภูมิ',
			'ban_khwao' =>'บ้านเขว้า',
			'khon_sawan' =>'คอนสวรรค์',
			'kaset_sombun' =>'เกษตรสมบูรณ์',
			'nong_bua_daeng' =>'หนองบัวแดง',
			'chatturat' =>'จัตุรัส',
			'bamnet_narong' =>'บำเหน็จณรงค์',
			'nong_bua_rawe' =>'หนองบัวระเหว',
			'thep_sathit' =>'เทพสถิต',
			'phu_khiao' =>'ภูเขียว',
			'ban_thaen' =>'บ้านแท่น',
			'kaeng_khro' =>'แก้งคร้อ',
			'khon_san' =>'คอนสาร',
			'phakdi_chumphon' =>'ภักดีชุมพล',
			'noen_sa_nga' =>'เนินสง่า',
			'sap_yai' =>'ซับใหญ่',
			'mueang_chaiyaphum(non_sumran)' =>'เมืองชัยภูมิ (สาขาตำบลโนนสำราญ)',
			'ban_wha_tao' =>'สาขาตำบลบ้านหว่าเฒ่า',
			'nong_bua_daeng' =>'หนองบัวแดง (สาขาตำบลวังชมภู)',
			'king_amphoe_sap_yai' =>'กิ่งอำเภอซับใหญ่ (สาขาตำบลซับใหญ่)',
			'coke_phet' =>'สาขาตำบลโคกเพชร',
			'thep_sathit' =>'เทพสถิต (สาขาตำบลนายางกลัก)',
			'ban_thaen' =>'บ้านแท่น (สาขาตำบลบ้านเต่า)',
			'kaeng_khro' =>'แก้งคร้อ (สาขาตำบลท่ามะไฟหวาน)',
			'khon_san' =>'คอนสาร (สาขาตำบลโนนคูณ)',
			'mueang_amnat_charoen' =>'เมืองอำนาจเจริญ',
			'chanuman' =>'ชานุมาน',
			'pathum_ratchawongsa' =>'ปทุมราชวงศา',
			'phana' =>'พนา',
			'senangkhanikhom' =>'เสนางคนิคม',
			'hua_taphan' =>'หัวตะพาน',
			'lue_amnat' =>'ลืออำนาจ',
			'mueang_nong_bua_lam_phu' =>'เมืองหนองบัวลำภู',
			'na_klang' =>'นากลาง',
			'non_sang' =>'โนนสัง',
			'si_bun_rueang' =>'ศรีบุญเรือง',
			'suwannakhuha' =>'สุวรรณคูหา',
			'na_wang' =>'นาวัง',
			'mueang_khon_kaen' =>'เมืองขอนแก่น',
			'ban_fang' =>'บ้านฝาง',
			'phra_yuen' =>'พระยืน',
			'nong_ruea' =>'หนองเรือ',
			'chum_phae' =>'ชุมแพ',
			'si_chomphu' =>'สีชมพู',
			'nam_phong' =>'น้ำพอง',
			'ubolratana' =>'อุบลรัตน์',
			'kranuan' =>'กระนวน',
			'ban_phai' =>'บ้านไผ่',
			'pueai_noi' =>'เปือยน้อย',
			'phon' =>'พล',
			'waeng_yai' =>'แวงใหญ่',
			'waeng_noi' =>'แวงน้อย',
			'nong_song_hong' =>'หนองสองห้อง',
			'phu_wiang' =>'ภูเวียง',
			'mancha_khiri' =>'มัญจาคีรี',
			'chonnabot' =>'ชนบท',
			'khao_suan_kwang' =>'เขาสวนกวาง',
			'phu_pha_man' =>'ภูผาม่าน',
			'sam_sung' =>'ซำสูง',
			'khok_pho_chai' =>'โคกโพธิ์ไชย',
			'nong_na_kham' =>'หนองนาคำ',
			'ban_haet' =>'บ้านแฮด',
			'non_sila' =>'โนนศิลา',
			'wiang_kao' =>'เวียงเก่า',
			'ban_pet' =>'ท้องถิ่นเทศบาลตำบลบ้านเป็ด',
			'tet_saban_tambon_muang_phon' =>'เทศบาลตำบลเมืองพล',
			'mueang_udon_thani' =>'เมืองอุดรธานี',
			'kut_chap' =>'กุดจับ',
			'nong_wua_so' =>'หนองวัวซอ',
			'kumphawapi' =>'กุมภวาปี',
			'non_sa_at' =>'โนนสะอาด',
			'nong_han' =>'หนองหาน',
			'thung_fon' =>'ทุ่งฝน',
			'chai_wan' =>'ไชยวาน',
			'si_that' =>'ศรีธาตุ',
			'wang_sam_mo' =>'วังสามหมอ',
			'ban_dung' =>'บ้านดุง',
			'nong_bua_lam_phu' =>'หนองบัวลำภู',
			'si_bun_rueang' =>'ศรีบุญเรือง',
			'na_klang' =>'นากลาง',
			'suwannakhuha' =>'สุวรรณคูหา',
			'non_sang' =>'โนนสัง',
			'ban_phue' =>'บ้านผือ',
			'nam_som' =>'น้ำโสม',
			'phen' =>'เพ็ญ',
			'sang_khom' =>'สร้างคอม',
			'nong_saeng' =>'หนองแสง',
			'na_yung' =>'นายูง',
			'phibun_rak' =>'พิบูลย์รักษ์',
			'ku_kaeo' =>'กู่แก้ว',
			'rachak_sinlapakhom' =>'ประจักษ์ศิลปาคม',
			'mueang_loei' =>'เมืองเลย',
			'na_duang' =>'นาด้วง',
			'chiang_khan' =>'เชียงคาน',
			'pak_chom' =>'ปากชม',
			'dan_sai' =>'ด่านซ้าย',
			'na_haeo' =>'นาแห้ว',
			'phu_ruea' =>'ภูเรือ',
			'tha_li' =>'ท่าลี่',
			'wang_saphung' =>'วังสะพุง',
			'phu_kradueng' =>'ภูกระดึง',
			'phu_luang' =>'ภูหลวง',
			'pha_khao' =>'ผาขาว',
			'erawan' =>'เอราวัณ',
			'nong_hin' =>'หนองหิน',
			'mueang_nong_khai' =>'เมืองหนองคาย',
			'tha_bo' =>'ท่าบ่อ',
			'mueang_bueng_kan' =>'เมืองบึงกาฬ',
			'phon_charoen' =>'พรเจริญ',
			'phon_phisai' =>'โพนพิสัย',
			'so_phisai' =>'โซ่พิสัย',
			'si_chiang_mai' =>'ศรีเชียงใหม่',
			'sangkhom' =>'สังคม',
			'seka' =>'เซกา',
			'pak_khat' =>'ปากคาด',
			'bueng_khong_long' =>'บึงโขงหลง',
			'si_wilai' =>'ศรีวิไล',
			'bung_khla' =>'บุ่งคล้า',
			'sakhrai' =>'สระใคร',
			'fao_rai' =>'เฝ้าไร่',
			'rattanawapi' =>'รัตนวาปี',
			'pho_tak' =>'โพธิ์ตาก',
			'mueang_maha_sarakham' =>'เมืองมหาสารคาม',
			'kae_dam' =>'แกดำ',
			'kosum_phisai' =>'โกสุมพิสัย',
			'kantharawichai' =>'กันทรวิชัย',
			'kantharawichai' =>'เชียงยืน',
			'borabue' =>'บรบือ',
			'na_chueak' =>'นาเชือก',
			'phayakkhaphum_phisai' =>'พยัคฆภูมิพิสัย',
			'wapi_pathum' =>'วาปีปทุม',
			'na_dun' =>'นาดูน',
			'yang_sisurat' =>'ยางสีสุราช',
			'kut_rang' =>'กุดรัง',
			'chuen_chom' =>'ชื่นชม',
			'lub' =>'หลุบ',
			'mueang_roi_et' =>'เมืองร้อยเอ็ด',
			'kaset_wisai' =>'เกษตรวิสัย',
			'pathum_rat' =>'ปทุมรัตต์',
			'chaturaphak_phiman' =>'จตุรพักตรพิมาน',
			'thawat_buri' =>'ธวัชบุรี',
			'phanom_phrai' =>'พนมไพร',
			'phon_thong' =>'โพนทอง',
			'pho_chai' =>'โพธิ์ชัย',
			'nong_phok' =>'หนองพอก',
			'selaphum' =>'เสลภูมิ',
			'suwannaphum' =>'สุวรรณภูมิ',
			'mueang_suang' =>'เมืองสรวง',
			'phon_sai' =>'โพนทราย',
			'at_samat' =>'อาจสามารถ',
			'moei_wadi' =>'เมยวดี',
			'si_somdet' =>'ศรีสมเด็จ',
			'changhan' =>'จังหาร',
			'chiang_khwan' =>'เชียงขวัญ',
			'nong_hi' =>'หนองฮี',
			'thung_khao_luangกิ่' =>'ทุ่งเขาหลวง',
			'mueang_kalasin' =>'เมืองกาฬสินธุ์',
			'na_mon' =>'นามน',
			'kamalasai' =>'กมลาไสย',
			'rong_kham' =>'ร่องคำ',
			'kuchinarai' =>'กุฉินารายณ์',
			'khao_wong' =>'เขาวง',
			'yang_talat' =>'ยางตลาด',
			'huai_mek' =>'ห้วยเม็ก',
			'sahatsakhan' =>'สหัสขันธ์',
			'kham_muang' =>'คำม่วง',
			'tha_khantho' =>'ท่าคันโท',
			'nong_kung_si' =>'หนองกุงศรี',
			'somdet' =>'สมเด็จ',
			'huai_phueng' =>'ห้วยผึ้ง',
			'sam_chai' =>'สามชัย',
			'na_khu' =>'นาคู',
			'don_chan' =>'ดอนจาน',
			'khong_chai' =>'ฆ้องชัย',
			'mueang_sakon_nakhon' =>'เมืองสกลนคร',
			'kusuman' =>'กุสุมาลย์',
			'kut_bak' =>'กุดบาก',
			'phanna_nikhom' =>'พรรณานิคม',
			'phang_khon' =>'พังโคน',
			'waritchaphum' =>'วาริชภูมิ',
			'nikhom_nam_un' =>'นิคมน้ำอูน',
			'wanon_niwat' =>'วานรนิวาส',
			'kham_ta_kla' =>'คำตากล้า',
			'ban_muang' =>'บ้านม่วง',
			'akat_amnuai' =>'อากาศอำนวย',
			'sawang_daen_din' =>'สว่างแดนดิน',
			'song_dao' =>'ส่องดาว',
			'tao_ngoi' =>'เต่างอย',
			'khok_si_suphan' =>'โคกศรีสุพรรณ',
			'charoen_sin' =>'เจริญศิลป์',
			'phon_na_kaeo' =>'โพนนาแก้ว',
			'phu_phan' =>'ภูพาน',
			'wanon_niwat' =>'วานรนิวาส (สาขาตำบลกุดเรือคำ)',
			'banhan' =>'อ.บ้านหัน จ.สกลนคร',
			'mueang_nakhon_phanom' =>'เมืองนครพนม',
			'pla_pak' =>'ปลาปาก',
			'tha_uthen' =>'ท่าอุเทน',
			'ban_phaeng' =>'บ้านแพง',
			'that_phanom' =>'ธาตุพนม',
			'renu_nakhon' =>'เรณูนคร',
			'na_kae' =>'นาแก',
			'si_songkhram' =>'ศรีสงคราม',
			'na_wa' =>'นาหว้า',
			'phon_sawan' =>'โพนสวรรค์',
			'na_thom' =>'นาทม',
			'wang_yang' =>'วังยาง',
			'mueang_mukdahan' =>'เมืองมุกดาหาร',
			'nikhom_kham_soi' =>'นิคมคำสร้อย',
			'don_tan' =>'ดอนตาล',
			'dong_luang' =>'ดงหลวง',
			'khamcha_i' =>'คำชะอี',
			'wan_yai' =>'หว้านใหญ่',
			'nong_sung' =>'หนองสูง',
			'mueang_chiang_mai' =>'เมืองเชียงใหม่',
			'chom_thong' =>'จอมทอง',
			'mae_chaem' =>'แม่แจ่ม',
			'chiang_dao' =>'เชียงดาว',
			'doi_saket' =>'ดอยสะเก็ด',
			'mae_taeng' =>'แม่แตง',
			'mae_rim' =>'แม่ริม',
			'samoeng' =>'สะเมิง',
			'fang' =>'ฝาง',
			'mae_ai' =>'แม่อาย',
			'phrao' =>'พร้าว',
			'san_pa_tong' =>'สันป่าตอง',
			'san_kamphaeng' =>'สันกำแพง',
			'san_sai' =>'สันทราย',
			'hang_dong' =>'หางดง',
			'hot' =>'ฮอด',
			'doi_tao' =>'ดอยเต่า',
			'omkoi' =>'อมก๋อย',
			'saraphi' =>'สารภี',
			'wiang_haeng' =>'เวียงแหง',
			'chai_prakan' =>'ไชยปราการ',
			'mae_wang' =>'แม่วาง',
			'mae_on' =>'แม่ออน',
			'doi_lo' =>'ดอยหล่อ',
			'tet_saban_nakorn_chiangmai(kan_lawi_la)' =>'เทศบาลนครเชียงใหม่ (สาขาแขวงกาลวิละ)',
			'tet_saban_nakorn_chiangmai(sri_wi)' =>'เทศบาลนครเชียงใหม่ (สาขาแขวงศรีวิชั)',
			'tet_saban_nakorn_chiangmai(meng_rai)' =>'เทศบาลนครเชียงใหม่ (สาขาเม็งราย)',
			'mueang_lamphun' =>'เมืองลำพูน',
			'mae_tha' =>'แม่ทา',
			'ban_hong' =>'บ้านโฮ่ง',
			'li' =>'ลี้',
			'thung_hua_chang' =>'ทุ่งหัวช้าง',
			'pa_sang' =>'ป่าซาง',
			'ban_thi' =>'บ้านธิ',
			'wiang_nong_long' =>'เวียงหนองล่อง',
			'mueang_lampang' =>'เมืองลำปาง',
			'mae_mo' =>'แม่เมาะ',
			'ko_kha' =>'เกาะคา',
			'soem_ngam' =>'เสริมงาม',
			'ngao' =>'งาว',
			'chae_hom' =>'แจ้ห่ม',
			'wang_nuea' =>'วังเหนือ',
			'thoen' =>'เถิน',
			'mae_phrik' =>'แม่พริก',
			'mae_tha' =>'แม่ทะ',
			'sop_prap' =>'สบปราบ',
			'hang_chat' =>'ห้างฉัตร',
			'mueang_pan' =>'เมืองปาน',
			'mueang_uttaradit' =>'เมืองอุตรดิตถ์',
			'tron' =>'ตรอน',
			'tha_pla' =>'ท่าปลา',
			'nam_pat' =>'น้ำปาด',
			'fak_tha' =>'ฟากท่า',
			'ban_khok' =>'บ้านโคก',
			'phichai' =>'พิชัย',
			'laplae' =>'ลับแล',
			'thong_saen_khan' =>'ทองแสนขัน',
			'mueang_phrae' =>'เมืองแพร่',
			'rong_kwang' =>'ร้องกวาง',
			'long' =>'ลอง',
			'sung_men' =>'สูงเม่น',
			'den_chai' =>'เด่นชัย',
			'song' =>'สอง',
			'wang_chin' =>'วังชิ้น',
			'nong_muang_khai' =>'หนองม่วงไข่',
			'mueang_nan' =>'เมืองน่าน',
			'mae_charim' =>'แม่จริม',
			'ban_luang' =>'บ้านหลวง',
			'na_noi' =>'นาน้อย',
			'pua' =>'ปัว',
			'tha_wang_pha' =>'ท่าวังผา',
			'wiang_sa' =>'เวียงสา',
			'thung_chang' =>'ทุ่งช้าง',
			'chiang_klang' =>'เชียงกลาง',
			'na_muen' =>'นาหมื่น',
			'santi_suk' =>'สันติสุข',
			'bo_kluea' =>'บ่อเกลือ',
			'song_khwae' =>'สองแคว',
			'phu_phiang' =>'ภูเพียง',
			'chaloem_phra_kiat' =>'เฉลิมพระเกียรติ(43-หนองคาย)',
			'mueang_phayao' =>'เมืองพะเยา',
			'chun' =>'จุน',
			'chiang_kham' =>'เชียงคำ',
			'chiang_muan' =>'เชียงม่วน',
			'dok_khamtai' =>'ดอกคำใต้',
			'pong' =>'ปง',
			'mae_chai' =>'แม่ใจ',
			'phu_sang' =>'ภูซาง',
			'phu_kamyao' =>'ภูกามยาว',
			'mueang_chiang_rai' =>'เมืองเชียงราย',
			'wiang_chai' =>'เวียงชัย',
			'chiang_khong' =>'เชียงของ',
			'thoeng' =>'เทิง',
			'phan' =>'พาน',
			'pa_daet' =>'ป่าแดด',
			'mae_chan' =>'แม่จัน',
			'chiang_saen' =>'เชียงแสน',
			'mae_sai' =>'แม่สาย',
			'mae_suai' =>'แม่สรวย',
			'wiang_pa_pao' =>'เวียงป่าเป้า',
			'phaya_mengrai' =>'พญาเม็งราย',
			'wiang_kaen' =>'เวียงแก่น',
			'khun_tan' =>'ขุนตาล',
			'mae_fa_luang' =>'แม่ฟ้าหลวง',
			'mae_lao' =>'แม่ลาว',
			'wiang_chiang_rung' =>'เวียงเชียงรุ้ง',
			'doi_luang' =>'ดอยหลวง',
			'mueang_mae_hong_son' =>'เมืองแม่ฮ่องสอน',
			'khun_yuam' =>'ขุนยวม',
			'pai' =>'ปาย',
			'mae_sariang' =>'แม่สะเรียง',
			'mae_la_noi' =>'แม่ลาน้อย',
			'sop_moei' =>'สบเมย',
			'pang_mapha' =>'ปางมะผ้า',
			'muen_tor' =>'ม่วยต่อ',
			'mueang_nakhon_sawan' =>'เมืองนครสวรรค์',
			'krok_phra' =>'โกรกพระ',
			'chum_saeng' =>'ชุมแสง',
			'nong_bua' =>'หนองบัว',
			'banphot_phisai' =>'บรรพตพิสัย',
			'kao_liao' =>'เก้าเลี้ยว',
			'takhli' =>'ตาคลี',
			'takhli' =>'ท่าตะโก',
			'phaisali' =>'ไพศาลี',
			'phayuha_khiri' =>'พยุหะคีรี',
			'phayuha_khiri' =>'ลาดยาว',
			'tak_fa' =>'ตากฟ้า',
			'mae_wong' =>'แม่วงก์',
			'mae_poen' =>'แม่เปิน',
			'chum_ta_bong' =>'ชุมตาบง',
			'huen_nam_hom' =>'สาขาตำบลห้วยน้ำหอม',
			'chum_ta_bong' =>'กิ่งอำเภอชุมตาบง (สาขาตำบลชุมตาบง)',
			'mea_ley' =>'แม่วงก์ (สาขาตำบลแม่เล่ย์)',
			'mueang_uthai_thani' =>'เมืองอุทัยธานี',
			'thap_than' =>'ทัพทัน',
			'sawang_arom' =>'สว่างอารมณ์',
			'nong_chang' =>'หนองฉาง',
			'nong_khayang' =>'หนองขาหย่าง',
			'ban_rai' =>'บ้านไร่',
			'lan_sak' =>'ลานสัก',
			'huai_khot' =>'ห้วยคต',
			'mueang_kamphaeng_phet' =>'เมืองกำแพงเพชร',
			'sai_ngam' =>'ไทรงาม',
			'khlong_lan' =>'คลองลาน',
			'khanu_woralaksaburi' =>'ขาณุวรลักษบุรี',
			'khlong_khlung' =>'คลองขลุง',
			'phran_kratai' =>'พรานกระต่าย',
			'lan_krabue' =>'ลานกระบือ',
			'sai_thong_watthana' =>'ทรายทองวัฒนา',
			'pang_sila_thong' =>'ปางศิลาทอง',
			'bueng_samakkhi' =>'บึงสามัคคี',
			'kosamphi_nakhon' =>'โกสัมพีนคร',
			'mueang_tak' =>'เมืองตาก',
			'ban_tak' =>'บ้านตาก',
			'sam_ngao' =>'สามเงา',
			'mae_ramat' =>'แม่ระมาด',
			'tha_song_yang' =>'ท่าสองยาง',
			'mae_sot' =>'แม่สอด',
			'phop_phra' =>'พบพระ',
			'umphang' =>'อุ้มผาง',
			'wang_chao' =>'วังเจ้า',
			'king_ta_pui' =>'กิ่ง',
			'mueang_sukhothai' =>'เมืองสุโขทัย',
			'ban_dan_lan_hoi' =>'บ้านด่านลานหอย',
			'khiri_mat' =>'คีรีมาศ',
			'kong_krailat' =>'กงไกรลาศ',
			'si_satchanalai' =>'ศรีสัชนาลัย',
			'si_samrong' =>'ศรีสำโรง',
			'sawankhalok' =>'สวรรคโลก',
			'si_nakhon' =>'ศรีนคร',
			'thung_saliam' =>'ทุ่งเสลี่ยม',
			'mueang_phitsanulok' =>'เมืองพิษณุโลก',
			'nakhon_thai' =>'นครไทย',
			'chat_trakan' =>'ชาติตระการ',
			'bang_rakam' =>'บางระกำ',
			'bang_krathum' =>'บางกระทุ่ม',
			'phrom_phiram' =>'พรหมพิราม',
			'wat_bot' =>'วัดโบสถ์',
			'wang_thong' =>'วังทอง',
			'noen_maprang' =>'เนินมะปราง',
			'mueang_phichit' =>'เมืองพิจิตร',
			'wang_sai_phun' =>'วังทรายพูน',
			'pho_prathap_chang' =>'โพธิ์ประทับช้าง',
			'taphan_hin' =>'ตะพานหิน',
			'bang_mun_nak' =>'บางมูลนาก',
			'pho_thale' =>'โพทะเล',
			'sam_ngam' =>'สามง่าม',
			'tap_khlo' =>'ทับคล้อ',
			'sak_lek' =>'สากเหล็ก',
			'bueng_na_rang' =>'บึงนาราง',
			'dong_charoen' =>'ดงเจริญ',
			'wachirabarami' =>'วชิรบารมี',
			'mueang_phetchabun' =>'เมืองเพชรบูรณ์',
			'chon_daen' =>'ชนแดน',
			'lom_sak' =>'หล่มสัก',
			'lom_kao' =>'หล่มเก่า',
			'wichian_buri' =>'วิเชียรบุรี',
			'si_thep' =>'ศรีเทพ',
			'nong_phai' =>'หนองไผ่',
			'bueng_sam_phan' =>'บึงสามพัน',
			'nam_nao' =>'น้ำหนาว',
			'wang_pong' =>'วังโป่ง',
			'khao_kho' =>'เขาค้อ',
			'mueang_ratchaburi' =>'เมืองราชบุรี',
			'chom_bueng' =>'จอมบึง',
			'suan_phueng' =>'สวนผึ้ง',
			'damnoen_saduak' =>'ดำเนินสะดวก',
			'ban_pong' =>'บ้านโป่ง',
			'bang_phae' =>'บางแพ',
			'photharam' =>'โพธาราม',
			'pak_tho' =>'ปากท่อ',
			'wat_phleng' =>'วัดเพลง',
			'ban_kha' =>'บ้านคา',
			'tet_saban_ban_kong' =>'ท้องถิ่นเทศบาลตำบลบ้านฆ้อง',
			'mueang_kanchanaburi' =>'เมืองกาญจนบุรี',
			'sai_yok' =>'ไทรโยค',
			'bo_phloi' =>'บ่อพลอย',
			'si_sawat' =>'ศรีสวัสดิ์',
			'tha_maka' =>'ท่ามะกา',
			'tha_muang' =>'ท่าม่วง',
			'pha_phum' =>'ทองผาภูมิ',
			'sangkhla_buri' =>'สังขละบุรี',
			'phanom_thuan' =>'พนมทวน',
			'lao_khwan' =>'เลาขวัญ',
			'dan_makham_tia' =>'ด่านมะขามเตี้ย',
			'nong_prue' =>'หนองปรือ',
			'huai_krachao' =>'ห้วยกระเจา',
			'tha_kra_dan' =>'สาขาตำบลท่ากระดาน',
			'ban_tuan' =>'บ้านทวน จ.กาญจนบุรี',
			'mueang_suphan_buri' =>'เมืองสุพรรณบุรี',
			'doem_bang_nang_buat' =>'เดิมบางนางบวช',
			'dan_chang' =>'ด่านช้าง',
			'bang_pla_ma' =>'บางปลาม้า',
			'si_prachan' =>'ศรีประจันต์',
			'don_chedi' =>'ดอนเจดีย์',
			'song_phi_nong' =>'สองพี่น้อง',
			'sam_chuk' =>'สามชุก',
			'u_thong' =>'อู่ทอง',
			'nong_ya_sai' =>'หนองหญ้าไซ',
			'mueang_nakhon_pathom' =>'เมืองนครปฐม',
			'kamphaeng_saen' =>'กำแพงแสน',
			'nakhon_chai_si' =>'นครชัยศรี',
			'don_tum' =>'ดอนตูม',
			'bang_len' =>'บางเลน',
			'sam_phran' =>'สามพราน',
			'phutthamonthon' =>'พุทธมณฑล',
			'mueang_samut_sakhon' =>'เมืองสมุทรสาคร',
			'krathum_baen' =>'กระทุ่มแบน',
			'ban_phaeo' =>'บ้านแพ้ว',
			'mueang_samut_songkhram' =>'เมืองสมุทรสงคราม',
			'bang_khonthi' =>'บางคนที',
			'amphawa' =>'อัมพวา',
			'mueang_phetchaburi' =>'เมืองเพชรบุรี',
			'khao_yoi' =>'เขาย้อย',
			'nong_ya_plong' =>'หนองหญ้าปล้อง',
			'cha_am' =>'ชะอำ',
			'tha_yang' =>'ท่ายาง',
			'ban_lat' =>'บ้านลาด',
			'ban_laem' =>'บ้านแหลม',
			'kaeng_krachan' =>'แก่งกระจาน',
			'mueang_prachuap_khiri_khan' =>'เมืองประจวบคีรีขันธ์',
			'kui_buri' =>'กุยบุรี',
			'thap_sakae' =>'ทับสะแก',
			'bang_saphan' =>'บางสะพาน',
			'bang_saphan_noi' =>'บางสะพานน้อย',
			'pran_buri' =>'ปราณบุรี',
			'hua_hin' =>'หัวหิน',
			'sam_roi_yot' =>'สามร้อยยอด',
			'mueang_nakhon_si_thammarat' =>'เมืองนครศรีธรรมราช',
			'phrom_khiri' =>'พรหมคีรี',
			'lan_saka' =>'ลานสกา',
			'chawang' =>'ฉวาง',
			'phipun' =>'พิปูน',
			'chian_yai' =>'เชียรใหญ่',
			'cha_uat' =>'ชะอวด',
			'tha_sala' =>'ท่าศาลา',
			'thung_song' =>'ทุ่งสง',
			'na_bon' =>'นาบอน',
			'thung_yai' =>'ทุ่งใหญ่',
			'pak_phanang' =>'ปากพนัง',
			'ron_phibun' =>'ร่อนพิบูลย์',
			'sichon' =>'สิชล',
			'khanom' =>'ขนอม',
			'hua_sai' =>'หัวไทร',
			'bang_khan' =>'บางขัน',
			'tham_phannara' =>'ถ้ำพรรณรา',
			'chulabhorn' =>'จุฬาภรณ์',
			'phra_phrom' =>'พระพรหม',
			'nopphitam' =>'นบพิตำ',
			'chang_klang' =>'ช้างกลาง',
			'chaloem_phra_kiat' =>'เฉลิมพระเกียรติ',
			'chian_yai' =>'เชียรใหญ่ (สาขาตำบลเสือหึง)',
			'suan_luang' =>'สาขาตำบลสวนหลวง',
			'ron_phibun' =>'ร่อนพิบูลย์ (สาขาตำบลหินตก)',
			'hua_sai' =>'หัวไทร (สาขาตำบลควนชะลิก)',
			'thung_song' =>'ทุ่งสง (สาขาตำบลกะปาง)',
			'mueang_krabi' =>'เมืองกระบี่',
			'khao_phanom' =>'เขาพนม',
			'ko_lanta' =>'เกาะลันตา',
			'khlong_thom' =>'คลองท่อม',
			'ao_luek' =>'อ่าวลึก',
			'plai_phraya' =>'ปลายพระยา',
			'lam_thap' =>'ลำทับ',
			'nuea_khlong' =>'เหนือคลอง',
			'mueang_phang_nga' =>'เมืองพังงา',
			'ko_yao' =>'เกาะยาว',
			'kapong' =>'กะปง',
			'takua_thung' =>'ตะกั่วทุ่ง',
			'takua_pa' =>'ตะกั่วป่า',
			'khura_buri' =>'คุระบุรี',
			'thap_put' =>'ทับปุด',
			'thai_mueang' =>'ท้ายเหมือง',
			'mueang_phuket' =>'เมืองภูเก็ต',
			'kathu' =>'กะทู้',
			'thalang' =>'ถลาง',
			'tung_ka' =>'ทุ่งคา',
			'mueang_surat_thani' =>'เมืองสุราษฎร์ธานี',
			'kanchanadit' =>'กาญจนดิษฐ์',
			'don_sak' =>'ดอนสัก',
			'ko_samui' =>'เกาะสมุย',
			'ko_pha_ngan' =>'เกาะพะงัน',
			'chaiya' =>'ไชยา',
			'tha_chana' =>'ท่าชนะ',
			'khiri_rat_nikhom' =>'คีรีรัฐนิคม',
			'ban_ta_khun' =>'บ้านตาขุน',
			'phanom' =>'พนม',
			'tha_chang' =>'ท่าฉาง',
			'ban_na_san' =>'บ้านนาสาร',
			'ban_na_doem' =>'บ้านนาเดิม',
			'khian_sa' =>'เคียนซา',
			'wiang_sa' =>'เวียงสระ',
			'phrasaeng' =>'พระแสง',
			'phunphin' =>'พุนพิน',
			'chai_buri' =>'ชัยบุรี',
			'vibhavadi' =>'วิภาวดี',
			'ko_pha_ngan' =>'เกาะพงัน (สาขาตำบลเกาะเต่า)',
			'ban_don' =>'บ้านดอน',
			'mueang_ranong' =>'เมืองระนอง',
			'la_un' =>'ละอุ่น',
			'kapoe' =>'กะเปอร์',
			'kra_buri' =>'กระบุรี',
			'suk_samran' =>'สุขสำราญ',
			'mueang_chumphon' =>'เมืองชุมพร',
			'tha_sae' =>'ท่าแซะ',
			'pathio' =>'ปะทิว',
			'lang_suan' =>'หลังสวน',
			'lamae' =>'ละแม',
			'phato' =>'พะโต๊ะ',
			'sawi' =>'สวี',
			'thung_tako' =>'ทุ่งตะโก',
			'mueang_songkhla' =>'เมืองสงขลา',
			'sathing_phra' =>'สทิงพระ',
			'chana' =>'จะนะ',
			'na_thawi' =>'นาทวี',
			'thepha' =>'เทพา',
			'saba_yoi' =>'สะบ้าย้อย',
			'ranot' =>'ระโนด',
			'krasae_sin' =>'กระแสสินธุ์',
			'rattaphum' =>'รัตภูมิ',
			'sadao' =>'สะเดา',
			'hat_yai' =>'หาดใหญ่',
			'na_mom' =>'นาหม่อม',
			'khuan_niang' =>'ควนเนียง',
			'bang_klam' =>'บางกล่ำ',
			'singhanakhon' =>'สิงหนคร',
			'khlong_hoi_khong' =>'คลองหอยโข่ง',
			'sum_nung_kam' =>'ท้องถิ่นเทศบาลตำบลสำนักขาม',
			'ban_pru' =>'เทศบาลตำบลบ้านพรุ',
			'mueang_satun' =>'เมืองสตูล',
			'khuan_don' =>'ควนโดน',
			'khuan_kalong' =>'ควนกาหลง',
			'tha_phae' =>'ท่าแพ',
			'la_ngu' =>'ละงู',
			'thung_wa' =>'ทุ่งหว้า',
			'manang' =>'มะนัง',
			'mueang_trang' =>'เมืองตรัง',
			'kantang' =>'กันตัง',
			'yan_ta_khao' =>'ย่านตาขาว',
			'palian' =>'ปะเหลียน',
			'sikao' =>'สิเกา',
			'huai_yot' =>'ห้วยยอด',
			'wang_wiset' =>'วังวิเศษ',
			'na_yong' =>'นาโยง',
			'ratsada' =>'รัษฎา',
			'hat_samran' =>'หาดสำราญ',
			'mueang_trang(krong_teng)' =>'อำเภอเมืองตรัง(สาขาคลองเต็ง)',
			'mueang_phatthalung' =>'เมืองพัทลุง',
			'kong_ra' =>'กงหรา',
			'khao_chaison' =>'เขาชัยสน',
			'tamot' =>'ตะโหมด',
			'khuan_khanun' =>'ควนขนุน',
			'pak_phayun' =>'ปากพะยูน',
			'si_banphot' =>'ศรีบรรพต',
			'pa_bon' =>'ป่าบอน',
			'bang_kaeo' =>'บางแก้ว',
			'pa_phayom' =>'ป่าพะยอม',
			'srinagarindra' =>'ศรีนครินทร์',
			'mueang_pattani' =>'เมืองปัตตานี',
			'khok_pho' =>'โคกโพธิ์',
			'nong_chik' =>'หนองจิก',
			'panare' =>'ปะนาเระ',
			'mayo' =>'มายอ',
			'thung_yang_daeng' =>'ทุ่งยางแดง',
			'sai_buri' =>'สายบุรี',
			'mai_kaen' =>'ไม้แก่น',
			'yaring' =>'ยะหริ่ง',
			'yarang' =>'ยะรัง',
			'kapho' =>'กะพ้อ',
			'mae_lan' =>'แม่ลาน',
			'mueang_yala' =>'เมืองยะลา',
			'betong' =>'เบตง',
			'bannang_sata' =>'บันนังสตา',
			'than_to' =>'ธารโต',
			'yaha' =>'ยะหา',
			'raman' =>'รามัน',
			'kabang' =>'กาบัง',
			'krong_pinang' =>'กรงปินัง',
			'mueang_narathiwat' =>'เมืองนราธิวาส',
			'tak_bai' =>'ตากใบ',
			'bacho' =>'บาเจาะ',
			'yi_ngo' =>'ยี่งอ',
			'ra_ngae' =>'ระแงะ',
			'rueso' =>'รือเสาะ',
			'si_sakhon' =>'ศรีสาคร',
			'waeng' =>'แว้ง',
			'sukhirin' =>'สุคิริน',
			'su_ngai_kolok' =>'สุไหงโก-ลก',
			'su_ngai_padi' =>'สุไหงปาดี',
			'chanae' =>'จะแนะ',
			'cho_airong' =>'เจาะไอร้อง',
			'bang_nra' =>'บางนรา',
		);

		
		$this->data['locations'] = $locations;

	}

}