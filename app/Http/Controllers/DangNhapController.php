<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use App\Models\GiangVien;
use App\Models\SinhVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DangNhapController extends Controller
{
    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Xác thực yêu cầu
        $validator = Validator::make($request->all(), [
            'TenDangNhap' => 'required|string|max:50',
            'MatKhau' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Tìm người dùng theo TenDangNhap
        $user = TaiKhoan::where('TenDangNhap', $request->TenDangNhap)->first();

        if ($user && Hash::check($request->MatKhau, $user->MatKhau)) {
            // Đăng nhập thành công
            // Kiểm tra vai trò và trả về thông tin tương ứng
            $userData = null;

            if ($user->VaiTro == 'GiangVien') {
                $userData = GiangVien::find($user->MaNguoiDung);  // Lấy thông tin giảng viên
            } elseif ($user->VaiTro == 'SinhVien') {
                $userData = SinhVien::find($user->MaNguoiDung);  // Lấy thông tin sinh viên
            }

            return response()->json([
                'message' => 'Đăng nhập thành công.',
                'data' => $userData,
                'vaiTro' => $user->VaiTro,
            ], 200);
        } else {
            // Đăng nhập thất bại
            return response()->json([
                'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác.',
            ], 401);
        }
    }
}
