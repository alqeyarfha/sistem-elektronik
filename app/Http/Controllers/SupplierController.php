<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index()
    {
        $supplier = Supplier::latest()->paginate(5);
        return view('supplier.index', compact('supplier'));
    }


    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        //validate form
	      $validated = $request->validate([
            'nama_supplier'      => 'required',
            'alamat'      => 'required',
            'no_hp'      => 'required',
        ]);

        $supplier = new Supplier();
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->alamat = $request->alamat;
        $supplier->no_hp = $request->no_hp;
        $supplier->save();
        return redirect()->route('supplier.index');
        
    }
        public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.show', compact('supplier'));
    }


    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_supplier'      => 'required',
            'alamat'      => 'required',
            'no_hp'      => 'required',
        ]);
        

        $supplier = Supplier::findOrFail($id);
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->alamat = $request->alamat;
        $supplier->no_hp = $request->no_hp;      
        $supplier->save();
        return redirect()->route('supplier.index');

    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('supplier.index');

    }
}
