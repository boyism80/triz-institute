$.fn.previewTab = function () {

    var $self           = $(this).addClass('preview-tab');
    var $category       = $('<div class="category"></div>').appendTo($self);
    var $contents       = $('<div class="category-content"></div>').appendTo($self);
    var $categoryList   = $('<ul class="list"></ul>').appendTo($category);
    var $contentList    = $('<ul class="list"></ul>').appendTo($contents);
    var $more           = $('<div class="more"></div>').text('more').bind('click', function () {

        $self.more();
    } ).appendTo($category);

    $self.addCategory = function (title, name, link, items) {

        var $item       = $('<li class="item"></li>').attr('name', name).text(title).bind('click', function () {

            $self.select(name);
        }).data({items: items, link: link}).appendTo($categoryList);

        return $self;
    }

    $self.clear = function () {

        $contentList.children('.item').remove();
        return $self;
    }

    $self.update = function () {

        var $current    = $self.current();
        if($current == null)
            return $self;

        $self.clear();

        var link        = $current.data('link');
        var items       = $current.data('items');
        $(items).each(function () {

            var $li     = $('<li class="item"></li>').appendTo($contentList);
            var $title  = $('<a class="title"></a>').attr('href', link + '?mode=read&index=' + this.idx).text(this.title).appendTo($li);
            var $date   = $('<div class="date"></div>').text(this.date).appendTo($li);
        } );
    }

    $self.current = function () {

        var $current    = $categoryList.children('.item[current]');
        if($current.length == 0)
            return null;

        return $current;
    }

    $self.select = function (name) {

        var $children   = $categoryList.children('.item');
        var $target     = $children.filter('[name=' + name + ']');
        if($target.length == 0)
            return $self;

        $children.removeAttr('current');
        $target.attr('current', '');
        
        $self.update();

        return $self;
    }

    $self.more = function () {

        var $current    = $self.current();
        if($current == null)
            return $self;

        var link        = $current.data('link');

        location.href   = link;
        return $self;
    }

    return $self;
}

$.fn.playController = function (icons, callback) {

    var $self           = $(this).addClass('play-controller');
    var $buttonPlay     = $('<div class="button"></div>').appendTo($self);
    var $buttonPause    = $('<div class="button"></div>').appendTo($self);

    var $iconPlay       = $('<img>').appendTo($buttonPlay);
    var $iconPause      = $('<img>').attr('src', icons.pause).appendTo($buttonPause);

    $self.activated     = false;

    $self.update = function () {

        if($self.activated)
            $iconPlay.attr('src', icons.active);
        else
            $iconPlay.attr('src', icons.play);

        return $self;
    }

    $self.play = function () {

        $buttonPlay.trigger('click');
        return $self;
    }

    $self.stop = function () {

        $buttonPause.trigger('click');
        return $self;
    }

    $buttonPlay.click(function () {

        $self.activated = true;
        $self.update();

        callback($self.activated);
    } );

    $buttonPause.click(function () {

        $self.activated = false;
        $self.update();

        callback($self.activated);
    });

    $self.stop();

    return $self;
}

$.fn.banner = function (option) {

    if(option == undefined)
        option          = {};

    if(option.size == undefined)
        option.size     = {};

    if(option.size.width == undefined)
        option.size.width   = null;

    if(option.size.height == undefined)
        option.size.height  = null;

    if(option.interval == undefined)
        option.interval     = 1000;

    if(option.visibleCount == undefined)
        option.visibleCount = 1;

    if(option.duration == undefined)
        option.duration     = 'slow';


    var $self           = $(this).addClass('banner');
    $self.container     = $self.children('.image-container');
    $self.images        = $self.container.children('.images');

    $self.running       = false;

    $self.menutab               = $('<div class="menutab"></div>').prependTo($self.container);
    $self.menutab.controller    = null;

    $self.items = function () {

        return $self.images.children('.item');
    }

    $self.init = function () {

        var offset      = 0;

        // Set images position
        $self.items().each(function (index) {

            $(this).css({left: index * option.size.width,
                width: option.size.width,
                height: option.size.height});
        } );

        // Fixed image size
        $self.images.width(option.size.width * option.visibleCount);
        $self.images.height(option.size.height);


        // Set index number
        $self.items().each(function (index) {

            $(this).attr('index', index);
        } );
    }

    $self.current = function () {

        return $self.items().filter('.item[current]');
    }

    $self.currentIndex = function () {

        return parseInt($self.current().attr('index'));
    }

    $self.align = function (direction) {

        var count           = $self.items().length;
        var num             = count - option.visibleCount;
        var currentIndex    = $self.currentIndex();

        switch(direction) {

            case 'front':
                $self.items().each(function (index) {

                    var offset      = (index - currentIndex + count) % count;
                    $(this).css('left', offset * option.size.width);
                } );
                break;

            case 'rear':
                $self.items().each(function (index) {

                    var x           = (num - $self.currentIndex() + count) % count;
                    var offset      = (x + index) % count - num;
                    $(this).css('left', offset * option.size.width);
                } );
                break;

            default:
                break;
        }
    }

    $self.move = function (dest) {

        function onComplete() {

            $self.update();
        }

        $self.items().stop();

        var count           = $self.items().length;
        var num             = count - option.visibleCount;
        var source          = $self.currentIndex();
        var step            = dest - source;
        var direction       = null;

        if(step == count - 1)
            step            = -1;
        else if(step == -(count - 1))
            step            = 1;

        if(step > 0)
            direction   = 'front';
        else
            direction   = 'rear';

        // Remove previous timer
        clearTimeout($self.handler);


        // Align elements order
        $self.align(direction);

        $self.items().each(function (index) {


            var W               = 0;
            var offset          = 0;

            if(direction == 'front') {

                W               = (count - $self.currentIndex()) % count;
                offset          = (index + W) % count - step;

            } else {

                W               = (count + num - $self.currentIndex()) % count;
                offset          = (W + index) % count - num - step;
            }

            $(this).animate({left: offset * option.size.width}, option.duration, function () {

                if($(this).is(':last-child') == false)
                        return;

                onComplete();
            });
        } );

        // Update current element
        $self.items().removeAttr('current');
        $self.items().filter('.item[index=' + dest + ']').attr('current', '');

        // Update controller
        if($self.menutab.controller != null)
            $self.menutab.controller.update();
    }

    $self.next = function () {

        var count           = $self.items().length;
        var source          = $self.currentIndex();
        var dest            = (source + 1) % count;

        return $self.move(dest);
    }

    $self.prev = function () {

        var count           = $self.items().length;
        var source          = $self.currentIndex();
        var dest            = (count + source - 1) % count;

        return $self.move(dest);
    }

    $self.run = function () {

        $self.running       = true;
        $self.update();
        return $self;
    }

    $self.stop = function () {

        $self.running       = false;
        $self.update();
        return $self;
    }

    $self.update = function () {

        clearTimeout($self.handler);

        if($self.running) {

            $self.handler   = setTimeout(function () {

                $self.next();
            }, option.interval);
        }
        return $self;
    }

    $self.resize = function (size) {

        option.size         = size;
        $self.init();

        return $self;
    }

    // Initialize
    $self.init();

    // Select default item
    $self.items().first().attr('current', '');


    // Menu tab - controller
    if(option.controller == true) {

        $self.menutab.controller        = $('<ul class="controller"></ul>').appendTo($self.menutab);

        $self.menutab.controller.update = function () {

            var index               = $self.currentIndex();
            $self.menutab.controller.children('.item').removeAttr('current');
            $self.menutab.controller.children('.item[index=' + index + ']').attr('current', '');
        }

        for(var i = 0; i < $self.items().length; i++) {

            $('<li class="item"></li>').attr('index', i).bind('click', function () {

                $self.move(parseInt($(this).attr('index')));
            } ).appendTo($self.menutab.controller);
        }

        $self.menutab.controller.update();
    }

    return $self;
}

$.fn.fadeBanner = function (option) {

    if(option == undefined)
        option          = {}

    if(option.interval == undefined)
        option.interval = 1000;

    if(option.duration == undefined)
        option.duration = 'slow';

    if(option.size == undefined)
        option.size     = {width: 400, height: 300};

    var $self           = $(this).addClass('fadeBanner');
    $self.container     = $self.children('.image-container');

    var $items          = $self.container.find('.item');


    $self.items         = function () {

        return $self.container.find('.item');
    }

    $self.select        = function (index, useAnimate) {

        if(useAnimate == undefined)
            useAnimate  = true;

        index           = ($self.items().length + index) % $self.items().length;

        $self.items().filter('.item:not([current])').css({opacity: 0});                    // Initialize all opacity

        $self.current().stop()
                       .removeAttr('current')                                       // Remove current attribute
                       .animate({opacity: 0}, useAnimate ? option.duration : 0);    // Hide animate


        var selection   = $self.items().filter('.item[idx=' + index + ']');
        $(selection).stop()                                                     // Stop hide animate
                    .detach().prependTo($self.container.children('.images'))
                    .attr('current', '')                                        // Set current attribute
                    .css({opacity: 1}, useAnimate ? option.duration : 0);       // Show animate
        

        return $self;
    }

    $self.current       = function () {

        return $self.items().filter('.item[current]');
    }

    $self.currentIndex  = function () {

        return parseInt($self.current().attr('idx'));
    }

    $self.prev          = function () {

        return $self.select($self.currentIndex() - 1);
    }

    $self.next          = function () {

        return $self.select($self.currentIndex() + 1);
    }

    $self.run           = function () {

        setInterval(function () {

            $self.next();
        }, option.interval);

        return $self;
    }

    $self.count         = function () {

        return $self.items().length;
    }

    $self.resize        = function (size) {

        $self.container.children('.images').css({width: size.width, height: size.height});
        return $self;
    }

    $self.items().css('opacity', 0).each(function (idx) {

        $(this).attr('idx', idx);
    } );

    $self.resize(option.size);
    $self.select(0, false);
    return $self;
}