<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class EventController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(){
        return [
            new Middleware('auth:sanctum',except:['index','show'])
        ];
    }
    public function index(Request $request)
    {    
      // récupère l'ID de l'utilisateur
        $events = Event::where('is_active', true)->orderBy('start_datetime')
               ->get();
        return $events ;
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|in:concert,conference,sport,workshop',
        'start_datetime' => 'required|date',
        'end_datetime' => 'required|date|after:start_datetime',
        'location' => 'required|string',
        'max_participants' => 'required|integer|min:1',
        'ticket_price' => 'required|numeric|min:0',
        'is_active' => 'sometimes|boolean',
            
            
        ]);
           /* Event::create([
                ...$request->all(),
                'created_by' => auth()->id(),
                'remaining_quota' => $request->max_participants,
        ]);*/

        //link to a user
       $event = $request->user()->events()->create([...$validated,'remaining_quota'=>$validated['max_participants']]);
       return $event;

        //
    }

    /**
     * Display the specified resource.
     */

    public function show(int $event,Request $request)
    {   $event = Event::findOrFail($event);
       return $event;
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $event)
    {$validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|in:concert,conference,sport,workshop',
        'start_datetime' => 'required|date',
        'end_datetime' => 'required|date|after:start_datetime',
        'location' => 'required|string',
        'max_participants' => 'required|integer|min:1',
        'ticket_price' => 'required|numeric|min:0',
        'is_active' => 'sometimes|boolean',    
        ]);
           /* Event::create([
                ...$request->all(),
                'created_by' => auth()->id(),
                'remaining_quota' => $request->max_participants,
        ]);*/
       $count = Event::where('id',"=",$event)->update([...$validated,'remaining_quota'=>$validated['max_participants']]);
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
    public function destroy(int $event,Request $request)
    {
       $event = Event::where('id',$event)->delete();
       if($event==0){
        return ["message" => 'you don\'t own this event'];
      }
      return [
        'message' => `the event  was successfull deleted`
      ];
    }
}
