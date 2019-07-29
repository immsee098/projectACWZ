<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_member) { 
	include_once(G5_PATH.'/ajax/load_board_call.php');
?>
<script>
	function close_call() {
		$.ajax({
			url:'<?=G5_URL?>/ajax/close_call.php'
			, success: function(data){
				$('.ui-call-alram-box').fadeOut(function() {
					$(this).remove();
				});
			}
		});
	}
</script>

<?
}
?>
