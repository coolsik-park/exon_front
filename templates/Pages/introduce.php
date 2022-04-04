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
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    section{
        margin-right: auto;
        margin-left: auto;
        width: 100%;
        height: 100vh;
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
    /* .swiper-button-next:after, .swiper-button-prev:after {
        color: white;
    }
    .swiper-button-next {
        right: 5%;
    }
    .swiper-button-prev {
        left: 5%;
    } */
    .swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet {
        width: 50px;
        height: 8px;
        border-radius: 4px;
        font-size: 0;
        background: white;
    }
    .swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet {
        margin-bottom: 40px;
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
        margin-right: 150px;
        height: 100vh;
        position: absolute;
        right: 20vh;
        top: 200px;
    }
    .section2--title__img {
       bottom: 0;
    }
    .section2--img {
        width: 160vh;;
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

    @keyframes fade {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }	 
    }
</style>

<div class="wrap">
    <section class="section1">
        <div id="section1--slide" class="swiper-container">
            <ul class="swiper-wrapper">
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
                <li class="swiper-slide">
                    <div class="section1--video__exon">
                        <video muted autoplay loop width="100%" class="section1--video">
                            <source src="/video/EXON 소개 영상.mp4" type="video/mp4">
                        </video>
                    </div>
                </li>
            </ul>
            <!-- <div class="swiper-button-next"></div> 
            <div class="swiper-button-prev"></div> -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <section class="section2 d-flex" style="padding-left: 0px;">
        <div class="section2--title__img"><img src="/img/introduce/Section-2-배경-.png" class="section2--img"></div>
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
            <div></div>
        </div>
    </section>
</div>



<script>
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
    })
    
    
</script>