<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\DataType;
use App\Models\DataRow;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $this->build();

        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => '管理员',
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => '普通用户',
                ])->save();
        }
    }

    private function build()
    {
        $dataType = DataType::firstOrNew(['slug' => 'roles']);
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'roles',
                'display_name_singular' => '角色',
                'display_name_plural'   => '角色',
                'icon'                  => 'voyager-lock',
                'model_name'            => 'App\\Models\\Role',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
                'server_side'           => 1
            ])->save();
        }

        $dataRow = DataRow::firstOrNew(['data_type_id' => $dataType->id,'field' => 'id']);
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'number',
                'display_name' => 'ID',
                'required' => 1,
                'browse' => 1,
                'read' => 0,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'details' => '',
                'order' => 1,
            ])->save();
        }

        $dataRow = DataRow::firstOrNew(['data_type_id' => $dataType->id,'field' => 'name']);
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'text',
                'display_name' => '名称',
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'details' => '
{
    "validation": {
        "rule": "required",
        "messages": {
            "required": "不能为空"
        }
    }
}
                ',
                'order' => 2,
            ])->save();
        }

        $dataRow = DataRow::firstOrNew(['data_type_id' => $dataType->id,'field' => 'display_name']);
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'text',
                'display_name' => '展示名称',
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'details' => '
{
    "validation": {
        "rule": "required",
        "messages": {
            "required": "不能为空"
        }
    }
}
                ',
                'order' => 3,
            ])->save();
        }

        $dataRow = DataRow::firstOrNew(['data_type_id' => $dataType->id,'field' => 'created_at']);
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'timestamp',
                'display_name' => '创建时间',
                'required' => 0,
                'browse' => 0,
                'read' => 0,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'details' => '',
                'order' => 4,
            ])->save();
        }

        $dataRow = DataRow::firstOrNew(['data_type_id' => $dataType->id,'field' => 'updated_at']);
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'timestamp',
                'display_name' => '更新时间',
                'required' => 0,
                'browse' => 0,
                'read' => 0,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'details' => '',
                'order' => 5,
            ])->save();
        }


    }
}
