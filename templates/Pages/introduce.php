<style>
    * {
        box-sizing: inherit;
    }
    .wrap {
        font-family: 'NanumBarunGothic';
    }
    @font-face { font-family: 'NanumBarunGothic';
    src: url('/fonts/NanumBarunGothic.eot');
    src: url('/fonts/NanumBarunGothic.eot') format('embedded-opentype'),
    url('/fonts/NanumBarunGothic.woff') format('woff');}
    .container {
        width: 100%;
        margin-right: auto;
        margin-left: auto;
    }
    section{
        margin-right: auto;
        margin-left: auto;
        width: 100%;
        height: 100vh;
        border: none;
    }
    .h-100 {
        height: 100% !important;
    }
    .align-items-center {
        align-items: center !important;
    }
    .justify-content-center {
        justify-content: center !important;
    }
    .d-flex {
        display: flex;
    }
    .center {
        text-align: center;
    }
    video {
        height: 95vh;
        width: 100%;
        object-fit: cover; // use "cover" to avoid distortion
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        color: white;
        position: absolute;
        right: 45px;
        animation: arrow 2s .2s both;
        animation-iteration-count: infinite;
    }
    .section1>.swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet {
        font-size: 0;
        background: white;
        margin-bottom: 40px;
        margin-right: 25px;
    }
    #section3--slide>.swiper-pagination-bullets .swiper-pagination-bullet {
        width: 50px;
        height: 8px;
        border-radius: 4px;
        font-size: 0;
        background: white;
    }
    #section3--slide>.swiper-pagination {
        width: 36vh;
        bottom: 4vh;
        margin-left: 30px;
    }


    /* Section1 */
    .section1 {
        background-image: linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),url("/img/introduce/행사현장1.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 95vh;
        border: none;
        position: relative;
    }
    .section1--title {
        padding-top: 20vh;
        flex-direction: column;
    }
    .section1--title__div {
        display: flex;
    }
    .section1--title__txt {
        color: white;
        font-size: 60px;
        font-weight: 800;
        animation: fade 1s ease-out;
    }
    .section1--title__second {
        margin-left: 16px;
    }
    .section1--title__img {
        margin-top: 40px;
    }
    .section1--img {
        width: 30vh;
        animation: fade 1s linear;
        margin-top: 50px;
    } 
    .section1--title__button {
        margin-top: 15vh;
    }
    .section1__button {
        width: 200px;
        height: 50px;
        color: white;
        border: 1px solid white;
        border-radius: 8px;
        font-weight: 600;
    }
    .section1__button:active,
    .section1__button:hover,
    .section1__button:focus {
        outline: 0;
    }
    .section1--title__bottom {
        color: #E1E1E1;
        font-size: 24px;
        font-weight: 500;
        position: absolute;
        margin-bottom: 35vh;
    }

    /* Section2 */
    .section2 {
        height: 100vh;
        position: relative;
    }
    .section2--container {
        margin-right: 0px;
        height: 100vh;
        position: absolute;
        right: 20vh;
        top: 200px;
        animation: fade 1s .2s both;
    }
    .section2--title__img {
    }
    .section2--img {
        width: 155vh;;
        margin-top: 35px;
        opacity: 0;

    }
    .section2--title__txt {
        font-size: 60px;
        font-weight: 700;
    }
    .section2--title__txt2 {
        font-size: 24px;
        font-weight: 400;
        color: #ABABAB;
        margin-top: 1vh;
    }
    .section2--title__txt3 {
        font-size: 16px;
        margin-top: 5vh;
        line-height: 35px;
    }
    #section2--slide .swiper-slide.swiper-slide-active img{
        animation: fade2 5s .2s both;
    }
    #section2--slide .swiper-slide {
    }

    /* Section3 */
    .section3 {
        background-color: #333333;
        height: 100vh;
        position: relative;
    }
    .section3--title {
        position: absolute;
        top: 10vh;
    }
    .section3--title__txt {
        font-size: 60px;
        font-weight: 700;
        color: #ffffff;
    }
    .section3--title__txt2 {
        font-size: 24px;
        font-weight: 400;
        color: #ABABAB;
        margin-top: 2.5vh;
    }
    .section3--slide__txt {
        display: flex;
        /* position: absolute; */
        top: 30vh;
        width: 40%;
        margin-right: 5%;
    }
    .section3--txt__num {
        font-size: 24px;
        color: white;
    }
    .section3--txt__num:after {
        content:'';
        width: 30vh;
        height: 0.3vh;
        background: white;
        position: absolute;
        margin-top: 1.5vh;
        margin-left: 2.5vh;
    }
    .section3--txt__words {
        margin-left: 6vh;
        width: 100%;
        color: white;
    }
    .section3--txt__words1 {
        font-size: 24px;
        font-weight: 700;
        margin-top: 3.5vh;
    }
    .section3--txt__words2 {
        font-size: 20px;
        font-weight: 700;
        margin-top: 9vh;
    }
    .section3--txt__words3 {
        font-size: 16px;
        color: #CBCBCB;
        margin-top: 1vh;
    }
    #section3--slide {
        height: 100vh;
    }
    .section3--slide__img {
        /* position: absolute; */
        top: 30vh;
        right: 20vh;
    }
    .section3--img {
        width: 580px;
        height: 340px;
        border-radius: 12px;
    }
    .section3--slide__div {
        display: flex;
        margin-top: 40vh;
        height: 50vh;
    }
    .section3--img__shadow {
        box-shadow: 0px 0px 28px #000000;
    }

    /* Section4 */
    .section4 {
        background-image: url('/img/introduce/EXON-process-배경.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .container {
        position: relative;
    }
    .section4--title__txt {
        font-size: 60px;
        font-weight: 700;
    }
    .section4--title__txt2 {
        font-size: 24px;
        font-weight: 400;
        color: #ABABAB;
        margin-top: 1vh;
    }
    .section4--title__txt3 {
        font-size: 16px;
        margin-top: 5vh;
        line-height: 35px;
    }
    .section4--title {
        position: absolute;
        right: 0;
        width: 45%;
        top: 10vh;
    }
    .section4--box__wrap {
        justify-content: space-around;
        position: absolute;
        width: 100%;
        top: 60vh;
    }
    .section4--box__div {
        width: 15%;
        text-align: center;
    }
    .section4--box__img {
        width: 11vh;
        height: 10vh;
        border-radius: 12px;
        margin: 0 auto;
        box-shadow: 10px 10px 28px #ABABAB;
    }
    .section4--box__txt {
        width: 100%;
        font-size: 1.25rem;
        font-weight: 600;
        color: #FD4659;
        margin-top: 2vh;
    }
    .section4--box__txt2 {
        width: 100%;
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1vh;
    }
    .section4--box__txt3 {
        width: 100%;
        font-size: 0.8rem;
        color: #ABABAB;
        line-height: 2vh;
        margin-top: 1vh;
    }
    

    /* Section5 */
    .section5 {
        background-image: url('/img/introduce/section5-배경.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Section6 */
    .section6 {

    }

    /* Section7 */
    .section7 {
        background-color: #FD4659;
        height: 70vh;
    }


    @media  screen and (max-width: 768px) {
        .section1--title__txt {
            font-size: 3rem;
            line-height: 7vh;
        }
        .section1--title__second {
            margin-left: 0px;
        }
        .section1--img {
            width: 25vh;
            margin-top: 30px;
        } 
        .section1__button {
            height: 55px;
            width: 100%;
            margin-top: 80px;
        }
        .section1--title {
            padding-top: 25vh;
        }
        .section1--title__div {
            display: block;
        }
        .section1--title__bottom {
            top: 350px;
            font-size: 1.23rem;
            left: 20px;
        }
    }
    @media  screen and (min-width: 1200px) {
        .container {
            max-width: 1200px;
        }
    }
    @media  screen and (min-width: 1600px) {
        #section3--slide>.swiper-pagination {
            width: 28vh;
            bottom: 15vh;
        }
        .section2--container {
            margin-right: 150px;
            height: 100vh;
            position: absolute;
            right: 20vh;
            top: 200px;
            animation: fade 1s .2s both;
        }
    }

    @keyframes fade {
    from {
        opacity: 0; 
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0px);
    }	 
    }
    @keyframes fade2 {
    0% {
        opacity: 0; 
        transform: translateX(-100px);
    }
    70% {
        opacity: 1;
        transform: translateX(0px);
    }
    100% {
        opacity: 0;
    }	 
    }
    @keyframes arrow {
    from { 
        transform: translateX(-70px);
    }
    to {
        transform: translateX(0px);
    }
    }	 
</style>

<div class="wrap">
    <section class="section1">
        <div id="section1--slide" class="swiper-container">
            <ul class="swiper-wrapper">
                <li class="swiper-slide">
                    <div class="section1--video__exon">
                        <video muted autoplay loop width="100%" id="section1--video1" class="section1--video">
                            <source src="/video/오프닝 영상.mp4" type="video/mp4">
                        </video>
                    </div>
                </li>
                <li class="swiper-slide">
                    <div class="section1--video__exon">
                        <video muted autoplay loop width="100%" class="section1--video">
                            <source src="/video/EXON 소개 영상.mp4" type="video/mp4">
                        </video>
                    </div>
                </li>
                <li class="swiper-slide">
                    <div class="container">
                        <div class="section1--title h-100 justify-content-center d-flex">
                            <div class="section1--title__div">
                                <div class="section1--title__txt">웨비나 행사를</div>
                                <div class="section1--title__txt section1--title__second">쉽고 빠르게</div>
                            </div>
                            <div class="section1--title__img"><img src="/images/EXON-로고-흰색.png" class="section1--img"></div>
                            <div class="section1--title__button"><button class="section1__button" type="button">지금 시작하기</button></div>
                            <div class="section1--title__bottom">Your Imagination Becomes Reality</div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="swiper-button-next"></div> 
            <!-- <div class="swiper-button-prev"></div> --> 
            <div class="swiper-pagination"></div> 
        </div>
    </section>
    <section class="section2 d-flex" style="padding-left: 0px;">
        <div id="section2--slide" class="swiper-container">
            <ul class="swiper-wrapper">
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경-.png" class="section2--img"></div>
                </li>
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경-3.png" class="section2--img"></div>
                </li>
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경-5.png" class="section2--img"></div>
                </li>
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경-7.png" class="section2--img"></div>
                </li>
            </ul>
        </div>
        <div class="section2--container">
            <div class="section2--title__txt">Who</div>
            <div class="section2--title__txt2">EXON은 웨비나 전문 플랫폼입니다</div>
            <div class="section2--title__txt3">
            EXON은 행사 개설부터 웨비나, 메타버스 기반 <br>
            전시‧박람회가 가능한 온라인 행사 플랫폼입니다. <br>
            EXON의 메타버스 기반의 다양한 인터랙션 기능은  <br>
            온라인 행사의 새로운 시대를 주도합니다.
            </div>
        </div>
    </section>
    <section class="section3">
        <div class="container">
            <div class="section3--title">
                <div class="section3--title__txt">Why</div>
                <div class="section3--title__txt2">EXON은 빠르고 안정적인 서비스를 제공합니다</div>
            </div>
            <div id="section3--slide" class="swiper-container">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <div class="section3--slide__div">
                            <div class="section3--slide__txt">
                                <div class="section3--txt__num">01</div>
                                    <div class="section3--txt__words">
                                        <div class="section3--txt__words1">Easy & Fast</div>
                                        <div class="section3--txt__words2">간단한 사용 방법</div>
                                        <div class="section3--txt__words3">행사 주최자, 참석자 모두 쉽게 사용할 수 있는 인터페이스</div>
                                    </div>
                                </div>
                            <div class="section3--slide__img"><img src="/img/introduce/섹션3-1.png" class="section3--img section3--img__shadow"></div>
                        </div>
                    </li>
                    <li class="swiper-slide">
                        <div class="section3--slide__div">
                            <div class="section3--slide__txt">
                                <div class="section3--txt__num">02</div>
                                    <div class="section3--txt__words">
                                        <div class="section3--txt__words1">Professionalism</div>
                                        <div class="section3--txt__words2">전문성 </div>
                                        <div class="section3--txt__words3">행사 개설, 모집, 운영, 송출, VOD, 데이터 제공 등 All-in-one 솔루션</div>
                                    </div>
                                </div>
                            <div class="section3--slide__img"><img src="/img/introduce/섹션3-1.png" class="section3--img section3--img__shadow"></div>
                        </div>
                    </li>
                    <li class="swiper-slide">
                        <div class="section3--slide__div">
                            <div class="section3--slide__txt">
                                <div class="section3--txt__num">03</div>
                                    <div class="section3--txt__words">
                                        <div class="section3--txt__words1">Stability & Security</div>
                                        <div class="section3--txt__words2">스트리밍 기술</div>
                                        <div class="section3--txt__words3">송출,저장,트랜스코딩 등 OVP(Online Video Platform)를 활용한 실시간 스트리밍 지원</div>
                                    </div>
                                </div>
                            <div class="section3--slide__img"><img src="/img/introduce/섹션3-1.png" class="section3--img section3--img__shadow"></div>
                        </div>
                    </li>
                    <li class="swiper-slide">
                        <div class="section3--slide__div">
                            <div class="section3--slide__txt">
                                <div class="section3--txt__num">04</div>
                                    <div class="section3--txt__words">
                                        <div class="section3--txt__words1">Data Solution</div>
                                        <div class="section3--txt__words2">통계 데이터</div>
                                        <div class="section3--txt__words3">참가자, 행사신청, 설문, 스트리밍 시청 데이터 </div>
                                    </div>
                                </div>
                            <div class="section3--slide__img"><img src="/img/introduce/섹션3-1.png" class="section3--img section3--img__shadow"></div>
                        </div>
                    </li>
                </ul>
                <div class="swiper-pagination"></div> 
            </div>
        </div>
    </section>
    <section class="section4">
        <div class="container">
            <div class="section4--title">
                <div class="section4--title__txt">How</div>
                <div class="section4--title__txt2">EXON에서는 쉽고 빠른 행사 개설이 가능합니다</div>
                <div class="section4--title__txt3">
                    EXON플랫폼은 간편화 된 행사 개설 프로세스를 통해 보다 쉽고 편리하게 
                    웨비나를 개설하고 방송할 수 있으며 간단한 본인인증 절차만 걸치면 
                    회원가입 없이도 웨비나에 신청 참여할 수 있습니다.         
                </div>
            </div>
            <div class="section4--box__wrap d-flex">
                <div class="section4--box__div">
                    <div class="section4--box__img select"></div>
                    <div class="section4--box__txt">STEP 01</div>
                    <div class="section4--box__txt2">행사 개설/모집</div>
                    <div class="section4--box__txt3">
                        일정, 모집 기간<br>
                        행사 내용 작성 <br>
                        유/무료 티켓 설정 <br>
                        설문 작성 
                    </div>
                </div>
                <div class="section4--box__div">
                    <div class="section4--box__img"></div>
                    <div class="section4--box__txt">STEP 02</div>
                    <div class="section4--box__txt2">웨비나 세팅</div>
                    <div class="section4--box__txt3">
                        웨비나 중계팀 신청    <br>
                        결제 진행 <br>
                        스트리밍키 발급 
                    </div>
                </div>
                <div class="section4--box__div">
                    <div class="section4--box__img"></div>
                    <div class="section4--box__txt">STEP 03</div>
                    <div class="section4--box__txt2">웨비나 진행</div>
                    <div class="section4--box__txt3">
                        스트리밍 송출 <br>
                        발표자료 Up/Down <br>
                        Q&A 
                    </div>
                </div>
                <div class="section4--box__div">
                    <div class="section4--box__img"></div>
                    <div class="section4--box__txt">STEP 04</div>
                    <div class="section4--box__txt2">행사 종료</div>
                    <div class="section4--box__txt3">
                        통계 데이터 <br>
                        행사 VOD 다운
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section5">
        <div class="container">
        </div>
    </section>
    <section class="section6">
        <div class="container">
        </div>
    </section>
    <section class="section7">
        <div class="container">
        </div>
    </section>
</div>



<script>
    //slide 
    const slide1 = new Swiper('#section1--slide', {
        loop : true,
        navigation: {
            nextEl: "#section1--slide .swiper-button-next",
            prevEl: "#section1--slide .swiper-button-prev",
                    },
        pagination: {
            el: ".swiper-pagination", //페이징 태그 클래스 설정 
            clickable: true, //버튼 클릭 여부 
            type : 'bullets', //페이징 타입 설정(종류: bullets, fraction, progressbar) 
            // Bullet Numbering 설정 
            loop: true, //슬라이드 반복 
                    },
        autoplay: {
            delay: 25000,
            disableOnInteraction: false,
        },
    });
    const slide2 = new Swiper('#section2--slide', {
        loop : true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });
    const slide3 = new Swiper('#section3--slide', {
        loop : true,
        pagination: {
            el: ".swiper-pagination", //페이징 태그 클래스 설정 
            clickable: true, //버튼 클릭 여부 
            type : 'bullets', //페이징 타입 설정(종류: bullets, fraction, progressbar) 
            // Bullet Numbering 설정 
            loop: true, //슬라이드 반복 
                    },
        spaceBetween: 30,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    });
</script>