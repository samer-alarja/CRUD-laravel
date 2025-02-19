<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Validator;
class ProductController extends Controller
{
   public function index()
   {
      return view('admin.product.home');
   }
   public function getCourse(Request $request)
   {
      $data = Product::where('teacher_id', '=', value: Auth::id())->get();
      return datatables()->of($data)
         ->addColumn('img', function ($row) {
            return "<a href='" . asset($row->image) . "' target='_blank'>
                        <img src='" . asset($row->image) . "' style='width:70px; height:70px;'>
                    </a>";
         })
         ->addColumn('edit', function ($row) {
            return "<a href='" . route('admin/products/edit', ['id' => $row->id]) . "' class='btn btn-success' style='margin-top:10px'>Edit</a>";
         })
         ->addColumn('delete', function ($row) {
            return "<a href='" . route('admin/products/delete', ['id' => $row->id]) . "' class='btn btn-danger' style='margin-top:10px'>Delete</a>";
         })
         ->rawColumns(['edit', 'delete', 'img'])
         ->make(true);
   }
   public function create()
   {
      return view('admin.product.create');
   }

   public function save(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'name' => 'required|max:255|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
         'description' => 'required|max:255|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
         'Base_Mark' => 'required|max:255',
         'Pass_Mark' => 'required|max:255',
         'image' => 'required|nullable|mimes:png,jpg,jpeg,webp',
      ]);
      if ($validator->fails()) {
         return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
         ], 422);
      }
      $getCourse = Product::where('teacher_id', '=', Auth::id())
         ->where('Name', '=', $request->name)
         ->get();
      if ($getCourse->isNotEmpty()) {
         return response()->json([
            'success' => false,
            'message' => 'You have already added this course',
            'errors' => ['name' => ['You have already added this course']]
         ], 422);
      }
      if ($request->has('image')) {
         $file = $request->file('image');
         $extension = $file->getClientOriginalExtension();
         $filename = time() . '.' . $extension;
         $path = 'uploads2/category/';
         $file->move($path, $filename);
      }
      Product::create([
         'Name' => $request->name,
         'Description' => $request->description,
         'Image' => $path . $filename,
         'Base_Mark' => $request->Base_Mark,
         'Pass_Mark' => $request->Pass_Mark,
         'teacher_id' => Auth::id(),
      ]);
      return response()->json(['success' => 'Form submitted successfully']);
   }
   public function edit($id)
   {
      $products = Product::findOrFail($id);
      return view('admin.product.update', compact('products'));
   }

   public function update(Request $request, $id)
   {
      $request->validate([
         'Name' => 'required|max:255|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
         'Description' => 'required|max:255|string|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
         'Base_Mark' => 'required|max:255',
         'Pass_Mark' => 'required|max:255',
         'image' => 'nullable|mimes:png,jpg,jpeg,webp',
      ]);
      $product = Product::findOrFail($id);
      if ($request->has('image')) {
         $file = $request->file('image');
         $extension = $file->getClientOriginalExtension();
         $filename = time() . '.' . $extension;
         $path = 'uploads2/category/';
         $file->move($path, $filename);
         $image = $path . $filename;
         if (File::exists($product->image)) {
            File::delete($product->image);
         }
      } else {
         $image = $product->image;
      }
      $data = $product->update([
         'Name' => $request->Name,
         'Description' => $request->Description,
         'Base_Mark' => $request->Base_Mark,
         'Pass_Mark' => $request->Pass_Mark,
         'Image' => $image,
      ]);
      if ($data) {
         session()->flash('success', 'Course Update Successful');
         return redirect(route("admin/products"));
      } else {
         session()->flash('error', 'Some problem occure');
         return redirect(to: route("admin.products/create"));
      }
   }
   public function delete($id)
   {
      $products = Product::findOrFail($id);
      if (File::exists($products->image)) {
         File::delete($products->image);
      }
      $products->delete();
      if ($products) {
         session()->flash('success', 'Course Delete Successful');
         return redirect(route("admin/products"));
      } else {
         session()->flash('error', 'Some problem occure');
         return redirect(route("admin.products/create"));
      }
   }

}

