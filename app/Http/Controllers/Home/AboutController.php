<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class AboutController extends Controller
{
    public function AboutPage(){
        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutpage'));
    } // End Method

    public function UpdateAbout(Request $request){

        $about_id = $request->id;

        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(523,605)->save('upload/home_about/'.$name_gen);
            $save_url = 'upload/home_about/'.$name_gen;
            $image->move(public_path('upload/home_about/'), $save_url );

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,

            ]); 
            $notification = array(
            'message' => 'About Page Updated with Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else{

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,

            ]); 
            $notification = array(
            'message' => 'About Page Updated without Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    } // End Method

    public function HomeAbout(){
        $aboutpage = About::find(1);
        return view('frontend.about_page' , compact('aboutpage'));
    }// End Method

    public function AboutMultiImage(){
        return view('admin.about_page.multimage');
    }// End Method 

    public function StoreMultiImage(Request $request){
        $images = $request->file('multi_image');
        foreach($images as $image){
            $name_gen = hexdec(uniqid()). '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(220,220)->save('upload/multi/' . $name_gen);
            // $save_url = 'upload/multi/' . $name_gen;
            MultiImage::insert([
                'multi_image' => $name_gen,
                'created_at' => Carbon::now()
            ]);
        }
    
        $notification = array(
            'message' => 'Multi Image Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method

    public function AllMultiImage(){
        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiimage',compact('allMultiImage'));

    } // End Method

    public function editMultipleImage($id){

        $multiImage = MultiImage::find($id);
        return view('admin.about_page.edit_multiple_image',compact('multiImage'));
    }//end Method

    public function updateMultipleImage(Request $request){

        $multi_image_id = $request->id;

        if ($request->file('multi_image')) {
            $image = $request->file('multi_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(220,220)->save('upload/multi/'.$name_gen);
            // $save_url = 'upload/multi/'.$name_gen;

            MultiImage::findOrFail($multi_image_id)->update([

                'multi_image' => $name_gen,

            ]); 
            $notification = array(
            'message' => 'Multi Image Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($notification);

        }

    } //end Method

    public function DeleteMultiImage($id){

        
        $multi = MultiImage::findOrFail($id);
        $img = 'upload/multi/'. $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Multi Image Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }//end Method


}
