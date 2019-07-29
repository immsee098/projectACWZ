<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_member) { 
	include_once(G5_PATH.'/ajax/load_memo_call.php');
?>
<script>
	function close_memo() {
		$.ajax({
			url:'<?=G5_URL?>/ajax/close_memo.php'
			, success: function(data){
				$('.ui-memo-alram-box').fadeOut(function() {
					$(this).remove();
				});
			}
		});
	}
</script>

<?
}
?>