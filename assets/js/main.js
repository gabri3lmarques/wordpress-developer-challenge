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
                if (Math.abs(event.clientX - startX) > 5 || Math.abs(event.clientY - startY) > 5) {
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
});