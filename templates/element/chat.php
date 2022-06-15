<?php foreach($message as $index =>$list): ?>
<div class='msgln' style="line-height:120%">
<span class='chat-time'><?php echo date("g:i A", strtotime("+9 hours", strtotime($list['created']))); ?></span>
    <div style="display:flex;">
        <b class='user-name' style="display:flex; height:24px;"><?php echo $list['user_name']; ?></b>
        <?php echo '<b style="display:flex;">'.$list['message'].'</b>'; ?>
    </div>
</div>
<?php endforeach; ?>