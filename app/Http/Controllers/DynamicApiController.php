<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Support\Facades\Schema;
class DynamicApiController extends Controller
{
    protected $recordController;

    public function __construct(RecordController $recordController)
    {
        $this->recordController = $recordController;
    }

    // Lấy tất cả bản ghi của bảng
    public function index($table)
    {
        // dd($table);
        // if (empty($table)) {
        //     return response()->json(['error' => 'Table name is requiredưdfds.'], 400);
        // }

        // Kiểm tra bảng có tồn tại trong cơ sở dữ liệu không
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table does not exist.'], 400);
        }

        return $this->recordController->index($table);
    }

    // Lấy bản ghi theo ID
    public function show($table, $id)
    {
        if (!$table) {
            return response()->json(['error' => 'Table name is requiredsdfgwe.'], 400);
        }

        // Kiểm tra bảng có tồn tại trong cơ sở dữ liệu không
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table does not exist.'], 400);
        }

        return $this->recordController->show($table, $id);
    }

    // Thêm bản ghi mới
    public function store(Request $request, $table)
    {
        if (!$table) {
            return response()->json(['error' => 'Table name is requireddfgr.'], 400);
        }

        // Kiểm tra bảng có tồn tại trong cơ sở dữ liệu không
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table does not exist.'], 400);
        }

        return $this->recordController->store($request, $table);
    }

    // Cập nhật bản ghi
    public function update(Request $request, $table, $id)
    {
        if (!$table) {
            return response()->json(['error' => 'Table name is requiredfdger.'], 400);
        }

        // Kiểm tra bảng có tồn tại trong cơ sở dữ liệu không
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table does not exist.'], 400);
        }

        return $this->recordController->update($request, $table, $id);
    }

    // Xóa bản ghi
    public function destroy($table, $id)
    {
        if (!$table) {
            return response()->json(['error' => 'Table name is requireddfger.'], 400);
        }

        // Kiểm tra bảng có tồn tại trong cơ sở dữ liệu không
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => 'Table does not exist.'], 400);
        }

        return $this->recordController->destroy($table, $id);
    }
}