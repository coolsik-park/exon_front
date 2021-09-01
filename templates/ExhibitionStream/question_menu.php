<input type = "button" id = "speaker" value = "연사자">
<input type = "button" id = "question" value = "질문">
<input type = "button" id = "answered" value = "답변완료">

<div id = "questionContent"></div>

<script>
$(document).ready(function(){
    $("#questionContent").load("/exhibition-stream/set-speaker/" + <?= $id ?>);
    
    $("#speaker").click(function () {
        $("#questionContent").load("/exhibition-stream/set-speaker/" + <?= $id ?>);
    });

    $("#question").click(function () {
        $("#questionContent").load("/exhibition-stream/set-answered/" + <?= $id ?>);
    });

    $("#answered").click(function () {
        $("#questionContent").load("/exhibition-stream/answered/" + <?= $id ?>);
    });  
}); 
</script>