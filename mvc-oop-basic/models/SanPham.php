<?php
class SanPham {
    public  $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllSanPham(){
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            ';
            $stmt = $this->conn->prepare($sql);

            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }


    public function getDetailSanPham($id){
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            WHERE san_phams.id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id'=>$id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function reduceStock($san_pham_id, $so_luong){
        try {
            $sql = 'UPDATE san_phams SET so_luong = GREATEST(so_luong - :so_luong, 0) WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':so_luong' => $so_luong,
                ':id' => $san_pham_id
            ]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return false;
        }
    }

    public function restoreStock($san_pham_id, $so_luong){
        try {
            $sql = 'UPDATE san_phams SET so_luong = so_luong + :so_luong WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':so_luong' => $so_luong,
                ':id' => $san_pham_id
            ]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
            return false;
        }
    }

    public function getListAnhSanPham($id){
        try {
            $sql = 'SELECT * FROM hinh_anh_san_phams WHERE san_pham_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id'=>$id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }


    public function getBinhLuanFromSanPham($id){
        try {
            $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten, tai_khoans.anh_dai_dien
            FROM binh_luans
            INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
            WHERE binh_luans.san_pham_id = :id
            ';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id'=>$id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function addBinhLuan($san_pham_id, $tai_khoan_id, $noi_dung){
        try {
            $sql = 'INSERT INTO binh_luans (san_pham_id, tai_khoan_id, noi_dung, ngay_dang) VALUES (:san_pham_id, :tai_khoan_id, :noi_dung, NOW())';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':tai_khoan_id' => $tai_khoan_id,
                ':noi_dung' => $noi_dung
            ]);

            return true;
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }

    public function getAllDanhMuc(){
        try {
            $sql = 'SELECT * FROM danh_mucs ORDER BY ten_danh_muc';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function findProductByName($keyword){
        try {
            $sql = 'SELECT * FROM san_phams WHERE LOWER(ten_san_pham) LIKE LOWER(:keyword) ORDER BY ngay_nhap DESC LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':keyword' => '%' . $keyword . '%']);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function findCategoryByName($keyword){
        try {
            $sql = 'SELECT * FROM danh_mucs WHERE LOWER(ten_danh_muc) LIKE LOWER(:keyword) LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':keyword' => '%' . $keyword . '%']);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getFirstProductByCategory($danh_muc_id){
        try {
            $sql = 'SELECT * FROM san_phams WHERE danh_muc_id = :danh_muc_id ORDER BY ngay_nhap DESC LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':danh_muc_id' => $danh_muc_id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getListSanPhamDanhMuc($danh_muc_id){
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            WHERE san_phams.danh_muc_id = :danh_muc_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':danh_muc_id' => $danh_muc_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getSanPhamByFilter($danh_muc_id = null, $minPrice = null, $maxPrice = null){
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            WHERE 1=1';

            $params = [];
            if (!empty($danh_muc_id)) {
                $sql .= ' AND san_phams.danh_muc_id = :danh_muc_id';
                $params[':danh_muc_id'] = $danh_muc_id;
            }
            if (!empty($minPrice)) {
                $sql .= ' AND COALESCE(san_phams.gia_khuyen_mai, san_phams.gia_san_pham) >= :minPrice';
                $params[':minPrice'] = $minPrice;
            }
            if (!empty($maxPrice)) {
                $sql .= ' AND COALESCE(san_phams.gia_khuyen_mai, san_phams.gia_san_pham) <= :maxPrice';
                $params[':maxPrice'] = $maxPrice;
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
