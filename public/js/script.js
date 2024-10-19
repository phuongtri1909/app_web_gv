
$(document).ready(function () {
    var header = $('.main-header .header');

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 50) {
            header.addClass('header-sticky');
        } else {
            header.removeClass('header-sticky');
        }
    });
});

/* Back to top button */
let backToTopButton = document.getElementById('back-to-top');

// Hiển thị nút khi cuộn xuống 200px
window.onscroll = function() {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        backToTopButton.classList.add('show');
    } else {
        backToTopButton.classList.remove('show');
    }
};

// Khi nhấn vào nút, cuộn lên đầu trang
backToTopButton.onclick = function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

document.addEventListener('DOMContentLoaded', function() {
    var triangleIcons = document.querySelectorAll('.triangle-icon');

    triangleIcons.forEach(function(triangleIcon) {
        var dropdownMenu = document.querySelector(triangleIcon.getAttribute('data-target'));
        var isOpen = false;

        triangleIcon.addEventListener('click', function(event) {
            event.stopPropagation();
            if (isOpen) {
                $(dropdownMenu).collapse('hide');
            } else {
                $(dropdownMenu).collapse('show');
            }
            isOpen = !isOpen;
        });

        document.addEventListener('click', function() {
            if (isOpen) {
                $(dropdownMenu).collapse('hide');
                isOpen = false;
            }
        });
    });
});

/* action button language */
$(document).ready(function() {
    $('.floatingButton').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('open');
        $('.floatingMenu').stop().slideToggle();
    });

    $(document).on('click', function(e) {
        const container = $(".floatingButton");
        const isButton = container.is(e.target) || container.has(e.target).length > 0;
        const isMenu = $('.floatingMenu').has(e.target).length > 0;

        if (!isButton && !isMenu) {
            if (container.hasClass('open')) {
                container.removeClass('open');
            }
        }

        if (!isButton && isMenu) {
            container.removeClass('open');
            $('.floatingMenu').stop().slideToggle();
        }
    });
});
/* end action button language */
$(document).ready(function() {
    $('.nav-item.dropdown').hover(function() {
        if ($(window).width() >= 768) {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200);
        }
    }, function() {
        if ($(window).width() >= 768) {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
        }
    });
    $('.nav-item.dropdown > a').click(function(e) {
        if ($(window).width() < 768) {
            e.preventDefault();
            var $dropdownMenu = $(this).next('.dropdown-menu');
            if ($dropdownMenu.hasClass('show')) {
                $dropdownMenu.removeClass('show').slideUp();
            } else {
                $('.dropdown-menu').removeClass('show').slideUp(); // Đóng tất cả các dropdown khác
                $dropdownMenu.addClass('show').slideDown();
            }
        } else {
            window.location.href = $(this).attr('href');
        }
    });
});

$(document).click(function(e) {
    var target = $(e.target);
    if (!target.closest('.nav-item.dropdown').length) {
        $('.dropdown-menu').removeClass('show').slideUp();
    }
});

// Lưu vị trí cuộn trang khi chuyển trang
document.addEventListener('DOMContentLoaded', function () {
    const scrollPosition = localStorage.getItem('scrollPosition');
    if (scrollPosition) {
        window.scrollTo(0, scrollPosition);
        localStorage.removeItem('scrollPosition');
    }
});

$(document).ready(function () {
    $('.language-switch').on('click', function (e) {
        e.preventDefault();
        localStorage.setItem('scrollPosition', $(window).scrollTop());
        window.location.href = $(this).attr('href');
    });

    const scrollPosition = localStorage.getItem('scrollPosition');
    if (scrollPosition) {
        $(window).scrollTop(scrollPosition);
        localStorage.removeItem('scrollPosition');
    }
});
// Lưu vị trí cuộn trang khi chuyển trang

// random background
document.addEventListener('DOMContentLoaded', () => {
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    const svgElements = document.querySelectorAll('.random-waves');
    svgElements.forEach(svgElement => {
        const color1 = getRandomColor();
        const color2 = getRandomColor();
        svgElement.style.background = `linear-gradient(to right, ${color1}, ${color2})`;
    });
});

