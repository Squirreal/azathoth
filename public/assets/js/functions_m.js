(function (jQuery, YYUI) {
    "use strict";

    YYUI.site = (function () {
        function init() {
            common();
            router();
        }

        function router() {
            if (typeof(module) === "undfined")  return;
            try {
                eval(module + 'Page()');
            } catch(err){
                //console.log(err);
            }
        }

        function common() {
            $body.on("click", ".link-item", function () {
                var url = $(this).data("url");
                if (url === "/")     return;
                window.top.location.href = url;
            });

            //FastClick.attach(document.body);
        }

        function homePage() {
            swiper();
        }

        function countryPage() {
            swiper();
        }

        function cityPage() {
            swiper();
        }

        function buildingPage() {
            swiper();
            tags();
            navbar();
            calc();
        }

        function presalePage() {
            swiper();
            tags();
            calc();
        }

        function swiper() {
            new Swiper('.swiper .swiper-container', {
                autoplay: {
                    delay: 3000,
                    stopOnLastSlide: false,
                    disableOnInteraction: true
                },
                pagination: {
                    el: '.swiper-pagination'
                }
            });
        }

        function tags() {
            new Swiper('.swiper-tags .swiper-container', {

            });

            $body.on("click", ".swiper-tags .title-item", function () {
                var index = $(this).index();
                $(this).parent().find(".title-item").removeClass("active");
                $(this).addClass("active");
                $(this).parent().parent().find(".intro-item").removeClass("active");
                $(this).parent().parent().find(".intro-item:eq(" + index + ")").addClass("active");
            });
        }

        function calc() {
            $body.on("click", "#btn-calc", function () {
                $("#calc-container").addClass("show");
            });
            $body.on("click", "#calc-container .btn-close", function () {
                $("#calc-container").removeClass("show");
                $("#calc-container .calc-result").addClass("hide");
            });

            $body.on("click", "#calc-container .btn-confirm", function () {
                layer.open({type: 2});
                $.post(window.location.href, {
                    calc: 1,
                    amount: $("#calc-amount").val(),
                    year: $("#calc-year").val(),
                    paymentRatio: $("#calc-payment-ratio").val(),
                    rate: $("#calc-lending-rate").val()
                }, function (resp) {
                    layer.closeAll();
                    if (resp.status === 'y') {
                        $("#calc-container .calc-result").removeClass("hide");
                        $("#calc-result-loan-amount").text(resp.data.loanAmount);
                        $("#calc-result-monthly-payment").text(resp.data.monthlyPayment);
                        $("#calc-result-yearly-payment").text(resp.data.yearlyPayment);
                    } else {
                        layer.open({
                            content: resp.msg,
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                    }
                });
            });

            $body.on("click", "#calc-container .btn-reset", function () {
                $("#calc-amount").val("");
                $("#calc-container .calc-result").addClass("hide");
            });
        }

        function navbar() {
            var $nav = $("#nav");

            $body.on("click", "#nav div", function () {
                $nav.find("div").removeClass("active");
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
                if (scrollTop >= 300) {
                    if (!$nav.hasClass("show")) {
                        $nav.addClass("show");
                    }
                } else {
                    if ($nav.hasClass("show")) {
                        $nav.removeClass("show");
                    }

                }
            });

            $(".waypoint").waypoint({
                handler: function(direction) {
                    $nav.find("div").removeClass("active");
                    $nav.find("div[data-target='" + this.element.id + "']").addClass("active");
                },
                offset: '60'
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