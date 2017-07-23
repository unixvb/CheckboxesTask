<?php

namespace App\Http\Controllers;

use App\Checkbox;
use Illuminate\Http\Request;

class CheckboxesController extends Controller
{
    public function index(){
        $row_n = config('app.rows_number');
        $col_n = config('app.cols_number');
        $checked_boxes = Checkbox::all();

        return view('pages.table', compact('row_n', 'col_n', 'checked_boxes'));
    }

    public function create(Request $request)
    {
        //$data = $request->only(['checkbox_row', 'checkbox_col']);
        //Checkbox::create(['checkbox_row' => $data['checkbox_row'],'checkbox_col' => $data['checkbox_col']]);
        Checkbox::create($request->all());
        return 'success add';
    }

    public function delete(Request $request)
    {
        $data = $request->only(['checkbox_row', 'checkbox_col']);
        Checkbox::where($data)->delete();
        return 'success delete';
    }
}
