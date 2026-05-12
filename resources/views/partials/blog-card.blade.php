<div class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center mt-4" data-aos="zoom-in">
    <a href="{{ url($locale.'/blogs/'.$slug) }}" class="blog-card">
        <div class="d-flex flex-column align-items-center w-100">
            <div class="media-center_item blog-card">
                <div class="media-center_item_img-container position-relative">
                    <img src="{{ $img }}" alt="{{ $title }}" class="img-fluid mb-0">
                </div>
                <h3 class="fs-20 media-center_item_text blog-title mt-3">{{ $title }}</h3>
                <div class="d-flex justify-content-start align-items-center mb-2 gap-1">
                    <img width="18" height="18" src="{{ asset('website/images/time.svg') }}" alt="time">
                    <p class="media-center_item_heading text-black">{{ $date }}</p>
                </div>
            </div>
        </div>
    </a>
</div>
