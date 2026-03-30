<?php

class GioHangClient
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getGioHangFromUser($taiKhoanId)
    {
        $sql = 'SELECT * FROM gio_hangs WHERE tai_khoan_id = :tai_khoan_id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tai_khoan_id' => $taiKhoanId]);
        return $stmt->fetch();
    }

    public function addGioHang($taiKhoanId)
    {
        $sql = 'INSERT INTO gio_hangs (tai_khoan_id) VALUES (:tai_khoan_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tai_khoan_id' => $taiKhoanId]);
        return (int)$this->conn->lastInsertId();
    }

    public function getOrCreateGioHangId($taiKhoanId)
    {
        $gioHang = $this->getGioHangFromUser($taiKhoanId);
        if (!empty($gioHang['id'])) {
            return (int)$gioHang['id'];
        }

        return $this->addGioHang($taiKhoanId);
    }

    public function getDetailGioHang($gioHangId)
    {
        $sql = 'SELECT
                    chi_tiet_gio_hangs.id AS chi_tiet_id,
                    chi_tiet_gio_hangs.san_pham_id,
                    chi_tiet_gio_hangs.so_luong,
                    san_phams.ten_san_pham,
                    san_phams.hinh_anh,
                    san_phams.gia_san_pham,
                    san_phams.gia_khuyen_mai,
                    san_phams.so_luong AS ton_kho
                FROM chi_tiet_gio_hangs
                INNER JOIN san_phams ON chi_tiet_gio_hangs.san_pham_id = san_phams.id
                WHERE chi_tiet_gio_hangs.gio_hang_id = :gio_hang_id
                ORDER BY chi_tiet_gio_hangs.id DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':gio_hang_id' => $gioHangId]);
        return $stmt->fetchAll();
    }

    public function addToCart($taiKhoanId, $sanPhamId, $soLuong = 1)
    {
        $soLuong = max(1, (int)$soLuong);

        $stmtSp = $this->conn->prepare('SELECT id, so_luong FROM san_phams WHERE id = :id LIMIT 1');
        $stmtSp->execute([':id' => $sanPhamId]);
        $sanPham = $stmtSp->fetch();

        if (!$sanPham) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại'];
        }

        $tonKho = (int)$sanPham['so_luong'];
        if ($tonKho <= 0) {
            return ['success' => false, 'message' => 'Sản phẩm đã hết hàng'];
        }

        $gioHangId = $this->getOrCreateGioHangId($taiKhoanId);

        $stmtExists = $this->conn->prepare('SELECT id, so_luong FROM chi_tiet_gio_hangs WHERE gio_hang_id = :gio_hang_id AND san_pham_id = :san_pham_id LIMIT 1');
        $stmtExists->execute([
            ':gio_hang_id' => $gioHangId,
            ':san_pham_id' => $sanPhamId
        ]);
        $item = $stmtExists->fetch();

        if ($item) {
            $soLuongMoi = min($tonKho, (int)$item['so_luong'] + $soLuong);
            $stmtUpdate = $this->conn->prepare('UPDATE chi_tiet_gio_hangs SET so_luong = :so_luong WHERE id = :id');
            $stmtUpdate->execute([
                ':so_luong' => $soLuongMoi,
                ':id' => $item['id']
            ]);
        } else {
            $stmtInsert = $this->conn->prepare('INSERT INTO chi_tiet_gio_hangs (gio_hang_id, san_pham_id, so_luong) VALUES (:gio_hang_id, :san_pham_id, :so_luong)');
            $stmtInsert->execute([
                ':gio_hang_id' => $gioHangId,
                ':san_pham_id' => $sanPhamId,
                ':so_luong' => min($soLuong, $tonKho)
            ]);
        }

        return ['success' => true];
    }

    public function updateItemQuantity($taiKhoanId, $chiTietId, $soLuong)
    {
        $soLuong = (int)$soLuong;

        $sql = 'SELECT chi_tiet_gio_hangs.id, chi_tiet_gio_hangs.san_pham_id, san_phams.so_luong AS ton_kho
                FROM chi_tiet_gio_hangs
                INNER JOIN gio_hangs ON chi_tiet_gio_hangs.gio_hang_id = gio_hangs.id
                INNER JOIN san_phams ON chi_tiet_gio_hangs.san_pham_id = san_phams.id
                WHERE chi_tiet_gio_hangs.id = :chi_tiet_id
                AND gio_hangs.tai_khoan_id = :tai_khoan_id
                LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':chi_tiet_id' => $chiTietId,
            ':tai_khoan_id' => $taiKhoanId
        ]);
        $item = $stmt->fetch();

        if (!$item) {
            return;
        }

        if ($soLuong <= 0) {
            $this->removeItem($taiKhoanId, $chiTietId);
            return;
        }

        $soLuongHopLe = min($soLuong, (int)$item['ton_kho']);
        $stmtUpdate = $this->conn->prepare('UPDATE chi_tiet_gio_hangs SET so_luong = :so_luong WHERE id = :id');
        $stmtUpdate->execute([
            ':so_luong' => $soLuongHopLe,
            ':id' => $chiTietId
        ]);
    }

    public function removeItem($taiKhoanId, $chiTietId)
    {
        $sql = 'DELETE chi_tiet_gio_hangs
                FROM chi_tiet_gio_hangs
                INNER JOIN gio_hangs ON chi_tiet_gio_hangs.gio_hang_id = gio_hangs.id
                WHERE chi_tiet_gio_hangs.id = :chi_tiet_id
                AND gio_hangs.tai_khoan_id = :tai_khoan_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':chi_tiet_id' => $chiTietId,
            ':tai_khoan_id' => $taiKhoanId
        ]);
    }

    public function createOrderFromCart($taiKhoanId, $payload)
    {
        $gioHang = $this->getGioHangFromUser($taiKhoanId);
        if (!$gioHang) {
            return ['success' => false, 'message' => 'Giỏ hàng trống'];
        }

        $chiTietGioHang = $this->getDetailGioHang((int)$gioHang['id']);
        if (empty($chiTietGioHang)) {
            return ['success' => false, 'message' => 'Giỏ hàng trống'];
        }

        $phiShip = 30000;
        $tongTienSanPham = 0;

        foreach ($chiTietGioHang as $item) {
            $donGia = (float)($item['gia_khuyen_mai'] ?: $item['gia_san_pham']);
            $tongTienSanPham += $donGia * (int)$item['so_luong'];
        }

        $tongThanhToan = $tongTienSanPham + $phiShip;
        $maDonHang = 'DH-' . strtoupper(substr(md5(uniqid((string)$taiKhoanId, true)), 0, 8));

        try {
            $this->conn->beginTransaction();

            foreach ($chiTietGioHang as $item) {
                $stmtTonKho = $this->conn->prepare('SELECT so_luong FROM san_phams WHERE id = :id LIMIT 1');
                $stmtTonKho->execute([':id' => (int)$item['san_pham_id']]);
                $rowTonKho = $stmtTonKho->fetch();

                $tonKho = (int)($rowTonKho['so_luong'] ?? 0);
                if ($tonKho < (int)$item['so_luong']) {
                    throw new Exception('Số lượng sản phẩm trong kho không đủ');
                }
            }

            $sqlDonHang = 'INSERT INTO don_hangs
                (ma_don_hang, tai_khoan_id, ten_nguoi_nhan, email_nguoi_nhan, sdt_nguoi_nhan, dia_chi_nguoi_nhan, ngay_dat, tong_tien, ghi_chu, phuong_thuc_thanh_toan_id, trang_thai_id)
                VALUES
                (:ma_don_hang, :tai_khoan_id, :ten_nguoi_nhan, :email_nguoi_nhan, :sdt_nguoi_nhan, :dia_chi_nguoi_nhan, :ngay_dat, :tong_tien, :ghi_chu, :phuong_thuc_thanh_toan_id, :trang_thai_id)';
            $stmtDonHang = $this->conn->prepare($sqlDonHang);
            $stmtDonHang->execute([
                ':ma_don_hang' => $maDonHang,
                ':tai_khoan_id' => $taiKhoanId,
                ':ten_nguoi_nhan' => $payload['ten_nguoi_nhan'],
                ':email_nguoi_nhan' => $payload['email_nguoi_nhan'],
                ':sdt_nguoi_nhan' => $payload['sdt_nguoi_nhan'],
                ':dia_chi_nguoi_nhan' => $payload['dia_chi_nguoi_nhan'],
                ':ngay_dat' => date('Y-m-d'),
                ':tong_tien' => $tongThanhToan,
                ':ghi_chu' => $payload['ghi_chu'] ?: null,
                ':phuong_thuc_thanh_toan_id' => (int)$payload['phuong_thuc_thanh_toan_id'],
                ':trang_thai_id' => 1
            ]);

            $donHangId = (int)$this->conn->lastInsertId();

            $sqlChiTiet = 'INSERT INTO chi_tiet_don_hangs (don_hang_id, san_pham_id, don_gia, so_luong, thanh_tien)
                           VALUES (:don_hang_id, :san_pham_id, :don_gia, :so_luong, :thanh_tien)';
            $stmtChiTiet = $this->conn->prepare($sqlChiTiet);

            foreach ($chiTietGioHang as $item) {
                $donGia = (float)($item['gia_khuyen_mai'] ?: $item['gia_san_pham']);
                $soLuong = (int)$item['so_luong'];
                $thanhTien = $donGia * $soLuong;

                $stmtChiTiet->execute([
                    ':don_hang_id' => $donHangId,
                    ':san_pham_id' => (int)$item['san_pham_id'],
                    ':don_gia' => $donGia,
                    ':so_luong' => $soLuong,
                    ':thanh_tien' => $thanhTien
                ]);

                $stmtCapNhatTonKho = $this->conn->prepare('UPDATE san_phams SET so_luong = so_luong - :so_luong WHERE id = :san_pham_id');
                $stmtCapNhatTonKho->execute([
                    ':so_luong' => $soLuong,
                    ':san_pham_id' => (int)$item['san_pham_id']
                ]);
            }

            $stmtClear = $this->conn->prepare('DELETE FROM chi_tiet_gio_hangs WHERE gio_hang_id = :gio_hang_id');
            $stmtClear->execute([':gio_hang_id' => (int)$gioHang['id']]);

            $stmtDeleteCart = $this->conn->prepare('DELETE FROM gio_hangs WHERE id = :gio_hang_id');
            $stmtDeleteCart->execute([':gio_hang_id' => (int)$gioHang['id']]);

            $this->conn->commit();

            return [
                'success' => true,
                'ma_don_hang' => $maDonHang,
                'don_hang_id' => $donHangId
            ];
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            return [
                'success' => false,
                'message' => 'Không thể tạo đơn hàng. Vui lòng thử lại.'
            ];
        }
    }

    public function getOrderHistoryByUser($taiKhoanId)
    {
        $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai, phuong_thuc_thanh_toans.ten_phuong_thuc
                FROM don_hangs
                INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                INNER JOIN phuong_thuc_thanh_toans ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
                WHERE don_hangs.tai_khoan_id = :tai_khoan_id
                ORDER BY don_hangs.id DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tai_khoan_id' => $taiKhoanId]);
        return $stmt->fetchAll();
    }

    public function getOrderDetailByUser($taiKhoanId, $donHangId)
    {
        $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai, phuong_thuc_thanh_toans.ten_phuong_thuc
                FROM don_hangs
                INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                INNER JOIN phuong_thuc_thanh_toans ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
                WHERE don_hangs.id = :don_hang_id AND don_hangs.tai_khoan_id = :tai_khoan_id
                LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':don_hang_id' => $donHangId,
            ':tai_khoan_id' => $taiKhoanId
        ]);
        return $stmt->fetch();
    }

    public function getOrderItems($donHangId)
    {
        $sql = 'SELECT chi_tiet_don_hangs.*, san_phams.ten_san_pham, san_phams.hinh_anh
                FROM chi_tiet_don_hangs
                INNER JOIN san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id
                WHERE chi_tiet_don_hangs.don_hang_id = :don_hang_id
                ORDER BY chi_tiet_don_hangs.id ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':don_hang_id' => $donHangId]);
        return $stmt->fetchAll();
    }

    public function cancelOrderByUser($taiKhoanId, $donHangId, $lyDoHuy = null)
    {
        try {
            $this->conn->beginTransaction();

            $sqlOrder = 'SELECT * FROM don_hangs WHERE id = :id AND tai_khoan_id = :tai_khoan_id LIMIT 1';
            $stmtOrder = $this->conn->prepare($sqlOrder);
            $stmtOrder->execute([
                ':id' => $donHangId,
                ':tai_khoan_id' => $taiKhoanId
            ]);
            $order = $stmtOrder->fetch();

            if (!$order) {
                throw new Exception('Đơn hàng không tồn tại');
            }

            $trangThaiHienTai = (int)$order['trang_thai_id'];
            if (!in_array($trangThaiHienTai, [1, 2, 3], true)) {
                throw new Exception('Đơn hàng này không thể hủy ở trạng thái hiện tại');
            }

            $items = $this->getOrderItems($donHangId);
            foreach ($items as $item) {
                $stmtStock = $this->conn->prepare('UPDATE san_phams SET so_luong = so_luong + :so_luong WHERE id = :san_pham_id');
                $stmtStock->execute([
                    ':so_luong' => (int)$item['so_luong'],
                    ':san_pham_id' => (int)$item['san_pham_id']
                ]);
            }

            $sqlUpdate = 'UPDATE don_hangs
                          SET trang_thai_id = 11,
                              ngay_huy = :ngay_huy,
                              ly_do_huy = :ly_do_huy
                          WHERE id = :id AND tai_khoan_id = :tai_khoan_id';
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':ngay_huy' => date('Y-m-d H:i:s'),
                ':ly_do_huy' => $lyDoHuy ?: null,
                ':id' => $donHangId,
                ':tai_khoan_id' => $taiKhoanId
            ]);

            $this->conn->commit();
            return ['success' => true];
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
