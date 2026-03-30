-- Add cancellation tracking columns for client order cancel flow
ALTER TABLE don_hangs
ADD COLUMN IF NOT EXISTS ngay_huy DATETIME NULL AFTER trang_thai_id,
ADD COLUMN IF NOT EXISTS ly_do_huy TEXT NULL AFTER ngay_huy;
