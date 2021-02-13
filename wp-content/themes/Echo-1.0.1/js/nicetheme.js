/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-06 15:27:44
 * @Last Modified by: suxing
 * @Last Modified time: 2019-11-01 18:03:58
*/

window.$ = jQuery;
var loading = '<span><div class="spinner-border spinner-border-sm text-primary" role="status"></div></span>';

function toggleCommentAuthorInfo() {
    var changeMsg = '[编辑资料]';
    var closeMsg = '[我写好了]';

    $('.comment-form-info').slideToggle('slow', function () {
        if ($('.comment-form-info').css('display') == 'none') {
            $('#toggle-comment-author-info').html(changeMsg);
        } else {
            $('#toggle-comment-author-info').html(closeMsg);
        }
    });
};

! function (n) {
    "use strict";
    var a = {
        initialize: function () {
            this.event(),this.toggler(), this.sideMenu() , this.navbarSticky(), this.scrollspy()
        },
        event: function () {},
        toggler: function () {
            n(".mobile-menu-toggler").each(function () {
                var a = n(this);
                a.on("click", function () {
                    a.toggleClass("active")
                }), n(window).resize(function () {
                    n(".mobile-menu-toggler").removeClass("active")
                })
            })
        },
        
        mobileMenu: function () {
            n(".mobile-menu-toggler").on("click", function () {
                n(".mobile-sidebar").toggleClass("in")
            }), n(".mobile-sidebar .mobile-overlay").on("click", function () {
                n(".mobile-sidebar").removeClass("in"), n(".mobile-menu-toggler").removeClass("active")
            }), this.sideMenuNavigation(n(".mobile-sidebar")), n(window).resize(function () {
                n(".mobile-sidebar").removeClass("in")
            })
        },
        
        sideMenuNavigation: function (a) {
            a.find(".menu-item-has-children > a").on("click", function (s) {
                var i = n(this);
                i.siblings(".sub-menu")[0] && (s.preventDefault(), i.parent().hasClass("in") ? (i.parent().removeClass("in"), i.parent().find(".in").removeClass("in"), i.parent().find(".sub-menu").stop(!0).slideUp(300)) : (i.closest(".in")[0] || (a.find(".menu-item-has-children.in .sub-menu").stop(!0).slideUp(300), a.find(".menu-item-has-children.in").removeClass("in")), i.parent().addClass("in"), i.parent().siblings(".in").find(".sub-menu").stop(!0).slideUp(300), i.parent().siblings(".in").removeClass("in"), i.siblings(".sub-menu").stop(!0).slideDown(300)))
            });
        },

        sideMenu: function () {
            n(".widget-sub-menu")[0] && this.sideMenuNavigation(n(".widget-sub-menu"))
        },
        
        navbarSticky: function () {
            var a = function (n, a, s) {
                s > a && n.addClass("sticked"), s > a + 50 && n.addClass("in"), 0 == s && n.removeClass("sticked").removeClass("in")
            };
            if (n(".header-sticky")[0]) {
                var s = n(".header-sticky").outerHeight(),
                    i = n(window).scrollTop();
                a(n(".header-sticky"), s, i), n(window).on("scroll", function () {
                    i = n(window).scrollTop(), a(n(".header-sticky"), s, i)
                })
            }
        },
        scrollspy: function () {
            var a = n(".page-toc"),
                s = a.outerHeight(),
                i = [];
            if (a.length) {
                a.find("[data-scrollspy]").each(function (a) {
                    i.push(n(this).data("scrollspy"))
                }), n(window).scroll(function () {
                    ! function () {
                        if (!a.hasClass("spying")) {
                            var e = n(window).scrollTop();
                            i.map(function (i, o) {
                                var t = n("#" + i).offset().top - s,
                                    l = t + n("#" + i).outerHeight();
                                e >= t && e <= l && (a.find(".nav-item").removeClass("active"), n("[data-scrollspy=" + i + "]").parent().addClass("active"))
                            })
                        }
                    }()
                }), a.find("[data-scrollspy]").click(function (i) {
                    i.preventDefault(), a.addClass("spying");
                    var e = n(this).data("scrollspy");
                    a.find(".nav-item").removeClass("active"), n(this).parent().addClass("active"), n("html,body").animate({
                        scrollTop: n("#" + e).offset().top - s
                    }, 800, function () {
                        a.removeClass("spying")
                    })
                })
            }
        }
    };
    n(document).ready(function () {
        a.initialize()
    }), n(window).on("load", function () {
        a.mobileMenu()
    })
}(jQuery);

function toggleDarkMode() {
    $('body').toggleClass('nice-dark-mode')
    if (!$('body').hasClass('nice-dark-mode')) {
        $('.logo-dark').removeClass('d-inline-block')
        $('.logo-dark').addClass('d-none')
        $('.logo-light').removeClass('d-none')
        $('.logo-light').addClass('d-inline-block')
    } else {
        $('.logo-dark').removeClass('d-none')
        $('.logo-dark').addClass('d-inline-block')
        $('.logo-light').removeClass('d-inline-block')
        $('.logo-light').addClass('d-none')
    }
}

jQuery(document).ready(function ($) {
    if (screen.width > 768) {
        // Scroll to Top
        $(window).scroll(function () {
            if ($(this).scrollTop() >= 50) {
                $('#widget-to-top').fadeIn(200);
            } else {
                $('#widget-to-top').fadeOut(200);
            }
        });
        $('.btn-totop').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
        });
    };

    if ($(".header-sticky")[0]) {
        var sidebarHeight = $(".header-sticky").outerHeight()
    } else {
        var sidebarHeight = 30
    };

    $('.sidebar-left, .sidebar-right').theiaStickySidebar({
        // Settings
        additionalMarginTop: sidebarHeight + 25
    });

    if ($(".site-menu .menu-item").hasClass("menu-item-has-children")) {
        $('.site-menu .menu-item-has-children').children('a').append('<span class="menu-icon"><i class="iconfont icon-arrow-down"></i></span>')
    };

    if ($(".mobile-sidebar .menu-item").hasClass("menu-item-has-children")) {
        $('.mobile-sidebar .menu-item-has-children').children('a').append('<span class="menu-icon"><i class="iconfont icon-arrow-down"></i></span>');
        $('.mobile-sidebar .menu-item-has-children').children('a').addClass('menu-link')
    };

    if ($(".widget-sub-menu")[0] && $(".widget-sub-menu .menu-item").hasClass("menu-item-has-children")) {
        $('.widget-sub-menu .menu-item-has-children').children('a').append('<span class="menu-icon"><i class="iconfont icon-arrow-down"></i></span>');
        // $('.widget-sub-menu .menu-item-has-children').children('a').addClass('menu-link')
    };
    
    var owl = $('.banner-index');
    if (owl.length > 0) {
        owl.owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            items: 1,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            responsiveClass:true
            //navText:['<i class="iconfont icon-changyongtubiao-xianxingdaochu-zhuanqu-12"></i>','<i class="iconfont icon-changyongtubiao-xianxingdaochu-zhuanqu-13"></i>']
        })
    };

    function ajax_load_comments(data) {
        var buttonDOM = $('#comments-next-button');
        buttonDOM.hide();

        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: data,
        })
            .done(function (response) {
                if (response) {
                    if (data.commentspage == 'newest') {
                        buttonDOM.data('paged', data.paged * 1 - 1);
                    } else {
                        buttonDOM.data('paged', data.paged * 1 + 1);
                    }
                    $('.' + data.append).append(response);
                    buttonDOM.show();
                } else {
                    buttonDOM.hide();
                }

            })
    };

    /* 
        ## comment button toggle
    */
    $('.btn-comment-smilies').on('click', function (i) { 
        var toggle = $(this).parents('.comment-form-body');
        
        if (!toggle.hasClass('active')) {
            toggle.addClass('active');
        }
        
        $(document).mouseup(function (e){ 
            var div = $(".comment-form-smilies"); 
            if (!div.is(e.target) && div.has(e.target).length === 0) { 
                toggle.removeClass('active');
            }
        });
        
        i.preventDefault();
    } );
    
    /*  
        ##Display Comments
     */
    $(document).on("click", '.btn-comment', function () {
        $(this).toggleClass('show');
        $('.post-comments').toggleClass('show');
        $("body, html").animate({ scrollTop: $("#respond").offset().top }, 800);
    });

    if ($(".comment-form-textarea")[0]) {
        $(".comment-form-textarea textarea").focus(function(){
            $(".comment-form-info").fadeIn()
        })
        
    }
    
    $(document).on('click', '#comments-next-button', function (event) {
        event.preventDefault();
        ajax_load_comments($('#comments-next-button').data());
    });

    $(document).on("click", '.btn-like[data-action="like"]', function () {
        event.preventDefault();
        var $this = $('.btn-like');
        var id = $(this).data("id");
        var html = $this.html();

        if ($this.hasClass('requesting')) {
            return false;
        }

        $this.addClass('requesting').html(loading);
        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: { action: 'echo_like', id, like_action: 'like' },
        })
            .done(function (data) {
                $this.addClass('current').html(html);
                $this.attr('data-action', 'unlike');
                ncPopupTips(1, __.thank_you)
                $('.like-count').html(data.trim());
                // isApollo && apolloAjaxPostLikeSection(id);
            })
            .always(function () {
                $this.removeClass('requesting');
            });
        return false;
    });

    $(document).on("click", '.btn-like[data-action="unlike"]', function () {
        event.preventDefault();
        var $this = $('.btn-like');
        var id = $(this).data("id");
        var html = $this.html();

        if ($this.hasClass('requesting')) {
            return false;
        }

        $this.addClass('requesting').html(loading);

        $this.removeClass('current');

        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: { action: 'echo_like', id, like_action: 'unlike' },
        })
            .done(function (data) {
                $this.removeClass('current').html(html);
                $this.attr('data-action', 'like');
                ncPopupTips(0, __.cancelled)
                $('.like-count').html(data.trim());
                // isApollo && apolloAjaxPostLikeSection(id);
            })
            .always(function () {
                $this.removeClass('requesting');
            });
        return false;
    });

    $(document).on('click', '.site-search-toggler', function (event) {
        event.preventDefault();
        ncPopup('middle', $('#site-search-template').html());
    });

    $(document).on('click', '.btn-share-toggler', function (event) {
        event.preventDefault();
        ncPopup('middle', $('#single-share-template').html());
    });

    $(document).on('click', '.single-popup', function (event) {
        event.preventDefault();
        var img = $(this).data("img");
        var title = $(this).data("title");
        var desc = $(this).data("desc");
        var html = '<div class="text-center"><h6 class="py-1">' + title + '</h6>\
                    <div class="text-muted text-sm mb-2" > '+ desc + ' </div>\
                    <img src="' + img + '" alt="' + title + '" style="width:100%;height:auto;">\
                    </div>'
        ncPopup('small', html)
    });

    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function givenElementInViewport(el, fn) {
        return function () {
            if (isElementInViewport(el)) {
                fn.call();
            }
        }
    }

    function addViewportEvent(el, fn) {
        if (window.addEventListener) {
            addEventListener('DOMContentLoaded', givenElementInViewport(el, fn), false);
            addEventListener('load', givenElementInViewport(el, fn), false);
            addEventListener('scroll', givenElementInViewport(el, fn), false);
            addEventListener('resize', givenElementInViewport(el, fn), false);
        } else if (window.attachEvent) {
            attachEvent('DOMContentLoaded', givenElementInViewport(el, fn));
            attachEvent('load', givenElementInViewport(el, fn));
            attachEvent('scroll', givenElementInViewport(el, fn));
            attachEvent('resize', givenElementInViewport(el, fn));
        }
    }

    $(document).on('click', '.dposts-ajax-load', function (event) {
        event.preventDefault();
        var $this = jQuery(this)
        if ($('.list-ajax-load').hasClass('loading') === false) {
            $('.list-ajax-load').addClass('loading');
            ajax_load_posts($this.data());
        }
    });

    if ($('.list-ajax-load').length > 0) {
        addViewportEvent(document.querySelector('.list-ajax-load'), function () {
            if ($('.dposts-ajax-load').data('comments') == 'comments') {
                return false;
            }

            if ($('.list-ajax-load').hasClass('loading') === false) {
                var data = $('.dposts-ajax-load').data();
                if ($('.dposts-ajax-load').data('paged') <= 3) {
                    $('.list-ajax-load').addClass('loading');
                    ajax_load_posts($('.dposts-ajax-load').data());
                }

            }

        });
    }

    function ajax_load_posts(data, callback = function () { }) {
        $('.ajax-loading').show();

        var loadButton = $('.dposts-ajax-load')
        var listAjaxLoad = $('.list-ajax-load')
        loadButton.hide();

        $.ajax({
            url: globals.ajax_url,
            type: 'POST',
            dataType: 'html',
            data: data,
        })
            .done(function (response) {
                callback();
                loadButton.removeAttr('disabled');
                if (response.trim()) {
                    loadButton.data('paged', data.paged * 1 + 1)
                    $('.' + data.append).append(response);
                    listAjaxLoad.removeClass('loading').show();
                } else {
                    loadButton.attr('disabled', 'disabled');
                    loadButton.addClass('btn-nostyle')
                    loadButton.text(__.reached_the_end).show();
                }
            })
            .fail(function () {
                $('.ajax-loading').hide();
            })
            .always(function () {
                $('.ajax-loading').hide();
                loadButton.show();
            });
    }

    // comment emoji
    var emojiContainer = $('.comment-form-smilies')
    if (emojiContainer && emojiContainer.length > 0) {
        $(document).on('click', '.add-smily', function (e) {
            var commentField = document.getElementById('comment')
            var _self = e.target.dataset.smilies ? e.target : e.target.parentNode;
            var tag = ' ' + _self.dataset.smilies + ' ';

            if (document.selection) {
                commentField.focus();
                sel = document.selection.createRange();
                sel.text = tag;
                commentField.focus()
            } else if (commentField.selectionStart || commentField.selectionStart == '0') {
                var startPos = commentField.selectionStart;
                var endPos = commentField.selectionEnd;
                var cursorPos = endPos;
                commentField.value = commentField.value.substring(0, startPos) + tag + commentField.value.substring(endPos, commentField.value.length);
                cursorPos += tag.length;
                commentField.focus();
                commentField.selectionStart = cursorPos;
                commentField.selectionEnd = cursorPos
            } else {
                commentField.value += tag;
                commentField.focus()
            }
        })
    }

    if ($('#widget-toc').length && toc.tag * 1 !== 0) {
		$('.post-content h' + toc.tag).each(function (index) {
			$(this).attr('id', 'toc-' + index)
        })
	}

	$('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
	    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	      if (target.length) {
	        $('html, body').animate({
	          scrollTop: (target.offset().top - 60)
	        }, 1000, "easeInOutExpo");
	        return false;
	      }
	    }
	});
});// End of use strict
console.log('\n' + ' %c Echo Designed by nicetheme® %c https://www.nicetheme.cn ' + '\n', 'color: #fadfa3; background: #030307; padding:5px 0; font-size:12px;', 'background: #fadfa3; padding:5px 0; font-size:12px;');
