<?php

namespace App\Http\Controllers;

use NumberFormatter;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{

    //
    public function index() {
        return view('reports.stock');
    }


    public function closingStock()
    {
        return view('reports.closing-stock');
    }


    public function salesProductTotals(?string $report_format="quantity")
    {
        /*
            final code 
        */
        if ($report_format=="sales") {
            $user = Auth::user();
            if ($user->hasRole('super-admin'))
                return view('reports.sales-product-totals', ['report_format' => 'sales']);
        }
        elseif ($report_format=="quantity")
            return view('reports.sales-product-totals', ['report_format' => 'quantity']);

        return abort(403, trans('error.unauthorized'));
    }


    /*
        for ajax call from blade file
        url     : "{{ route('ajax.sales-product-totals') }}", 

    */
    public function getSalesProductTotals(Request $request)
    {

        $res = array();

        $draw = 1;
        if ($request->has('draw'))
            $draw = $request->get('draw');

        $product="_ALL";
        if ($request->has('search')){
            $value = $request->get('search')['value'];
            if (!is_null($value))
                $product = $value;
        }

        $limit = 0;
        if ($request->has('limit'))
        {
            $limit = $request->get('limit');
        }

        /**
         * period_monthly or period_quarterly
         */
        $report_format = 'Sales';
        if ($request->has('report_format'))
            $report_format = $request->get('report_format');

        $period = 'period_monthly';
        if ($request->has('period'))
            $period = $request->get('period');

        $year = date('Y');
        if ($request->has('year'))
            $year = $request->get('year');

        $month = date('n');
        if ($request->has('month'))
        {
            $month = $request->get('month');
            if (empty($month))
                $month = date('n');
        }

        $quarter = 'Q1';
        if ($request->has('quarter'))
        {
            $quarter = $request->get('quarter');

            if (empty($quarter))
                $quarter = 'Q1';
        }

        $category = "_ALL";
        if ($request->has('category'))
        {
            $category = $request->get('category');
            if (empty($category))
                $category = "_ALL";
        }
       
        $sale_order = new SaleOrder();
        $res = $sale_order->calculateProductSalesTotals('period_monthly', $year, "_ALL", "_ALL", $product, 0);
        //dd($res);

        /*
            iterate through array and sort by part_number=>months
        */
        $data = array();
        foreach ($res as $month=>$product_array)
        {
            // foreach ($product_array as $product)
            //     $data[ $product['part_number'] ][ $month ] = $product['amount_sold'];

            foreach ($product_array as $product)
            {

                $data[ $product['id'] ][ 'part_number' ] = $product['part_number'];
                $data[ $product['id'] ][ 'description' ] = $product['description'];
                
                if ($month==1)
                    $data[ $product['id'] ][ 1 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==2)
                    $data[ $product['id'] ][ 2 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==3)
                    $data[ $product['id'] ][ 3 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==4)
                    $data[ $product['id'] ][ 4 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==5)
                    $data[ $product['id'] ][ 5 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==6)
                    $data[ $product['id'] ][ 6 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==7)
                    $data[ $product['id'] ][ 7 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==8)
                    $data[ $product['id'] ][ 8 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==9)
                    $data[ $product['id'] ][ 9 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==10)
                    $data[ $product['id'] ][ 10 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==11)
                    $data[ $product['id'] ][ 11 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
                elseif($month==12)
                    $data[ $product['id'] ][ 12 ] = ($report_format == 'sales' ? $product['amount_sold'] : $product['quantity_sold']);
            }
        }

        $fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::CURRENCY);
        $fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);

        $arr = array();
        //foreach ($data as $part_number=>$month)
        foreach ($data as $key=>$value)
        {

            $total = 0;
            
            if (array_key_exists(1, $value))
                $total = (float)$value[1];
            if (array_key_exists(2, $value))
                $total += (float)$value[2];
            if (array_key_exists(3, $value))
                $total += (float)$value[3];
            if (array_key_exists(4, $value))
                $total += (float)$value[4];
            if (array_key_exists(5, $value))
                $total += (float)$value[5];
            if (array_key_exists(6, $value))
                $total += (float)$value[6];
            if (array_key_exists(7, $value))
                $total += (float)$value[7];
            if (array_key_exists(8, $value))
                $total += (float)$value[8];
            if (array_key_exists(9, $value))
                $total += (float)$value[9];
            if (array_key_exists(10, $value))
                $total += (float)$value[10];
            if (array_key_exists(11, $value))
                $total += (float)$value[11];
            if (array_key_exists(12, $value))
                $total += (float)$value[12];

            $arr[] = array(
                "id" => $key,
                "part_number" => $value['part_number']."<br><small>".$value['description']."</small>",
                "jan" => (array_key_exists(1, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[1], "INR") : number_format($value[1],0,'.',',')) : 0),
                "feb" => (array_key_exists(2, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[2], "INR") : number_format($value[2],0,'.',',')) : 0),
                "mar" => (array_key_exists(3, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[3], "INR") : number_format($value[3],0,'.',',')) : 0),
                "apr" => (array_key_exists(4, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[4], "INR") : number_format($value[4],0,'.',',')) : 0),
                "may" => (array_key_exists(5, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[5], "INR") : number_format($value[5],0,'.',',')) : 0),
                "jun" => (array_key_exists(6, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[6], "INR") : number_format($value[6],0,'.',',')) : 0),
                "jul" => (array_key_exists(7, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[7], "INR") : number_format($value[7],0,'.',',')) : 0),
                "aug" => (array_key_exists(8, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[8], "INR") : number_format($value[8],0,'.',',')) : 0),
                "sep" => (array_key_exists(9, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[9], "INR") : number_format($value[9],0,'.',',')) : 0),
                "oct" => (array_key_exists(10, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[10], "INR") : number_format($value[10],0,'.',',')) : 0),
                "nov" => (array_key_exists(11, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[11], "INR") : number_format($value[11],0,'.',',')) : 0),
                "dec" => (array_key_exists(12, $value) ? ($report_format == 'sales' ? $fmt->formatCurrency($value[12], "INR") : number_format($value[12],0,'.',',')) : 0),
                "total" => $total
            );
        }

        /*
            sort, descending, on the total column
            for DESC sorting, you reverse the position of the a and the b
        */
        usort($arr, function($a, $b) {
            //return $a['total'] <=> $b['total'];
            return $b['total'] <=> $a['total'];
        });

        /*
            if limit is set, slice the array
        */
        if ($limit > 0)
            $arr = array_slice($arr, 0, $limit);

        /*
            format the total column
        */
        for ($i=0;$i<count($arr);$i++)
            $arr[$i]["total"] = ($report_format == 'sales' ? $fmt->formatCurrency($arr[$i]['total'],"INR") : number_format($arr[$i]['total'],0,'.',','));

        $totalRecords = count($arr);
        $totalRecordswithFilter = count($arr);
        
        $response = array(
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $arr,
            'error' => null
        );

        return response()->json($response);
    }

}
