<?php
class AdminBaoCaoThongKeController
{
    public function home()
    {
        header('Location: ' . BASE_URL_ADMIN . '?act=san-pham');
        exit();
    }
}