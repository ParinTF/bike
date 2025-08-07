<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Config;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    var $rp = 10;

    public function __construct()
    { // Underscore 2 ขีด
        // get config from app.php
        $this->rp = Config::get('app.result_per_page');
    }
    public function index()
    {
        $products = Product::paginate($this->rp);
        return view('product/index', compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->q;
        if ($query) {
            $products = Product::where('code', 'like', '%' . $query . '%')
                ->orWhere('name', 'like', '%' . $query . '%')
                ->paginate($this->rp);
        } else {
            $products = Product::paginate($this->rp);
        }
        return view('product/index', compact('products'));
    }

    public function edit($id = null)
    {
        $categories = Category::pluck('name', 'id')->prepend('เลือกรายการ', '');
        if ($id) {
            $product = Product::find($id);
            return view('product/edit')
                ->with('product', $product)
                ->with('categories', $categories);
        } else {
            return view('product/add')
                ->with('categories', $categories);
        }
    }
    public function insert(Request $request)
    {
        $rules = array(
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required|numeric',
            'price' => 'numeric',
            'stock_qty' => 'numeric',
        );

        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('product/create') // หรือ form ที่ใช้เพิ่มสินค้า
                ->withErrors($validator)
                ->withInput();
        }

        // ✅ สร้าง object ใหม่
        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;

        // ✅ อัปโหลดไฟล์หากมีการอัปโหลด
        if ($request->hasFile('image')) {
            $f = $request->file('image');
            $upload_to = 'upload/images';

            $relative_path = $upload_to . '/' . $f->getClientOriginalName();
            $absolute_path = public_path($upload_to);

            $f->move($absolute_path, $f->getClientOriginalName());
            Image::make(public_path() . '/' . $relative_path)->resize(250, 250)->save();

            $product->image_url = $relative_path;
        }

        // ✅ บันทึกลงฐานข้อมูล
        $product->save();

        return redirect('product')->with('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function update(Request $request)
    {
        $rules = array(
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required|numeric',
            'price' => 'numeric',
            'stock_qty' => 'numeric',
        );

        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข',
        );

        $id = $request->id;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('product/edit/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        // ✅ ค้นหาสินค้าในฐานข้อมูลก่อนใช้งาน
        $product = Product::find($id);

        // ✅ อัปเดตข้อมูลฟิลด์ต่าง ๆ
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock_qty = $request->stock_qty;

        // ✅ อัปโหลดไฟล์หากมีการอัปโหลด
        if ($request->hasFile('image')) {
            $f = $request->file('image');
            $upload_to = 'upload/images'; // ต้องสร้างโฟลเดอร์นี้ไว้ที่ public/

            // สร้าง path ที่จะเก็บไฟล์
            $relative_path = $upload_to . '/' . $f->getClientOriginalName();
            $absolute_path = public_path($upload_to);

            // ย้ายไฟล์ไปยังโฟลเดอร์
            $f->move($absolute_path, $f->getClientOriginalName());
            Image::make(public_path() . '/' . $relative_path)->resize(250, 250)->save();
            // เก็บ path ลงฐานข้อมูล
            $product->image_url = $relative_path;
        }


        // ✅ บันทึกลงฐานข้อมูล
        $product->save();

        return redirect('product')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }
    public function remove($id)
    {
        Product::find($id)->delete();
        return redirect('product')
            ->with('ok', true)
            ->with('msg', 'ลบข้อมูลสําเร็จ');
    }
}
