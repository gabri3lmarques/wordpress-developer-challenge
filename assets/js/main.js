document.addEventListener('DOMContentLoaded', function () {

    const links = document.querySelectorAll('.bx-desafio-video-card-img-link');

    links.forEach(link => {
        let isDragging = false;
        let startX, startY;

        link.addEventListener('mousedown', function (event) {
            isDragging = false;
            startX = event.clientX;
            startY = event.clientY;

            function onMouseMove(event) {
                if (Math.abs(event.clientX - startX) > 5 || Math.abs(event.clientY - startY) > 5) {http://cali-villa.local/video/pellentesque-habitant-morbi-7/
                    isDragging = true;
                }
            }

            function onMouseUp(event) {
                link.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
                if (isDragging) {
                    event.preventDefault();
                }
            }

            link.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });

        link.addEventListener('click', function(event) {
            if (isDragging) {
                event.preventDefault();
            }
        });
    });

    // função para criar o sticky menu
    const menu = document.querySelector('.bx-desafio-menu');
    const mobileLogo = document.querySelector('.bx-desafio-logo-mobile');
    const mobileLinks = document.querySelector('.bx-desafio-links-mobile');

    function scrollDownFunction() {
        if(menu){
            menu.classList.add("sticky");
        }
        if(mobileLogo){
            mobileLogo.classList.remove("visible");
        }
        if(mobileLinks){
            mobileLinks.classList.add("visible");
        }
    }

    function scrollUpFunction() {
        if(menu){
            menu.classList.remove("sticky");
        }
        if(mobileLogo){
            mobileLogo.classList.add("visible");
        }
        if(mobileLinks){
            mobileLinks.classList.remove("visible");
        }
    }

    let hasScrolledDown = false;

    window.addEventListener('scroll', function() {
        if (window.scrollY >= 10 && !hasScrolledDown) {
            hasScrolledDown = true;
            scrollDownFunction();
        } else if (window.scrollY === 0 && hasScrolledDown) {
            hasScrolledDown = false;
            scrollUpFunction();
        }
    });
});