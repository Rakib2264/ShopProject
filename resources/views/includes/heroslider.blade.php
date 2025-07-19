<!-- START SECTION DYNAMIC BANNER -->
<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div id="dynamicBannerCarousel" class="carousel slide carousel-fade light_arrow" data-bs-ride="carousel">
        <div class="carousel-inner" id="BannerSliderContainer">
            <!-- Dynamic Banners Will Appear Here -->
        </div>
        <a class="carousel-control-prev" href="#dynamicBannerCarousel" role="button" data-bs-slide="prev">
            <i class="ion-chevron-left"></i>
        </a>
        <a class="carousel-control-next" href="#dynamicBannerCarousel" role="button" data-bs-slide="next">
            <i class="ion-chevron-right"></i>
        </a>
    </div>
</div>
<!-- END SECTION DYNAMIC BANNER -->
<script>
    LoadDynamicBanners();

    async function LoadDynamicBanners() {
        try {
            let res = await axios.get('/ListProductBySlider');
            $('#BannerSliderContainer').empty();

            res.data['data'].forEach((item, index) => {
                let product = item.product;
                let isActive = index === 0 ? 'active' : '';
                let banner = `
                    <div class="carousel-item ${isActive} background_bg" data-img-src="${product.image}">
                        <div class="banner_slide_content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7 col-9">
                                        <div class="banner_content overflow-hidden">
                                            <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">
                                                Up to ${product.discount ? Math.round((product.price - product.discount_price) * 100 / product.price) : 0}% Off!
                                            </h5>
                                            <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">
                                                ${product.title}
                                            </h2>
                                            <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase"
                                               href="/product-details/${product.id}"
                                               data-animation="slideInLeft"
                                               data-animation-delay="1.5s">
                                               Shop Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#BannerSliderContainer').append(banner);
            });

            // Optional: Set background images from `data-img-src`
            $('.carousel-item').each(function () {
                let bg = $(this).data('img-src');
                $(this).css('background-image', `url('${bg}')`);
            });

        } catch (error) {
            console.error("Banner Load Error:", error);
        }
    }
</script>
