<?php

namespace App\Repositories;

use App\Permission;

use Gate;

class PermissionsRepository extends VueTableRepository {

    public function __construct(Permission $permission) {
        $this->model = $permission;
    }

    public function getTableData() {
        $data = parent::getTableData();

        return response()->json(
            $data
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function add($request) {
        if (Gate::denies('create',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $this->validatorCreate($data)->validate();

        $user = $this->model->create([
            'name' => $data['name']
        ]);

        return ['status' => 'Право добавлено'];

    }

    public function update($request, $permission) {
        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $this->validatorUpdate($data, $permission)->validate();

        $permission->fill($data)->update();

        return ['status' => 'Право изменено'];

    }

    public function delete($permission) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $permission->roles()->detach();

        $t_name = $permission->name;

        if($permission->delete()) {
            return ['status' => 'Право ' . $t_name . ' удалено'];
        }
    }

    protected function validatorCreate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:permissions'
        ]);
    }

    protected function validatorUpdate(array $data, Permission $permission)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id
        ]);
    }
	
}

?>