<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../common/js/jquery-3.2.1.min.js"></script>
    <script src="../common/js/slick.js"></script>
    <script src="../common/js/swiper.min.js"></script>
    <script src="../common/js/mobile-detect.min.js"></script>
    <script src="../common/js/responsiveImg.js"></script>   
    <script src="../common/js/common.js"></script>
    <title>EXON</title>
</head>
<body>

    <div style="max-width: 700px;margin: 0 auto;border: 1px solid #dbdbdb;border-radius: 0.938rem;">
        <div style="padding: 3.125rem 1.875rem 1.875rem">
            <a href="<?=$front_url?>"><img src="<?=$front_url?>/images/h1-logo.png" alt="EXON"></a>
        </div>
        <div style="padding: 1.875rem">
            <p style="margin:0;padding:0;font-size: 1.25rem;line-height: 1.45;"><?=$user_name?>님께서 신청하신 <?=$title?> 행사 참가신청이 취소되었습니다.</p>
            <p style="margin-top: 1.875rem;font-size: 1.875rem;line-height: 1.33;font-weight: 700;">참가신청이 취소되었습니다.</p>
            <div style="margin-top: 4.375rem;border-top: 3px solid #000;">   
                <ul style="margin:0;padding:0;list-style: none;padding: 1.25rem 0;font-size: 0.875rem;line-height: 1.43;border-bottom: 1px solid #afafaf;">
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">행사명</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$title?></span></li>
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">모집일시</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$apply_sdate?> ~ <?=$apply_edate?></span></li>
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">행사일시</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$sdate?> ~ <?=$edate?></span></li>
                </ul>
                <ul style="margin:0;padding:0;list-style: none;padding: 1.25rem 0;font-size: 0.875rem;line-height: 1.43;border-bottom: 1px solid #afafaf;">
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">담당자</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$name?></span></li>
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">이메일</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$email?></span></li>
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">연락처</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$tel?></span></li>
                </ul>
                <ul style="margin:0;padding:0;list-style: none;padding: 1.25rem 0;font-size: 0.875rem;line-height: 1.43;">
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">환불금액</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$refund?></span></li>
                    <li style="display:flex;"><span style="display:inline-block;width:20%;padding: 0.313rem 0;font-weight: 700;">취소일시</span><span style="display: inline-block;padding: 0.313rem 0;width: 80%;font-weight: 500;"><?=$now?></span></li>
                </ul>
            </div>
            <div>
                <div class="btn-wp" style="margin-top: 1.875rem;"><a href="<?=$front_url?>" style="width: 220px;margin-right: 10px;display: inline-block;padding: 12px 20px;font-size: 0.938rem;line-height: 1.47;background-color: #000;color: #fff;border-radius: 3px;border: 1px solid #000;text-align: center;text-decoration: none;">EXON 홈페이지 이동</a></div>
                <p style="margin-top: 1.875rem;font-size: 0.875rem;color: #afafaf;line-height: 1.45;">개설자에 의해 참가신청이 취소 되었습니다. 행사 관련 문의는 담당자에게 문의해주세요.</p>
            </div>
        </div>
    </div>

</body>
</html>