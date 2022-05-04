<style>
    * {
        box-sizing: inherit;
        font-family: 'NanumBarunGothic';
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
        height: 800px;
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
        /* animation: arrow 2s .2s both; */
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
        height: 685px;
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
    .section1--title__m {
        display: none;
    }
    #section1--slide {
        display: block;
    }

    /* Section2 */
    .section2 {
        height: 800px;
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
        margin-top: 101px;
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
    #section2--slideM .swiper-slide.swiper-slide-active img{
        animation: fade2 5s .2s both;
    }
    #section2--slideM .swiper-slide {
    }
    #section2--slide {
        display: block;
    }
    #section2--slideM {
        display: none;
    }

    /* Section3 */
    .section3 {
        background-color: #333333;
        height: 800px;
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
        line-height: 20px;
    }
    #section3--slide {
        height: 780px;
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
        height: 800px;
        position: relative;
        overflow: hidden;
    }
    .container {
        
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
        top: 20vh;
    }
    .section4--box__wrap {
        justify-content: space-around;
        position: absolute;
        width: 100%;
        top: 485px;
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
        position: relative;
    }
    .section4--img {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
    }
    .unselect {
        background-color: #ffffff;
    }
    /* .unselect:hover {
        background-color: #FD4659;
    } */
    .select {
        background-color: #FD4659;
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
        /* animation: fade .8s .5s both; */
    }
    .section4--box__txt3 {
        width: 100%;
        font-size: 0.8rem;
        color: #ABABAB;
        line-height: 20px;
        margin-top: 1vh;
    }
    .section4--progress__PC {
        width: 130%;
        position: absolute;
        background-color: #FD4659;
        height: 1em;
        top: 71.5vh;
        left: -15%;
        border-radius: 12px;
        /* animation:  section4--progress 8s 1s both; */
    }
    /* .section4--progress__M {
        width: 100%;
        position: absolute;
        background-color: #FD4659;
        height: 1em;
    } */
    /* .section4--txt__div1 {
        animation: bottomFly 1s 1s both;
    } */
    /* .section4--txt__div2 {
        animation: bottomFly 1s 2s both;
    } 
    .section4--txt__div3 {
        animation: bottomFly 1s 3s both;
    } 
    .section4--txt__div4 {
        animation: bottomFly 1s 4s both;
    } */
    /* .section4--box__img2 {
        animation: section4--box__color 1s 2s both;
    }
    .section4--box__img3 {
        animation: section4--box__color 1s 3s both;
    }
    .section4--box__img4 {
        animation: section4--box__color 1s 4s both;
    } */
    .section4--progress__Mimg {
        display: none;
    }
    .section4--progress__PCimg {
        display: none;
        height: 800px;
        width: 100%;
    }
    .step1Icon {
        font-size: 35px;
        margin-top: 20px;
    }
    .step2Icon {
        font-size: 35px;
        margin-top: 20px;
        /* animation:  section4--icon__color  8s 1s both */
    }
    .step3Icon {
        font-size: 35px;
        margin-top: 20px;
    }
    .step4Icon {
        font-size: 35px;
        margin-top: 20px;
    }
    

    /* Section5 */
    .section5 {
        background-image: url('/img/introduce/section5-배경.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        height: 800px;
        overflow: hidden;
    }
    .section5--title__div {
        color: white;
        width: 40%;
        text-align: right;
        position: absolute;
        top: 22vh;
        margin-right: 10vh;
    }
    .section5--box__txt {
        width: 100%;
        font-size: 7rem;
        font-weight: 600;
        margin-top: 2vh;
        /* animation: rightFly 3s 0s both; */
        opacity: 0;
    }
    .section5--box__txt2 {
        width: 100%;
        font-size: 2rem;
        font-weight: 400;
        margin-top: 4vh;
        line-height: 45px;
        /* animation: rightFly 3s .5s both; */
        opacity: 0;
    }
    .section5--box__txt3 {
        width: 100%;
        font-size: 1rem;
        color: #E9E8E8;
        line-height: 30px;
        margin-top: 4vh;
        /* animation: rightFly 3s 1s both; */
        opacity: 0;
    }
    .section5--txt__bold {
        font-weight: 800;
        color: white;
        font-size: 2.5rem;
    }
    .section5--txt3__bold {
        font-weight: 800;
        font-size: 1.25rem;
        color: white;
    }
    .section5--img__div {
        width: 57%;
        position: absolute;
        right: 5vh;
        top: 19vh;
    }
    .section5--img {
        width: 100%;
    }

    /* Section6 */
    .section6 {
        background-image: url('/img/introduce/section6-배경.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 800px;
    }
    .container {
        position: relative;
    }
    .section6--title__div {
        position: absolute;
        right: 0;
        top: 575px;
    }
    .section6--title__txt {
        font-size: 60px;
        font-weight: 700;
    }
    .section6--title__txt2 {
        font-size: 24px;
        font-weight: 400;
        color: #ABABAB;
        margin-top: 1vh;
        line-height: 30px;
    }
    .section6--img__div {
        position: absolute;
        top: 4em;
    }
    .section6-img1 {
        display: inline-block;
        width: 100%;
        height: 50vh;
        margin-top: 9vh;
        border-top-left-radius: 45%;
        border-top-right-radius: 45%;
    }
    .section6-img2 {
        display: inline-block;
        width: 100%;
        height: 22vh;
        /* margin-top: 0.5em; */
    }
    .section6-img3 {
        display: inline-block;
        width: 100%;
        height: 40vh;
        margin-top: 5em;
        border-top-left-radius: 45%;
    }
    .section6-img4 {
        display: inline-block;
        width: 100%;
        height: 30vh;
        margin-top: 0.5em;
        border-bottom-right-radius: 60%;
    }
    .section6--img__ul {
        column-width: 330px;
	    column-gap: 0.5em;
        width: 60%;
        column-count: 2;
        background-color: white;
    }
    .section6--img__li1:before {
        content:'';
        color: white;
        background: linear-gradient(rgba(0,0,0,.8),rgba(0,0,0,.8));
        width: 100%;
        height: 85%;
        bottom: 0;
        position: absolute;
        opacity: 0;
        border-top-left-radius: 45%;
        border-top-right-radius: 45%;
    }
    .section6--img__li1:after {
        content: '웨비나';
        color: white;
        position: absolute;
        left: 40%;
        top: 60%;
        font-size: 1.5rem;
        font-weight: 700;
        opacity: 0;
    }
    .section6--img__li1 {
        position: relative;
    }
    .section6--img__li1:hover:before {
        opacity: 1;
    }
    .section6--img__li1:hover:after {
        opacity: 1;
    }
    .section6--img__li2:before {
        content:'';
        color: white;
        background: linear-gradient(rgba(0,0,0,.8),rgba(0,0,0,.8));
        width: 100%;
        height: 100%;
        bottom: 0;
        position: absolute;
        opacity: 0;
    }
    .section6--img__li2:after {
        content: '컨퍼런스/포럼';
        color: white;
        position: absolute;
        left: 30%;
        top: 50%;
        font-size: 1.5rem;
        font-weight: 700;
        opacity: 0;
    }
    .section6--img__li2 {
        position: relative;
        margin-top: 0.5em;
    }
    .section6--img__li2:hover:before {
        opacity: 1;
    }
    .section6--img__li2:hover:after {
        opacity: 1;
    }

    .section6--img__li3:before {
        content:'';
        color: white;
        background: linear-gradient(rgba(0,0,0,.8),rgba(0,0,0,.8));
        width: 100%;
        height: 81%;
        bottom: 0;
        position: absolute;
        opacity: 0;
        border-top-left-radius: 45%;
    }
    .section6--img__li3:after {
        content: '교육/강의';
        color: white;
        position: absolute;
        left: 35%;
        top: 60%;
        font-size: 1.5rem;
        font-weight: 700;
        opacity: 0;
    }
    .section6--img__li3 {
        position: relative;
    }
    .section6--img__li3:hover:before {
        opacity: 1;
    }
    .section6--img__li3:hover:after {
        opacity: 1;
    }

    .section6--img__li4:before {
        content:'';
        color: white;
        background: linear-gradient(rgba(0,0,0,.8),rgba(0,0,0,.8));
        width: 100%;
        height: 98%;
        position: absolute;
        bottom: 0;
        opacity: 0;
        border-bottom-right-radius: 60%;
    }
    .section6--img__li4:after {
        content: 'E-sports';
        color: white;
        position: absolute;
        left: 37%;
        top: 50%;
        font-size: 1.5rem;
        font-weight: 700;
        opacity: 0;
    }
    .section6--img__li4 {
        position: relative;
    }
    .section6--img__li4:hover:before {
        opacity: 1;
    }
    .section6--img__li4:hover:after {
        opacity: 1;
    }


    /* Section7 */
    .section7 {
        background-color: #FD4659;
        height: 80vh;
        position: relative;
        border: none;
    }
    .section7--title__div {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        color: white;
        position: relative;
        top: 18vh;
    }
    .section7--logo {
        width: 30vh;
    }
    .section7__button {
        width: 200px;
        height: 50px;
        color: #FD4659;
        border-radius: 8px;
        font-weight: 700;
        background-color: white;
        font-size: 1.25rem;
        margin-top: 30px;
    }
    .section7__button:active,
    .section7__button:hover,
    .section7__button:focus {
        outline: 0;
    }
    .section7--title__txt {
        font-size: 3rem;
        font-weight: 800;
    }
    .section7--title__txt2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 30px;
    }


    @media  screen and (max-width: 768px) {
        .section1--title__txt {
            font-size: 3rem;
            line-height: 7vh;
        }
        .section1 {
            height: 875px;
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
            margin-top: 20px;
        }
        .section1--title {
            padding-top: 25vh;
        }
        .section1--title__div {
            display: block;
        }
        .section1--title__bottom {
            top: 42vh;
            font-size: 1.23rem;
            left: 20px;
        }
        .section1--title__m {
            display: block;
        }
        #section1--slide {
            display: none;
        }
        
        .section2 {
            height: 780px;
        }
        .section2--title__txt {
            font-size: 40px;
        }
        .section2--title__txt2 {
            font-size: 1rem;
        }
        .section2--title__txt3 {
            font-size: 12px;
        }
        .section2--container {
            left: 2vh;
            top: 100px;
            right: 0;
        }
        .section2--img {
            width: 1000px;
            height: auto;
            margin-top: 155px;
        }
        #section2--slide {
            display: none;
        }
        #section2--slideM {
            display: block;
        }

        .section3 {
            height: 850px;
        }
        #section3--slide {
            height: 850px;
        }
        .section3--slide__div {
            flex-direction: column;
            margin-top: 34vh;
        }
        .section3--title__txt {
            font-size: 40px;
        }
        .section3--title__txt2 {
            font-size: 1rem;
        }
        .section3--title__txt3 {
            font-size: 12px;
        }
        .section3--slide__txt {
            width: 100%;
        }
        .section3--img {
            width: 100%;
            height: auto;
            margin-top: 3em;
        }
        .section3--txt__num {
            font-size: 1.5em
        }
        .section3--txt__words1 {
            font-size: 1.25em;
        } 
        .section3--txt__words2 {
            font-size: 1.25em;
        }   
        .section3--txt__words3 {
            font-size: 1em;
        }   
        #section3--slide>.swiper-pagination-bullets .swiper-pagination-bullet {
            width: 35px;
        }
        #section3--slide>.swiper-pagination {
            margin-left: 8vh;
            bottom: 15vh;
        }
        .section3--txt__words {
            margin-left: 3vh;
        }

        .section4 {
            height: 140vh;
            background-image: url('/img/introduce/section4-backgroundM.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .section4--box__img {
            left: 14px;
            width: 80px;
            height: 80px;
        }
        .section4--box__txt {
            margin-top: 0;
        }
        .section4--title {
            width: 90%;
            margin-right: 5%;
            top: 6vh;
        }
        .section4--title__txt {
            font-size: 40px;
        }
        .section4--title__txt2 {
            font-size: 1rem;
        }
        .section4--title__txt3 {
            font-size: 12px;
        }
        .section4--box__wrap {
            flex-direction: column;
            width: 96%;
        }
        .section4--txt__div {
            flex-direction: row;
            width: 50%;
            margin-left: 2em;
        }
        .section4--box__div {
            display: flex;
            width: 80%;
            margin-bottom: 3.75em;
        }
        .section4--progress__PC {
            display: none;
        }
        .section4--progress__M {
            display: block;
            width: 16px;
            position: absolute;
            background-color: #FD4659;
            height: 120vh;
            border-radius: 12px;
            left: 80px;
            top: 330px;
            /* animation:  section4--progressM 8s 0.5s both; */
        }
        .section4--progress__Mimg {
            display: block;
        }
        .section4--progress__PCimg {
            display: none;
        }
        .step1Icon {
            font-size: 43px;
            margin-top: 20px;
        }
        .step2Icon {
            font-size: 43px;
            margin-top: 20px;
            /* animation:  section4--icon__color  8s 1s both */
        }
        .step3Icon {
            font-size: 43px;
            margin-top: 20px;
        }
        .step4Icon {
            font-size: 43px;
            margin-top: 20px;
        }

        .section5--img__div {
            width: 120%;
            position: absolute;
            right: -12%;
            top: 58%;
        }
        .section5--box__txt {
            font-weight: 700;
        }
        .section5--title__div {
            color: white;
            width: 90%;
            text-align: center;
            position: absolute;
            top: 5vh;
            margin-right: 5%;
            margin-left: 5%;
        }
        .section5--box__txt {
            font-size: 50px;
        }
        .section5--box__txt2 {
            font-size: 1rem;
        }
        .section5--txt__bold {
            font-size: 1.5rem;
        }
        .section5--box__txt3 {
            font-size: 0.75rem;
            margin-top: 2vh;
        }
        .section5--txt3__bold {
            font-size: 0.9rem;
        }

        .section6 {
            background-image: url('/img/introduce/section6-backgroundM.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .section6--title__div{
            right: 15px;
        }
        .section6--title__txt {
            font-size: 40px;
        }
        .section6--title__txt2 {
            font-size: 1rem;
        }
        .section6--img__ul {
            column-width: auto;
            width: auto;
            height: auto;
            margin-right: 5%;
        }
        .section6-img1 {
            height: auto;
        }
        .section6-img2 {
            height: auto;
        }
        .section6-img3 {
            height: auto;
            margin-top: 9em;
        }
        .section6-img4 {
            height: auto;
        }
        .section6--img__div {
            top: 5.5em;
        }
        .section6--img__li1:before {
            height: 78%;
        }  
        .section6--img__li1:after {
            left: 31%;
            top: 59%;
        }
        .section6--img__li3:before {
            height: 50%;
        }
        .section6--img__li2:after {
            left: 11%;
            top: 37%;
        }
        .section6--img__li3:after {
            left: 22%;
            top: 71%;
        }
        .section6--img__li4:before {
            height: 96%;
        }
        .section6--img__li4:after {
            left: 23%;
            top: 39%;
        }

        .section7--title__txt {
            text-align: center;
            font-size: 1.5rem;
        }
        .section7--title__txt2 {
            text-align: center;
            font-size: 1rem;
        }
        .section7__button {
            width: 300px;
        }
    }
    @media  screen and (max-height: 800px) {
        .section4 {
            height: 177vh;
        }
    }
    @media  screen and (min-width: 1200px) {
        .container {
            max-width: 1200px;
        }
        .section4--progress__M {
            display: none;
        }
    }
    @media  screen and (min-width: 1600px) {
        .section1 {
            height: 890px;
        }
        .section2 {
            height: 980px;
        }
        .section3 {
            height: 980px;
        }
        .section4 {
            height: 1080px;
        }
        .section5 {
            height: 980px;
        }
        .section6 {
            height: 1080px;
        }
        #section3--slide {
            height: 900px;
        }
        #section3--slide>.swiper-pagination {
            width: 28vh;
            bottom: 0vh;
        }
        .section2--container {
            margin-right: 150px;
            height: 100vh;
            position: absolute;
            right: 20vh;
            top: 200px;
            animation: fade 1s .2s both;
        }

        .section4--progress__PC {
            width: 195%;
            left: -70%;
            top:74.5vh;
            /* animation:  section4--progress1600 9s 1s both; */
        }
        /* .section4--txt__div2 {
            animation: bottomFly 1s 2s both;
        } 
        .section4--txt__div3 {
            animation: bottomFly 1s 3s both;
        } 
        .section4--txt__div4 {
            animation: bottomFly 1s 4s both;
        }
        .section4--box__img2 {
            animation: section4--box__color 1s 2s both;
        }
        .section4--box__img3 {
            animation: section4--box__color 1s 3s both;
        }
        .section4--box__img4 {
            animation: section4--box__color 1s 4s both;
        } */
        .section4--progress__M {
            display: none;
        }
        .section4--box__wrap {
            top: 70vh;
        }
        .step1Icon {
            font-size: 50px;
            margin-top: 25px;
        }
        .step2Icon {
            font-size: 50px;
            margin-top: 25px; 
            /* animation:  section4--icon__color  8s 1s both */
        }
        .step3Icon {
            font-size: 50px;
            margin-top: 25px;
        }
        .step4Icon {
            font-size: 50px;
            margin-top: 25px;
        }

        .section6-img1 {
            display: inline-block;
            width: 100%;
        }
        .section6-img2 {
            display: inline-block;
            width: 100%;
            height: 20vh;
        }
        .section6-img3 {
            display: inline-block;
            width: 100%;
            height: 40vh;
            margin-top: 5.5em;
        }
        .section6-img4 {
            display: inline-block;
            width: 100%;
            height: 30vh;
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
    @keyframes rightFly {
        from{
            transform: translateX(-1000px);
        }
        to {
            transform: translateX(0px);
            opacity: 1;
        }
    }
    @keyframes bottomFly {
        from{
            transform: translateY(600px);
            opacity: 0;
        }
        to {
            transform: translateY(0px);
            opacity: 1;
        }
    }
    @keyframes section4--progress {
        from{
            transform: translateX(-1200px);
        }
        to {
            transform: translateX(0px);
        }
    }
    @keyframes section4--progress1600 {
        from{
            transform: translateX(-1600px);
        }
        to {
            transform: translateX(-100px);
        }
    }

    @keyframes section4--progressM {
        from{
            height: 23vh;
        }
        to {
            height: 130vh;
        }
    }
    @keyframes section4--box__color {
        from{
            background: #ffffff;
        }
        to {
            background: #FD4659;
        }
    }
    @keyframes section4--icon__color {
        from{
           
        }
        to {
            color: #ffffff;
        }
    }
    
</style>
<div class="wrap">
    <section id="section1" class="section1">
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
                            <div class="section1--title__button"><a href="/"><button class="section1__button" type="button">지금 시작하기</button></a></div>
                            <div class="section1--title__bottom">Your Imagination Becomes Reality</div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="swiper-button-next"></div> 
            <!-- <div class="swiper-button-prev"></div> --> 
            <div class="swiper-pagination"></div> 
        </div>
        <div class="section1--title__m">
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
        </div>
    </section>
    <section  id="section2" class="section2 d-flex" style="padding-left: 0px;">
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
        <div id="section2--slideM" class="swiper-container">
            <ul class="swiper-wrapper">
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경m-.png" class="section2--img"></div>
                </li>
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경m-3.png" class="section2--img"></div>
                </li>
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경m-5.png" class="section2--img"></div>
                </li>
                <li class="swiper-slide">
                    <div class="section2--title__img"><img src="/img/introduce/Section-2-배경m-7.png" class="section2--img"></div>
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
    <section  id="section3" class="section3">
        <div class="container">
            <div class="section3--title">
                <div class="section3--title__txt">Why</div>
                <div class="section3--title__txt2">EXON은 빠르고 안정적인 서비스를 제공합니다</div>
            </div>
            <div id="section3--slide" class="swiper-container">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <div class="section3--slide__div d-flex">
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
                            <div class="section3--slide__img"><img src="/img/introduce/section3-img-2.png" class="section3--img section3--img__shadow"></div>
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
                            <div class="section3--slide__img"><img src="/img/introduce/section3-img-3.png" class="section3--img section3--img__shadow"></div>
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
                            <div class="section3--slide__img"><img src="/img/introduce/section3-img-4.png" class="section3--img section3--img__shadow"></div>
                        </div>
                    </li>
                </ul>
                <div class="swiper-pagination"></div> 
            </div>
        </div>
    </section>
    <section id="section4"class="section4">
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
            <div class="section4--progress__PCdiv">
                <div class="section4--progress__PC"></div>
                <img class="section4--progress__PCimg" src="/img/introduce/EXON-process-배경.png">
            </div>
            <div class="section4--progress__Mdiv">
                <div class="section4--progress__M"></div>
                <img class="section4--progress__Mimg" src="/img/introduce/section4-backgroundM.png">
            </div>
            <div class="section4--box__wrap d-flex">
                <div class="section4--box__div">
                    <div class="section4--box__img select">
                        <i class="fa-solid fa-chalkboard-user step1Icon" style="color: white;"></i>
                    </div>
                    <div class="section4--txt__div section4--txt__div1">
                        <div class="section4--box__txt">STEP 01</div>
                        <div class="section4--box__txt2">행사 개설/모집</div>
                        <div class="section4--box__txt3">
                            일정, 모집 기간<br>
                            행사 내용 작성 <br>
                            유/무료 티켓 설정 <br>
                            설문 작성 
                        </div>
                    </div>
                </div>
                <div class="section4--box__div">
                    <div class="section4--box__img unselect section4--box__img2">
                        <i class="fa-solid fa-gears step2Icon"></i>
                    </div>
                    <div class="section4--txt__div section4--txt__div2">
                        <div class="section4--box__txt">STEP 02</div>
                        <div class="section4--box__txt2">웨비나 세팅</div>
                        <div class="section4--box__txt3">
                            웨비나 중계팀 신청    <br>
                            결제 진행 <br>
                            스트리밍키 발급 
                        </div>
                    </div>
                </div>
                <div class="section4--box__div">
                    <div class="section4--box__img unselect section4--box__img3">
                        <i class="fa-solid fa-forward-step step3Icon"></i>
                    </div>
                    <div class="section4--txt__div section4--txt__div3">
                        <div class="section4--box__txt">STEP 03</div>
                        <div class="section4--box__txt2">웨비나 진행</div>
                        <div class="section4--box__txt3">
                            스트리밍 송출 <br>
                            발표자료 Up/Down <br>
                            Q&A 
                        </div>
                    </div>
                </div>
                <div class="section4--box__div">
                    <div class="section4--box__img unselect section4--box__img4">
                        <i class="fa-solid fa-hourglass-end step4Icon"></i>
                    </div>
                    <div class="section4--txt__div section4--txt__div4">
                        <div class="section4--box__txt">STEP 04</div>
                        <div class="section4--box__txt2">행사 종료</div>
                        <div class="section4--box__txt3">
                            통계 데이터 <br>
                            행사 VOD 다운
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="section5"class="section5 d-flex">
            <div class="section5--title__div">
                <div class="section5--box__txt">What</div>
                <div class="section5--box__txt2"><span class="section5--txt__bold">EXON</span>은 차별화된 <br><span class="section5--txt__bold">서비스</span>를 제공합니다</div>
                <div class="section5--box__txt3">
                    사용자 중심의 UI/UX 디자인 <span class="section5--txt3__bold">행사 개설/모집</span> <br>
                    RTMP 방식의 고화질 영상 송출이 가능한 <span class="section5--txt3__bold">안정적인 스트리밍 서비스</span> <br>
                    회원가입 없이도 시청 가능한 <span class="section5--txt3__bold">참가자들의 쉬운 접근성 </span><br>
                    경제적인 웨비나 진행으로 인한 <span class="section5--txt3__bold">행사 운영 비용 절감 </span> <br>
                    참가자들의 행사 참여 패턴을 분석한 <span class="section5--txt3__bold"> 데이터를 활용한 행사 분석 </span>
                </div>
            </div>
            <div class="section5--img__div"><img src="/img/introduce/스타벅스카드.jpg" class="section5--img"></div>
    </section>
    <section class="section6">
        <div class="container">
            <div class="section6--img__div">
                <ul class="section6--img__ul">
                    <li class="section6--img__li1"><img src="/img/introduce/section6-img1.png" class="section6-img1"></li>
                    <li class="section6--img__li2"><img src="/img/introduce/section6-img2.png" class="section6-img2"></li>
                    <li class="section6--img__li3"><img src="/img/introduce/section6-img3.png" class="section6-img3"></li>
                    <li class="section6--img__li4"><img src="/img/introduce/section6-img4.png" class="section6-img4"></li>
                </ul>
            </div>
            <div class="section6--title__div">
                <div class="section6--title__txt">Where</div>
                <div class="section6--title__txt2">EXON 플랫폼은 Live와 VOD가 <br>필요한 여러 분야에 활용 가능합니다</div>
            </div>
        </div>
    </section>
    <section class="section7">
        <div class="container">
            <div class="section7--title__div">
                <div class="section7--title__logo"><img src="/images/EXON-로고-검은색.png" class="section7--logo"></div>
                <div class="section7--title__txt">쉽고 빠른 웨비나 행사 개설</div>
                <div class="section7--title__txt2">지금 바로 행사를 개설해보세요.</div>
                <div class="section7--title__btn"><a href="/exhibition/add"><button class="section7__button" type="button">행사 개설하기</button></a></div>
            </div>
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
            delay: 35000,
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
    const slide2m = new Swiper('#section2--slideM', {
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

    const section1 = document.querySelector('#section1');
    const section1Height = section1.getBoundingClientRect().height;
    const section2 = document.querySelector('#section2');
    const section2Height = section2.getBoundingClientRect().height;
    const section3 = document.querySelector('#section3');
    const section3Height = section3.getBoundingClientRect().height;
    const section4 = document.querySelector('#section4');
    const section4Height = section4.getBoundingClientRect().height;
    const section5 = document.querySelector('#section5');
    const section5Height = section5.getBoundingClientRect().height;

    const section4ProgressPc = document.querySelector('.section4--progress__PC');
    const section4ProgressM = document.querySelector('.section4--progress__M');
    const section4TxtDiv2 = document.querySelector('.section4--txt__div2');
    const section4TxtDiv3 = document.querySelector('.section4--txt__div3');
    const section4TxtDiv4 = document.querySelector('.section4--txt__div4');
    const section4BoxImg2 = document.querySelector('.section4--box__img2');
    const section4BoxImg3 = document.querySelector('.section4--box__img3');
    const section4BoxImg4 = document.querySelector('.section4--box__img4'); 
    const step2Icon = document.querySelector('.step2Icon');
    const step3Icon = document.querySelector('.step3Icon');
    const step4Icon = document.querySelector('.step4Icon');

    const section5BoxTxt1 = document.querySelector('.section5--box__txt');
    const section5BoxTxt2 = document.querySelector('.section5--box__txt2');
    const section5BoxTxt3 = document.querySelector('.section5--box__txt3');
    
    document.addEventListener('scroll', ()=>{
        if(window.scrollY > section1Height + section2Height + section3Height + (section4Height - 500)) {
            section5BoxTxt1.style.animation = "rightFly 3s .1s both";
            section5BoxTxt2.style.animation = "rightFly 3s .1s both";
            section5BoxTxt3.style.animation = "rightFly 4s .1s both";
        } else {
        
        }

        if(window.scrollY > section1Height + section2Height + (section3Height - 500)) {
            section4ProgressPc.style.animation = "section4--progress 8s 1s both";
            section4ProgressM.style.animation = "section4--progressM 8s 0.5s both";
            section4TxtDiv2.style.animation = "bottomFly 1s 2s both";
            section4TxtDiv3.style.animation = "bottomFly 1s 3s both";
            section4TxtDiv4.style.animation = "bottomFly 1s 4s both";
            section4BoxImg2.style.animation = "section4--box__color 1s 2s both";
            section4BoxImg3.style.animation = "section4--box__color 1s 3s both";
            section4BoxImg4.style.animation = "section4--box__color 1s 4s both";
            step2Icon.style.animation = "section4--icon__color  1s 2s both";
            step3Icon.style.animation = "section4--icon__color  1s 3s both";
            step4Icon.style.animation = "section4--icon__color  1s 4s both";
        } else {
            
        }

    });
</script>