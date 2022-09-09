<?php

namespace App\Http\Controllers\Home;

use App\Models\HomeSlide;
use Illuminate\Http\Request;
Use Image;
use App\Http\Controllers\Controller;

class HomeSliderController extends Controller
{
    public function HomeSlider(){
        $homeslide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all' , compact('homeslide'));
    }
    // public function UpdateSlider(Request $request){
    //     $slide_id = $request->id;
    //     if($request->file('home_slide')){
    //         $image = $request->file('home_slide');
    //         $imageName = time(). $image->getClientOriginalExtension();
    //         $image->move( public_path('upload/home_slide/' , $imageName) );
    //         HomeSlide::findorfail($slide_id)->update([
    //             'title' => $request->title,
    //             'short_title' => $request->short_title,
    //             'video_url' =>$request->video_url,
    //             'home_slide' => $imageName
    //         ]);

            
    //         $notifications = array(
    //             'message' => 'Home Slider Has Been Updated with Image',
    //             'alert-type' => 'success'
    //         );
    //         return redirect()->back()->with($notifications);
    //     }else{
    //         HomeSlide::findorfail($slide_id)->update([
    //             'title' => $request->title,
    //             'short_title' => $request->short_title,
    //             'video_url' =>$request->video_url,
    //         ]);
    //         $notifications = array(
    //             'message' => 'Home Slider Has Been Updated without Image',
    //             'alert-type' => 'success'
    //         );
    //         return redirect()->back()->with($notifications);
    //     }
    // }

    public function UpdateSlider(Request $request){

        $slide_id = $request->id;

        if ($request->file('home_slide')) {
            $image = $request->file('home_slide');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(636,850)->save('upload/home_slide/'.$name_gen);
            $save_url = 'upload/home_slide/'.$name_gen;
            $image->move(public_path('upload/home_slide/'), $save_url );

            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
                'home_slide' => $save_url,

            ]); 
            $notification = array(
            'message' => 'Home Slide Updated with Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else{

            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,  

            ]); 
            $notification = array(
            'message' => 'Home Slide Updated without Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } // end Else

     } // End Method 

}
