<?php
namespace App\Http\Controllers;

use App\Events\RecordUpdate;
use App\Events\RecordUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class RecordController extends Controller
{
    // Lấy tất cả bản ghi từ bảng động
    public function index($table)
    {
        try {
            // Lấy model tương ứng với bảng
            $modelClass = $this->getModelClass($table);

            if (!class_exists($modelClass)) {
                return response()->json(['error' => 'Model not found for table: ' . $table], 404);
            }

            // Lấy tất cả các bản ghi
            $records = $modelClass::with($this->getRelations($modelClass))->get();
            return response()->json($records);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    // Lấy một bản ghi cụ thể từ bảng động
    public function show($table, $id)
    {
        try {
            // Lấy model tương ứng với bảng
            $modelClass = $this->getModelClass($table);

            if (!class_exists($modelClass)) {
                return response()->json(['error' => 'Model not found for table: ' . $table], 404);
            }

            // Tìm bản ghi theo ID
            $record = $modelClass::with($this->getRelations($modelClass))->find($id);

            if (!$record) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            event(new RecordUpdate($table, 'show', $record));
            return response()->json($record);
            // return response()->json($this->transformRecord($record));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    // Thêm một bản ghi mới vào bảng động
    public function store(Request $request, $table)
    {
        try {
            // Lấy model tương ứng với bảng
            $modelClass = $this->getModelClass($table);

            if (!class_exists($modelClass)) {
                return response()->json(['error' => 'Model not found for table: ' . $table], 404);
            }

            // Lấy các quy tắc xác thực từ model
            $validationRules = $modelClass::getValidationRules();

            // Xác thực dữ liệu từ request
            $validator = Validator::make($request->all(), $validationRules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            // Tạo bản ghi mới
            $record = $modelClass::create($request->all());
            event(new RecordUpdate($table, 'created', $record));
            // RecordUpdated::dispatch($table, 'created', $record);

            return response()->json($record, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    // Cập nhật một bản ghi trong bảng động
    public function update(Request $request, $table, $id)
    {
        try {
            // Lấy model tương ứng với bảng
            $modelClass = $this->getModelClass($table);

            if (!class_exists($modelClass)) {
                return response()->json(['error' => 'Model not found for table: ' . $table], 404);
            }

            // Tìm bản ghi theo ID
            $record = $modelClass::find($id);

            if (!$record) {
                return response()->json(['error' => 'Record not found'], 404);
            }

            // Lấy các quy tắc xác thực từ model
            $validationRules = $modelClass::getValidationRules();

            // Xác thực dữ liệu từ request
            $validator = Validator::make($request->all(), $validationRules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            // Cập nhật bản ghi
            $record->update($request->all());
            event(new RecordUpdate($table, 'updated', $record));

            return response()->json($record);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    // Xóa một bản ghi khỏi bảng động
    public function destroy($table, $id)
    {
        try {
            // Lấy model tương ứng với bảng
            $modelClass = $this->getModelClass($table);

            if (!class_exists($modelClass)) {
                return response()->json(['error' => 'Model not found for table: ' . $table], 404);
            }

            // Tìm bản ghi theo ID
            $record = $modelClass::find($id);

            if (!$record) {
                return response()->json(['error' => 'Record not found'], 404);
            }

            // Xóa bản ghi
            $record->delete();
            event(new RecordUpdate($table, 'deleted', $record));

            return response()->json(['message' => 'Record deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    // Lấy class model tương ứng với bảng
    private function getModelClass($table)
    {
        // Quy tắc đặt tên model theo tên bảng: PascalCase và số ít
        // Ví dụ: bảng `users` -> model `App\Models\User`
        $modelName = ucfirst(Str::singular($table));
        return "App\\Models\\$modelName";
    }
    // private function getRelations($modelClass)
    // {
    //     if ($modelClass == 'App\Models\DoAn') {
    //         return ['taiLieu'];  // Chỉ tải quan hệ 'taiLieu' cho bảng DoAn
    //     }
    // // Danh sách các phương thức quan hệ (nếu có)
    //     if (method_exists($modelClass, 'relationsToLoad')) {
    //         return $modelClass::relationsToLoad();
    //     }
    //     return []; // Không có quan hệ nếu không được khai báo
    // }


    private function transformRecord($record)
    {
        // Chuyển đổi bản ghi thành mảng để điều chỉnh cấu trúc dữ liệu
        return $record->toArray();
    }

    private function getRelations($modelClass)
    {
        // Kiểm tra model có tồn tại hay không
        if (!class_exists($modelClass)) {
            throw new \Exception("Model class $modelClass does not exist.");
        }

        // Kiểm tra model có định nghĩa phương thức `relationsToLoad`
        if (method_exists($modelClass, 'relationsToLoad')) {
            return $modelClass::relationsToLoad();
        }

        // Xử lý cấu hình quan hệ cụ thể cho từng model
        $relationsMap = [
            'App\Models\DoAn' => ['taiLieu'], // Tải 'taiLieu' cho model DoAn
            // Thêm các model khác tại đây nếu cần
        ];

        // Trả về quan hệ nếu model tồn tại trong danh sách ánh xạ
        return $relationsMap[$modelClass] ?? [];
    }

}