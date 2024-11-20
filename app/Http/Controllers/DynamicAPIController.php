<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class DynamicAPIController extends Controller
{
    public function index($table)
    {
        if (!Schema::hasTable($table.'s')) {
            return response()->json(['error' => 'Table not found '.$table], 404);
        }

        $model = $this->getModel($table);
        return response()->json($model::all());
    }

    public function show($table, $id)
    {
        if (!Schema::hasTable($table.'s')) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $model = $this->getModel($table);
        $record = $model::find($id);

        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($record);
    }

    public function store(Request $request, $table)
    {
        if (!Schema::hasTable($table.'s')) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $model = $this->getModel($table);
        $validated = $this->validateRequest($request, $model);

        if ($validated !== true) {
            return response()->json(['errors' => $validated], 400);
        }

        $record = $model::create($request->all());
        return response()->json($record, 201);
    }

    public function update(Request $request, $table, $id)
    {
        if (!Schema::hasTable($table.'s')) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $model = $this->getModel($table);
        $record = $model::find($id);

        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $validated = $this->validateRequest($request, $model);

        if ($validated !== true) {
            return response()->json(['errors' => $validated], 400);
        }

        $record->update($request->all());
        return response()->json($record);
    }

    public function destroy($table, $id)
    {
        if (!Schema::hasTable($table.'s')) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $model = $this->getModel($table);
        $record = $model::find($id);

        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $record->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    // Hàm lấy model tương ứng với bảng
    private function getModel($table)
    {
        $modelClass = 'App\\Models\\' . ucfirst($table);

        if (!class_exists($modelClass)) {
            abort(404, 'Model not found');
        }

        return new $modelClass;
    }

    // Hàm validate dữ liệu
    private function validateRequest(Request $request, $model)
    {
        $rules = $model->getValidationRules() ?? [];
        $validator = Validator::make($request->all(), $rules);

        return $validator->fails() ? $validator->errors() : true;
    }
}
