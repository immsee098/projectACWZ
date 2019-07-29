<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 랜덤 테이블값 추가
$g5['random_table'] = G5_TABLE_PREFIX.'random';


// 랜덤 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['random_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['random_table']}` (
	  `ra_id` int(11) NOT NULL AUTO_INCREMENT,
	  `ra_title` varchar(255)  NOT NULL default '',
	  `ra_text` text NOT NULL,
	  `ra_img` text NOT NULL,
	  `ra_use` int(11) NOT NULL default '0',
	  PRIMARY KEY (`ra_id`)
	) ", false);
}

?>