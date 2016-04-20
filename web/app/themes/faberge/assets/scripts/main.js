/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {
    function ajaxPush(URL, pop, title) {
        if (!!pop) {
            history.pushState({
                    href: URL
                },
                title, URL
            );
        }
        if (!safariBug) {
            safariBug = true;
        }
    }
    var safariBug = false;
    var Sage = {
        // All pages
        'common': {
            init: function() {
                $('#responsive_menu_pro_menu .nolink>a').off('click');
                $('#responsive_menu_pro_menu .nolink>a').click(function(e) { e.preventDefault(); })

                $('#responsive_menu_pro_additional_content').click(closeRM);
                window.onpopstate = popstateCallback;
                $('.wpmenucart-contents').click(function(e){ 
                    e.preventDefault();
                    $('.cart-tab').addClass('inview');
                });
                $(document).click( function(e) {
                    if (e.which != 2 && !$(e.target).closest('.cart-tab, .wpmenucart-shortcode').length) { 
                        closeCart() 
                    } 
                });

                //if(typeof productVariation !== 'undefined')$('.variation.default').click();

                function popstateCallback(event) {
                    if (!!event.state) {
                        document.location = event.state.href;
                    } else if (safariBug) {

                        document.location.reload();
                    }
                }

                function closeRM() {
                    $responsive_menu_pro_jquery('#responsive_menu_pro').animate({
                        left: -$responsive_menu_pro_jquery('#responsive_menu_pro').width()
                    }, 500, 'linear', function() {
                        $responsive_menu_pro_jquery('#responsive_menu_pro').css('display', 'none');
                        $responsive_menu_pro_jquery('#responsive_menu_pro').removeClass('responsive_menu_pro_opened');
                        $responsive_menu_pro_jquery('#responsive_menu_pro_button').removeClass('responsive_menu_pro_button_active');
                        if ($responsive_menu_pro_jquery(window).width() >= 2000) {
                            $responsive_menu_pro_jquery('#responsive_menu_pro').removeAttr('style')
                        }
                        isOpen = false
                    })
                }
                 function closeCart() {
                    $('.cart-tab').removeClass('inview');
                }

                function UISearch(el, options) {
                    this.el = el;
                    this.inputEl = el.querySelector('form > input.sb-search-input');
                    this._initEvents();
                }
                UISearch.prototype = {
                    _initEvents: function() {
                        var self = this,
                            initSearchFn = function(ev) {
                                ev.stopPropagation();
                                // trim its value
                                self.inputEl.value = self.inputEl.value.replace(/^\s+|\s+$/g, '');

                                if (!classie.has(self.el, 'sb-search-open')) { // open it
                                    ev.preventDefault();
                                    self.open();
                                } else if (classie.has(self.el, 'sb-search-open') && /^\s*$/.test(self.inputEl.value)) { // close it
                                    ev.preventDefault();
                                    self.close();
                                }
                            };

                        this.el.addEventListener('click', initSearchFn);
                        this.el.addEventListener('touchstart', initSearchFn);
                        this.inputEl.addEventListener('click', function(ev) {
                            ev.stopPropagation();
                        });
                        this.inputEl.addEventListener('touchstart', function(ev) {
                            ev.stopPropagation();
                        });
                    },
                    open: function() {
                        var self = this;
                        classie.add(this.el, 'sb-search-open');
                        // focus the input
                        if (!mobilecheck()) {
                            this.inputEl.focus();
                        }
                        // close the search input if body is clicked
                        var bodyFn = function(ev) {
                            self.close();
                            this.removeEventListener('click', bodyFn);
                            this.removeEventListener('touchstart', bodyFn);
                        };
                        document.addEventListener('click', bodyFn);
                        document.addEventListener('touchstart', bodyFn);
                    },
                    close: function() {
                        this.inputEl.blur();
                        classie.remove(this.el, 'sb-search-open');
                    }
                };
                (function classieCreator() {

                    'use strict';

                    // class helper functions from bonzo https://github.com/ded/bonzo

                    function classReg(className) {
                        return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
                    }

                    // classList support for class management
                    // altho to be fair, the api sucks because it won't accept multiple classes at once
                    var hasClass, addClass, removeClass;

                    if ('classList' in document.documentElement) {
                        hasClass = function(elem, c) {
                            return elem.classList.contains(c);
                        };
                        addClass = function(elem, c) {
                            elem.classList.add(c);
                        };
                        removeClass = function(elem, c) {
                            elem.classList.remove(c);
                        };
                    } else {
                        hasClass = function(elem, c) {
                            return classReg(c).test(elem.className);
                        };
                        addClass = function(elem, c) {
                            if (!hasClass(elem, c)) {
                                elem.className = elem.className + ' ' + c;
                            }
                        };
                        removeClass = function(elem, c) {
                            elem.className = elem.className.replace(classReg(c), ' ');
                        };
                    }

                    function toggleClass(elem, c) {
                        var fn = hasClass(elem, c) ? removeClass : addClass;
                        fn(elem, c);
                    }

                    var classie = {
                        // full names
                        hasClass: hasClass,
                        addClass: addClass,
                        removeClass: removeClass,
                        toggleClass: toggleClass,
                        // short names
                        has: hasClass,
                        add: addClass,
                        remove: removeClass,
                        toggle: toggleClass
                    };

                    // transport
                    if (typeof define === 'function' && define.amd) {
                        // AMD
                        define(classie);
                    } else {
                        // browser global
                        window.classie = classie;
                    }

                })();

                function mobilecheck() {
                    var check = false;
                    (function(a) {
                        if (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
                    })(navigator.userAgent || navigator.vendor || window.opera);
                    return check;
                }
                //var search = new UISearch(document.getElementById('sb-search'));

            },
            finalize: function() {
                // JavaScript to be fired on all pages, after page specific JS is fired
            }
        },
        // Home page
        'home': {
            init: function() {
                // JavaScript to be fired on the home page
            },
            finalize: function() {
                // JavaScript to be fired on the home page, after the init JS
            }
        },
        // About us page, note the change from about-us to about_us.
        'about_us': {
            init: function() {
                // JavaScript to be fired on the about us page
            }
        },
        'store_locator': {
            init: function() {
                $('#addressInputCountry').change(function(e) {
                    cslmap.searchLocations();
                });

            }
        },
        'woocommerce': {
            init: function() {
                $('body').on('click','.variation',variationHandler);
                $('body').on('click','.related.products .type-product>a',ajaxCallback);
                                    var not_first_time = true;
                    $('body').on('woocommerce_variation_select_change','.variations_form', function() {
                        if (not_first_time) {
                            $.fn.wc_variations_image_update = function(variation) {
                                var $form = this,
                                    $product = $form.closest('.product'),
                                    $product_img = $product.find('div.images img:eq(0)'),
                                    $product_link = $product.find('div.images a.zoom:eq(0)'),
                                    variation_link = variation.image_link;
                                if (variation_link) variation_link = variation_link[variation_link.length - 4] === '.' ? variation_link.substr(0, variation_link.length - 4) + '_zoom' + variation_link.substr(variation_link.length - 4) : variation_link + '_zoom';
                                if (variation && variation.image_src && variation.image_src.length > 1) {
                                    $product_img.wc_set_variation_attr('src', variation.image_src);
                                    $product_img.wc_set_variation_attr('title', variation.image_title);
                                    $product_img.wc_set_variation_attr('alt', variation.image_alt);
                                    $product_img.wc_set_variation_attr('srcset', variation.image_srcset);
                                    $product_img.wc_set_variation_attr('sizes', variation.image_sizes);
                                    $product_link.wc_set_variation_attr('href', variation_link);
                                    $product_link.wc_set_variation_attr('title', variation.image_caption);
                                } else {
                                    $product_img.wc_reset_variation_attr('src');
                                    $product_img.wc_reset_variation_attr('title');
                                    $product_img.wc_reset_variation_attr('alt');
                                    $product_img.wc_reset_variation_attr('srcset');
                                    $product_img.wc_reset_variation_attr('sizes');
                                    $product_link.wc_reset_variation_attr('href');
                                    $product_link.wc_reset_variation_attr('title');
                                }
                            };
                            not_first_time = false;
                        }
                    });
                    $('body').on('show_variation','.variations_form', function(event, variation) {

                        var selected = $('.variations-thumbs').children('.active').attr('data-color');
                        if (variation['attributes']['attribute_pa_color'] !== selected) {
                            console.log(variation);
                            $('.variations-thumbs').children().removeClass('active');
                            $('.variations-thumbs').children().filter(function() {
                                //may want to use $.trim in here
                                return $(this).attr('data-color') == variation['attributes']['attribute_pa_color'];
                            }).addClass('active');

                        }
                    });
                function variationHandler(e) {
                    var target = e.currentTarget,
                        variationID = target.id.split('-')[1],
                        variation = productVariation[variationID],
                        subs = variation.variation_image,
                        image = variation.image,
                        $image = $(image),
                        value = variation.value,
                        price = variation.price,
                        priceEl = $('.price>.amount'),
                        attributes = variation.attributes,

                        variations = $('.variations-thumbs'),

                        codeEl = $('.product_title.entry-title .codice'),
                        code = codeEl.text(),


                        bigImage = $('.woocommerce-main-image'),
                        parentEl = bigImage.parent(),
                        oldImage = bigImage.children('img'),
                        oldImageH = oldImage.height(),

                        options = $('#pa_color').children('option'),
                        color = $(target).attr('data-color'),
loading2= function(){ return parentEl.children('.whirl.traditional');},
 loading=loading2();
                            if(!loading.length){
                             loading=$('<div class="whirl traditional" ></div>');
                             loading.hide().appendTo(parentEl);   
                         }
                    bigImage.fadeOut(function() {
                        loading.show();
                        parentEl.css('height', oldImageH);
                        $image.appendTo(bigImage);
                        variations.find('.variation').removeClass('active');
                        $(target).addClass('active');
                        oldImage.remove();
                        options.removeAttr("selected");

                        $('#pa_color>option').filter(function() {
                            //may want to use $.trim in here
                            return $(this).text().toLowerCase() == color;
                        }).prop('selected', true);
                        $form = $('.variations_form');
                        $form.find('.variations select').change();

                        bigImage[0].href = subs;
                        bigImage.imagesLoaded().done(function() {
                            loading.hide();
                            parentEl.css('height', '');
                            bigImage.fadeIn();
                        });


                        codeEl.text(value);
                        priceEl.text(price + '€');
                        if (Object.keys(attributes).length > 1) Object.keys(attributes).forEach(function(el) {
                            if (el !== 'pa_color') {
                                var cells = $('.shop_attributes,.variations_form').find('tr.' + el + '>td.value');
                                cells.forEach(function(cell) {
                                    var text = cell.children('p').length ? cell.children('p') : cell;
                                    text.text(attributes[el]);
                                })
                            }
                        })
                    });
                }

                function ajaxCallback(e) {
                    e.preventDefault();
                    var target = e.currentTarget,
                        targetID = target.parentElement.id.split('-')[1],
                        title = $(target).children('h3').text() + ' - Faberge',
                        loading2= function(){ return $('#container .whirl.traditional');};

                    $.ajax({
                        url: faberge.ajax_url,
                        cache: false,
                        localCache: true,
                        cacheTTL: 1,
                        cacheKey: targetID,
                        type: "POST",
                        headers: { "cache-control": "no-cache" },
                        data: {
                            'action': 'get_product_detail',
                            'product_id': targetID
                        },
                        beforeSend:function(){
                            $('#content').hide();
                            var loading=loading2();
                            if(!loading.length){
                             $('#container').append('<div class="whirl traditional" ></div>');   
                         }else{loading.show();}
                        },
                        success: function(returned) {
                            var loading=loading2();
                            if(loading.length) loading.hide();

                            $('#content').empty().html(returned).fadeIn();
                            document.title = title;
                            ajaxPush(e.currentTarget.href, true, title)                                                        
                            $form = $('.variations_form');
                            if ($form && typeof $form.wc_variation_form === 'function') {
                                $form.wc_variation_form();
                            }
                            faberge_variation_slider();
                            $("a[data-rel^='prettyPhoto'],a.zoom").prettyPhoto({
                                hook: 'data-rel',
                                social_tools: false,
                                theme: 'pp_woocommerce',
                                horizontal_padding: 20,
                                opacity: 0.8,
                                deeplinking: false
                            });
                            


                        }
                    });
                }

                function faberge_variation_slider(){
                if (document.querySelector('#slider-variation') !== null) return new Swiper('#slider-variation', {
                    direction: 'vertical',
                    slidesPerView: 'auto',
                    autoHeight: 'auto',
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                });
                }
                faberge_variation_slider();
                
            }
        },
        'home': {
            init: function() {
                function setConstant() {
                    _obj.win = $(window),
                        _obj.doc = $(document),
                        _obj.html = $("html"),
                        _obj.body = $("body"),
                        _obj.win_w = _obj.win.width(),
                        _obj.win_h = _obj.win.height(),
                        _obj.doc_h = _obj.doc.height(),
                        _obj.ie = !1,
                        _obj.raf = null,
                        _obj.touch = !1,
                        _obj.deltaTop = 60,
                        _obj.shoppingbag = $("#co-shoppingbag"),
                        _obj.shoppingbagList = _obj.shoppingbag.find("ul"),
                        _obj.mainContent = $("#co-main"),
                        _obj.pageContent = $("#co-content"),
                        _obj.pageFooter = $("footer.footer"),
                        _obj.filter = null //,
                        //Modernizr.touch && (_obj.touch = !0),
                    setMobileVariable()
                        //_obj.html.hasClass("ie8") && (_obj.ie = !0)
                }

                function setMobileVariable() {
                    _obj.win_w < 800 ? _obj.isMobile = !0 : _obj.isMobile = !1
                }

                function ArticlesList(a) {
                    a.get(0) && (this.el = a,
                        this.articles = this.el.find(".panel-grid"),
                        this.article_array = [],
                        this.init())
                }
                ArticlesList.prototype = {
                    init: function() {
                        var a = this;
                        //_obj.isMobile || _obj.touch ||
                        this.articles.each(function() {
                            a.article_array.push(new Article($(this)))
                        })
                    },
                    doScroll: function(a) {
                        if (this.el)
                            for (var b = 0; b < this.article_array.length; b++)
                                this.article_array[b].doScroll(a)
                    },
                    resetScroll: function(a) {
                        if (this.el)
                            for (var b = 0; b < this.article_array.length; b++)
                                this.article_array[b].resetScroll(a)
                    },
                    resize: function() {
                        if (this.el)
                            for (var a = 0; a < this.article_array.length; a++)
                                this.article_array[a].resize()
                    }
                };

                function Article(a) {
                    a.get(0) && (this.el = a,
                        this.figure = this.el.find(".widget_sow-image, .widget_sp_image"),
                        this.randomTop = 0,
                        this.init())
                }
                Article.prototype = {
                    init: function() {
                        //this.el.hasClass("shadow") && (this.productOne = this.el.next(".related-products").find(".product").eq(0),
                        //this.productTwo = this.el.next(".related-products").find(".product").eq(1),
                        //this.title = this.el.find(".box-title")),
                        this.el.find(".box-title").get(0) && !this.title && (this.scrollable = this.el.find(".box-title")),
                            //this.el.find(".content").get(0) && (this.scrollable = this.el.find(".content")),
                            //this.el.find(".non-align").get(0) && (this.push = this.el.find("li").eq(1)),
                            //_obj.touch ||
                            //this.title || 1 === this.el.index() || this.el.hasClass("header") ||
                            (this.randomTop = 50),
                            this.loadImage()
                    },
                    loadImage: function() {
                        var a = new Image;
                        a.addEventListener ? a.addEventListener("load", this.onImageLoad.bind(this), !1) : a.attachEvent("load", this.onImageLoad.bind(this)),
                            a.src = this.figure.find("img").attr("src")
                    },
                    onImageLoad: function() {
                        this.loaded = !0,
                            this.resize(),
                            this.doScroll(0)
                    },
                    doScroll: function(a) {
                        if (this.el && this.loaded) {
                            var b = (this.top - a) / _obj.win_h + 0;
                            b > 1 && (b = 1),
                                0 > b && (b = 0),
                                this.scrollable && this.animeScrollable(b),
                                //this.push && this.animePush(b),
                                //this.title && this.scrollShowcase(-a),
                                this.randomTop //&& this.scrollEl(b)
                        }
                    },
                    scrollShowcase: function(a) {
                        this.title.css({
                                "-webkit-transform": "translate3d(0," + a / 2 + "px,0)",
                                "-moz-transform": "translate3d(0," + a / 2 + "px,0)",
                                "-ms-transform": "translate3d(0," + a / 2 + "px,0)",
                                "-o-transform": "translate3d(0," + a / 2 + "px,0)",
                                transform: "translate3d(0," + a / 2 + "px,0)"
                            }),
                            this.productOne.css({
                                "-webkit-transform": "translate3d(0," + a / 3 + "px,0)",
                                "-moz-transform": "translate3d(0," + a / 3 + "px,0)",
                                "-ms-transform": "translate3d(0," + a / 3 + "px,0)",
                                "-o-transform": "translate3d(0," + a / 3 + "px,0)",
                                transform: "translate3d(0," + a / 3 + "px,0)"
                            }),
                            this.productTwo.css({
                                "-webkit-transform": "translate3d(0," + a / 4 + "px,0)",
                                "-moz-transform": "translate3d(0," + a / 4 + "px,0)",
                                "-ms-transform": "translate3d(0," + a / 4 + "px,0)",
                                "-o-transform": "translate3d(0," + a / 4 + "px,0)",
                                transform: "translate3d(0," + a / 4 + "px,0)"
                            })
                    },
                    scrollEl: function(a) {
                        this.el.css({
                            "margin-top": 40 + this.randomTop * a
                        })
                    },
                    resetScroll: function() {
                        this.el && (this.scrollable && this.resetScrollable(),
                            this.push && this.resetPush(),
                            this.title && this.resetSlideshow(),
                            this.el.css({
                                "margin-top": 0
                            }))
                    },
                    animeScrollable: function(a) {
                        var b = a * this.height;
                        this.scrollable.css({
                            "-webkit-transform": "translate3d(0," + b + "px,0)",
                            "-moz-transform": "translate3d(0," + b + "px,0)",
                            "-ms-transform": "translate3d(0," + b + "px,0)",
                            "-o-transform": "translate3d(0," + b + "px,0)",
                            transform: "translate3d(0," + b + "px,0)"
                        })
                    },
                    animePush: function(a) {
                        var b = a * this.height / 2;
                        this.push.css({
                            "margin-top": b
                        })
                    },
                    resetSlideshow: function() {
                        this.title.css({
                                "-webkit-transform": "translate3d(0,0,0)",
                                "-moz-transform": "translate3d(0,0,0)",
                                "-ms-transform": "translate3d(0,0,0)",
                                "-o-transform": "translate3d(0,0,0)",
                                transform: "translate3d(0,0,0)"
                            }),
                            this.productOne.css({
                                "-webkit-transform": "translate3d(0,0,0)",
                                "-moz-transform": "translate3d(0,0,0)",
                                "-ms-transform": "translate3d(0,0,0)",
                                "-o-transform": "translate3d(0,0,0)",
                                transform: "translate3d(0,0,0)"
                            }),
                            this.productTwo.css({
                                "-webkit-transform": "translate3d(0,0,0)",
                                "-moz-transform": "translate3d(0,0,0)",
                                "-ms-transform": "translate3d(0,0,0)",
                                "-o-transform": "translate3d(0,0,0)",
                                transform: "translate3d(0,0,0)"
                            })
                    },
                    resetScrollable: function() {
                        this.scrollable.css({
                            "-webkit-transform": "translate3d(0,0,0)",
                            "-moz-transform": "translate3d(0,0,0)",
                            "-ms-transform": "translate3d(0,0,0)",
                            "-o-transform": "translate3d(0,0,0)",
                            transform: "translate3d(0,0,0)"
                        })
                    },
                    resetPush: function(a) {
                        a * this.height / 2;
                        this.push.css({
                            "margin-top": 0
                        })
                    },
                    resize: function() {
                        this.el && (this.height = 200,
                            this.width = this.figure.find("img").width(),
                            this.top = this.el.offset().top - parseInt(this.el.css("margin-top"), 0))
                    }
                }
                var _obj = {};
                setConstant();
                $('.parallax .so-panel.widget_text ').flowtype({
                    maxFont: 16,
                    fontRatio: 80,
                    minFont: 13
                });

                function doScroll() {
                    Math.floor(_easingScroll) !== _tempScroll && (_tempScroll = Math.floor(_easingScroll),
                        _articlesList.doScroll(_tempScroll))
                }

                function animloop() {
                    _obj.raf = window.requestAnimationFrame(animloop),
                        _easingScroll += .1 * (_scroll - _easingScroll),
                        doScroll()
                }

                function checkScroll() {
                    _obj.isMobile ? _obj.raf && (_articlesList.resetScroll(),
                        window.cancelAnimationFrame(_obj.raf),
                        _obj.win.off("scroll", onScroll),
                        _obj.raf = null) : _obj.raf || (_tempScroll = _easingScroll - 1,
                        animloop(),
                        _obj.win.on("scroll", onScroll))
                }

                function onScroll() {
                    _scroll = _obj.win.scrollTop();
                }

                function onResize() {
                    _obj.win_w = _obj.win.width(),
                        _obj.win_h = _obj.win.height(),
                        _obj.doc_h = _obj.doc.height(),
                        //void 0 !== _obj.shoppingbag && _obj.shoppingbag.length > 0 && void 0 !== _obj.mainContent && shoppingBagRight(),
                        setMobileVariable(),
                        _articlesList.resize();
                    //_navigation.resize(),
                    //_shoppingbagpreview.resize();
                    //for (var a = 0; a < _slideshow_array.length; a++)
                    //  _slideshow_array[a].resize();
                    //for (var b = 0; b < _carrousel_array.length; b++)
                    //  _carrousel_array[b].resize();
                    //_brandNav.resize(),
                    _obj.ie8 || checkScroll()
                        //_popin && _popin.resize(),

                    // initPage()
                }
                var $j = jQuery.noConflict(),
                    _popin, _brandNav, _navigation, _articlesList, _carrousel_array, _scroll = 0,
                    _easingScroll = 0,
                    _tempScroll = -1,
                    _shoppingbagpreview;
                _articlesList = new ArticlesList($(".parallax"));
                var a;
                a = _obj.touch ? "orientationchange" : "resize",
                    _obj.win.on(a, function() {
                        onResize()
                    });
                onResize();
            }
        }
    };

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function(func, funcname, args) {
            var fire;
            var namespace = Sage;
            funcname = (funcname === undefined) ? 'init' : funcname;
            fire = func !== '';
            fire = fire && namespace[func];
            fire = fire && typeof namespace[func][funcname] === 'function';

            if (fire) {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function() {
            // Fire common init JS
            UTIL.fire('common');

            // Fire page-specific init JS, and then finalize JS
            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, 'finalize');
            });

            // Fire common finalize JS
            UTIL.fire('common', 'finalize');
        }
    };

    // Load Events
    $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
