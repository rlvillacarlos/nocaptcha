<?php defined('SYSPATH') or die('No direct script access.'); ?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>NoCAPTCHA</title>

        <!-- Bootstrap Core CSS -->
        <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

        <!-- Plugin CSS -->
        <link href="public/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="public/css/creative.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body id="page-top">

        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">                
                    <a class="navbar-brand page-scroll" href="#page-top">
                        <i class="glyphicon glyphicon-ok-sign"></i>
                        NoCaptcha
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
            </div>
            <!-- /.container-fluid -->
        </nav>



        <section class="bg-primary" id="about">
            <div class="container">
                <div class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">  
                        <div class="row item active">
                            <div class="col-lg-8 col-lg-offset-2 text-center">
                                <h2 class="section-heading">
                                    <i class="fa fa-fw fa-envelope"></i> 
                                    I Gmail therefore I am.
                                </h2>                    
                            </div>
                        </div>                        
                        <div class="row item">
                            <div class="col-lg-8 col-lg-offset-2 text-center">
                                <h2 class="section-heading">
                                    <i class="fa fa-fw fa-youtube-play"></i> 
                                    I Youtube therefore I am.
                                </h2>                    
                            </div>
                        </div>                        
                        <div class="row item">
                            <div class="col-lg-8 col-lg-offset-2 text-center">
                                <h2 class="section-heading">
                                    <i class="fa fa-fw fa-google-plus-square"></i> 
                                    I Google+ therefore I am.
                                </h2>                    
                            </div>
                        </div>                                                
                        <div class="row item">
                            <div class="col-lg-8 col-lg-offset-2 text-center">
                                <h2 class="section-heading">
                                    <i class="fa fa-fw fa-play-circle-o"></i> 
                                    I Google Play therefore I am.
                                </h2>                    
                            </div>
                        </div>                                                
                        <div class="row item">
                            <div class="col-lg-8 col-lg-offset-2 text-center">
                                <h2 class="section-heading">
                                    <i class="fa fa-fw fa-users"></i> 
                                    I am human, I won't CAPTCHA.
                                </h2>                    
                            </div>
                        </div>                                                
                    </div>                    
                </div>
            </div>
        </section>

        <section id="services">
            <?php if(!$isLogged){?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">
                            Feel the NoCAPTCHA experience now!
                        </h2>
                        <hr class="primary">
                    </div>

                    <hr class="light">
                </div>               
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <a href="register" class="page-scroll btn btn-default btn-xl sr-button">
                            <i class="fa fa-fw fa-link"></i> Connect account
                        </a>                        
                    </div>
                </div>
            </div>
            <?php }else{?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-10 center-block" style="float: none">
                        <h2 class="section-heading text-center">
                           Welcome <?=$user?>
                        </h2>
                        <?php if(isset($state)){?>
                        <p class="text-center" style="padding:40px 0px;">
                            You have <?=$state['remaining']?> out of <?=$state['quota']?> auto-human(s)
                            available in your account today.
                        </p>                       
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <a href="disconnect" class="page-scroll btn btn-yellow btn-xl sr-button">
                            <i class="fa fa-fw fa-unlink"></i> Disconnect account
                        </a>                        
                    </div>
                </div>
                
            </div>
            <?php }?>
        </section>


<!--        <section id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                        <h2 class="section-heading">Let's Get In Touch!</h2>
                        <hr class="primary">
                        <p>Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
                    </div>
                    <div class="col-lg-4 col-lg-offset-2 text-center">
                        <i class="fa fa-phone fa-3x sr-contact"></i>
                        <p>123-456-6789</p>
                    </div>
                    <div class="col-lg-4 text-center">
                        <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                        <p><a href="mailto:your-email@your-domain.com">feedback@startbootstrap.com</a></p>
                    </div>
                </div>
            </div>
        </section>-->

        <!-- jQuery -->
        <script src="public/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="public/vendor/scrollreveal/scrollreveal.min.js"></script>
        <script src="public/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

        <!-- Theme JavaScript -->
        <script src="public/js/creative.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.carousel').carousel({inteval:1000});
            });
        </script>
    </body>

</html>
