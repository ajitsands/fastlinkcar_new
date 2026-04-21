<div
  class="modal fade"
  id="modalvehicleimages"
  tabindex="-1"
  aria-hidden="true"
  data-bs-backdrop="static"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content text-center">

      <!-- HEADER -->
      <div class="modal-header border-0">
          <h5 class="modal-title">Vehicle Pics</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close">
        </button>
      </div>

      <!-- CAROUSEL -->
      <div
        id="modalCarouselControls"
        class="carousel slide pb-3"
        data-bs-interval="false"
      >

        <!-- INDICATORS (DYNAMIC) -->
        <div class="carousel-indicators" id="vehicleCarouselIndicators"></div>

        <!-- IMAGES (DYNAMIC) -->
        <div class="carousel-inner" id="vehicleCarouselInner"></div>

        <!-- PREV BUTTON -->
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#modalCarouselControls"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon"></span>
        </button>

        <!-- NEXT BUTTON -->
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#modalCarouselControls"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon"></span>
        </button>

      </div>

    </div>
  </div>
</div>