<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Child;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class ChildTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('name', 'child');
        if (!$dataType->exists) {
            $dataType->fill([
                'slug'                  => 'child',
                'display_name_singular' => __('voyager::seeders.data_types.child.singular'),
                'display_name_plural'   => __('voyager::seeders.data_types.child.plural'),
                'icon'                  => 'voyager-github',
                'model_name'            => 'App\Models\Child',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
                'details'               => [
                    'order_column' => 'child_name',
                    'order_display_column' => 'child_name',
                    'order_direction' => 'asc',
                    'default_search_key' => 'child_name',
                    'scope' => null,
                ],
            ])->save();
        }
        //Data Rows
        $childDataType = DataType::where('slug', 'child')->firstOrFail();
        $dataRow = $this->dataRow($childDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'child_name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('voyager::seeders.data_rows.child_name'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => '',
                    'null'    => '',
                    'options' => [
                        '' => '-- None --',
                    ],
                    'relationship' => [
                        'key'   => 'id',
                        'label' => 'name',
                    ],
                ],
                'order' => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'mother_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('voyager::seeders.data_rows.mother_id'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'father_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('voyager::seeders.data_rows.father_id'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'date_of_birth');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'date',
                'display_name' => __('voyager::seeders.data_rows.date_of_birth'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 7,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'birth_place');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('voyager::seeders.data_rows.birth_place'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 8,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'child_of');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.child_of'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 9,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'akte_no');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('voyager::seeders.data_rows.akte_no'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 10,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'gender');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('voyager::seeders.data_rows.gender'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 11,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'blood_type_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('voyager::seeders.data_rows.blood_type_id'),
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 12,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.created_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 14,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.updated_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 15,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'child_hasmany_mother_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => __('voyager::seeders.data_rows.mother'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'model' => 'App\\Models\\Mother',
                    'table' => 'mother',
                    'type' => 'belongsTo',
                    'column' => 'mother_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table' => 'blog',
                    'pivot' => '0',
                    'taggable' => '0',
                ],
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'child_hasmany_father_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => __('voyager::seeders.data_rows.father'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'model' => 'App\\Models\\Father',
                    'table' => 'father',
                    'type' => 'belongsTo',
                    'column' => 'father_id',
                    'key' => 'id',
                    'label' => 'name',
                    'pivot_table' => 'blog',
                    'pivot' => '0',
                    'taggable' => '0',
                ],
                'order'        => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($childDataType, 'child_hasmany_blood_type_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => __('voyager::seeders.data_rows.blood_type'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'model' => 'App\\Models\\BloodType',
                    'table' => 'blood_type',
                    'type' => 'belongsTo',
                    'column' => 'blood_type_id',
                    'key' => 'id',
                    'label' => 'blood_type_name',
                    'pivot_table' => 'blog',
                    'pivot' => '0',
                    'taggable' => '0',
                ],
                'order'        => 13,
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('voyager::seeders.menu_items.child'),
            'url'     => '',
            'route'   => 'voyager.child.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-github',
                'color'      => null,
                'parent_id'  => 65,
                'order'      => 3,
            ])->save();
        }

        //Permissions
        Permission::generateFor('child');

    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
