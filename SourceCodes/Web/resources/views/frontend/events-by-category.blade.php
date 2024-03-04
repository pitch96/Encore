@forelse ($events as $event)
    <div class="col-xl-4 col-lg-4 col-md-6 col-12 float-left mb-4">
        <div class="web_development_card">
            <div class="card-view event position-relative border-0">
                <img src="{{ $event->image }}" alt="img" class="mansory_img img-fluid">
                <a href="{{ url('event/detail/' . $event->id) }}" class="text-decoration-none">
                    <div class="event_inner_card position-absolute">
                        <div class="container rock_box py-2">
                            <h1 class="rock">
                                {{ strlen($event->event_title) > 15 ? mb_substr($event->event_title, 0, 15) . '...' : $event->event_title }}
                            </h1>
                            <div class="row">
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12">
                                    <div>
                                        <i class="fa fa-calendar rock_icon " aria-hidden="true "></i>
                                        <span class="rock_date">
                                            {{ date_format(date_create($event->start_date), 'F d') }} to
                                            {{ date_format(date_create($event->end_date), 'd') }} </span>
                                    </div>
                                    <br>
                                    <div class="buy-ticket">

                                        <button class="btn-search" type="button ">Buy Ticket</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="location">
                                        <i class="fa fa-map-marker rock_icon" aria-hidden="true"></i>
                                        <span class="rock_date">
                                            {{ strlen($event->venue) > 10 ? mb_substr($event->venue, 0, 10) . '...' : $event->venue }},
                                            {{ $event->city }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@empty
    <div class="col-md-4 mb-4 float-left">
        <h2 class="text-white">No Record Found</h2>
    </div>
@endforelse
