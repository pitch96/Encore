<section class="logoMarqueeSection ">
    <div class="container-fluid px-0 " id="logoMarqueeSection ">
        <div class="default-content-container flex items-center ">
            <div class="marquee default-content-container-inner marquee-wrapper relative overflow-hidden inline-block ">
                <marquee class="pause" behavior="scroll" direction="left" scrollamount="10" onmouseover="this.stop();" onmouseout="this.start();">
                @php 
                    $events = \App\Models\Admin\Event::dashboardEvents()->orderBy('start_date')->get();
                @endphp
                @if(count($events) > 0)
                @foreach ($events as $event)
                    <a href="{{ url('event/detail/' . $event->id) }}" class="marquee_anchor ">
                        <img src="{{ asset('event-images/' . $event->image) }}" title=""
                            class="marqueelogo marquee_image image-size">
                        <div class="marquee_overlay ">
                            <div class="marquee_icon "><i class="fa fa-link " aria-hidden="true "></i></div>
                        </div>
                    </a>
                @endforeach
                @endif
                </marquee>
            </div>
        </div>
    </div>
</section>
