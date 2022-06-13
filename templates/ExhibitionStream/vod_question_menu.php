<style>
    *{
        font-size:1.06rem;
    }
</style>
<div class="webinar-cont1">
    <h3 class="sr-only">질의 응답</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty4-body">                                    
            <ul class="wb-in-tab">
                <li id="speaker" class="" style="cursor:pointer"><a>연사자</a></li>
                <li id="question" class="" style="cursor:pointer"><a>질문</a></li>
                <li id="answered" class="" style="cursor:pointer"><a>답변완료</a></li>
            </ul> 
            <div id = "questionContent"></div> 
        </div>
    </div>                               
</div>

<script>
$(document).ready(function(){
    $("#questionContent").load("/exhibition-stream/vod-set-speaker/" + <?= $id ?>);
    $("#speaker").attr("class", "on");
    
    $("#speaker").click(function () {
        $("#questionContent").load("/exhibition-stream/vod-set-speaker/" + <?= $id ?>);
        $("#speaker").attr("class", "on");
        $("#question").attr("class", "");
        $("#answered").attr("class", "");
    });

    $("#question").click(function () {
        $("#questionContent").load("/exhibition-stream/vod-set-answered/" + <?= $id ?>);
        $("#speaker").attr("class", "");
        $("#question").attr("class", "on");
        $("#answered").attr("class", "");
    });

    $("#answered").click(function () {
        $("#questionContent").load("/exhibition-stream/vod-answered/" + <?= $id ?>);
        $("#speaker").attr("class", "");
        $("#question").attr("class", "");
        $("#answered").attr("class", "on");
    });  
}); 
</script>