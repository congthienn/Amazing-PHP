<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing</title>
    <?php include_once __DIR__ . '/../../Amazing-PHP/assets/vendor/library.php'?>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../frontend/layouts/partials/header.php' ?>
    </div>
    <div>
        <div class="img_ads">
            <div><img src="/../Amazing-PHP/assets/uploads/slider_4.png" width="100%"></div>
            <div><img src="/../Amazing-PHP/assets/uploads/slider_3.png" width="100%"></div>
            <div><img src="/../Amazing-PHP/assets/uploads/slider_1.png" width="100%"></div>
            <div><img src="/../Amazing-PHP/assets/uploads/slider_2.webp" width="100%"></div>
        </div>
        <div class="grid wide">
            <div class="row">
                <div class="col l-4">
                    <figure class="banner">
                        <img src="/../Amazing-PHP/assets/uploads/banner_1.png" class="banner_img">
                    </figure>
                    
                </div>
                <div class="col l-4">
                    <figure class="banner">
                        <img src="/../Amazing-PHP/assets/uploads/banner_2.png" class="banner_img">
                    </figure>
                    
                </div>
                <div class="col l-4">
                    <div class="row">
                        <div class="col-l-12">
                            <figure class="banner">
                                <img src="/../Amazing-PHP/assets/uploads/banner_3.png" class="banner_img">
                            </figure>
                            
                        </div>
                        <div class="col-l-12">
                            <figure style="margin-top: 30px;" class="banner">
                                <img src="/../Amazing-PHP/assets/uploads/banner_4.png" class="banner_img">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../frontend/layouts/partials/footer.php'?>
    </div>
</body>
<script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
<script src="/../Amazing-PHP/assets/vendor/slick/slick.min.js"></script>
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/slick/slick-theme.css">
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/slick/slick.css">
<script>
    $(document).ready(function(){
        $('.img_ads').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
        });
    });
    
</script>
</html>