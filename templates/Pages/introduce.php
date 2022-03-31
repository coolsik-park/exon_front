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
        padding-right: 15px;
        padding-left: 15px;
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


    /* Section1 */
    .section1 {
        background-image: linear-gradient(rgba(0,0,0,.7),rgba(0,0,0,.7)),url("/img/introduce/행사현장1.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 95vh;
        border: none;
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
        margin-top: 28vh;
        margin-left: 80vh;
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
            width: 22vh;
        } 
        .section1__button {
            height: 55px;
            width: 100%;
        }
        .section1--title {
            padding-top: 25vh;
        }
        .section1--title__div {
            display: block;
        }
        .section1--title__bottom {
            margin-left: 10vh;
            margin-top: 18vh;
            font-size: 0.9rem;
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
        <div class="container">
            <div class="section1--title h-100 justify-content-center d-flex">
                <div class="section1--title__div">
                    <div class="section1--title__txt">웨비나 행사를</div>
                    <div class="section1--title__txt section1--title__second">쉽고 빠르게</div>
                </div>
                <div class="section1--title__img"><img src="/images/h-logo-w.png" class="section1--img"></div>
                <div class="section1--title__button"><button class="section1__button" type="button">지금 시작하기</button></div>
                <div class="section1--title__bottom">Your Imagination Becomes Reality</div>
            </div>
        </div>
    </section>
</div>