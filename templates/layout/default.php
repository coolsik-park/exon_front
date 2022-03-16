<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */


    $loguser = $this->getRequest()->getSession()->read('Auth.User');

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta property="og:type" content="website"/>
	<meta property="og:title" content="EXON 엑스온"/>
	<meta property="og:description" content="웨비나 개설, 진행 및 실시간 방송 서비스, 온라인 세미나, 컨벤션, 언택트 행사 개최, 진행 및 온라인 방송진행, 행사 홍보"/>
	<meta property="og:image" content="http://www.exon.co.kr"/>
    <meta name="keywords" content="">
    <meta name="description" content="웨비나 개설, 진행 및 실시간 방송 서비스, 온라인 세미나, 컨벤션, 언택트 행사 개최, 진행 및 온라인 방송진행, 행사 홍보">
    <meta name="author" content="">
    <meta name="google-site-verification" content="-8KzMCcsPArgJ4XXXHvmwhqKVYm4kL5X0CTekqr8NqY" />
    <meta name="naver-site-verification" content="2f106c2883a67935638fedcf2fc68912931a27a1" />
    <meta name="naver-site-verification" content="691220371d52b4ab2727e6f7cb48a6f25b810fa9" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/slick.js"></script>
    <script src="/js/swiper.min.js"></script>
    <script src="/js/mobile-detect.min.js"></script>
    <script src="/js/responsiveImg.js"></script>   
    <script src="/js/common.js"></script>
    <title>EXON 엑스온</title>
    
    <style>
        #my-page {
            height: 25px;
            z-index: 100;
        }
        #sub-menu > li {
            padding: 12px 20px;
        }
        .footer__info--img {
            width: 40px;
            margin-left: 10px; 
        }
        .footer__info--imgDiv {
            float: right;
            margin: -30px 0px 20px 0px;
        }
        @media  screen and (max-width: 768px) {
        .footer__info--imgDiv {
            float: left;
            margin: 20px 0px 20px 0px;
        }
        #footer {
            height: 650px;
        }
        }
    </style>
</head>
<body>
 <p id="accessibility"><a href="#container">본문바로가기</a></p>   
 <div id="wrap">
    <header id="header">
        <!-- pc -->
        <div class="static">
            <h1 class="h-logo"><a href="/">EXON</a></h1>
            <div class="header-search">               
                <!-- <form action="#"> -->
                    <fieldset>
                        <legend>행사 검색</legend>
                            <input id="search" type="text" placeholder="찾으시는 행사를 검색해주세요" class="ipt">
                            <button id="search-button" type="button" class="ico-sh">검색</button>
                    </fieldset>                        
                <!-- </form>  -->
            </div>
            <div class="h-elt">                
                <?php if(empty($loguser)): ?>
                <!-- before -->
                    <a href="/users/login">로그인</a>
                    <a href="/users/add">회원가입</a>
                    <a href="/exhibition-users/certification">행사신청내역</a>
                <?php else: ?>
                <!-- log after -->
                    <a href="/users/logout">로그아웃</a>
                    <div id="my-page" style="display:inline-block; padding-left:30px;">
                        <a href="#">마이페이지</a>
                        <br>
                        <ul id="sub-menu" style="display:inline-block;">
                            <li><a href="/users/edit">회원 정보 변경</a></li>
                            <li><a href="/exhibition-users/sign-up/application">신청 내역 관리</a></li>
                            <li><a href="/exhibition/index/all">개설 행사 관리</a></li>
                        </ul> 
                    </div>
                <?php endif;?>
            </div>            
        </div>
        <!-- mo -->
        <div class="static-mo">
            <h1 class="h-logo"><a href="/">EXON</a></h1>
            <button type="button" class="tg-search">검색</button>
            <div class="header-search-mo">
                <div class="search-ipt-wp">
                    <input type="text" placeholder="찾으시는 행사를 검색해주세요" class="ipt">
                    <button type="button" class="search">검색</button>
                </div>                   
                <button type="button" class="cancel">취소</button>
            </div>
            <button type="button" class="tg-menu">메뉴오픈</button>     
        </div>
        <div id="aside">
            <div class="aside-head">
                <a href="/" class="a-logo">EXON</a>
                <button type="button" class="tg-close">메뉴닫기</button>
            </div>
            <div class="aside-body">
                <div class="log-area">
                    <?php if(empty($loguser)): ?>
                        <a href="/users/login" class="btn1">로그인</a>
                        <a href="/users/add" class="btn2">회원가입</a>
                    <?php else: ?>
                        <a href="/users/logout" class="btn1">로그아웃</a>
                    <?php endif; ?>
                    <!-- <div>
                        <a href="#" class="btn3">회원 로그인</a>
                        <a href="#" class="btn3">비회원 신청내역 확인</a>
                    </div>                     -->
                </div>
                <div class="menu">
                    <ul id="nav">
                        <li class="sub-no"><button type="button">EXON 소개</button></li>
                        <li>
                            <button type="button">마이페이지</button>
                            <ul>
                                <li><a href="/users/edit">회원 정보 수정</a></li>
                                <li>
                                    <a href="#">신청 내역 관리</a>
                                    <ul class="lst-depth">
                                        <li><a href="/exhibition-users/sign-up/application">신청 행사</a></li>
                                        <li><a href="/exhibition-users/sign-up/close">종료 행사</a></li>
                                        <li><a href="/exhibition-users/sign-up/cancel">취소/환불</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">개설 행사 관리</a>
                                    <ul class="lst-depth">
                                        <li><a href="/exhibition/index/all">개설 행사</a></li>
                                        <li><a href="/exhibition/index/ongoing">진행중 행사</a></li>
                                        <li><a href="/exhibition/index/temp">임시저장 행사</a></li>
                                        <li><a href="/exhibition/index/ended">종료 행사</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <button type="button">고객센터</button>
                            <ul class="lst-depth">
                                <li><a href="/boards/customer-service">자주하는 질문</a></li>
                                <li><a href="/boards/notice">공지사항</a></li>
                                <li><a href="/boards/add">문의하기</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>        

    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
        

    
    <footer id="footer">
        <div class="static">
            <div class="footer-top">    
                <ul>
                    <li><a href="#">회사소개</a></li>
                    <li><a href="/boards/customer-service">고객센터</a></li>
                    <li><a href="/pages/terms-of-service">서비스 이용약관 </a></li>
                    <li><a href="/pages/personal-info-agreement">개인정보처리방침</a></li>
                    <li><a href="/pages/electronic-transaction">전자금융거래 이용약관</a></li>
                    <li><a href="/pages/refund">취소 및 환불 약관</a></li>
                    <li><a href="/pages/unsubscribe">이메일 주소 무단수집 거부</a></li>
                </ul> 
            </div>
            <div class="footer-btm">
                <div class="f-logo">[엑스온]</div>
                <div class="footer-cs">
                    <p><strong>고객센터</strong> <span>평일 10시~17시 1:1 문의하기</span></p>
                    <p class="link"><a href="mailto:exon@orcatv.co.kr">exon@orcatv.co.kr</a></p>
                </div>
            </div>                           
            <div class="footer-info">                    
                <p class="f-tx1">(주)오르카티비 대표 박기영 | 사업자등록번호 563-87-00725 | 통신판매업 신고번호 제 2021-성남수정-1324<br>
                    개인정보책임자 최찬경 | 경기도 성남시 수정구 대왕판교로 815, 메타버스 허브 419호 | Tel. 031-778-6252</p>
                <p class="f-tx2">엑스온은 통신판매중개자이며 행사에 대한 당사자 및 주최자가 아닙니다. 따라서 엑스온은 등록된 행사에 대하여 책임을 지지 않습니다.</p>   
                <p class="f-copy">copyright ⓒ exon.live, ALL Right Reserved.</p> 
                <div class="footer__info--imgDiv">
                    <a href="https://blog.naver.com/exonlive" target="_blank"><img src="/img/blog.png" class="footer__info--img"></a> 
                    <a href="https://pf.kakao.com/_HxkNJb/chat" target="_blank"><img src="/img/kakao.png" class="footer__info--img"></a> 
                    <a href="https://www.instagram.com/exon.live/" target="_blank"><img src="/img/inst.png" class="footer__info--img"></a> 
                    <a href="https://www.facebook.com/exonlive.world" target="_blank"><img src="/img/fb.png" class="footer__info--img"></a> 
                    <a href="https://www.youtube.com/channel/UC6QVbMRa4r3scRl5tfKXYCQ" target="_blank"><img src="/img/you.png" class="footer__info--img"></a>
                </div> 
            </div>   
        </div>
    </footer>    
 </div>   

 <script>
     ui.slider.mainVisual();
     ui.slider.mainSlider2();
     ui.slider.mainSlider3();
     ui.slider.mainSlider4();
     ui.slider.mainSlider5();
 </script>
</body>
</html>

<script>
    $(document).ready(function () {
        $('#sub-menu').hide();

        $('#my-page').mouseover(function(){
            $('#sub-menu').slideDown();
            $('#my-page').css("position","relative");
            $('#sub-menu').css({"position":"absolute","right":"0px","top":"25px","z-index":"1","background-color":"rgba(255,255,255,1)","border":"1px solid #dbdbdb",
            "width":"130px","text-align":"center"});
        });
        
        $('#my-page').mouseleave(function(){
            $('#sub-menu').hide();
        });
    });

    $(document).on("click", "#search-button", function () {
        var key = $("#search").val();
        if (key == '') {
            window.location.href = "/exhibition/search";
        } else {
            window.location.href = "/exhibition/search/" + key;
        }
    });

    $(document).ready(function(e) {
        $("#search").keydown(function(keyCode) {
            if (keyCode.keyCode == 13) {
                var key = $("#search").val();
                if (key == '') {
                    window.location.href = "/exhibition/search";
                } else {
                    window.location.href = "/exhibition/search/" + key;
                }
            }
        });
    });
</script>