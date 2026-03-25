<?php
class SanPham
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function getAllSanPham()
    {
        try {
            $sql = 'SELECT * FROM san_phams';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo " lỗi" . $e->getMessage();
        }
    }

    public function getAllProduct()
    {
        return $this->getAllSanPham();
    }

    public function getDetailSanPham($id)
    {
        try {
            $sql = 'SELECT * FROM san_phams WHERE id = :id LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo " lỗi" . $e->getMessage();
            return false;
        }
    }

    public function getBinhLuanBySanPham($sanPhamId)
    {
        try {
            $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten
                    FROM binh_luans
                    LEFT JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
                    WHERE binh_luans.san_pham_id = :san_pham_id
                    AND binh_luans.trang_thai = 1
                    ORDER BY binh_luans.id DESC';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':san_pham_id' => $sanPhamId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo " lỗi" . $e->getMessage();
            return [];
        }
    }

    public function getDefaultTaiKhoanId()
    {
        try {
            $sql = 'SELECT id FROM tai_khoans WHERE chuc_vu_id = 2 LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();

            if (!empty($row['id'])) {
                return (int)$row['id'];
            }

            $sqlAny = 'SELECT id FROM tai_khoans LIMIT 1';
            $stmtAny = $this->conn->prepare($sqlAny);
            $stmtAny->execute();
            $rowAny = $stmtAny->fetch();
            return (int)($rowAny['id'] ?? 0);
        } catch (Exception $e) {
            echo " lỗi" . $e->getMessage();
            return 0;
        }
    }

    public function insertBinhLuan($taiKhoanId, $sanPhamId, $noiDung)
    {
        try {
            $sql = 'INSERT INTO binh_luans (tai_khoan_id, san_pham_id, noi_dung, ngay_dang, trang_thai)
                    VALUES (:tai_khoan_id, :san_pham_id, :noi_dung, :ngay_dang, :trang_thai)';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':tai_khoan_id' => $taiKhoanId,
                ':san_pham_id' => $sanPhamId,
                ':noi_dung' => $noiDung,
                ':ngay_dang' => date('Y-m-d H:i:s'),
                ':trang_thai' => 1,
            ]);
        } catch (Exception $e) {
            echo " lỗi" . $e->getMessage();
            return false;
        }
    }
}
