<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use App\Models\GiangVien;
use App\Models\SinhVien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DangNhapController extends Controller
{
    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Lấy người dùng dựa trên username
        $user = User::with('role.permissions')->where('username', $request->username)->first();

        // Kiểm tra thông tin đăng nhập
        if (!$user || !Hash::check($request->password, $user->PasswordHash)) {
            return response()->json(['error' => 'Invalid username or password'], 401);
        }

        // Lấy vai trò của người dùng
        $roleID = $user->RoleID;
        if (!$roleID) {
            return response()->json(['error' => 'Role not assigned'], 404);
        }

        // Khởi tạo biến để lưu thông tin chi tiết người dùng
        $userDetails = null;
        Log::info('Loaded user role: ', ['RoleID' => $roleID]);

        // Kiểm tra RoleID và lấy thông tin chi tiết
        if ($roleID == 1) { // Sinh viên
            $userDetails = SinhVien::where('MaSinhVien', $user->MaNguoiDung)->first();
        } elseif ($roleID == 2) { // Giảng viên
            $userDetails = GiangVien::where('MaGiangVien', $user->MaNguoiDung)->first();
        } elseif ($roleID == 4) { // Cán bộ khoa
            $giangVien = GiangVien::where('MaGiangVien', $user->MaNguoiDung)->first();
            if ($giangVien && $giangVien->CanBoKhoa) {
                $userDetails = $giangVien;
            } else {
                return response()->json(['error' => 'Invalid role or permission'], 401);
            }
        }

        if (!$userDetails) {
            return response()->json(['error' => 'User details not found'], 404);
        }

        // Lấy danh sách quyền hạn từ Role
        $permissions = $user->role->permissions ? $user->role->permissions->pluck('PermissionName') : [];

        // Trả về thông tin người dùng
        return response()->json([
            "status" => "success",
            'userId' => $user->id,
            'role' => $user->role->RoleName ?? 'Unknown Role',
            'userDetails' => $userDetails,
            'permissions' => $permissions,
        ]);
    }
}
 