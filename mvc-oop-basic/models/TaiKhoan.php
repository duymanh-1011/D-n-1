<?php

class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ================= LOGIN =================
    public function checkLogin($email, $mat_khau)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);

            $user = $stmt->fetch();

            if (!$user) return false;

            // check password
            if (!password_verify($mat_khau, $user['mat_khau'])) {
                return false;
            }

            // check quyền + trạng thái
            if ($user['chuc_vu_id'] != 2) return false;
            if ($user['trang_thai'] != 1) return false;

            return $user;

        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    //   LẤY USER 
    public function getTaiKhoanFromEmail($email)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    //  CHECK EMAIL 
    public function checkEmailExists($email)
    {
        try {
            $sql = "SELECT id FROM tai_khoans WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    //  REGISTER 
    public function register($ho_ten, $email, $ngay_sinh, $dia_chi, $password, $sdt)
    {
        try {
            $sql = "INSERT INTO tai_khoans 
                    (ho_ten, email, ngay_sinh, dia_chi, mat_khau, so_dien_thoai, chuc_vu_id, trang_thai)
                    VALUES (:ho_ten, :email, :ngay_sinh, :dia_chi, :mat_khau, :sdt, 2, 1)";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':ngay_sinh' => $ngay_sinh,
                ':dia_chi' => $dia_chi,
                ':mat_khau' => $password,
                ':sdt' => $sdt
            ]);

            return true;

        } catch (Exception $e) {
            error_log("Register Error: " . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function updateTaiKhoan($id, $ho_ten, $email, $ngay_sinh, $dia_chi, $so_dien_thoai)
    {
        try {
            $sql = "UPDATE tai_khoans SET ho_ten = :ho_ten, email = :email, ngay_sinh = :ngay_sinh, dia_chi = :dia_chi, so_dien_thoai = :so_dien_thoai WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':ngay_sinh' => $ngay_sinh,
                ':dia_chi' => $dia_chi,
                ':so_dien_thoai' => $so_dien_thoai,
                ':id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateMatKhau($id, $mat_khau)
    {
        try {
            $sql = "UPDATE tai_khoans SET mat_khau = :mat_khau WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':mat_khau' => password_hash($mat_khau, PASSWORD_DEFAULT),
                ':id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            error_log("Update Password Error: " . $e->getMessage());
            return false;
        }
    }
}
