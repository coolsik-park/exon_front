<?php foreach($message as $index =>$list): ?>
<div class='msgln'><span class='chat-time'><?php echo $list['created']; ?></span> 
<b class='user-name'><?php echo $list['user_name']; ?></b> <?php echo stripslashes(htmlspecialchars($list['message'])); ?><br></div>
<?php endforeach; ?>