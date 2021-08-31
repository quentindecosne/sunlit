<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use Illuminate\Support\Arr;
use \App\Http\Requests\StoreTaxRequest;
use Illuminate\Support\Facades\Auth;


class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->can('list taxes'))
            return view('taxes.index');
    
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
                $order_column = "taxes.amount";
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
        $totalRecords = Tax::get()->count();
        $totalRecordswithFilter = Tax::where('name', 'like', '%'.$search.'%')
            ->orWhere('amount', 'like', '%'.$search.'%')
            ->get()
            ->count();
        

        // Fetch records
        if ($length < 0)
            $taxes = Tax::where('name', 'like', '%'.$search.'%')
                ->orWhere('amount', 'like', '%'.$search.'%')
                ->orderBy($order_column, $order_dir)
                ->get();
        else
            $taxes = Tax::where('name', 'like', '%'.$search.'%')
                ->orWhere('amount', 'like', '%'.$search.'%')
                ->orderBy($order_column, $order_dir)
                ->skip($start)
                ->take($length)
                ->get();

        $arr = array();

        foreach($taxes as $record)
        {
            $arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "amount" => $record->amount,
                "display_amount" => $record->display_amount
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tax = new Tax();
        return view('taxes.form', ['tax' => $tax]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData = Arr::except($validatedData, array('display_amount'));
        $tax = Tax::create($validatedData);
        if ($tax){
            return redirect(route('taxes'))->with('success', trans('app.record_added', ['field' => 'tax']));
        }
        return back()->withInputs($request->input())->with('error', trans('error.record_added', ['field' => 'tax']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax = Tax::find($id);
        if ($tax){
            return view('taxes.form', ['tax' => $tax]);
        }
        return view('taxes.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaxRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaxRequest $request, $id)
    {
        $validatedData = $request->validated();
        $validatedData = Arr::except($validatedData, array('display_amount'));
        $tax = Tax::whereId($id)->update($validatedData);
        if ($tax){
            return redirect(route('taxes'))->with('success', trans('app.record_edited', ['field' => 'tax']));
        }
        return back()->withInputs($request->input())->with('error', trans('error.record_edited', ['field' => 'tax']));
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
        if ($user->can('delete taxes')){
            Tax::destroy($id);
            return redirect(route('taxes'))->with('success', trans('app.record_deleted', ['field' => 'tax']));
        }
        return abort(403, trans('error.unauthorized'));
    }

    /**
     * Display a listing of the resource for select2
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function getListForSelect2(Request $request)
    {
        if ($request->has('q')){
            $taxes = Tax::where('name', 'like', $request->get('q').'%')->get(['id', 'name as text']);
        }
        else{
            $taxes = Tax::get(['id', 'name as text']);
        }
        return ['results' => $taxes];
    }     
}
