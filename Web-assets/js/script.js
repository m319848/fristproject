// last

// when the document is ready
document.addEventListener("DOMContentLoaded", function () {

    // UTM tracker start
    function getUrlParameters() {
        var params = {};
        window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (str, key, value) {
            params[key] = value;
        });
        return params;
    }

    var urlParams = getUrlParameters();

    function updateButtonUrl() {
        var button = document.getElementById('launch-app-cta-utm'); // Replace 'your-button-id' with your button's ID
        if (button) {
            var baseUrl = button.getAttribute('href').split('?')[0]; // Get the base URL without parameters
            var queryString = Object.keys(urlParams).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(urlParams[key])).join('&');
            var updatedUrl = baseUrl + '?' + queryString;
            button.setAttribute('href', updatedUrl);
        }
    }

    updateButtonUrl();
    // UTM tracker end


    // Supporters slider
    const swiperSupporters = new Swiper(".supporters-swiper", {
        slidesPerView: 3.5,
        spaceBetween: 32,
        speed: 600,
        navigation: {
            nextEl: '.next-supporters',
            prevEl: '.prev-supporters',
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
                spaceBetween: 12,
            },
            767: {
                slidesPerView: 2.5,
                spaceBetween: 24,
            },
            1280: {
                slidesPerView: 3.5,
                spaceBetween: 32,
            }
        },
    });

    // Partners Say Block Slider
    const swiperPS = new Swiper('.partners-swiper', {
        direction: "horizontal",
        preventClicks: true,
        preventClicksPropagation: true,
        loop: false,
        mousewheel: false,
        speed: 600,
        centeredSlides: false,
        lazy: true,
        navigation: {
            nextEl: '.next-ps-card',
            prevEl: '.prev-ps-card',
        },
        touch: {
            enabled: true
        },
        keyboard: {
            enabled: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1.3,
                spaceBetween: 24,
            },
            767: {
                slidesPerView: 2.5,
                spaceBetween: 24,
            },
            991: {
                slidesPerView: 3.1,
                spaceBetween: 24,
            },
            1280: {
                slidesPerView: 4.1,
                spaceBetween: 24,
            }
        },
    })

    // Adviser Block Slider
    const swiperAdvisors = new Swiper('.advisors-swiper', {
        direction: "horizontal",
        preventClicks: true,
        preventClicksPropagation: true,
        loop: false,
        mousewheel: false,
        speed: 600,
        centeredSlides: false,
        lazy: true,
        navigation: {
            nextEl: '.next-advisor-btn',
            prevEl: '.prev-advisor-btn',
        },
        touch: {
            enabled: true
        },
        keyboard: {
            enabled: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1.3,
                spaceBetween: 16,
            },
            767: {
                slidesPerView: 2.5,
                spaceBetween: 24,
            },
            991: {
                slidesPerView: 3.1,
                spaceBetween: 24,
            },
            1280: {
                slidesPerView: 4.1,
                spaceBetween: 24,
            }
        },
    })

    // MW Block Slider
    const swiperMW = new Swiper('.mw-swiper', {
        direction: "horizontal",
        preventClicks: true,
        preventClicksPropagation: true,
        loop: false,
        mousewheel: false,
        speed: 600,
        centeredSlides: false,
        lazy: true,
        /*autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },*/
        pagination: {
            el: ".mw-swiper-pagination",
        },
        navigation: {
            nextEl: '.next-mw',
            prevEl: '.prev-mw',
        },
        touch: {
            enabled: true
        },
        keyboard: {
            enabled: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 12,
            },
            767: {
                slidesPerView: 2.5,
                spaceBetween: 24,
            },
            991: {
                slidesPerView: 2.5,
                spaceBetween: 24,
            },
            1280: {
                slidesPerView: 3.1,
                spaceBetween: 30,
            }
        },
    })

    var asideDropMenu = document.querySelector('.aside-drop-menu-wrapper');
    var telegramNavLink = document.getElementById('telegram-nav-link');

    telegramNavLink.addEventListener('click', function (event) {
        if (asideDropMenu.classList.contains('is-open')) {
            asideDropMenu.classList.remove('is-open')
        } else {
            asideDropMenu.classList.add('is-open')
        }

    })


    document.addEventListener('click', function (event) {

        // if the click was not inside Aside Drop Menu
        if (!asideDropMenu.contains(event.target) && !telegramNavLink.contains(event.target) && asideDropMenu.classList.contains('is-open')) {
            // hide the element
            asideDropMenu.classList.remove('is-open')
        }

    });

    // FAQ
    document.querySelectorAll('.faq-item-header').forEach((item) => {
        item.addEventListener('click', (event) => {
            const answer = event.target.nextElementSibling;
            if (answer.style.display === 'block' || event.target.classList.contains('active')) {
                answer.style.display = 'none';
                event.target.classList.remove('active');
            } else {
                answer.style.display = 'block';
                event.target.classList.add('active');
            }
        });
    });

    $('.about-popup-close-sign').on('click', function (ev) {
        var videoURL = $('.about-popup-video-screen iframe').prop('src');
        videoURL = videoURL.replace("&autoplay=1", "");
        $('.about-popup-video-screen iframe').prop('src', '');
        $('.about-popup-video-screen iframe').prop('src', videoURL);
    });
});


// sec Last

document.addEventListener("DOMContentLoaded", () => {
    /* onReady start */
    // Check if the browser is Safari
    /*const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
      if (!isSafari) {
        if (Webflow.env("editor") === undefined) {
          const lenis = new Lenis();
    
          function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
          }
          requestAnimationFrame(raf);
    
          function connectToScrollTrigger() {
            lenis.on("scroll", ScrollTrigger.update);
          }
        }
      }*/
});



// Third LAst

// when the document is ready
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        document.querySelector('body').classList.add('page-ready');
    }, 1000);
    // var productsDropMenu = document.querySelector('.products-drop-menu-wrapper');
    // var productsMenuWrapper = document.querySelector('.products-menu-wrapper');
    // var productsDropIcon = document.getElementById('products-drop-icon');
    // var productsNavLink = document.getElementById('products-nav-link');
    var appDropMenu = document.querySelector('.app-drop-menu-wrapper');
    // var appDropIcon = document.getElementById('app-drop-icon');


    // listen for clicks on the entire document
    document.addEventListener('click', function (event) {

        // if the click was not inside Products Drop Menu
        // if (!productsMenuWrapper.contains(event.target) && !productsNavLink.contains(event.target) && productsDropMenu.style.display === "flex") {
        // hide the element
        // productsDropMenu.style.transition = 'all 0.25s ease';
        // productsDropIcon.style.transition = 'all 0.25s ease'
        // productsDropMenu.style.opacity = '0';
        // productsDropIcon.style.transform = 'rotateZ(0deg)'
        // setTimeout(function() {
        // productsDropMenu.style.display = 'none';
        // productsDropMenu.style.transition = 'none';
        // }, 250);

        // }

        // if the click was not inside App Drop Menu
        if (!appDropMenu.contains(event.target) && !appNavLink.contains(event.target) && appDropMenu.style.display === "flex") {
            // hide the element
            appDropMenu.style.transition = 'all 0.25s ease';
            //appDropIcon.style.transition = 'all 0.25s ease'
            appDropMenu.style.opacity = '0';
            //appDropIcon.style.transform = 'rotateZ(0deg)'
            setTimeout(function () {
                appDropMenu.style.display = 'none';
                // appDropMenu.style.transition = 'none';
            }, 250);

        }

    });
    /*Marquee Clone*/
    function MarqueeClone() {
        let marquee = document.querySelectorAll("[data-marquee]");
        if (marquee) {
            marquee.forEach((marquee) => {
                let marqueeList = marquee.querySelector("[data-marquee-list]");
                let marqueeListClone = marqueeList.cloneNode(true);
                let marqueeListClone2 = marqueeList.cloneNode(true);
                marqueeList.after(marqueeListClone);
                marqueeList.after(marqueeListClone2);
            });
        }
    }
    MarqueeClone();
});
