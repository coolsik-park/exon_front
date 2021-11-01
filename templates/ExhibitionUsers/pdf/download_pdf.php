<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8"> -->
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="UTF-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../common/js/jquery-3.2.1.min.js"></script>
    <script src="../common/js/slick.js"></script>
    <script src="../common/js/swiper.min.js"></script>
    <script src="../common/js/mobile-detect.min.js"></script>
    <script src="../common/js/responsiveImg.js"></script>   
    <script src="../common/js/common.js"></script>
    <title>EXON</title>    


    <style type="text/css">  
        @font-face {
            font-family: 'NanumGothic';
            font-style: normal;
            font-weight: 400;
        }
        
        *{
            font-family: 'NanumGothic';;
        }
    </style>
</head>
<body style="max-height:300px;">
    <h1 style="text-align: center;">증빙 영수증</h1><br>
    <div style="max-width: 700px;margin: 0 auto;border: 1px solid #dbdbdb;border-radius: 0.938rem;">
        <div style="padding: 3.125rem 1.875rem 1.875rem;">
            <a href="<?=$front_url?>"><img src="<?=$img_src?>" alt="EXON"></a>
        </div>
        <div style="padding: 0 1.875rem 1.875rem;color: #000;">
            <div style="font-size: 1.250rem;line-height: 1.45;">
                <h1 style="margin:0;padding:0;margin-bottom: 3.750rem;font-size: 2.188rem;font-weight: 700;line-height: 1.49;">증빙 영수증</h1>               
                <p style="font-size: 1.25rem;line-height: 1.45;color: #afafaf;"><?=$category?></p>
                <p style=" font-size: 1.875rem;line-height: 1.45;line-height: 1.33;"><?=$title?></p>                
                <ul style="margin:0;padding:0;list-style: none;margin-top: 3.125rem;">
                    <li style="margin-bottom: 1.875rem;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">금액</p>
                        <p style="margin:0;padding:0"><?=$cost?></p>
                    </li>
                    <li style="margin-bottom: 1.875rem;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">신청일</p>
                        <p style="margin:0;padding:0"><?=$apply_date?></p>
                    </li>
                    <li style="margin-bottom: 1.875rem;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">행사 기간</p>
                        <p style="margin:0;padding:0"><?=$sdate?> ~ <?=$edate?></p>
                    </li>
                </ul>
                <ul style="margin:0;padding:0;list-style: none;border-top: 1px solid #afafaf;">
                    <li style="padding: 1.875rem 0 0;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">이름</p>
                        <p style="margin:0;padding:0"><?=$users_name;?></p>
                    </li>
                    <li style="padding: 1.875rem 0 0;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">이메일</p>
                        <p style="margin:0;padding:0"><?=$users_email?></p>
                    </li>
                    <li style="padding: 1.875rem 0;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">연락처</p>
                        <p style="margin:0;padding:0"><?=$users_hp?></p>
                    </li>
                </ul>
                <ul style="margin:0;padding:0;list-style: none;border-top: 1px solid #afafaf;">
                    <li style="padding: 1.875rem 0 0">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">담당자</p>
                        <p style="margin:0;padding:0"><?=$name?></p>
                    </li>
                    <li style="padding: 1.875rem 0 0;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">담당자 이메일</p>
                        <p style="margin:0;padding:0"><?=$email?></p>
                    </li>
                    <li style="padding: 1.875rem 0;">
                        <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;color: #afafaf;">담당자 연락처</p>
                        <p style="margin:0;padding:0"><?=$tel?></p>
                    </li>
                </ul>
            </div>
            <div style="background: #f9f9f9;border-radius: 10px;padding: 1.5rem 1.813rem;font-size: 0.875rem;
            line-height: 1.43;color: #6e6e6e;">
                <p>본 영수증이 발행 된 이후 행사 정보가 달라질 수 있습니다. 행사 시작 전에 행사 페이지에서 변경 사항이
                    없는지 확인해주시기 바랍니다.</p>
                <p style="margin-top: 10px;">본 행사 취소는 '신청 내역 관리'에서 변경하실 수 있습니다.</p>   
                <p style="margin-top: 10px;">기타 행사와 관련된 문의는 행사 담당자에게 문의주시기 바랍니다.</p> 
            </div>
        </div>
    </div>
</body>
</html>