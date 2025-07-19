<!-- START SECTION CLIENT LOGO -->
<div class="section small_pt">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h2>Our Brands</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Dynamic Brand Carousel -->
                <div id="brandSlider"
                     class="client_logo carousel_slider owl-carousel owl-theme nav_style3"
                     data-dots="false" data-nav="true" data-margin="30" data-loop="true" data-autoplay="true"
                     data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "767":{"items": "4"}, "991":{"items": "5"}}'>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CLIENT LOGO -->
<script>
    LoadBrands();

    async function LoadBrands() {
        try {
            let res = await axios.get('/BrandList');
            const $slider = $('#brandSlider');

            // Destroy previous owl carousel if already initialized
            if ($slider.hasClass('owl-loaded')) {
                $slider.trigger('destroy.owl.carousel');
                $slider.removeClass('owl-loaded');
                $slider.find('.owl-stage-outer').children().unwrap();
            }

            $slider.empty(); // Clear existing items

            res.data['data'].forEach((brand) => {
                let BrandItem = `
                    <div class="item">
                        <div class="cl_logo">
                            <img src="${brand['brandImg']}" alt="${brand['brandName']}" style="max-height: 60px; margin: auto;" />
                        </div>
                    </div>`;
                $slider.append(BrandItem);
            });

            // Re-initialize the owl carousel
            $slider.owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                margin: 30,
                autoplay: true,
                responsive: {
                    0: { items: 2 },
                    480: { items: 3 },
                    767: { items: 4 },
                    991: { items: 5 }
                },
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
            });

        } catch (error) {
            console.error("Brand loading failed:", error);
        }
    }
</script>
