<!-- START SECTION CATEGORIES -->
<div class="section small_pb small_pt">
	<div class="container">
    	<div class="row justify-content-center">
			<div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Categories</h2>
                </div>
                <p class="text-center leads">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius.</p>
            </div>
		</div>
        <div class="row align-items-center">
            <div class="col-12">
                <div id="topcategoryItem" class="cat_slider cat_style1 mt-4 mt-md-0 carousel_slider owl-carousel owl-theme nav_style5" data-loop="true" data-dots="false" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "576":{"items": "4"}, "768":{"items": "5"}, "991":{"items": "6"}, "1199":{"items": "7"}}'>
                  
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CATEGORIES --> 

<script>
    TopCategory();

    async function TopCategory() {
        try {
            let res = await axios.get('/CategoryList');
            const $carousel = $('#topcategoryItem');

            // Destroy previous carousel if exists
            if ($carousel.hasClass("owl-loaded")) {
                $carousel.trigger('destroy.owl.carousel');
                $carousel.removeClass("owl-loaded");
                $carousel.find(".owl-stage-outer").children().unwrap();
            }

            $carousel.empty();

            res.data['data'].forEach((item) => {
                let EachItem = `  
                    <div class="item">
                        <div class="categories_box text-center">
                            <a href="#">
                                <img style="width:100px; height:80px; object-fit:cover; margin:auto;" src="${item['categoryImg']}" alt="${item['categoryName']}"/>
                                <span style="display:block; margin-top:10px; font-weight:500;">${item['categoryName']}</span>
                            </a>
                        </div>
                    </div>`;
                $carousel.append(EachItem);
            });

            // Re-initialize the carousel
            $carousel.owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                margin: 30,
                responsive: {
                    0: { items: 2 },
                    480: { items: 3 },
                    576: { items: 4 },
                    768: { items: 5 },
                    991: { items: 6 },
                    1199: { items: 7 }
                },
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
            });

        } catch (error) {
            console.error("Failed to load categories:", error);
        }
    }
</script>
