<?php
include_once('./_common.php');

if(!$is_member) { 
	goto_url('./login.php');
}

$re_mb = get_member($re_mb_id);
if(!$re_mb['mb_id']) { $re_mb['mb_id'] = $re_mb_id; }
$re_ch = get_character($re_mb['ch_id']);

// 읽음 표시 설정
// -- 해당 멤버와 나눈 대화 전체 읽음 표시
$sql = " update {$g5['memo_table']}
			set me_read_datetime = '".G5_TIME_YMDHIS."'
			where me_send_mb_id = '{$re_mb['mb_id']}'
			and me_recv_mb_id = '{$member['mb_id']}'
			and me_read_datetime = '0000-00-00 00:00:00' ";
sql_query($sql);

// 대화 알람 제거
$sql = " update {$g5['member_table']}
			set mb_memo_call = ''
			where mb_id = '{$member['mb_id']}'";
sql_query($sql);


// 최근 대화내역 가져오기
$sql = "select *
		from	{$g5['memo_table']}
		where	(me_recv_mb_id = '{$re_mb[mb_id]}' and me_send_mb_id = '{$member[mb_id]}')
			OR	(me_send_mb_id = '{$re_mb[mb_id]}' and me_recv_mb_id = '{$member[mb_id]}')
		ORDER BY me_id desc ";
$result = sql_query($sql);
$total = sql_num_rows($result);

$page_rows = 5;
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$total_page  = ceil($total / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$sql .= " limit {$from_record}, $page_rows ";
$result = sql_query($sql);
$max_count = sql_num_rows($result);

$last_me_id = 0;
$list = array();
for($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$last_me_id = $last_me_id > $row['me_id'] ? $last_me_id : $row['me_id'];
}


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
		<form name="fmemoform" action="./update.php" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
			<input type="hidden" name="pop" value="<?=$pop?>" />
			<input type="hidden" name="re_mb_id" value="<?=$re_mb[mb_id]?>" />

			<table>
				<colgroup>
					<col style="width: 32px;" />
					<col style="width: 50px;" />
					<col style="width: 200px;" />
					<col style="width: 110px;" />
					<col style="width: 80px;" />
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
	$i = 1;
	if($total_page > 1) { ?>
					<tr>
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td colspan="4">
							<a href="#" id="load_talk_prev" class="ui-btn small full etc">이전대화보기</a>
						</td>
					</tr>
<? } ?>

<? for($j=($max_count-1); $j >= 0; $j--) { 
	$me = $list[$j];
	if($me['me_send_mb_id'] == $member['mb_id']) { 
		$class = "right";
		$mb = $member;
		$ch = $character;
		$del= './memo_delete.php?me_id='.$me['me_id'];
	} else { 
		$class = "";
		$mb = $re_mb;
		$ch = $re_ch;
		$del = '';
	}
	
	// 템플릿 불러오기
	include('./memo_view.skin.php');
} ?>
					<tr id="write_area_line">
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td>답장쓰기</td>
						<td colspan="3">
							<textarea name="me_memo" id="me_memo" required class="required" tabindex="1"><?php echo $content ?></textarea>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td colspan="4">
							<button type="submit" class="ui-btn full point" tabindex="2">답장보내기</button>
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
	</form>


	<div id="foot" class="index">
		<a href="./index.php"	class="index">메모리스트</a>
		<a href="./form.php"	class="write">메모작성</a>
		<a href="./logout.php"	class="login">로그인</a>
	</div>
</div>


<?=$write_page?>



<script src="./js/_custom.js"></script>

<script>
var paging = 1;
$('#me_memo').focus();
$('#load_talk_prev').on('click', function() {
	paging++;
	$.ajax({
		type: 'get'
		, async: true
		, url: "./ajax/ajax_prev_talk.php?re_mb_id=<?=$re_mb_id?>&page="+paging
		, beforeSend: function() {

		}
		, success: function(data) {
			var response = data.trim();
			
			$('#body tbody tr').eq(0).after(response);
			if(!response) {
				$('#load_talk_prev').remove();
			}
			var th_count = 1;
			$('#body tbody tr').each(function() {
				$(this).find('th').text(th_count);
				th_count++;
			});
		}
		, error: function(data, status, err) {

		}
		, complete: function() { 

		}
	});
	return false;
});


$(function(){
	setInterval(function(){load_comment_list()},5000);
});

var last_cmcode = <?=$last_me_id?>;
function load_comment_list () {
	$.ajax({
		type: 'get'
		, async: true
		, url: "./ajax/ajax_latest_talk.php?re_mb_id=<?=$re_mb_id?>&me_id="+last_cmcode
		, beforeSend: function() {
		  }
		, success: function(data) {
			var response = data.trim();
			if(response) {
				$('#body tbody #write_area_line').before(response);
				var last_me_id = $('#last_idx').val();
				var last_count = $('#last_count').val();

				$('#last_idx').remove();
				$('#last_count').remove();
				last_cmcode = last_me_id;
				for(i=1; i <= last_count; i+=1) {
					$('#body tbody tr').eq(i).remove();
					$('#body tbody tr').eq(i).remove();
				}

				var th_count = 1;
				$('#body tbody tr').each(function() {
					$(this).find('th').text(th_count);
					th_count++;
				});
			}
		  }
		 , complete: function() { 
		}
	});
}
function fmemoform_submit(f)
{
	return true;
}
</script>

</body>
</html>
