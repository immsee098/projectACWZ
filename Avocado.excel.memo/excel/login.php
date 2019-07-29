<?php
include_once('./_common.php');

// 이미 로그인 중이라면
if ($is_member) {
	if ($url)
		goto_url($url);
	else
		goto_url('./index.php');
}

$url = G5_URL."/excel";

// url 체크
check_url_host($url);
$login_url        = login_url($url);
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";


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
		<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
			<input type="hidden" name="url" value='<?php echo $login_url ?>'>

			<table>
				<colgroup>
					<col style="width: 32px;" />
					<col style="width: 100px;" />
					<col style="width: 100px;" />
					<col style="width: 150px;" />
					<col />
				</colgroup>

				<thead>
					<tr>
						<th style="border-left: 0; border-right: 0;">&nbsp;</th>
						<th>A</th>
						<th>B</th>
						<th>C</th>
						<th>D</th>
						<th>E</th>
						<th>F</th>
						<th>G</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>1</th>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th>2</th>
						<td>&nbsp;</td>
						<td>아이디</td>
						<td><input type="text" name="mb_id" id="login_id" required class="frm_input required" size="20" maxLength="20" placeholder="아이디"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th>3</th>
						<td>&nbsp;</td>
						<td>비밀번호</td>
						<td><input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20" placeholder="비밀번호"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th>4</th>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><button type="submit">로그인하기</button></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				<? for($i=5; $i < 40; $i++) { ?>
					<tr>
						<th><?=$i?></th>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
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

		</form>

	</div>
	<div id="foot" class="login">
		<a href="./index.php"	class="index">메모리스트</a>
		<a href="./form.php"	class="write">메모작성</a>
		<a href="./login.php"	class="login">로그인</a>
	</div>
</div>


<script src="./js/_custom.js"></script>

</body>
</html>
