<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryDealer;
use Illuminate\Http\Request;

class CategoryDealerController extends Controller
{
   
   public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:category_dealers_read'])->only('index');
        $this->middleware(['permission:category_dealers_create'])->only('create','store');
        $this->middleware(['permission:category_dealers_update'])->only('edit','update');
        $this->middleware(['permission:category_dealers_delete'])->only('destroy');

    }//end of constructor

    public function index()
    {
        $category_dealers = CategoryDealer::whenSearch(request()->search)->latest()->paginate(10);

        return view('dashboard.category_dealers.index',compact('category_dealers'));

    }//end of index

    
    public function create()
    {
        return view('dashboard.category_dealers.create');
        
    }//end of create

   
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => ['required','max:255'],
            'name_en' => ['required','max:255'],
            'image'   => ['required']
        ]);

        try {

            $request_data = $request->except('image');

            $request_data['image'] = $request->file('image')->store('category_dealers_image','public');

            CategoryDealer::create($request_data);

            session()->flash('success', __('dashboard.added_successfully'));
            return redirect()->route('dashboard.category_dealers.index');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }//end try

    }//end of store

   
    
    public function edit(CategoryDealer $categoryDealer)
    {
        return view('dashboard.category_dealers.edit',compact('categoryDealer'));

    }//end of edit

    
    public function update(Request $request, CategoryDealer $categoryDealer)
    {
        $request->validate([
            'name_ar'   => ['required','max:255'],
            'name_en'   => ['required','max:255'],
        ]);

        try {

            $request_data = $request->except('image');

            if ($request->image) {    

                Storage::disk('local')->delete('public/' . $categoryDealer->image);

                $request_data['image'] = $request->file('image')->store('category_dealers_image','public');
            }

            $categoryDealer->update($request_data);

            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.category_dealers.index');

         } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }//end try

    }//end of update

    
    public function destroy(CategoryDealer $categoryDealer)
    {
        try {

            Storage::disk('local')->delete('public/' . $categoryDealer->image);

            $categoryDealer->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.category_dealers.index');

         } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }//end try
        
    }//end pf destroy

}//end pf controller