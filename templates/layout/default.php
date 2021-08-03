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
<!--[if IE 9]> <html class="no-js ie9 fixed-layout" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js " lang="en"> <!--<![endif]-->
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Site Meta -->
    <title>EXON</title>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="exon"/>
	<meta property="og:description" content="exon"/>
	<meta property="og:image" content="http://www.exon.co.kr"/>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">

	<!-- Google Fonts -->
 	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700" rel="stylesheet"> 
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
 <body>
	
	<header class="header site-header">
			<div class="container">
                헤더
                <?php if(empty($loguser)): ?>
                <a href="/Users/login">로그인</a>
                <a href="/Users/add">회원가입</a>
            <?php else: ?>
                <!-- log after -->
                <a href="/Users/logout">로그아웃</a>
                <!-- // -->

            <?php endif;?>
			</div><!-- end container -->
		</header><!-- end header -->

        


        

            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        

        <footer class="footer primary-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="widget clearfix">
                            <h4 class="widget-title">EXON</h4>
                            <div class="">
                                <p>(우)11111 라이브몰로 <br><br> 대표전화: 080-111-2222 / 팩스: 02-111-2222</p>
                               
                            </div><!-- end newsletter -->
                        </div><!-- end widget -->
                    </div><!-- end col -->                   
                </div><!-- end row -->
            </div><!-- end container -->
        </footer><!-- end primary-footer -->
        <footer class="footer secondary-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>&copy;LiveMolo, All rights reserved.  (근무시간: 9시~18시 / 토,일,공휴일 제외)</p>
                    </div>

                </div><!-- end row -->
            </div><!-- end container -->
		</footer><!-- end second footer -->

    </div><!-- end wrapper -->


</body>
</html>
