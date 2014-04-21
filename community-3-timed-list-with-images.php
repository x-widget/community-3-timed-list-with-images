<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

widget_css();

$icon_url = widget_data_url( $widget_config['code'], 'icon' );

$file_headers = @get_headers($icon_url);

if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $icon_url = null;
}

if( $widget_config['title'] ) $title = $widget_config['title'];
else $title = 'no title';

if( $widget_config['forum1'] ) $_bo_table = $widget_config['forum1'];
else $_bo_table = $widget_config['default_forum_id'];

$limit = 4;

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"limit"		=>	$limit,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);	
?>

<div class="comm3_timed_list_with_image">
    <div class="timed_list_title">
		<?if( $icon_url ) echo "<img class='icon' src='".$icon_url."'/>";?>
		<a href='<?=G5_BBS_URL?>/board.php?bo_table=<?=$_bo_table?>'><?=$title?></a>
		
		<span class='more-button'><a href='<?=G5_BBS_URL?>/board.php?bo_table=<?=$_bo_table?>'>자세히</a></span>
		<div style='clear:right;'></div>
	</div>
    <table width='100%' cellpadding=0 cellspacing=0>
    <?php for ($i=0; $i<count($list); $i++) {?>
	<tr valign='top'>
		
		<?php			
			$_wr_id = $list[$i]['wr_id'];
			$imgsrc = x::post_thumbnail($_bo_table, $_wr_id, 38, 30);		
			if( $date_and_time[0] == date("Y-m-d") ) $post_date = $date_and_time[1];
			else $post_date = $date_and_time[0];

			if( $imgsrc ) $img = $imgsrc['src'];
			else {
				$_wr_content = db::result("SELECT wr_content FROM $g5[write_prefix]$_bo_table WHERE wr_id='$_wr_id'");
				$img = x::thumbnail_from_image_tag($_wr_content, $_bo_table, 38, 30);
				if ( empty($img) ) $img = x::url()."/widget/".$widget_config['name'].'/img/no-image.png';
			}
			
			echo "<td width='40'><div class='timed_list_image'><a href='".$list[$i]['url']."'><img src='$img'/></a></div></td>";
			        
            echo "<td>
					<div class='subject'><a href='".$list[$i]['url']."'>".conv_subject($list[$i]['subject'], 15, '...')."</a></div>
					<div class='contents_wrapper'><a href='".$list[$i]['url']."'>".cut_str(strip_tags($list[$i]['wr_content']), 35, '...')."</a></div>
			
				</td>";
			
			if( !$list[$i]['wr_comment'] ) $comment_count = "<span class='comment_count no-comment'>0</span>";
			else $comment_count = "<span class='comment_count'>".strip_tags($list[$i]['wr_comment'])."</span>";
			
			echo "<td width='100'><div class='comment_and_time'>".$comment_count."<br><span class='time'>".$post_date."</span></div></td>";
             ?>	
	</tr>	
    <?php }  ?>
    <?php if(count($list) == 0) { //게시물이 없을 때  ?>
		<tr>
			<td width=40><div class='timed_list_image'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/no-image.png'/></a></div></td>
			 <td width=240>
				<div class='subject'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'>사이트 만들기 안내</a></div>
				<div class='contents_wrapper'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'>사이트 만들기 안내</a></div>
			 </td>	
			<td><div class='comment_and_time'>10<br><span class='time'><?=date('H:i', time())?></span></div></td>
		</tr>
		<tr>
			<td width=40><div class='timed_list_image'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=4'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/no-image.png'/></a></div></td>
			 <td width=240>
				<div class='subject'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=4'>블로그 만들기</a></div>
				<div class='contents_wrapper'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=4'>블로그 만들기</a></div>
			</td>	
			<td><div class='comment_and_time'>10<br><span class='time'><?=date('H:i', time())?></span></div></td>
		</tr>
		<tr>
			<td width=40><div class='timed_list_image'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=3'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/no-image.png'/></a></div></td>
			 <td width=240>
				<div class='subject'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=3'>커뮤니티 사이트 만들기</a></div>
				<div class='contents_wrapper'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=3'>커뮤니티 사이트 만들기</a></div>
			</td>	
			<td><div class='comment_and_time'>10<br><span class='time'><?=date('H:i', time())?></span></div></td>
		</tr>
		<tr>
			<td width=40><div class='timed_list_image'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=2'><img src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/no-image.png'/></a></div></td>
			 <td width=240>
				<div class='subject'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=2'>여행사 사이트 만들기</a></div>
				<div class='contents_wrapper'><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=2'>여행사 사이트 만들기</a></div>
			</td>	
			<td><div class='comment_and_time'>10<br><span class='time'><?=date('H:i', time())?></span></div></td>
		</tr>
    <?php }  ?>
    </table>    
</div>



<!--[if IE]>
	<style>
		.comm3_timed_list_with_image .timed_list_title{
			margin-bottom:10px;
		}
		
		.comm3_timed_list_with_image td{
			padding-top:0;	
		}
	</style>
<![endif]-->