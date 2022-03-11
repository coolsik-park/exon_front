<head>
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
</head>

<div id="container">       
    <div class="contents">      
        <div class="section-webinar4">
            <div class="webinar-cont">
                <div class="wb-cont1">
                    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" poster="https://orcaexon.co.kr/videos/abcd/orcatv.png" data-setup="{}">
                        <source src="https://orcaexon.co.kr/videos/abcd/EXON_VOD.mp4" type="video/mp4" />
                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to aweb browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                </div>                
            </div>
            <!-- webinar-tab -->
            <div id="webinar-tab" class="webinar-tab">
                <div class="webinar-tab-top">
                    <div class="webinar-toggle">
                        <button type="button" class="webinar-tab-tg">토글버튼</button>                           
                    </div>  
                    <div class="w-tab-wrap">
                        <div class="w-tab-wrap-inner">
                            <ul class="w-tab">
                                <li id="li9" class="" style="display:none;"><button type="button" id="tab9" name="실시간 채팅">실시간 채팅</button></li>
                                <li id="li8" class="" style="display:none;"><button type="button" id="tab8" name="설문">설문</button></li>
                                <li id="li7" class="" style="display:none;"><button type="button" id="tab7" name="공지사항">공지사항</button></li>
                                <li id="li6" class="" style="display:none;"><button type="button" id="tab6" name="질의 응답">질의 응답</button></li>
                                <li id="li5" class="" style="display:none;"><button type="button" id="tab5" name="출석체크">출석체크</button></li>
                                <li id="li4" class="" style="display:none;"><button type="button" id="tab4" name="프로그램">프로그램</button></li>
                                <li id="li3" class="" style="display:none;"><button type="button" id="tab3" name="담당자 정보">담당자 정보</button></li>
                                <li id="li2" class="" style="display:none;"><button type="button" id="tab2" name="개설자 정보">개설자 정보</button></li>
                                <li id="li1" class="" style="display:none;"><button type="button" id="tab1" name="행사 정보">행사 정보</button></li>
                                <li id="li0" class="" style="display:none;"><button type="button" id="tab0" name="자료">자료</button></li>
                            </ul>
                        </div>                            
                    </div>
                </div>   
                <!-- // top -->
                <?= $this->Form->create() ?>   
                <div class="webinar-tab-body">  

                </div>
                <?php $this->Form->end(); ?>    
                <!-- // body-->
            </div>
            <!-- //webinar-tab -->
        </div>
    </div>    
</div>