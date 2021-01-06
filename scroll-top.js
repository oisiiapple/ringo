jQuery(document).ready(function($) {
    $(window).scroll(function() {
        var a = $(window).scrollTop();
        if (a > 1000) {
            // 「#page-top」だと動作しない
            $(".page-top p").fadeIn("slow");
        } else {
            $(".page-top p").fadeOut("slow");
        }
    });

    $("#move-page-top").on("click", function(){
        $("html, body").animate({scrollTop:0}, "slow");
    });
});
