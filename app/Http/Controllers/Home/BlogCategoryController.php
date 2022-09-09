<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
   public function AllBlogCategory(){
        $blogcategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all' , compact('blogcategory'));
   } // End Method

    public function AddBlogCategory(){
        return view('admin.blog_category.blog_category_add');

    } // End Method

    public function StoreBlogCategory(Request $request){
        $request->validate([
            'category' => 'required'
        ],[
            'category.required' => 'blog category is required'
        ]);

        BlogCategory::insert([
            'blog_category' =>$request->category
        ]);

        $notification = array(
            'message' => 'Blog Category Has Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);

    } // End Method

    public function EditBlogCategory($id){
        $blogcategory = BlogCategory::findorfail($id);
        return view('admin.blog_category.blog_category_edit', compact('blogcategory'));

    } //End Method

    public function UpdateBlogCategory(Request $request, $id){
        BlogCategory::findorfail($id)->update([
            'blog_category' => $request->category
        ]);
        $notification = array(
            'message' => 'Blog Category Has Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);

    } //end Method

    public function DeleteBlogCategory($id){
        BlogCategory::findorfail($id)->delete();

        $notification = array(
            'message' => 'Blog Category Has Delated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);

    } //End method
}
