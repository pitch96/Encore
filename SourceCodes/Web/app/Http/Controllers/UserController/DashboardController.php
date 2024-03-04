<?php

namespace App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use App\Services\HomePageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    protected $homePageService;
    public function __construct(HomePageService $homePageService)
    {
        $this->homePageService = $homePageService;
    }

    /**
     * Get All Active Events from events table
     */
    public function dashboard()
    {
        try {
            $response = $this->homePageService->homePageData();
            return view('frontend.dashboard', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

        /**
     * Get All Active Events from events table
     */
    public function dashboard_old()
    {
        try {
            $response = $this->homePageService->homePageData();
            return view('frontend.dashboard_old', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Search Events by event_title
     * @param [string] title
     */
    public function autocomplete(Request $request)
    {
        try {
            $res = $this->homePageService->autoCompleteSearch($request);
            return response()->json($res);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Search Events
     * @param [string] title
     * @param [date] date
     * @param [category_id] INT
     */
    public function events(Request $request)
    {
        try {
            $response = $this->homePageService->searchEvent($request);
            return view('frontend.search-event', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Search Events by id
     */
    public function eventDetail($id)
    {
        try {
            $response = $this->homePageService->getEvent($id);
            return view('frontend.event-detail', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', trans('messages.event.error.not_found'));
        }
    }

    /**
     * Return function to show the single event details
     * 
     * @param[integer] $id
     */
    public function singleEventDetail($id)
    {
        try {
            $response = $this->homePageService->getEvent($id);
            return view('frontend.event-detail', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', trans('messages.event.error.not_found'));
        }
    }

    /**
     * Search Events by category id
     * @param['int] id
     */
    public function searchEventsByCategory($id)
    {
        try {
            $events = $this->homePageService->searchEventsByCategory($id);
            return view('frontend.events-by-category', compact('events'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Search Events by event_title
     * @param [string] title
     * @param [date] date
     * @param [category_id] INT
     */
    public function filterEvents(Request $request)
    {
        try {
            $response = $this->homePageService->searchEvent($request);
            return view('frontend.events-by-category', $response);
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Sale page
     * @param [string] title
     * @param [date] date
     * @param [category_id] INT
     */
    // public function sales(Request $request)
    // {
    //     try {
    //         Log::info("this is the sales page");
    //         return view('frontend.sales');
    //     } catch (\Exception $exception) {
    //         return Redirect::back()->with('error', $exception->getMessage());
    //     }
    // }
}
