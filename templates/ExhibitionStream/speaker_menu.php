<input type = "button" id = "speaker" value = "연사자">
<input type = "button" id = "question" value = "질문">
<input type = "button" id = "answered" value = "답변완료">

<div id = "content">
    
</div>

<script>
    $("#content").load("/exhibition-stream/set-speaker/" + <?= $id ?>);
    
    $("#speaker").click(function () {
        $("#content").load("/exhibition-stream/set-speaker/" + <?= $id ?>);
    });
    
    $("#question").click(function () {
        $("#content").load("/exhibition-stream/set-answered/" + <?= $id ?>);
    });

    $("#answered").click(function () {
        $("#content").load("/exhibition-stream/answered/" + <?= $id ?>);
    });
</script>