<link rel="stylesheet" href="/../Amazing-PHP/backend/layouts/css/style_header.css">
<div class="header_container">
    <ul class="header_item">
        <li><label class="header_item--child" id="hide_slidebar" for="check_hide_slidebar"><i style="font-size: 20px;" class="fas fa-bars"></i></label></li>
        <input type="checkbox" id="check_hide_slidebar" hidden>
        <li class="header_item--child"><a href="/../Amazing-PHP/backend/">Trang chủ</a></li>
        <li class="header_item--child"><a href="">Sản phẩm</a></li>
    </ul>
    <ul class="header_item">
        <li class="header_item--child"><i class="fas fa-search"></i></li>
        <li class="header_item--child"><i class="far fa-comments"></i></li>
        <li class="header_item--child"><i class="fas fa-bell"></i></li>
    </ul>
</div>
<script>
    $(document).ready(function(){
        $("#hide_slidebar").click(function(){
            var check_show_slidebar = $("#check_hide_slidebar").prop("checked");
            if(check_show_slidebar == false){
                $(".text").addClass("hide");
                $(".slidebar_container").animate({"width":"70px"});
                $(".main_slidebar").removeClass('l-2').addClass('l-1-4');
                $(".main_content").removeClass('l-10').addClass('l-11-6');
            }else{
                $(".slidebar_container").animate({"width":"100%"});
                $(".main_slidebar").removeClass('l-1-4').addClass('l-2');
                $(".main_content").removeClass('l-11-6').addClass('l-10');
                $(".text").removeClass("hide");
            }
        });
    });
</script>