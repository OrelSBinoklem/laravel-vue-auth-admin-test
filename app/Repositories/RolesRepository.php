<?php

namespace App\Repositories;

use App\Role;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class RolesRepository extends VueTableRepository {
	
	public function __construct(Role $role) {
		$this->model = $role;
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
            'name' => $data['name'],
            'immunity' => $data['immunity'],
        ]);

        return ['status' => 'Роль добавлена'];

    }

    public function update($request, $role) {
        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $this->validatorUpdate($data, $role)->validate();

        $role->fill($data)->update();

        return ['status' => 'Роль изменена'];

    }

    public function delete($role) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $t_name = $role->name;

        if($role->delete()) {
            return ['status' => 'Роль ' . $t_name . ' удалена'];
        }
    }

    protected function validatorCreate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:roles',
            'immunity' => 'required|integer|between:0,100'
        ]);
    }

    protected function validatorUpdate(array $data, Role $role)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'immunity' => 'required|integer|between:0,100'
        ]);
    }
}

?>