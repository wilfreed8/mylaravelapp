<?php

namespace App\Http\Controllers;

use App\Models\announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class AnnouncementController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(){
        return [
            new Middleware('auth:sanctum',except:['index','show'])
        ];
    }
    public function index()
    {
        $announcements = Announcement::where('publish_date', '<=', now())
        ->orderBy('publish_date', 'desc')
        ->get();
         return $announcements;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'required|date',
        ]);
        $Announcement = $request->user()->announcements()->create([...$validated]);
        
        return $Announcement;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $announcement,Request $request)
    {
        $announcements = Announcement::findOrFail($announcement);
       return $announcements;
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,int $announcement)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'required|date',
        ]);
        $count = Announcement::where('id',"=",$announcement)->update($validated);
        if($count==0){
          return ["message" => 'you don\'t own this event',
           ];
        }
        
        return [
          "message" => "the event  was successfull update",
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $announcement,Request $request)
    {
        $count = Announcement::where('id',"=",$announcement)->delete();
        if($count==0){
          return ["message" => 'you don\'t own this event',
           ];
        }
        
        return [
          "message" => "the event  was successfull delete",
        ];
    }
}
