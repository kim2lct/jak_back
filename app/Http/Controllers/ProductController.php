<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\UserHasRoles;
use Str;

class ProductController extends Controller
{
    
    
    public function index(){
        $products = Product::orderByDesc('id')->get();
        return response([                
            'products'=>$products,          
        ],200); 

    }

    public function show($id){
        $product = Product::find($id);
        if($product){
        return response([                
            'product'=>$product,          
        ],200); 
        }else{
            return response([                
            'message'=>'Product Not Found!',          
        ],400); 
        }
    }

    public function store(Request $request){ 
           
        if(UserHasRoles::where('roleable_id',auth()->user()->id)->first()->role_id <> 1){
            return response([                            
            'message'=>'You Not Authorized!'          
        ],401); 
        }

        try {
            $validated = $request->validate([
            'name'=>'required|unique:products,name',
            'price'=>'required|numeric',
            'category'=>'required|string',
            'image'=>'file|mimes:jpg,png|max:1024'
        ]);  
                         
                     } catch (\Exception $e) {
                         return response([
            'message'=>$e->getMessage(),
        ],401);
                     }             

        $product = Product::create([
            'name'=>$validated['name'],
            'price'=>$validated['price'],
            'category'=>$validated['category'],
            'image'=>$this->uploadImage($request->image,$validated['name'])
        ]);

        return response([                
            'product'=>$product,          
        ],201); 
        
    }

    public function update(Request $request,Product $product){
        if(UserHasRoles::where('roleable_id',auth()->user()->id)->first()->role_id <> 1){
            return response([                            
            'message'=>'You Not Authorized!'          
        ],401); 
        }
        $validated = $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'category'=>'required|string',
            'image'=>'file|mimes:jpg,png|max:1024'
        ]);

        $arr = [
            'name'=>$validated['name'],
            'price'=>$validated['price'],
            'category'=>$validated['category'],            
        ];

        if($request->image){
            $arr['image'] = $this->uploadImage($request->image,$validated['name']);
        }

        $product->update($arr);

        return response([                
            'product'=>$product,
            'message'=>'Product was updated!'          
        ],201); 
    }

    public function delete(Product $product){

        if(UserHasRoles::where('roleable_id',auth()->user()->id)->first()->role_id <> 1){
            return response([                            
            'message'=>'You Not Authorized!'          
        ],401); 
        }
        unlink(public_path('images').'/'.$product->image);
        $product->delete();
        return response([                            
            'message'=>'Product was Delete!'          
        ],201); 
    }

    protected function uploadImage($file,$name){
        $imageName = Str::slug($name,'-').'.'.$file->extension();  
    
        $file->move(public_path('images'), $imageName);
        return $imageName;
    }
}
