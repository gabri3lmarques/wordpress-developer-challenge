//classe para a criação do carrossel

class Carousel {
    constructor(element) {
        this.carousel = element;
        this.carouselInner = this.carousel.querySelector('.carousel-inner');
        this.carouselItems = this.carousel.querySelectorAll('.carousel-item');
        this.itemsPerSlide = parseInt(this.carousel.getAttribute('data-items'), 10) || 1;
        this.currentIndex = 0;
        this.startX = 0;
        this.currentX = 0;
        this.isDragging = false;
        this.translateX = 0;

        this.init();
    }

    init() {
        this.setItemsWidth();

        this.carouselInner.addEventListener('mousedown', this.startDrag.bind(this));
        this.carouselInner.addEventListener('mousemove', this.dragging.bind(this));
        this.carouselInner.addEventListener('mouseup', this.endDrag.bind(this));
        this.carouselInner.addEventListener('mouseleave', this.endDrag.bind(this));

        this.carouselInner.addEventListener('touchstart', this.startDrag.bind(this), { passive: true });
        this.carouselInner.addEventListener('touchmove', this.dragging.bind(this), { passive: true });
        this.carouselInner.addEventListener('touchend', this.endDrag.bind(this));
    }

    setItemsWidth() {
        const itemWidth = 100 / this.itemsPerSlide;
        this.carouselItems.forEach(item => {
            item.style.minWidth = `${itemWidth}%`;
        });
    }

    startDrag(e) {
        this.isDragging = true;
        this.startX = e.pageX || e.touches[0].pageX;
        this.carouselInner.style.transition = 'none';
        this.carouselInner.style.cursor = 'grabbing';
    }

    dragging(e) {
        if (!this.isDragging) return;

        e.preventDefault();
        this.currentX = e.pageX || e.touches[0].pageX;
        const moveX = this.currentX - this.startX;
        this.carouselInner.style.transform = `translateX(${this.translateX + moveX}px)`;
    }

    endDrag(e) {
        if (!this.isDragging) return;

        this.isDragging = false;
        const moveX = this.currentX - this.startX;
        const itemWidth = this.carouselItems[0].offsetWidth;
        this.carouselInner.style.transition = 'transform 0.3s ease';
        this.carouselInner.style.cursor = 'grab';

        if (Math.abs(moveX) > itemWidth / 3) {
            if (moveX < 0 && this.currentIndex < this.carouselItems.length - this.itemsPerSlide) {
                this.currentIndex++;
            } else if (moveX > 0 && this.currentIndex > 0) {
                this.currentIndex--;
            }
        }

        this.translateX = -this.currentIndex * itemWidth;
        this.carouselInner.style.transform = `translateX(${this.translateX}px)`;
    }
}

// Criação de uma instância do Carousel
document.addEventListener('DOMContentLoaded', () => {
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => new Carousel(carousel));
});
