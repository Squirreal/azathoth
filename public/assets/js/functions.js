(function (jQuery, YYUI) {
    "use strict";

    YYUI.site = (function () {
        function init() {
            router();
            animated();
            header();
            sidebar();
        }

        function router() {
            if (typeof(module) === "undfined")  return;
            try {
                eval(module + 'Page()');
            } catch(err){
                //console.log(err);
            }
        }

        function animated() {
            var t = $(".animated").length,
                i = 0;
            0 != t && $(".animated").each(function() {
                var t = $(this),
                    animate = $(this).data("animate");
                setTimeout(function() {
                    t.addClass(animate)
                }, 150 * i);
                i += 1;
            });
        }

        function homePage() {
            new Swiper('.hot-country .swiper-container', {
                navigation: {
                    nextEl: '.hot-country .swiper-button-next',
                    prevEl: '.hot-country .swiper-button-prev'
                },
                slidesPerView: 4,
                spaceBetween: 15
            });

            new Swiper('.hot-city .swiper-container', {
                navigation: {
                    nextEl: '.hot-city .swiper-button-next',
                    prevEl: '.hot-city .swiper-button-prev'
                },
                slidesPerView: 4,
                spaceBetween: 15
            });
        }

        function countryPage() {
            new Swiper('.hot-city .swiper-container', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                slidesPerView: 4,
                spaceBetween: 15
            });

            navbar();
        }

        function cityPage() {
            navbar();

            $body.on("click", ".pagination li a", function () {
                var page = $(this).data("page");
                $.post(window.location.href, {p:page}, function (html) {
                    $(".section .container").html(html);
                    animated();
                });
            });

        }

        function buildingPage() {
            navbar();

            var imgCount = $(".building-image").length;
            if (imgCount === 1) {
                $(".building-image").addClass("col-1");
            } else if (imgCount === 2) {
                $(".building-image").addClass("col-2");
            } else if (imgCount === 3) {
                $(".building-image").addClass("col-3");
            } else if ($(".building-video").length > 0 && imgCount >= 4 && imgCount < 8) {
                $(".building-image").addClass("col-4");
                $(".building-image:gt(3)").addClass("hide");
            } else if (imgCount === 5) {
                $(".building-image:eq(0)").addClass("col-2");
            }

            $(".js-img-viwer").smartPhoto();

            new Swiper('.swiper-apartment .swiper-container', {
                slidesPerView: 3,
                spaceBetween: 12,
                pagination: {
                    el: '.swiper-pagination',
                    clickable :true,
                }
            });

            var brokerRight = $body.width() - $("#broker").width() - $("#broker").offset().left;
            $("#broker").css("right", brokerRight + "px");
            
            message();
        }

        function presalePage() {
            navbar();

            var imgCount = $(".building-image").length;
            if (imgCount === 1) {
                $(".building-image").addClass("col-1");
            } else if (imgCount === 2) {
                $(".building-image").addClass("col-2");
            } else if (imgCount === 3) {
                $(".building-image").addClass("col-3");
            } else if ($(".building-video").length > 0 && imgCount >= 4 && imgCount < 8) {
                $(".building-image").addClass("col-4");
                $(".building-image:gt(3)").addClass("hide");
            } else if (imgCount === 5) {
                $(".building-image:eq(0)").addClass("col-2");
            }

            $(".js-img-viwer").smartPhoto();

            new Swiper('.swiper-apartment .swiper-container', {
                slidesPerView: 4,
                spaceBetween: 12,
                pagination: {
                    el: '.swiper-pagination',
                    clickable :true,
                }
            });

            var brokerRight = $body.width() - $("#broker").width() - $("#broker").offset().left;
            $("#broker").css("right", brokerRight + "px");

            message();
        }

        function header() {
            var timer = null;
            $body.on("click", ".btn-lang-switcher", function () {
                $("#layer-lang-switcher").addClass("show");
            });
            $body.on("click", "#layer-lang-switcher .close", function () {
                $("#layer-lang-switcher").removeClass("show");
            });
            $body.on("click", ".btn-login,.need-login", function () {
                // $("#layer-login").addClass("show");
                // var url = $("#layer-login .qrcode").data("url") + "?_t=" + new Date().getTime();
                // $("#layer-login .qrcode").css({"background-image":"url('" + url + "')"});
                //
                // window.clearInterval(timer);
                // timer = setInterval(function () {
                //     $.post(url, {'act':'verify'}, function(data) {
                //         if (data.status === 'y') {
                //             window.location.reload();
                //         }
                //     });
                // }, 1000);
                window.top.location.href = "/login?redirect=" + encodeURIComponent(window.location.href);
            });
            // $body.on("click", "#layer-login .close", function () {
            //     $("#layer-login").removeClass("show");
            //     window.clearInterval(timer);
            // });

            $body.on("click", "#btn-share", function () {
                $("#layer-share").addClass("show");
                new QRCode(document.getElementById("qrcode-share"), shareUrl);
            });
            $body.on("click", "#layer-share .close", function () {
                $("#layer-share").removeClass("show");
            });
        }


        function navbar() {
            var $nav = $("#nav");

            $body.on("click", "#nav li", function () {
                $nav.find("li").removeClass("active");
                $(this).addClass("active");
                scrollTo("#" + $(this).data("target"), 500);
            });

            $(window).scroll(function () {
                var scrollTop = 0;
                if (document.body.scrollTop) {
                    scrollTop = document.body.scrollTop;
                } else {
                    scrollTop = document.documentElement.scrollTop;
                }
                //console.log(scrollTop);
                if (scrollTop >= 500) {
                    if (!$nav.hasClass("fixed")) {
                        $nav.addClass("fixed");
                        $nav.animate({
                            top : 0
                        },500, function () {

                        });
                    }
                    if ($("#broker").length > 0) {
                        $("#broker").addClass("fixed");
                    }
                } else {
                    if ($nav.hasClass("fixed")) {
                        $nav.removeClass("fixed");
                        $nav.animate({
                            top : -100
                        },500, function () {

                        });
                    }

                    if ($("#broker").length > 0) {
                        $("#broker").removeClass("fixed");
                    }

                }
            });

            $(".waypoint").waypoint({
                handler: function(direction) {
                    $nav.find("li").removeClass("active");
                    $nav.find("li[data-target='" + this.element.id + "']").addClass("active");
                },
                offset: '160'
            });
        }
        
        function message() {
            $body.on("click", "#btn-consult", function () {
                $("#layer-message").addClass("show");
                $("#msg-form input[name='type']").val($(this).data("type"));
                $("#msg-form input[name='id']").val($(this).data("id"));
            });

            $body.on("click", "#layer-message .close", function () {
                $("#layer-message").removeClass("show");
            });

            $body.on("submit", "#msg-form", function () {
                var check = true;

                $("#msg-form .input").each(function () {
                    if ($.trim($(this).val()) === "") {
                        check = false;
                        $(this).addClass("error");
                    } else {
                        $(this).removeClass("error");
                    }
                });

                if (check) {
                    $("#btn-send").attr("disabled", "disabled");
                    $.post($("#msg-form").attr("action"), $("#msg-form").serialize(), function (resp) {
                        $("#btn-send").removeAttr("disabled");
                        $("#layer-message").removeClass("show");
                        $("#msg-form .input").val("");
                        alert(resp.msg);
                    });
                }

                return false;
            });

            $body.on("keyup", "#msg-form .input", function () {
                if ($.trim($(this).val()) === "") {
                    $(this).addClass("error");
                } else {
                    $(this).removeClass("error");
                }
            });
        }

        function scrollTo(element,speed) {
            if (!speed) {
                speed = 300;
            }
            if (!element) {
                $("html,body").animate({scrollTop:0 },speed);
            } else {
                if (element.length > 0) {
                    $("html,body").animate({scrollTop:$(element).offset().top - 60},speed);
                }
            }
        }

        function sidebar() {
            $body.on("click", "#btn-go-top", function () {
                $("html,body").animate({scrollTop:0 },500);
            });
        }


        return {
            init : init
        }
    })();

    $(document).ready(function () {
        YYUI.site.init();
    });
}($, window.YYUI || {}));