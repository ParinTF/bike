<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Config, Validator;
class CategoryController extends Controller {
    var $rp = 2;
    public function category() {
        $category = Category::paginate($this->rp);
        return view('product/category',compact('category'));
    }
    public function search(Request $request) {
        $query = $request->q;
        if($query) {
            $category = Category::where('name', 'like', '%'.$query.'%')
            ->orWhere('name', 'like', '%'.$query.'%')
            ->paginate($this->rp);
        }
        else {
            $category = Category::paginate($this->rp);
        }
        return view('product/category', compact('category'));
    }

    public function edit($id = null) {
        $category = Category::find($id);
        
        if($id) {
            // edit view
            $category = Category::where('id', $id)->first(); return view('product/editcategory')
            ->with('category', $category);
        } else {
            // add view
            return view('product/addcategory');
        }
    }
    public function update(Request $request) {
        $rules = array(
        
        'name' => 'required',
        
        );
        
        $messages = array(
        'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน'
        );
        
        $id = $request->id;
        $temp = array(
        
            'name' => $request->name,
        );
        //ตรงนี้เป็นการนําค่าจากฟอร์ม มาใส่ตัวแปร array temp เพราะ class Validator ต้องการ array
        $validator = Validator::make($temp, $rules, $messages);
        if ($validator->fails()) {
        return redirect('category/edit/'.$id)
        ->withErrors($validator)
        ->withInput();
        }
        
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        return redirect('category')
->with('ok', true)
->with('msg', 'บันทึกขอมูลเรียบร้อยแลว้');
}
    public function insert(Request $request) {
        // validation ไว้เขียนทีหลัง ความสําคัญน้อยกว่า วิธีเอาค่าจากฟอร์ม มาบันทึกครับ
        $rules = array(
            'name' => 'required',
            );
            
            $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน', 
            );
            
            $id = $request->id;
            $temp = array(
                
                'name' => $request->name,
                
            );
            //ตรงนี้เป็นการนําค่าจากฟอร์ม มาใส่ตัวแปร array temp เพราะ class Validator ต้องการ array
            $validator = Validator::make($temp, $rules, $messages);
            if ($validator->fails()) {
            return redirect('category/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
            }
        $category = new Category();
       
        $category->name = $request->name;
        
        $category->save(); 
        
        return redirect('category')
        ->with('ok', true)
        ->with('msg', 'เพิ่มข้อมูลเรียบร้อยแล้ว ');
        }
        public function remove($id) {
            Category::find($id)->delete();
            return redirect('category')
            ->with('ok', true)
            ->with('msg', 'ลบข้อมูลสําเร็จ');
    }
}
