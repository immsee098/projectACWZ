<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<tr>
	<th><?=$i++?></th>
	<td>&nbsp;</td>
	<td rowspan="2">
		<? if($ch['ch_name']) { ?>[<?=$ch['ch_name']?>] <? } ?><?=$mb['mb_name']?>
	</td>
	<td>
		<?=date('m-d H:i', strtotime($me['me_send_datetime']))?>
	</td>
	<td>
		<? if($me['me_read_datetime'] == '0000-00-00 00:00:00' && $mb['mb_id'] == $member['mb_id']) { ?>
			***
		<? } else { ?>
			읽음
		<? } ?>
	</td>
	<td>
		<? if($del){ ?>
			<a href="<?=$del?>" onclick="return confirm('정말 삭제하시겠습니까? 상대방의 우편함의 내용도 함께 삭제 됩니다.');" class="ui-btn ico del">삭제</a>
		<? } ?>
	</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><?=$i++?></th>
	<td>&nbsp;</td>
	<td colspan="3">
		<?=conv_content($me['me_memo'], 0)?>
	</td>
	<td>&nbsp;</td>
</tr>
