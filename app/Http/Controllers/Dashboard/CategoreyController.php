<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Categorey;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoreyController extends Controller
{

    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:categoreys_read'])->only('index');
        $this->middleware(['permission:categoreys_create'])->only('create','store');
        $this->middleware(['permission:categoreys_update'])->only('edit','update');
        $this->middleware(['permission:categoreys_delete'])->only('destroy');

    }//end of constructor

    public function index()
    {
        $categoreys = Categorey::where('sub_categoreys','0')->whenSearch(request()->search)->latest()->paginate(10);

        return view('dashboard.categoreys.index', compact('categoreys'));

    }//end of index

    
    public function create()
    {
        return view('dashboard.categoreys.create');

    }//end of create

    
    public function store(Request $request)
    {

        $request->validate([
            'name_ar' => ['required','max:255'],
            'name_en' => ['required','max:255'],
        ]);

        try {

            categorey::create($request->all());

            session()->flash('success', __('dashboard.added_successfully'));
            return redirect()->route('dashboard.categoreys.index');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }//end try

    }//end of store

    
    public function edit(Categorey $categorey)
    {
        return view('dashboard.categoreys.edit', compact('categorey'));
        
    }//end of edit

    
    public function update(Request $request, Categorey $categorey)
    {
        
        $request->validate([
            'name_ar'   => ['required','max:255'],
            'name_en'   => ['required','max:255'],
        ]);

        try {

            $categorey->update($request->all());

            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.categoreys.index');

         } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }//end try

    }//end of update

    
    public function destroy(Categorey $categorey)
    {
        try {

            $categorey->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.categoreys.index');

         } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }//end try
        
    }//end pf destroy

    public function sub_categoreys($id)
    {
    
        $categoreys = Categorey::where('sub_categoreys',$id)->get();

        return response()->json($categoreys);

    }//end of  sub_categoreys 

}//end pf controller
