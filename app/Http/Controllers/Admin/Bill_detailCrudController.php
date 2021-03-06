<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Bill_detailRequest as StoreRequest;
use App\Http\Requests\Bill_detailRequest as UpdateRequest;
use Box\Spout\Reader;
use Box\Spout\Writer;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\DB;
use Box\Spout\Writer\Style\StyleBuilder;

class Bill_detailCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Bill_detail');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/bill_detail');
        $this->crud->setEntityNameStrings('bill_detail', 'bill_details');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

//        $this->crud->setFromDb();
        $this->crud->setListView("backpack::crud.list_foods");

        // ------ CRUD FIELDS
//         $this->crud->addField($options, 'update/create/both');
        $this->crud->addFields([
            [
                // MANDATORY
                'name'  => 'id_bill', // DB column name (will also be the name of the input)
                'label' => 'ID Bill', // the human-readable label for the input
                'type'  => 'text', // the field type (text, number, select, checkbox, etc)
            ],
            ['name' => 'id_food', // The db column name
                'label' => 'ID Food', // Table column heading
                'type' => 'text']
        ], 'create');
         $this->crud->addFields([
             [
                 // MANDATORY
                 'name'  => 'quantity', // DB column name (will also be the name of the input)
                 'label' => 'Quantity', // the human-readable label for the input
                 'type'  => 'text', // the field type (text, number, select, checkbox, etc)
             ],
             ['name' => 'price', // The db column name
                 'label' => 'Price', // Table column heading
                 'type' => 'text']
         ], 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
         $this->crud->addColumns([
             [
                 // MANDATORY
                 'name'  => 'id', // DB column name (will also be the name of the input)
                 'label' => 'ID', // the human-readable label for the input
                 'type'  => 'text', // the field type (text, number, select, checkbox, etc)
             ],
             [
                 // MANDATORY
                 'name'  => 'id_bill', // DB column name (will also be the name of the input)
                 'label' => 'ID Bill', // the human-readable label for the input
                 'type'  => 'text', // the field type (text, number, select, checkbox, etc)
             ],
             ['name' => 'id_food', // The db column name
                 'label' => 'ID Food', // Table column heading
                 'type' => 'text'],
             [
                 // MANDATORY
                 'name'  => 'quantity', // DB column name (will also be the name of the input)
                 'label' => 'Quantity', // the human-readable label for the input
                 'type'  => 'text', // the field type (text, number, select, checkbox, etc)
             ],
             ['name' => 'price', // The db column name
                 'label' => 'Price', // Table column heading
                 'type' => 'text']
         ]); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function ExportExcelAction()
    {
        $customer = DB::table("bill_detail")->get();

        $table_title = ['id','id_bill','id_food','quantity','price'];

        $oExcel =  Writer\WriterFactory::create(Type::XLSX); // for XLSX files
        $oExcel->openToBrowser("bill-detail.xlsx");

        $oExcel->addRowWithStyle($table_title,(new StyleBuilder())->setFontBold()->setFontSize(14)->build());
        foreach ($customer as $sheet){
            $oExcel->addRow(get_object_vars($sheet));
        }
        $oExcel->close();
    }

    public function ImportExcelAction()
    {
        if(isset($_FILES['excelFile']))
        {
            $target_file = basename($_FILES["excelFile"]["name"]);
            $des_file = 'uploads/' . basename($_FILES["excelFile"]["name"]);
            $excelFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $title = ['id','id_bill','id_food','quantity','price'];
            if($excelFileType != "xlsx" ) {
                return redirect()->back()->with("error","Sorry, only XLSX files are allowed.");
            }
            else {
                move_uploaded_file($_FILES["excelFile"]["tmp_name"], $des_file);
                $this->import_CusDB($des_file,$title);
            }
        }
        return redirect()->back();
    }

    public function import_CusDB($file_name,$title){
        $reader = Reader\ReaderFactory::create(Type::XLSX); // for XLSX files
        //$reader = ReaderFactory::create(Type::CSV); // for CSV files
        //$reader = ReaderFactory::create(Type::ODS); // for ODS files

        $reader->open($file_name);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key=>$row) {
                // do stuff with the row
                if($key==1){
                    $arr_diff = array_diff($title,$row);
                    if(count($arr_diff)!=0){
                        $reader->close();
                        unlink($file_name);
                        return redirect()->back()->with("error","Excel file not match pattern");
                    }
                }
                elseif($key!=1 && $row[0] != ""){
                    if(gettype($row[0])!="integer" || gettype($row[1])!="integer"|| gettype($row[2])!="integer" || gettype($row[3])!="integer"){
                        $reader->close();
                        unlink($file_name);
                        return redirect()->back()->with("error","False Value Type");
                    }
                    $count_id = DB::table("bill_detail")->where("id_bill",$row[0])->where("id_food",$row[1])->count();
                    if($count_id>0){
                        //Update
                        DB::table("bill_detail")->where("id_bill",$row[0])->where("id_food",$row[1])->update([
                            "quantity"=>$row[3],
                            "price"=>$row[4],
                        ]);
                    }else{
                        //Insert
//                        dd($row);
                        DB::table('bill_detail')->insert([
                            "id_bill"=>$row[1],
                            "id_food"=>$row[2],
                            "quantity"=>$row[3],
                            "price"=>$row[4],
                        ]);
                    }
                }
            }
        }
        $reader->close();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
