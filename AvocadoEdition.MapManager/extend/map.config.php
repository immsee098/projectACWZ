<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 맵 관련 테이블값 추가
$g5['map_table'] = G5_TABLE_PREFIX.'map'; // 지역 테이블
$g5['map_event_table'] = G5_TABLE_PREFIX.'map_event'; // 지역이벤트 테이블
$g5['map_move_table'] = G5_TABLE_PREFIX.'map_flow'; // 지역설정 테이블


// 맵 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['map_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['map_table']}` (
		`ma_id` int(11) NOT NULL AUTO_INCREMENT,
		`ma_name` varchar(255) NOT NULL default '',
		`ma_parent` int(11) NOT NULL default '0',
		`ma_top` int(111) NOT NULL default '0',
		`ma_left` int(11) NOT NULL default '0',
		`ma_width` int(11) NOT NULL default '0',
		`ma_height` int(11) NOT NULL default '0',
		`ma_use` int(11) NOT NULL default '0',
		PRIMARY KEY (`ma_id`)
	) ", false);
}

// 맵 이동 설정값이 없을 경우 생성
if(!sql_query(" DESC {$g5['map_move_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['map_move_table']}` (
		`mf_id` int(11) NOT NULL AUTO_INCREMENT,
		`mf_start` int(11) NOT NULL default '0',
		`mf_end` int(11) NOT NULL default '0',
		`mf_use` int(11) NOT NULL default '0',
		PRIMARY KEY (`mf_id`)
	) ", false);
}

// 맵 이벤트 설정값이 없을 경우 생성
if(!sql_query(" DESC {$g5['map_event_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['map_event_table']}` (
		`me_id` int(11) NOT NULL AUTO_INCREMENT,
		`ma_id` int(11) NOT NULL default '0',
		`me_type` varchar(255) NOT NULL default '',
		`me_title` varchar(255) NOT NULL default '',
		`me_img` varchar(255) NOT NULL default '',
		`me_content` text NOT NULL,
		`me_get_item` int(11) NOT NULL default '0',
		`me_get_money` int(11) NOT NULL default '0',
		`me_move_map` int(11) NOT NULL default '0',
		`me_get_hp` int(11) NOT NULL default '0',
		`me_mon_hp` int(11) NOT NULL default '0',
		`me_mon_attack` int(11) NOT NULL default '0',
		`me_per_s` int(11) NOT NULL default '0',
		`me_per_e` int(11) NOT NULL default '0',
		`me_replay_cnt` int(11) NOT NULL default '0',
		`me_now_cnt` int(11) NOT NULL default '0',
		`me_use` int(11) NOT NULL default '0',
		PRIMARY KEY (`me_id`)
	) ", false);
}

// 캐릭터에 맵 이동 값이 존재하지 않을 경우
if($is_member && $character['ch_id'] && !isset($character['ma_id'])) { 
	sql_query(" ALTER TABLE `{$g5['character_table']}` ADD `ma_id` INT(11) NOT NULL DEFAULT '0' AFTER `ch_side` ");
}

// 관리자에 맵 기능 사용 여부 설정값 추가
if(!isset($config['cf_use_map'])) { 
	sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `cf_use_map` INT(11) NOT NULL DEFAULT '0' AFTER `cf_open` ");
}

?>
