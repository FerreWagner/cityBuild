<?php
namespace app\admin\model;
use think\Model;

class Study extends Model
{
    /**
     * @param $id
     * @return $this
     * 删除统考信息
     */
    public static function delStatus($id)
    {
        return self::update(['del' => 1], ['id' => $id]);
    }
}