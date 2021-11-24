
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
                    <h2 class="h-ty1"><span class="t1">Top 10</span><span class="t2">지금 핫한 전시 10</span></h2>
                    <div class="main-sect2-hot-item">
                        <a href="exhibition/view/<?php echo $hot[0]['exhibition_id']; ?>" class="main-sd-item">
                            <div class="imgs">
                                <img src="<?php echo $hot[0]['img_path'] . $hot[0]['img_name'];?>" alt="">
                            </div>
                        </a>
                        <div class="desc">
                            <div class="info">
                                <span class="state"><?php if($hot[0]['playing']) echo "진행중"; else echo "진행전"; ?></span>
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
                                        <a href="exhibition/view/<?php echo $list['exhibition_id']; ?>" class="main-sd-item">
                                            <div class="imgs"><img src="<?php echo $list['img_path'] . $list['img_name'];?>" alt=""></div>
                                            <div class="desc">
                                                <div class="info">
                                                    <span class="state"><?php if($list['playing']) echo "진행중"; else echo "진행전"; ?></span>
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
                <div class="main-sect3">
                    <div class="main-slider3">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="/upload/exhibition/@bnr1.jpg" class="responsiveImg" data-media-web="/upload/exhibition/@bnr1.jpg" data-media-mobile="/upload/exhibition/@bnr1-mo.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/@bnr1.jpg" class="responsiveImg" data-media-web="/upload/exhibition/@bnr1.jpg" data-media-mobile="/upload/exhibition/@bnr1-mo.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/@bnr1.jpg" class="responsiveImg" data-media-web="/upload/exhibition/@bnr1.jpg" data-media-mobile="/upload/exhibition/@bnr1-mo.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/@bnr1.jpg" class="responsiveImg" data-media-web="/upload/exhibition/@bnr1.jpg" data-media-mobile="/upload/exhibition/@bnr1-mo.jpg" alt=""></div>
                                <div class="swiper-slide"><img src="/upload/exhibition/@bnr1.jpg" class="responsiveImg" data-media-web="/upload/exhibition/@bnr1.jpg" data-media-mobile="/upload/exhibition/@bnr1-mo.jpg" alt=""></div>
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
                                            <a href="exhibition/view/<?php echo $list['exhibition_id']; ?>">
                                            <div class="imgs"><img src="<?php echo $list['img_path'] . $list['img_name'];?>" alt=""></div>
                                            <div class="desc">
                                                <div class="info">
                                                    <span class="state"><?php if($list['playing']) echo "진행중"; else echo "진행전"; ?></span>
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
                                            <a href="exhibition/view/<?php echo $list['exhibition_id']; ?>">
                                            <div class="imgs"><img src="<?php echo $list['img_path'] . $list['img_name'];?>" alt=""></div>
                                            <div class="desc">
                                                <div class="info">
                                                    <span class="state"><?php if($list['playing']) echo "진행중"; else echo "진행전"; ?></span>
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
            </div>       
        </div>
    </div>
