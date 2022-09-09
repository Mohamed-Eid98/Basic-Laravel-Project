<?php

namespace App\Http\Controllers\Home;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
Use Image;

class PortfolioController extends Controller
{
    public function AllPortfolio(){
        
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all',compact('portfolio'));
    }//end Method

    public function AddPortfolio(){
       return view('admin.portfolio.portfolio_add');

    } //End Method

    public function StorePortfolio(Request $request){
        $request->validate([
            'portfolio_name' => 'required',
            'portfolio_title' => 'required',
            'portfolio_image' => 'required'
        ],[
            'portfolio_name.required' => 'This field Is Required',
            'portfolio_title.required' => 'This field Is Required',
        ]);

        $image = $request->file('portfolio_image');
        $name_gen = hexdec(uniqid()). '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(1020,519)->save('upload/portfolio/'.$name_gen);

        Portfolio::insert([
            'portfolio_name'=> $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_image' => $name_gen,
            'portfolio_description' => $request->portfolio_description,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Portfolio Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);
 
     } //End Method

     public function deletePortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        $img = $portfolio->portfolio_image;
        unlink('upload/portfolio/'.$img);

        Portfolio::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Portfolio Image Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);   


     }//End Method

     public function EditPortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit',compact('portfolio'));
    }// End Method

    public function UpdatePortfolio(Request $request){
        $portfolio_id = $request->id;

        if($request->file('portfolio_image'))
        {
            $image= $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()). '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1020,519)->save('upload/portfolio/'.$name_gen);

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $name_gen,
            ]);
        }else{
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
            ]);
        }

        $notification = array(
            'message' => 'Portfolio Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);
    
    
        
    }//End Method

    public function PortfolioDetails($id){
        $portfolio = Portfolio::findorfail($id);
        return view('frontend.portfolio_details' ,compact('portfolio'));

    }// End Method


}
