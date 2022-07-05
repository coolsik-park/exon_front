<style>
    .msgln span.chat-time {
        margin-right: 6px;
        margin-left: 6px;
    }
</style>



<?php foreach($message as $index =>$list): ?>
<div class='msgln' style="line-height:120%;">
    <div style="margin-bottom: 20px; position: relative;">
    <b style="opacity: 0.8"><?php echo $list['user_name']; ?></b>
        <p style=" border:0; border-radius: 15px; height:fit-content; width: 100%; padding:8px 38px 7px 7px; background-color: #F0F0F0; word-break: keep-all;">
            <?php echo '<b class="user-name" style="word-break:break-all; margin:0; padding:0; font-weight: 500; background-color: inherit; color:black; line-height:1.5;">'.$list['message'].'</b>'; ?>
        </p>
        <b style=" position: absolute; right: 0; bottom: 0px; padding: 0px 8px 0px 4px;  display:flex; height:33px; width: fit-content;  align-items: center; color: white; border-radius: 15px; z-index: 9999;"><span class='chat-time' style='display:flex; color: darkgrey;'><?php echo date("H:i", strtotime("+9 hours", strtotime($list['created'])));?></span></b>
       
    </div>
</div>
<?php endforeach; ?>