<?php
include_once('./_common.php');

if(!$is_member) { 
	goto_url('./login.php');
}

$sql = "select
			MAX(me_id) as me_id,
			COUNT(me_id) as count,
			if(me_recv_mb_id = '{$member['mb_id']}', me_send_mb_id, me_recv_mb_id) as mb_id
		from {$g5['memo_table']}
		where	me_send_mb_id = '{$member[mb_id]}'
			OR	me_recv_mb_id = '{$member[mb_id]}'
		group by mb_id
		order by me_id desc";
$result = sql_query($sql);

$total = sql_num_rows($result);
$rows = 10;
$total_page  = ceil($total / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql .= " limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$write_page = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['PHP_SELF'].'?type=');
?>

<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">

<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="HandheldFriendly" content="true">
<meta name="format-detection" content="telephone=no">

<title>Book1 - Microsoft Excel</title>
<link rel="stylesheet" href="<?=G5_URL?>/excel/css/style.css" type="text/css">

<link rel="shortcut icon" href="<?=G5_URL?>/excel/img/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?=G5_URL?>/excel/img/favicon.ico" type="image/x-icon">

<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php if(defined('G5_IS_ADMIN')) { ?>
var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
<?php } ?>
</script>
<script src="<?php echo G5_JS_URL ?>/jquery-1.12.3.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.cookie.js"></script>
<script src="<?php echo G5_JS_URL ?>/common.js"></script>


</head>
<body>

<div id="excel_page">
	<div id="head"></div>

	<div id="body">
		<table>
			<colgroup>
				<col style="width: 32px;" />
				<col style="width: 50px;" />
				<col style="width: 100px;" />
				<col style="width: 100px;" />
				<col style="width: 50px;" />
				<col />
				<col style="width: 20px;"/>
			</colgroup>
			<thead>
				<tr>
					<th style="border-left: 0; border-right: 0;">&nbsp;</th>
					<th>A</th>
					<th>B</th>
					<th>C</th>
					<th>D</th>
					<th>E</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>

<?
	for($i=1; $row = sql_fetch_array($result); $i++) {
		$me = sql_fetch("select * from {$g5['memo_table']} where me_id = '{$row['me_id']}'");
		$total = $row['count'];
		$mb = get_member($row['mb_id']);
		$ch = get_character($mb['ch_id']);

?>
				<tr>
					<th><?=$i?></th>
					<td>&nbsp;</td>
					<td><strong><?=$mb['mb_name']?>님</strong></td>
					<td><?=date('m-d H:i', strtotime($me['me_send_datetime']))?></td>
					<td>
						<? if($me['me_read_datetime'] == '0000-00-00 00:00:00' && $me['me_send_mb_id'] != $member['mb_id']) { ?>
						<i class="ico-new">새글</i>
						<? } else { ?>
						&nbsp;
						<? } ?>
					</td>
					<td>
						<a href="./view.php?re_mb_id=<?=$row['mb_id']?>">
							<? if($me['me_send_mb_id'] == $member['mb_id']) { ?>
							ME ▶
							<? } ?>
							<?php echo conv_subject($me['me_memo'], 120, '...'); ?>
						</a>
					</td>
					<td>&nbsp;</td>
				</tr>
<? } ?>
				<tr>
					<th><?=$i++?></th>
					<td>&nbsp;</td>
					<td colspan="4">
						<?=$write_page?>
					</td>
					<td>&nbsp;</td>
				</tr>
			<? for($i; $i < 40; $i++) { ?>
					<tr>
						<th><?=$i?></th>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
			<? } ?>
			</tbody>
		</table>
	</div>

	<div id="foot" class="index">
		<a href="./index.php"	class="index">메모리스트</a>
		<a href="./form.php"	class="write">메모작성</a>
		<a href="./logout.php"	class="login">로그인</a>
	</div>
</div>


<?=$write_page?>



<script src="./js/_custom.js"></script>

</body>
</html>
