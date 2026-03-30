<?php

class TaiKhoanClient
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function checkLogin($email, $matKhau)
    {
        try {
            $sql = 'SELECT * FROM tai_khoans WHERE email = :email LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($matKhau, $user['mat_khau'])) {
                return [
                    'success' => false,
                    'message' => 'Email hoặc mật khẩu không đúng'
                ];
            }

            if ((int)$user['chuc_vu_id'] !== 2) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản không có quyền đăng nhập client'
                ];
            }

            if ((int)$user['trang_thai'] !== 1) {
                return [
                    'success' => false,
                    'message' => 'Tài khoản của bạn đang bị khóa'
                ];
            }

            return [
                'success' => true,
                'user' => [
                    'id' => (int)$user['id'],
                    'email' => $user['email'],
                    'ho_ten' => $user['ho_ten']
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Không thể đăng nhập lúc này'
            ];
        }
    }

    public function getTaiKhoanById($id)
    {
        try {
            $sql = 'SELECT * FROM tai_khoans WHERE id = :id LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }
}
