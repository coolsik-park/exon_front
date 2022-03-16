<style>
    .subBanner {
        width:1180px; 
        height:239.78px;
    }
    .main-sect2-hot-item .desc .h-ty2{
        word-wrap:break-word;
    }
    .main-sd-item .h-ty3 {
        word-wrap:break-word;
    }
    .swiper-button-next {
        display: none;
    }
    .swiper-button-prev {
        display: none;
    }
    .visible {
        display: block;
    }
    .slider2Div {
        width: 100%;
        height: 260px;
        background: inherit;
        position: absolute;
        left: 0;
        top: 1297px;
    }
    .slider4Div {
        width: 100%;
        height: 260px;
        background: inherit;
        position: absolute;
        left: 0;
        top: 2038px;
    }
    .slider5Div {
        width: 100%;
        height: 260px;
        background: inherit;
        position: absolute;
        left: 0;
        top: 2400px;
    }
    .hotImg {
        width: 580px; height: 292px;
    }
    @media  screen and (max-width: 768px) {
        .subBanner {
            width:375px; 
            height:239.78px;
        }
        .main-slider3 .swiper-slide img {
            height: auto;
        }
        .slider2Div {
            display: none;
        }
        .slider4Div {
            display: none;
        }
        .slider5Div {
            display: none;
        }
        .main-sect2-hot-item {
            flex-direction: column;
        }
        .main-sect2 {
            padding-right: 4vw;
        }
        .main-sect2-hot-item .imgs {
            width: 100%;
        }
        .main-sect2-hot-item .desc {
            padding-left: 0px;
            padding-top: 12px;
            width: 100%;
        }
        .main-sect2-hot-item .desc .h-ty2 {
            margin-top: 1.625rem;
        }
        .main-sect2-hot-item .desc a {
            margin-top: 0.625rem;
            padding: 0.688rem 1rem;
            font-size: 0.8rem;
        }
        .main-slider3 .swiper-slide {
            height: 68.5px;
        }
        .hotImg {
            height: 190px;
        }
        .main-visual .imgs img {
            height: 190px;
        }
        .main-visual {
            padding: 0px;
        }
    }
</style>
<div id="container">
        <div class="main">
            <div class="main-visual">                
                <div class="swiper-container">
                    <div class="swiper-wrapper">
						<?php foreach ($banner as $list): ?>
							<div class="swiper-slide">
								<a href="/exhibition/view/<?php echo $list->exhibition_id; ?>" class="imgs"><img src="<?php echo $list->img_path . $list->img_name;?>" class="responsiveImg" data-media-web="<?php echo $list->img_path . $list->img_name;?>" data-media-mobile="<?php echo $list->img_path . $list->img_name;?>" alt="" ></a>
							</div>
						<?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div> 
                    <div class="swiper-button-prev"></div>    
                    <div class="swiper-pagination pagination-num"></div>                   
                    <div class="swiper-pagination pagination-bottom"></div>
                </div>
            </div>
            
            <div class="static">
                <div class="main-sect1">
                    <div><a href="#" class="arr-link1"><span>EXON 소개</span></a></div>
                    <div><a href="/exhibition/add" class="arr-link1"><span>행사개설</span></a></div>
                </div>
                <div class="main-sect2">
                    <h2 class="h-ty1"><span class="t1">Top 10</span><span class="t2">지금 핫한 행사 10</span></h2>
                    <div class="main-sect2-hot-item">
                        <a href="/exhibition/view/<?php echo $hot[0]['exhibition_id']; ?>" class="main-sd-item">
                        <div class="imgs">
                                <img class="hotImg" src="<?php echo DS . $hot[0]['img_path'] .DS. $hot[0]['img_name'];?>" alt="">
                            </div>
                        </a>
                        <div class="desc">
                            <div class="info">
                                <span class="state">
                                <?php 
                                    if($hot[0]['playing']) : echo "진행중"; 
                                    else : 
                                        if(date('m. d. H:m') < $hot[0]['sdate']) : 
                                            echo "진행전"; 
                                        else :
                                            echo "종료";
                                        endif;
                                    endif;
                                ?>
                                </span>
                                <span class="date"><?php echo $hot[0]['sdate'] . " ~ " . $hot[0]['edate']; ?></span>
                            </div>
                            <h3 class="h-ty2"><?php echo $hot[0]['title']; ?></h3>
                            <p class="tx"><?php echo $hot[0]['description']; ?></p>
                            <a href="exhibition/view/<?php echo $hot[0]['exhibition_id']; ?>" class="btn">자세히 보기</a>
                        </div>
                    </div>
                    <div class="main-slider2">
                        <div class="swiper-container">
                                <div class="swiper-wrapper">
                            <?php foreach($hot as $index => $list): ?>
                                <?php if($index): ?>
                                    <div class="swiper-slide">
                                        <a href="/exhibition/view/<?php echo $list['exhibition_id']; ?>" class="main-sd-item">
                                        <div class="imgs"><img style="width:280px; height:155px;" src="<?php echo DS . $list['img_path'] .DS. $list['img_name'];?>" alt=""></div>
                                            <div class="desc">
                                                <div class="info">
                                                    <span class="state">
                                                        <?php 
                                                            if($list['playing']) : echo "진행중"; 
                                                            else : 
                                                                if(date('m. d. H:m') < $list['sdate']) : 
                                                                    echo "진행전"; 
                                                                else :
                                                                    echo "종료";
                                                                endif;
                                                            endif;
                                                        ?>
                                                    </span>
                                                    <span class="date"><?php echo $list['sdate'] . " ~ " . $list['edate']; ?></span>
                                                </div>
                                                <h3 class="h-ty3"><?php echo $list['title']; ?></h3>
                                                <p class="tx-1"><?php echo $list['description']; ?></p>
                                            </div>
                                        </a>                                    
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>        
                        </div> 
                        <div class="swiper-button-next"></div> 
                        <div class="swiper-button-prev"></div>      
                    </div>                
                </div>
                <div class="slider2Div">
                </div>
                <div class="main-sect3">
                    <div class="main-slider3">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="/upload/exhibition/1.jpg" class="responsiveImg subBanner" data-media-web="/upload/exhibition/1.jpg" data-media-mobile="/upload/exhibition/1.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/2.jpg" class="responsiveImg subBanner" data-media-web="/upload/exhibition/2.jpg" data-media-mobile="/upload/exhibition/2.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/3.jpg" class="responsiveImg subBanner" data-media-web="/upload/exhibition/3.jpg" data-media-mobile="/upload/exhibition/3.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/4.jpg" class="responsiveImg subBanner" data-media-web="/upload/exhibition/4.jpg" data-media-mobile="/upload/exhibition/4.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/5.jpg" class="responsiveImg subBanner" data-media-web="/upload/exhibition/5.jpg" data-media-mobile="/upload/exhibition/5.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/6.jpg" class="responsiveImg subBanner" data-media-web="/upload/exhibition/6.jpg" data-media-mobile="/upload/exhibition/6.jpg" alt=""></div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
                <div class="main-sect4">
                    <div class="h-ty1-wp">
                        <h2 class="h-ty1"><span class="t1">Top 10</span><span class="t2">이번 달에 새로<br>열리는 전시</span></h2>
                        <!-- <a href="#">자세히 보기</a> -->
                    </div>                    
                    <div class="main-slider4">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                            <?php foreach($hot as $index => $list): ?>
                                <div class="swiper-slide">
                                    <div class="swiper-slide">
                                        <div class="main-sd-item">
                                            <a href="/exhibition/view/<?php echo $list['exhibition_id']; ?>">
                                            <div class="imgs"><img style="width:280px; height:155px;" src="<?php echo DS . $list['img_path'] .DS. $list['img_name'];?>" alt=""></div>
                                            <div class="desc" style="width: 271px;">
                                                <div class="info">
                                                    <span class="state">
                                                    <?php 
                                                        if($list['playing']) : echo "진행중"; 
                                                        else : 
                                                            if(date('m. d. H:m') < $list['sdate']) : 
                                                                echo "진행전"; 
                                                            else :
                                                                echo "종료";
                                                            endif;
                                                        endif;
                                                    ?>
                                                    </span>
                                                    <span class="date"><?php echo $list['sdate'] . " ~ " . $list['edate']; ?></span>
                                                </div>
                                                <h3 class="h-ty3"><?php echo $list['title']; ?></h3>
                                                <p class="tx-1"><?php echo $list['description']; ?></p>
                                            </div>
                                            </a>
                                        </div>                                    
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div> 
                        <div class="swiper-button-prev"></div>   
                    </div>                    
                </div>
                <div class="slider4Div">
                </div>
                <div class="main-sect5">
                    <div class="h-ty1-wp">
                        <h2 class="h-ty1"><span class="t1">Top 10</span><span class="t2">일반 전시</span></h2>
                        <!-- <a href="#">자세히 보기</a> -->
                    </div>                    
                    <div class="main-slider5">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                            <?php foreach($hot as $index => $list): ?>
                                <div class="swiper-slide">
                                    <div class="swiper-slide">
                                        <div class="main-sd-item">
                                            <a href="/exhibition/view/<?php echo $list['exhibition_id']; ?>">
                                            <div class="imgs"><img style="width:280px; height:155px;" src="<?php echo DS . $list['img_path'] .DS. $list['img_name'];?>" alt=""></div>
                                            <div class="desc" style="width: 271px;">
                                                <div class="info">
                                                    <span class="state">
                                                    <?php 
                                                        if($list['playing']) : echo "진행중"; 
                                                        else : 
                                                            if(date('m. d. H:m') < $list['sdate']) : 
                                                                echo "진행전"; 
                                                            else :
                                                                echo "종료";
                                                            endif;
                                                        endif;
                                                    ?>
                                                    </span>
                                                    <span class="date"><?php echo $list['sdate'] . " ~ " . $list['edate']; ?></span>
                                                </div>
                                                <h3 class="h-ty3"><?php echo $list['title']; ?></h3>
                                                <p class="tx-1"><?php echo $list['description']; ?></p>
                                            </div>
                                            </a>
                                        </div>                                    
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div> 
                        <div class="swiper-button-prev"></div>   
                    </div>                    
                </div>
                <div class="slider5Div">
                </div>              
            </div>       
        </div>
    </div>

    <script>

        //메인 배너 화살표 
        $('.swiper-container').mouseover(function(){
            $('.swiper-button-next').addClass('visible');
            $('.swiper-button-prev').addClass('visible');
        });
        $('.swiper-container').mouseleave(function(){
            $('.swiper-button-next').removeClass('visible');
            $('.swiper-button-prev').removeClass('visible');
        });

        //slider2 화살표 / 영역 hover 시 
        $('.slider2Div').mouseover(function(){
            $('.main-slider2 .swiper-button-next').addClass('visible');
            $('.main-slider2 .swiper-button-prev').addClass('visible');
        });
        $('.slider2Div').mouseleave(function(){
            $('.main-slider2 .swiper-button-next').removeClass('visible');
            $('.main-slider2 .swiper-button-prev').removeClass('visible');
        });

        //slider2 화살표 / 화살표 영역 hover 시 
        $('.main-slider2 .swiper-button-prev').mouseover(function(){
            $('.main-slider2 .swiper-button-prev').addClass('visible');
        });
        $('.main-slider2 .swiper-button-prev').mouseleave(function(){
            $('.main-slider2 .swiper-button-prev').removeClass('visible');
        });
        $('.main-slider2 .swiper-button-next').mouseover(function(){
            $('.main-slider2 .swiper-button-next').addClass('visible');
        });
        $('.main-slider2 .swiper-button-next').mouseleave(function(){
            $('.main-slider2 .swiper-button-next').removeClass('visible');
        });

        //slider4 화살표 / 영역 hover 시 
        $('.slider4Div').mouseover(function(){
            $('.main-slider4 .swiper-button-next').addClass('visible');
            $('.main-slider4 .swiper-button-prev').addClass('visible');
        });
        $('.slider4Div').mouseleave(function(){
            $('.main-slider4 .swiper-button-next').removeClass('visible');
            $('.main-slider4 .swiper-button-prev').removeClass('visible');
        });

        //slider4 화살표 / 화살표 영역 hover 시 
        $('.main-slider4 .swiper-button-prev').mouseover(function(){
            $('.main-slider4 .swiper-button-prev').addClass('visible');
        });
        $('.main-slider4 .swiper-button-prev').mouseleave(function(){
            $('.main-slider4 .swiper-button-prev').removeClass('visible');
        });
        $('.main-slider4 .swiper-button-next').mouseover(function(){
            $('.main-slider4 .swiper-button-next').addClass('visible');
        });
        $('.main-slider4 .swiper-button-next').mouseleave(function(){
            $('.main-slider4 .swiper-button-next').removeClass('visible');
        });

         //slider5 화살표 / 영역 hover 시 
         $('.slider5Div').mouseover(function(){
            $('.main-slider5 .swiper-button-next').addClass('visible');
            $('.main-slider5 .swiper-button-prev').addClass('visible');
        });
        $('.slider5Div').mouseleave(function(){
            $('.main-slider5 .swiper-button-next').removeClass('visible');
            $('.main-slider5 .swiper-button-prev').removeClass('visible');
        });

        //slider5 화살표 / 화살표 영역 hover 시 
        $('.main-slider5 .swiper-button-prev').mouseover(function(){
            $('.main-slider5 .swiper-button-prev').addClass('visible');
        });
        $('.main-slider5 .swiper-button-prev').mouseleave(function(){
            $('.main-slider5 .swiper-button-prev').removeClass('visible');
        });
        $('.main-slider5 .swiper-button-next').mouseover(function(){
            $('.main-slider5 .swiper-button-next').addClass('visible');
        });
        $('.main-slider5 .swiper-button-next').mouseleave(function(){
            $('.main-slider5 .swiper-button-next').removeClass('visible');
        });

      

    </script>
