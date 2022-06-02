
<style>
    * {
    margin: 0;
    padding: 0;
  }
   
  /* body {
    margin: 20px auto;
    font-family: "Lato";
    font-weight: 300;
  }
   
  form {
    padding: 15px 25px;
    display: flex;
    gap: 10px;
    justify-content: center;
  }
   
  form label {
    font-size: 1.5rem;
    font-weight: bold;
  }
   
  input {
    font-family: "Lato";
  } */
   
  /* a {
    color: #0000ff;
    text-decoration: none;
  }
   
  a:hover {
    text-decoration: underline;
  }
   
  #wrapper,
  #loginform {
    margin: 0 auto;
    padding-bottom: 25px;
    background: #eee;
    width: 600px;
    max-width: 100%;
    border: 2px solid #212121;
    border-radius: 4px;
  }
   
  #loginform {
    padding-top: 18px;
    text-align: center;
  }
   
  #loginform p {
    padding: 15px 25px;
    font-size: 1.4rem;
    font-weight: bold;
  } */
   
  #chatbox {
    text-align: left;
    /* margin: 3px; */
    padding: 0px 10px;
    background: #fff;
    height: 100%;
    width: 100%;
    /* border: 1px solid #a7a7a7; */
    overflow: auto;
    border-radius: 4px;
    border-bottom: 4px solid #a7a7a7;
  }
   
  #usermsg {
    flex: 1;
    border-radius: 4px;
    /* border: 1px solid #ff9800; */
  }
   
  #name {
    border-radius: 4px;
    border: 1px solid #ff9800;
    padding: 2px 8px;
  }
   
  /* #submitmsg,
  #enter{
    background: #ff9800;
    border: 2px solid #e65100;
    color: white;
    padding: 4px 10px;
    font-weight: bold;
    border-radius: 4px;
  } */
   
  /* .error {
    color: #ff0000;
  }
   
  #menu {
    padding: 15px 25px;
    display: flex;
  }
   
  #menu p.welcome {
    flex: 1;
  }
   
  a#exit {
    color: white;
    background: #c62828;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: bold;
  } */
   
  .msgln {
    margin: 0 0 5px 0;
  }
   
  .msgln span.left-info {
    color: orangered;
  }
   
  .msgln span.chat-time {
    color: #666;
    font-size: 60%;
    vertical-align: super;
  }
   
  .msgln b.user-name, .msgln b.user-name-left {
    font-weight: bold;
    background: #546e7a;
    color: white;
    padding: 2px 4px;
    font-size: 90%;
    border-radius: 4px;
    margin: 0 5px 0 0;
  }
   
  .msgln b.user-name-left {
    background: orangered;
  }

  .wb-alert {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .webinar-cont-ty1-btm {
    height: auto;
    position: static;
  }

  textarea {
    resize: none;
    padding: 0;
  }
  .noticeBox {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
  .noticeBox::-webkit-scrollbar {
      display: none; /* Chrome, Safari, Opera*/
  }
  #chatbox {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
  #chatbox::-webkit-scrollbar {
      display: none; /* Chrome, Safari, Opera*/
  }
  #submitmsg {
    margin-left: 3%;
  }
  @media  screen and (max-width: 1200px) {
    textarea {
      padding: 0;
    }
    .webinar-cont-ty1-btm {
      position: static;
      margin-top: 20px;
    }
    .webinar-cont-ty1 {
      background: white;
    }
  }
</style>

<!-- <div id="wrapper">
    <div id="menu">
        <p class="welcome">Welcome, <b></b></p>
        <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
    </div>

    <div id="chatbox"></div>

    <form name="message" action="">
        <input type="hidden" name="last_id" id="last_id" value="1">
        <input name="usermsg" type="text" id="usermsg" />
        <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
    </form>
</div> -->

<div class="webinar-cont1">
    <h3 class="sr-only">실시간 채팅</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty1-body"> 
              <!-- <p class="wb-alert">사용할 탭을 선택해주세요</p>                                   
              <p class="wb-alert">실시간 채팅 탭이 활성화되었습니다</p>                                    -->
              <!-- <div class="chatting-msg-box"> -->
                  <div id="chatbox">
                    <?php if ($exhibition->notice != null) : ?>
                    <div class="noticeBox" style="margin-bottom:20px;word-wrap:break-word; overflow-y: scroll; height: 60px; position:sticky; top: 0; background: white; border-bottom:3px solid #a5a5a5; scrollbar-width: none;"><?= $this->Text->autoParagraph($exhibition->notice) ?><br></div>
                    <?php endif; ?>
                    <!-- <hr style="border:1px solid #a5a5a5; margin-bottom: 20px;"> -->
                  </div>
              <!-- </div>   -->
        </div>
        <div class="webinar-cont-ty1-btm">
            <div class="chatting-submit">
                <input type="hidden" name="last_id" id="last_id" value="1">
                <textarea id="usermsg" name="usermsg" placeholder="" rows="2" cols="20" wrap="hard" onkeyup="enterkey()"></textarea>
                <button type="submit" id="submitmsg" name="submitmsg" class="btn-ty4 redbg">전송</button>
            </div>
        </div>
    </div>                            
</div>




<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    // jQuery Document
    $(document).ready(function () {});
</script>


<script>
chatInterval = setInterval(loadLog, 1000);

function enterkey() {
  if (!event.shiftKey && window.event.keyCode == 13) {
    var clientmsg = $("#usermsg").val().replace(/(?:\r\n|\r|\n)/g,'<br/>');
    if (clientmsg == '<br/>') {
      $("#usermsg").val("");
      return false;
    }
    $.post("/ExhibitionStreamChatLog/chatLog/<?=$stream_id?>", { text: clientmsg });
    $("#usermsg").val("");
    // loadLog()
    return false;
  }
}

function loadLog(){     
  var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
  
  $.ajax({
      url: "/ExhibitionStreamChatLog/getChatLog/"+$("#last_id").val() + "/<?=$stream_id?>/<?=$now?>",
      cache: false,
      dataType: 'json',
      success: function(data){     
          $("#chatbox").append(data.contents); //Insert chat log into the #chatbox div                       
          $("#last_id").val(data.last_id); 
          
          //Auto-scroll           
          var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
          if(newscrollHeight > oldscrollHeight){
              $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
          }               
      },
  });
}

$(document).ready(function(){ 
    //If user wants to end session
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit==true){window.location = '/ExhibitionStreamChatLog/chatOut';}      
    });

    //If user submits the form
    $("#submitmsg").click(function () {
        var clientmsg = $("#usermsg").val().replace(/(?:\r\n|\r|\n)/g,'<br/>');
        $.post("/ExhibitionStreamChatLog/chatLog/<?=$stream_id?>", { text: clientmsg });
        $("#usermsg").val("");
        // loadLog()
        return false;
    });
});

</script>
