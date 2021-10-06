<style>
    #header, footer {
        display: none!important;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="../common/css/style.css">
    <script src="../common/js/jquery-3.2.1.min.js"></script>
    <script src="../common/js/slick.js"></script>
    <script src="../common/js/swiper.min.js"></script>
    <script src="../common/js/mobile-detect.min.js"></script>
    <script src="../common/js/responsiveImg.js"></script>   
    <script src="../common/js/common.js"></script>
    <title>EXON</title>
</head>

<body>
    <div class="model-pop-wrap">
        <div class="popup-wrap">
            <div class="popup-head">
                <h1>설문 결과</h1>
                <button id="close" type="button" class="popup-close">팝업닫기</button>
            </div>
            <div class="popup-body">  
                <div class="pop-poll-items-wrap">
                    <div class="pop-poll-item">
                        <p class="tit">어느 계절이 가장 좋나요?</p>
                        <ul>
                            <li><span class="chk-dsg"><input type="radio" id="pp1-1" name="pp1"><label for="pp1-1">봄</label></span></li>
                            <li><span class="chk-dsg"><input type="radio" id="pp1-2" name="pp1"><label for="pp1-2">여름</label></span></li>
                            <li><span class="chk-dsg"><input type="radio" id="pp1-3" name="pp1"><label for="pp1-3">가을</label></span></li>
                            <li><span class="chk-dsg"><input type="radio" id="pp1-4" name="pp1"><label for="pp1-4">겨울</label></span></li>
                        </ul>
                    </div>
                    <div class="pop-poll-item">
                        <p class="tit">핸드폰을 가지고 있나요?</p>
                        <ul>
                            <li><span class="chk-dsg"><input type="radio" id="pp2-1" name="pp2"><label for="pp2-1">봄</label></span></li>
                            <li><span class="chk-dsg"><input type="radio" id="pp2-2" name="pp2"><label for="pp2-2">여름</label></span></li>
                            <li><span class="chk-dsg"><input type="radio" id="pp2-3" name="pp2"><label for="pp2-3">가을</label></span></li>
                            <li><span class="chk-dsg"><input type="radio" id="pp2-4" name="pp2"><label for="pp2-4">겨울</label></span></li>
                        </ul>
                    </div>
                    <div class="pop-poll-item">
                        <p class="tit">행사 내용이 마음에 드시나요</p>
                        <textarea name="" id="" cols="30" rows="3"></textarea>
                    </div>
                </div>        
                <div class="popup-btm alone">     
                    <button id="ok" type="button" class="btn-ty2">확인</button>
                </div>        
            </div>
        </div> 
    </div>
</body>

<script>
    $('#close').on('click', function() {
        window.close();
    });

    $('#ok').on('click', function() {
        window.close();
    });
</script>