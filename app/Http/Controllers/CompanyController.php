<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controllers;
use App\Models\Company;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('id','desc') -> paginate(5); // show 5 by 5
        return view('companies.index',compact('companies')); // compact passer data mn controller l vue kadirha ela chkel array 
    }
    public function create() {
        return view('companies.create');
    }
    // store a newly created resource in storage
    public function store (Request $request){
        $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|unique:companies,email',
            'address'=>'required',
        ]);
        Company::create($request->post());
        return redirect()->route('companies.index')->with('success','company ha been created');
    }

    // Display the specified resource
    public function show(Company $company) {
        return view('companies.show',compact('companies'));
    }

    // Show the form for editing the specified resource
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'=>'required|min:3',
            'email'=>"required|unique:companies,email,$company->id",
            'address'=>'required',
        ]);

        $company->fill($request->post()) -> save();

        return redirect()->route('companies.index')->with('success','company has been updated');
        }

        // Remove the specified resource from storage
    public function destroy(Company $company) {
        $company->delete();
            return redirect()->route('companies.index')->with('success','company deleted successfully');
            }
}
