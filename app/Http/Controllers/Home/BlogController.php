<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
Use Image;

class BlogController extends Controller
{
    public function AllBlog(){
        
        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all',compact('blogs'));

    } //End Method

    public function AddBlog(){
        
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        // dd($categories);
        return view('admin.blogs.blogs_add' , compact('categories'));

    } //End Method

    public function StoreBlog(Request $request){
        
        $request->validate([
            'blog_category_id' => 'required',
            'blog_title' => 'required',
            'blog_tags' =>  'required|max:100',
            'blog_image' => 'required|image'
        ]);

        $image= $request->file('blog_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(430,327)->save('upload/blog/'.$name_gen);
        $save_url = 'upload/blog/'.$name_gen;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_image' => $save_url,
            'blog_description' => $request->blog_description,
            'created_at' =>Carbon::now()
        ]);

        $notifications = array(
            'message' => 'Blog Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog')->with($notifications);

    } //End Method

    public function EditBlog($id){
        $blogs = Blog::findorfail($id);
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blogs.blogs_edit',compact('blogs','categories'));
    } //End Method

    public function UpdateBlog(Request $request,$id){
        if($request->file('blog_image')){
            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()). '.' .$image->getClientOriginalExtension();
            Image::make($image)->resize(430,327)->save('upload/blog/'.$name_gen);
            $save_url = 'upload/blog/' .$name_gen;

            Blog::findorfail($id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_image' => $save_url,
                'blog_description' => $request->blog_description,
                'updated_at' =>Carbon::now()
            ]);

            $notifications = array(
                'message' => 'Blog With Image Has Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog')->with($notifications);
        }
        else{
            
            Blog::findorfail($id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'updated_at' =>Carbon::now()
            ]);

            $notifications = array(
                'message' => 'Blog Without Image Has Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog')->with($notifications);
        }

    } //End Method

    public function DeleteBlog($id){
        $blog = Blog::findorfail($id);
        $image = $blog->blog_image;
        unlink($image);
        Blog::findorfail($id)->delete();

        $notifications = array(
            'message' => 'Blog Has Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog')->with($notifications);

    } //End Method

}
