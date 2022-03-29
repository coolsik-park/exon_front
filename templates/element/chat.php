<?php foreach($message as $index =>$list): ?>
<div class='msgln' style="line-height:120%">
<span class='chat-time'><?php echo date("m/d/y, g:i A", strtotime("+9 hours", strtotime($list['created']))); ?></span>
<b class='user-name'><?php echo $list['user_name']; ?></b>
<?php echo '<b>'.$list['message'].'</b>'; ?>
</div>
<?php endforeach; ?>