<?php foreach($message as $index =>$list): ?>
<div class='msgln' style="line-height:120%">
    <div>
        <b style="display:flex; height:24px; width:fit-content;"><span class='chat-time' style='display:flex;'><?php echo date("H:i", strtotime("+9 hours", strtotime($list['created'])));?></span><?php echo $list['user_name']; ?></b>
        <p style="border:1px solid grey; height:fit-content; width:fit-content; padding:7px; margin-left:27px;">
            <?php echo '<b class="user-name" style="margin:0; padding:0; background-color:white; color:black; line-height:1.5;">'.$list['message'].'</b>'; ?>
        </p>
    </div>
</div>
<?php endforeach; ?>