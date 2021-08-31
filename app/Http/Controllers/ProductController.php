<?php

namespace App\Http\Controllers;


use \NumberFormatter;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use \App\Http\Requests\StoreProductRequest;

use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->can('list products'))
            return view('products.index');
    
        return abort(403, trans('error.unauthorized'));
    }


    public function getListForDatatables(Request $request)
    {
        $draw = 1;
        if ($request->has('draw'))
            $draw = $request->get('draw');

        $start = 0;
        if ($request->has('start'))
            $start = $request->get("start");

        $length = 10;
        if ($request->has('length')) {
            $length = $request->get("length");
        }

        $order_column = 'name';
        $order_dir = 'ASC';
        $order_arr = array();
        if ($request->has('order')) {

            $order_arr = $request->get('order');
            $column_arr = $request->get('columns');
            $column_index = $order_arr[0]['column'];

            if ($column_index==1)
                $order_column = "categories.name";
            elseif ($column_index==2)
                $order_column = "suppliers.company";
            elseif ($column_index==3)
                $order_column = "taxes.name";
            else
                $order_column = $column_arr[$column_index]['data'];
            $order_dir = $order_arr[0]['dir'];
        }


        $search = '';
        if ($request->has('search')) {
            $search_arr = $request->get('search');
            $search = $search_arr['value'];
        }

        // Total records
        $totalRecords = Product::all()->count();
        
        $totalRecordswithFilter = Product::join('categories', 'categories.id', '=', 'products.category_id')
            ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
            ->join('taxes', 'taxes.id', '=', 'products.tax_id')
            ->where('products.code', 'like', '%'.$search.'%')
            ->orWhere('products.name', 'like', '%'.$search.'%')
            ->get()
            ->count();



        /*
            build the query
        */
        $query = Product::query();

        $query->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
            ->join('taxes', 'taxes.id', '=', 'products.tax_id');


        /*
            individual column filtering
        */
        $column_arr = $request->get('columns');
        
        if (!empty($column_arr[1]['search']['value'])) 
            $query->where('categories.name', 'like', '%'.$column_arr[1]['search']['value'].'%');
       

        if (!empty($column_arr[2]['search']['value']))
            $query->where('suppliers.company', 'like', '%'.$column_arr[2]['search']['value'].'%');


        if (!empty($column_arr[3]['search']['value']))
            $query->where('taxes.name', 'like', '%'.$column_arr[3]['search']['value'].'%');


        if (!empty($column_arr[4]['search']['value']))
            $query->where('products.code', 'like', '%'.$column_arr[4]['search']['value'].'%');


        if (!empty($column_arr[5]['search']['value']))
            $query->where('products.name', 'like', '%'.$column_arr[5]['search']['value'].'%');



        $query->orderBy($order_column, $order_dir);

        if ($length < 0)
            $query->skip($start)
                ->take($length);

        $products = $query->get(['products.*', 'categories.name as category_name', 'taxes.name as tax_name']);

        $arr = array();

        $fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::CURRENCY);

        foreach($products as $record)
        {

            $arr[] = array(
                "id" => $record->id,
                "category" => $record->category->name,
                "supplier" => $record->supplier->company,
                "tax" => $record->tax->display_amount,
                "code" => $record->code,
                "name" => $record->name,
                "model" => $record->model,
                "purchase_price" => $fmt->format($record->purchase_price/100), //sprintf('%01.2f',($record->purchase_price/100)),
                "minimum_quantity" => $record->minimum_quantity,
                "cable_length" => $record->cable_length,
                "kw_rating" => $record->kw_rating,
                "part_number" => $record->part_number,
                "notes" => $record->notes

            );
        }

        $response = array(
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $arr,
            'error' => null
        );

        
        echo json_encode($response);

        exit;
    }


    public function getExportList()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();
        return view('products.form', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData = Arr::except($validatedData, array('display_purchase_price'));
        $product = Product::create($validatedData);
        if ($product){
            return redirect(route('products'))->with('success', trans('app.record_added', ['field' => 'product']));
        }
        return back()->withInputs($request->input())->with('error', trans('error.record_added', ['field' => 'product']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product)
            return view('products.show', ['product'=>$product]);

            return back()->with('error', trans('error.resource_doesnt_exist', ['field' => 'product']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if ($product){
            return view('products.form', ['product' => $product]);
        }
        return view('products.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $id)
    {
        $validatedData = $request->validated();
        $validatedData = Arr::except($validatedData, array('display_purchase_price'));
        $product = Product::whereId($id)->update($validatedData);
        if ($product){
            return redirect(route('products'))->with('success', trans('app.record_edited', ['field' => 'product']));
        }
        return back()->withInputs($request->input())->with('error', trans('error.record_edited', ['field' => 'product']));
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->can('delete products')){
            Product::destroy($id);
            return redirect(route('products'))->with('success', trans('app.record_deleted', ['field' => 'product']));
        }
        return abort(403, trans('error.unauthorized'));
    }
}
