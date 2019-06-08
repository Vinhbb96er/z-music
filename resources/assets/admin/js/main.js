(function (jQuery) {

    // Variable
    var $ = jQuery;
    $.fn.ripple = function () {
        $(this).click(function (e) {
            var rippler = $(this),
                ink = rippler.find(".ink");

            if (rippler.find(".ink").length === 0) {
                rippler.append("<span class='ink'></span>");
            }


            ink.removeClass("animate");
            if (!ink.height() && !ink.width()) {
                var d = Math.max(rippler.outerWidth(), rippler.outerHeight());
                ink.css({
                    height: d,
                    width: d
                });
            }

            var x = e.pageX - rippler.offset().left - ink.width()/2;
            var y = e.pageY - rippler.offset().top - ink.height()/2;
            ink.css({
              top: y+'px',
              left:x+'px'
            }).addClass("animate");
        });
    };

    $.fn.carouselAnimate = function()
    {
        function doAnimations(elems)
        {
          var animEndEv = 'webkitAnimationEnd animationend';

          elems.each(function () {
            var $this = $(this),
            $animationType = $this.data('animation');
            $this.addClass($animationType).one(animEndEv, function () {
              $this.removeClass($animationType);
            });
          });
        }

        var $myCarousel          = this;
        var $firstAnimatingElems = $myCarousel.find('.item:first')
                                              .find('[data-animation ^= "animated"]');

        doAnimations($firstAnimatingElems);
        $myCarousel.carousel('pause');
        $myCarousel.on('slide.bs.carousel', function (e) {
          var $animatingElems = $(e.relatedTarget)
          .find("[data-animation ^= 'animated']");
          doAnimations($animatingElems);
        });
    };


    this.hide = function()
    {
        $(".tree").hide();
        $(".sub-tree").hide();
    };


    this.treeMenu = function()
    {

        $('.tree-toggle').click(function(e){
            e.preventDefault();
            var $this = $(this).parent().children('ul.tree');
            $(".tree").not($this).slideUp(600);
            $this.toggle(700);

            $(".tree").not($this).parent("li").find(".tree-toggle .right-arrow").removeClass("fa-angle-down").addClass("fa-angle-right");
            $this.parent("li").find(".tree-toggle .right-arrow").toggleClass("fa-angle-right fa-angle-down");
        });

        $('.sub-tree-toggle').click(function(e) {
            e.preventDefault();
            var $this = $(this).parent().children('ul.sub-tree');
            $(".sub-tree").not($this).slideUp(600);
            $this.toggle(700);

            $(".sub-tree").not($this).parent("li").find(".sub-tree-toggle .right-arrow").removeClass("fa-angle-down").addClass("fa-angle-right");
            $this.parent("li").find(".sub-tree-toggle .right-arrow").toggleClass("fa-angle-right fa-angle-down");
        });
    };



    this.leftMenu =  function()
    {

         $('.opener-left-menu').on('click', function(){
            $(".line-chart").width("100%");
            $(".mejs-video").height("auto").width("100%");
            if($('#right-menu').is(":visible"))
            {
               $('#right-menu').animate({ 'width': '0px' }, 'slow', function(){
                      $('#right-menu').hide();
                  });
            }
            if( $('#left-menu .sub-left-menu').is(':visible') ) {
                $('#content').animate({ 'padding-left': '0px'}, 'slow');
                $('#left-menu .sub-left-menu').animate({ 'width': '0px' }, 'slow', function(){
                    $('.overlay').show();
                      $('.opener-left-menu').removeClass('is-open');
                      $('.opener-left-menu').addClass('is-closed');
                    $('#left-menu .sub-left-menu').hide();
                });

            }
            else {
                $('#left-menu .sub-left-menu').show();
                $('#left-menu .sub-left-menu').animate({ 'width': '230px' }, 'slow');
                $('#content').animate({ 'padding-left': '230px','padding-right':'0px'}, 'slow');
                $('.overlay').hide();
                      $('.opener-left-menu').removeClass('is-closed');
                      $('.opener-left-menu').addClass('is-open');
            }
        });
    };


    this.userList = function(){

       $(".user-list ul").niceScroll({
            touchbehavior:true,
            cursorcolor:"#FF00FF",
            cursoropacitymax:0.6,
            cursorwidth:24,
            usetransition:true,
            hwacceleration:true,
            autohidemode:"hidden"
        });

    };


    this.rightMenu =  function(){
            $('.opener-right-menu').on('click', function(){
            userList();
            $(".user").niceScroll();
            $(".user ul li").on('click',function(){
                $(".user-list ul").getNiceScroll().remove();
                $(".user").hide();
                $(".chatbox").show(1000);
                userList();
            });

            $(".close-chat").on("click",function(){
                $(".user").show();
                $(".chatbox").hide(1000);
            });

            $(".line-chart").width("100%");

            if($('#left-menu .sub-left-menu').is(':visible')) {
                $('#left-menu .sub-left-menu').animate({ 'width': '0px' }, 'slow', function(){
                    $('#left-menu .sub-left-menu').hide();
                     $('.overlay').show();
                      $('.opener-left-menu').removeClass('is-open');
                      $('.opener-left-menu').addClass('is-closed');
                });

                $('#content').animate({ 'padding-left': '0px'}, 'slow');
            }

            if($('#right-menu').is(':visible') ) {
                $('#right-menu').animate({ 'width': '0px' }, 'slow', function(){
                    $('#right-menu').hide();
                });
                $('#content').animate({ 'padding-right': '0px'}, 'slow');
            }
            else {
                $('#right-menu').show();
                $('#right-menu').animate({ 'width': '230px' }, 'slow');
                $('#content').animate({ 'padding-right': '230px'}, 'slow');
            }
        });
    };



    $(".box-v6-content-bg").each(function(){
          $(this).attr("style","width:" + $(this).attr("data-progress") + ";");
    });

    $('.carousel-thumb').on('slid.bs.carousel', function () {
          if($(this).find($(".item")).is(".active"))
          {
              var Current  = $(this).find($(".item.active")).attr("data-slide");
              $(".carousel-thumb-img li img").removeClass("animated rubberBand");
              $(".carousel-thumb-img li").removeClass("active");

              $($(".carousel-thumb-img").children()[Current]).addClass("active");
              $($(".carousel-thumb-img li").children()[Current]).addClass("animated rubberBand");
          }
    });



    $(".carousel-thumb-img li").on("click",function(){
        $(".carousel-thumb-img li img").removeClass("animated rubberBand");
        $(".carousel-thumb-img li").removeClass("active");
        $(this).addClass("active");
    });

    $("#mimin-mobile-menu-opener").on("click",function(e){
        $("#mimin-mobile").toggleClass("reverse");
        var rippler = $("#mimin-mobile");
        if(!rippler.hasClass("reverse"))
        {
            if(rippler.find(".ink").length == 0) {
              rippler.append("<div class='ink'></div>");
            }
            var ink = rippler.find(".ink");
            ink.removeClass("animate");
            if(!ink.height() && !ink.width())
            {
                var d = Math.max(rippler.outerWidth(), rippler.outerHeight());
                ink.css({height: d, width: d});

            }
            var x = e.pageX - rippler.offset().left - ink.width()/2;
            var y = e.pageY - rippler.offset().top - ink.height()/2;
            ink.css({
              top: y+'px',
              left:x+'px',
            }).addClass("animate");

            rippler.css({'z-index':9999});
            rippler.animate({
              backgroundColor: "#FF6656",
              width: '100%'
            }, 750 );

             $("#mimin-mobile .ink").on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
              function(e){
                $(".sub-mimin-mobile-menu-list").show();
                $("#mimin-mobile-menu-opener span").removeClass("fa-bars").addClass("fa-close").css({"font-size":"2em"});
              });
        }else{

                if(rippler.find(".ink").length == 0) {
                  rippler.append("<div class='ink'></div>");
                }
                var ink = rippler.find(".ink");
                ink.removeClass("animate");
                if(!ink.height() && !ink.width())
                {
                    var d = Math.max(rippler.outerWidth(), rippler.outerHeight());
                    ink.css({height: d, width: d});

                }
                var x = e.pageX - rippler.offset().left - ink.width()/2;
                var y = e.pageY - rippler.offset().top - ink.height()/2;
                ink.css({
                  top: y+'px',
                  left:x+'px',
                }).addClass("animate");
                rippler.animate({
                  backgroundColor: "transparent",
                  'z-index':'-1'
                }, 750 );

                $("#mimin-mobile .ink").on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
                function(e){
                  $("#mimin-mobile-menu-opener span").removeClass("fa-close").addClass("fa-bars").css({"font-size":"1em"});
                  $(".sub-mimin-mobile-menu-list").hide();
                });
        }
    });



    $(".form-text").on("click",function(){
        $(this).before("<div class='ripple-form'></div>");
        $(".ripple-form").on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
          function(e){
              // do something here
              $(this).remove();
           });
    });

    $('.mail-wrapper').find('.mail-left').css('height', $('.mail-wrapper').innerHeight());
    $("#left-menu ul li a").ripple();
    $(".ripple div").ripple();
    $("#carousel-example3").carouselAnimate();
    $("#left-menu .sub-left-menu").niceScroll();
     $(".sub-mimin-mobile-menu-list").niceScroll({
            touchbehavior:true,
            cursorcolor:"#FF00FF",
            cursoropacitymax:0.6,
            cursorwidth:24,
            usetransition:true,
            hwacceleration:true,
            autohidemode:"hidden"
        });

    $(".fileupload-v1-btn").on("click",function(){
      var wrapper = $(this).parent("span").parent("div");
      var path    = wrapper.find($(".fileupload-v1-path"));
      $(".fileupload-v1-file").click();
      $(".fileupload-v1-file").on("change",function(){
          path.attr("placeholder",$(this).val());
          console.log(wrapper);
          console.log(path);
      });
    });

    var datetime = null,
        date = null;

    var update = function () {
        date = moment(new Date())
        datetime.html(date.format('HH:mm'));
        datetime2.html(date.format('dddd, MMMM Do YYYY'));
    };

    $(document).ready(function(){
        datetime = $('.time h1');
        datetime2 = $('.time p');
        update();
        setInterval(update, 1000);
    });


    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    leftMenu();
    rightMenu();
    treeMenu();
    hide();
})(jQuery);

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            showAnimationLoader();
        },
        complete: function () {
            hideAnimationLoader();
        },
    });

    $('.alert-messages-block').delay(10000).hide(300);

    $(document).on('click', '.checkbox-all', function () {
        var check = $(this).prop('checked');

        $('.checkbox-element').each(function () {
            $(this).prop('checked', check);
        });
    });

    $(document).on('click', '.checkbox-element', function () {
        var check = 0;

        $('.checkbox-element').each(function () {
            if ($(this).prop('checked')) {
                check ++;
            }
        });

        if (check == 0 || check != $('.checkbox-element').length) {
            $(document).find('.checkbox-all').prop('checked', false);
        } else if (check == $('.checkbox-element').length) {
            $(document).find('.checkbox-all').prop('checked', true);
        }
    });

    $('.block-all, .active-all').on('click', function () {
        var dataId = [];
        var url = $(this).data('url');
        var msg = $(this).data('msg');

        $('.checkbox-element').each(function () {
            if ($(this).prop('checked')) {
                dataId.push($(this).val());
            }
        });

        if (!dataId.length) {
            alertWarning({message: Lang.get('lang.message.no_select')});

            return false;
        }

        confirmInfo({message: msg}, function () {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    dataId: dataId
                }
            }).done(function (data) {
                if (data.success) {
                    alertSuccess({message: data.message}, function () {
                        location.reload();
                    });
                } else {
                    alertDanger({message: data.message}, function () {
                        location.reload();
                    });
                }
            });
        });
    });

    $(document).on('change', '.user-status', function () {
        if ($(this).val() == $(this).data('old')) {
            $(this).removeClass('changed');
        } else {
            $(this).addClass('changed');
        }
    });

    $(document).on('change', '.media-status', function () {
        if ($(this).val() == $(this).data('old')) {
            $(this).removeClass('changed');
        } else {
            $(this).addClass('changed');
        }
    });

    $('.change-media-status').on('click', function () {
        var data = [];

        $('select.media-status.changed').each(function () {
            data.push({
                id: $(this).data('media'),
                status: $(this).val()
            })
        });

        if (!data.length) {
            alertWarning({message: 'Bạn chưa thay đổi trạng thái nào!'});

            return false;
        }

        confirmInfo({message: 'Bạn có chắc chắn muốn thay đổi tất cả trạng thái này?'}, function () {
            $.ajax({
                url: '/ajax/media/change-status',
                method: 'POST',
                data: {
                    mediaData: data
                }
            }).done(function (data) {
                if (data.success) {
                    alertSuccess({message: data.message}, function () {
                        location.reload();
                    });
                } else {
                    alertDanger({message: data.message}, function () {
                        location.reload();
                    });
                }
            });
        });
    });

    $('.change-user-status').on('click', function () {
        var data = [];

        $('select.user-status.changed').each(function () {
            data.push({
                id: $(this).data('user'),
                status: $(this).val()
            })
        });

        if (!data.length) {
            alertWarning({message: 'Bạn chưa thay đổi trạng thái nào!'});

            return false;
        }

        confirmInfo({message: 'Bạn có chắc chắn muốn thay đổi tất cả trạng thái này?'}, function () {
            $.ajax({
                url: '/ajax/user/change-status',
                method: 'POST',
                data: {
                    userData: data
                }
            }).done(function (data) {
                if (data.success) {
                    alertSuccess({message: data.message}, function () {
                        location.reload();
                    });
                } else {
                    alertDanger({message: data.message}, function () {
                        location.reload();
                    });
                }
            });
        });
    });

    $(document).on('change', '.user-role', function () {
        if ($(this).val() == $(this).data('old')) {
            $(this).removeClass('changed');
        } else {
            $(this).addClass('changed');
        }
    });

    $('.change-user-role').on('click', function () {
        var data = [];

        $('select.user-role.changed').each(function () {
            data.push({
                id: $(this).data('user'),
                role: $(this).val()
            })
        });

        if (!data.length) {
            alertWarning({message: 'Bạn chưa thay đổi quyền nào!'});

            return false;
        }

        confirmInfo({message: 'Bạn có chắc chắn muốn thay đổi tất cả quyền của các người thành viên này?'}, function () {
            $.ajax({
                url: '/ajax/user/change-role',
                method: 'POST',
                data: {
                    userData: data
                }
            }).done(function (data) {
                if (data.success) {
                    alertSuccess({message: data.message}, function () {
                        location.reload();
                    });
                } else {
                    alertDanger({message: data.message}, function () {
                        location.reload();
                    });
                }
            });
        });
    });
});

function showAnimationLoader() {
    $('#process-loader').show();
    $('body').append('<div class="modal-backdrop disable-background fade in"></div>');
    $('body').css('overflow', 'hidden');
}

function hideAnimationLoader() {
    $('#process-loader').hide();
    $('.disable-background').remove();
    $('body').css('overflow', '');
}
