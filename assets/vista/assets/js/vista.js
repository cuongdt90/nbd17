(function ($) {
    /**
     *
     * @desc Component Tab
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbTab = function () {
        return this.each(function () {
            var $tab = $(this).find('.v-tab');
            var $tabContent = $('.v-tab-contents .v-tab-content');
            $tab.on('click', function () {
                var tabId = $(this).attr('data-tab');
                $tab.removeClass('active');
                $(this).addClass('active');
                $tabContent.removeClass('active');
                $('.v-tab-contents #' + tabId).addClass('active');
            });
        });
    };

    /**
     *
     * @desc Component Dropdown
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbDropdown = function () {
        return this.each(function () {
            var sefl = this;
            var $btn = $(this).find('.v-btn-dropdown');

            $(this).nbClickOutSite({
                'targetE' : $(this),
                'removeClass': 'active'
            });

            $btn.on('click', function () {
                if ($(sefl).hasClass('active')) {
                    $(sefl).removeClass('active');
                }else {
                    $(sefl).addClass('active');
                }
            });
        });
    };

    /**
     *
     * @param options
     * @desc Ele click out
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbClickOutSite = function (options) {
        var defaults = {
            'targetE' : null,
            'removeClass' : ''
        };
        var opts = $.extend({}, $.fn.nbClickOutSite.defaults, options);
        return this.each(function () {
            var sefl = this;
            var $win = $(document);
            $win.on("click", function(event){
                if ($(sefl).has(event.target).length == 0 && !$(sefl).is(event.target)){
                    opts.targetE.removeClass(opts.removeClass);
                }
            });
        });
    };

    /**
     * @desc Library perfect scroll
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbPerfectScrollbar = function () {
        return this.each(function () {
            new PerfectScrollbar(this);
        });
    };

    /**
     *
     * @param options
     * @desc
     * @version 2.0.0
     * @author Netbase Online Design Team
     *
     */
    $.fn.nbElDropdown = function (options) {
        var defaults = {
            'itemInRow': 3,
        };

        var opts = $.extend({}, $.fn.nbDropdown.defaults, options);
        this.initPositionItem = function (items, item, itemInRow, itemDistance) {

            var leftItem = items.width() / itemInRow;
            var topItem = item.height() + itemDistance;
            item.show();
            item.each(function () {
                var index = $(this).index();
                var indexMod = index % itemInRow;
                var indexI = parseInt(index / itemInRow);
                $(this).css({
                    'left': leftItem * indexMod + 'px',
                    'top' : topItem * indexI + 'px'
                });
            });

        };
        this.getApiElement = function (dataType) {
            var result = '';
            var src = '';
            switch (dataType) {
                case 'shapes':
                    src = 'https://media-public.canva.com/MABrm9_5-j0/3/thumbnail_large.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'icons':
                    src = 'https://media-public.canva.com/MABhGmG8RA8/1/thumbnail.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'lines':
                    src = 'https://media-public.canva.com/MABKNAgIqvQ/1/thumbnail_large.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'animal':
                    src = 'https://media-public.canva.com/MABKNAgIqvQ/1/thumbnail_large.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'misc':
                    src = 'https://media-public.canva.com/MABhGmG8RA8/1/thumbnail.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'facebook':
                    src = 'https://media-public.canva.com/MABhGmG8RA8/1/thumbnail.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'dropbox':
                    src = 'https://media-public.canva.com/MABhGmG8RA8/1/thumbnail.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'pixabay':
                    src = 'https://media-public.canva.com/MABhGmG8RA8/1/thumbnail.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'unsplash':
                    src = 'https://media-public.canva.com/MABhGmG8RA8/1/thumbnail.jpg';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                case 'business-card':
                    src = 'http://demo2.cmsmart.net/web2print/wp-content/uploads/nbdesigner/designs/610bd64612/preview/frame_1.png';
                    result = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>';
                    break;
                default:
                    alert('bbbb');
                    break;

            }
            return result;
        };

        return this.each(function () {
            var $items = $(this).find('.items');
            var $item = $(this).find('.item');
            var $mainItems = $(this).find('.main-items');
            var $resultLoaded = $(this).find('.result-loaded');
            var $galleryItem = $(this).find('.nbdesigner-gallery');
            var $contentItem = $(this).find('.result-loaded .content-item');
            var $loadingGif = $(this).find('.loading-photo');
            var $tabScroll = $(this).closest('.v-scrollbar');
            var $infoSupport = $(this).closest('.v-content').find('.info-support');

            // ========================= Main================================================
            $item.on('click', function () {
                var indexItem = $(this).index();
                var indexItemRow = parseInt(indexItem / opts.itemInRow) + 1;
                var widthItem = $(this).outerWidth();
                var dataType = $(this).attr('data-type');
                var dataApi = $(this).attr('data-api');

                if (dataType == 'webcam') {
                    $('.nbd-vista .v-popup-webcam').nbShowPopup();
                    return;
                }

                $mainItems.find('.pointer').css({
                    'left': ((widthItem) * (indexItem % opts.itemInRow + 1) - widthItem / 2)  + 'px'
                });

                if (dataApi == 'false') {
                    $resultLoaded.show().addClass('overflow-visible');
                    $contentItem.filter(function (index) {
                        return $(this).attr('data-type') === dataType;
                    }).show();
                    $galleryItem.hide();
                    if (!$mainItems.hasClass('active-expanded')) {
                        $(this).siblings().css({
                            'opacity': '0.5'
                        });
                        $mainItems.addClass('active-expanded');
                        $resultLoaded.addClass('loaded');
                        var nextAllItem = $items.find('.item:nth-child(' + indexItemRow * opts.itemInRow + ')').nextAll();
                        $(nextAllItem).each(function () {
                            $(this).hide();
                        });
                    }else {
                        $(this).css({
                            'opacity': '1'
                        });
                        $(this).siblings().css({
                            'opacity': '1'
                        });
                        $mainItems.removeClass('active-expanded');
                        $contentItem.hide();
                        $resultLoaded.removeClass('loaded');
                        $item.show();
                    }
                    return false;
                }else {
                    if (!$mainItems.hasClass('active-expanded')) {
                        $(this).siblings().css({
                            'opacity': '0.5'
                        });
                        var nextAllItem = $items.find('.item:nth-child(' + indexItemRow * opts.itemInRow + ')').nextAll();
                        $(nextAllItem).each(function () {
                            $(this).hide();
                        });
                        $infoSupport.find('span').empty().text($(this).find('.item-info').text());

                        var src = 'https://media-public.canva.com/MABrm9_5-j0/3/thumbnail_large.jpg';
                        var item = '<div class="nbdesigner-item"><img src="' + src + '"><span class="photo-desc">xxxxxx</span></div>'

                        for (var i=0;i<100;i++) {
                            $galleryItem.append(item);
                        }

                        $resultLoaded.show();
                        $galleryItem.hide();
                        $contentItem.hide();
                        $loadingGif.show();

                        $galleryItem.imagesLoaded()
                            .always( function( instance ) {
                                // All images loaded
                                setTimeout(function () {
                                    $galleryItem.show();
                                    $mainItems.addClass('active-expanded');
                                    $resultLoaded.addClass('loaded');
                                    $loadingGif.hide();

                                    // if (isMasonry) {
                                    //     $galleryItem.masonry('destroy');
                                    // }
                                    $galleryItem.masonry({
                                        itemSelector: '.nbdesigner-item'
                                    });
                                    $galleryItem.find('.nbdesigner-item').each(function (i) {
                                        var animate = Math.floor(Math.random() * 10);
                                        animate = (animate + 1) * 100;
                                        $(this).addClass('slideInDown animated in-view animate' + animate);
                                    });
                                    var resultHeight = $resultLoaded.height();
                                    var resultOfsetTop = $resultLoaded.offset().top;

                                    $tabScroll.on('scroll', function () {
                                        console.log(resultHeight);
                                        console.log(resultOfsetTop);
                                        var scrollTop = $(this).scrollTop();
                                        console.log(scrollTop);
                                        if ((scrollTop > resultOfsetTop + 100) && (scrollTop < (resultOfsetTop+ resultHeight + 100))) {
                                            $infoSupport.addClass('nbd-show');
                                        }else {
                                            $infoSupport.removeClass('nbd-show');
                                        }
                                    });
                                }, 1000);
                            })
                            .done( function( instance ) {
                                // All images successfull loaded
                            })
                            .fail( function() {
                                // All images loaded, at least one is broken
                            })
                            .progress( function( instance, image ) {
                            });

                    }else {
                        $(this).css({
                            'opacity': '1'
                        });
                        $(this).siblings().css({
                            'opacity': '1'
                        });
                        $mainItems.removeClass('active-expanded');
                        // $resultLoaded.find('.nbdesigner-gallery').empty();
                        $resultLoaded.hide();
                        $resultLoaded.removeClass('loaded');
                        $galleryItem.hide();
                        $item.show();
                        $loadingGif.hide();
                    }

                    // Event click in close result
                    $infoSupport.find('.close-result-loaded').on('click', function () {

                        $mainItems.removeClass('active-expanded');
                        // $resultLoaded.find('.nbdesigner-gallery').empty();
                        $resultLoaded.hide();
                        $resultLoaded.removeClass('loaded');
                        $galleryItem.hide();
                        $item.show();
                        $loadingGif.hide();
                        $item.show().css({'opacity' : '1'});
                        $tabScroll.scrollTop(0);
                    });

                    return false;
                }

            });
        });

    };

    /**
     *  @author Netbase Online Design Team
     */
    $.fn.nbShowPopup = function () {
        return this.each(function () {
            var sefl = this;
            var $close = $(this).find('.overlay-popup, .close-popup');
            if (!$(this).hasClass('nb-show')) {
                $(this).addClass('nb-show');
            }
            $close.on('click', function () {
                $(sefl).removeClass('nb-show');
            });
        });
    };

    /**
     *
     * @param text
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbWarning = function (text) {
        return this.each(function () {
            var $itemWarning = $(this).find('.item');
            $(this).addClass('nbd-show');
            if ($itemWarning.length < 3) {
                var htmlWaring = '<div class="item animate300 animated nbScaleOut main-warning nbd-show">' +
                    '<i class="nbd-icon-vista nbd-icon-vista-warning warning"></i>' +
                    '<span class="title-warning">'+ text +'</span>' +
                    '<i class="nbd-icon-vista nbd-icon-vista-clear close-warning"></i>' +
                    '</div>';
                var $warning = $(htmlWaring);
                var $close = $warning.find('.close-warning');
                $(this).append($warning);
                $close.on('click', function () {
                    $warning.removeClass('nbScaleOut').addClass('nbScaleIn');
                    $warning.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                        $warning.remove();
                    });
                });

                setTimeout(function () {
                    $warning.removeClass('nbScaleOut').addClass('nbScaleIn');
                    $warning.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                        $warning.remove();
                    });
                }, 10000);

            }

        });
    };

    /**
     *
     * @param text
     * @version 2.0.0
     * @author Netbase Online Design Team
     */
    $.fn.nbToasts = function (text) {
        return this.each(function () {

            var htmlToast = '<div class="animate300 animated nbSlideInUp toast">' +
                                '<span>'+ text +'</span>' +
                                '<i class="nbd-icon-vista nbd-icon-vista-clear nbd-close-toast"></i>' +
                            '</div>';
            var $toast = $(htmlToast);

            $(this).addClass('nbd-show').append($toast);
            $toast.find('.nbd-close-toast').on('click', function () {
                $toast.removeClass('nbSlideInUp').addClass('nbSlideInDown');
                $toast.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                    $toast.remove();
                });
            });

            setTimeout(function () {
                $toast.removeClass('nbSlideInUp').addClass('nbSlideInDown');
                $toast.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                    $toast.remove();
                });
            }, 10000);
        });
    };

    $(document).ready(function () {
        $('.nbd-vista .v-tabs').nbTab();
        $('.nbd-vista .v-dropdown').nbDropdown();
        $('.nbd-vista .v-scrollbar').nbPerfectScrollbar();
        $('.nbd-vista .v-elements').nbElDropdown({
            'itemInRow' : 3
        });
        $('.nbd-vista .item-reset').on('click', function () {
            $('.nbd-vista .nbd-warning').nbWarning('warning');
        });
        $('.nbd-vista .item-done').on('click', function () {
            // $('.nbd-vista .nbd-toasts').nbToasts('I am a toast');
            $('.nbd-vista .v-popup-terms').nbShowPopup();
        });
    });
})(jQuery);