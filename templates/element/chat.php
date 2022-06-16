<?php foreach($message as $index =>$list): ?>
<div class='msgln' style="line-height:120%">
    <div style="display:flex;">
        <span class='chat-time' style='display:flex;'><?php echo date("H:i A", strtotime("+9 hours", strtotime($list['created'])));?></span>
        <b class='user-name' style="display:flex; height:24px; width:fit-content;"><?php echo $list['user_name']; ?></b>
        <?php echo '<b style="display:flex; margin-top:2px;">'.$list['message'].'</b>'; ?>
    </div>
</div>
<?php endforeach; ?>