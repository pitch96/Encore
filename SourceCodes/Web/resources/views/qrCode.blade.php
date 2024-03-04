{{-- @extends('frontend.layouts.app')
<?php error_reporting(0); ?>
@section('title', 'Qr Codes')

@section('content')
    <div class="searchevent_banner">
        @include('frontend.layouts.header') --}}
        {{-- <div> --}}
            @foreach ($response as $item)
            @dd($item);
                {{-- <td colspan="2" style="padding-bottom: 7px;">
                    <img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chld=L|0&chl={{ $qr_number->ticket_no }}'
                        alt="Thubnail" style="width: 8%; margin-right: 8px; margin-left: 8px; margin-top: 325px;" />
                </td> --}}
            @endforeach
        {{-- </div>
@endsection --}}
