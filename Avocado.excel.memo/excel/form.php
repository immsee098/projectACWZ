<?php
include_once('./_common.php');

if(!$is_member) { 
	goto_url('./login.php');
}

$content = "";
// 탈퇴한 회원에게 쪽지 보낼 수 없음
if ($me_recv_mb_id)
{
	$mb = get_member($me_recv_mb_id);
	if (!$mb['mb_id'])
		alert_close('회원정보가 존재하지 않습니다.\\n\\n탈퇴하였을 수 있습니다.');

	if (!$mb['mb_open'] && $is_admin != 'super')
		alert_close('정보공개를 하지 않았습니다.');

	// 4.00.15
	$row = sql_fetch(" select me_memo from {$g5['memo_table']} where me_id = '{$me_id}' and (me_recv_mb_id = '{$member['mb_id']}' or me_send_mb_id = '{$member['mb_id']}') ");
	if ($row['me_memo'])
	{
		$content = "\n\n\n".' >'
						 ."\n".' >'
						 ."\n".' >'.str_replace("\n", "\n> ", get_text($row['me_memo'], 0))
						 ."\n".' >'
						 .' >';

	}
}

$i = 0;

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
		<form name="fmemoform" action="./update.php" method="post" autocomplete="off">
			<input type="hidden" name="pop" value="<?=$pop?>" />
			<input type="hidden" name="re_mb_id" value="<?=$re_mb[mb_id]?>" />

			<table>
				<colgroup>
					<col style="width: 32px;" />
					<col style="width: 50px;" />
					<col style="width: 100px;" />
					<col style="width: 410px;" />
					<col  />
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
					<tr>
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td rowspan="2">받는사람</td>
						<td>
							<input type="hidden" name="re_mb_id" id="re_mb_id" value="" />
							<input type="text" name="re_mb_name" value="" id="re_mb_name" onkeyup="get_ajax_member(this, 'member_list', 're_mb_id');" placeholder="멤버 이름을 검색하세요"/>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td>
							<div id="member_list" class="ajax-list-box theme-box"><div class="list">SEARCHING...</div></div>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

					<tr>
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td>내용</td>
						<td>
							<textarea name="me_memo" id="me_memo" required class="required" rows="10"><?php echo $content ?></textarea>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th><?=$i++?></th>
						<td>&nbsp;</td>
						<td colspan="2"><button type="submit" class="ui-btn point">전송</button></td>
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


	<div id="foot" class="write">
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
			$('#body tbody').prepend(response);
			if(!response) {
				$('#load_talk_prev').remove();
			}
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
				$('#body tbody').append(response);
				var last_me_id = $('#last_idx').val();
				var last_count = $('#last_count').val();

				$('#last_idx').remove();
				$('#last_count').remove();
				last_cmcode = last_me_id;
				for(i=0; i < last_count; i++) {
					$('#body tbody tr').eq(i).remove();
				}
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
