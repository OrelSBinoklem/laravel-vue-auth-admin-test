<?php

namespace App\Repositories;

use App\Role;

class RolesRepository extends VueTableRepository {
	
	public function __construct(Role $role) {
		$this->model = $role;
	}

    public function add($request) {


        if (Gate::denies('create',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $user = $this->model->create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if($user) {
            $user->roles()->attach($data['role_id']);
        }

        return ['status' => 'Пользователь добавлен'];

    }


    public function update($request, $user) {
        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $data = $request->all();

        $this->validatorUpdate($data)->validate();

        if(isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->fill($data)->update();
        $user->roles()->sync([$data['role_id']]);

        return ['status' => 'Пользователь изменен'];

    }

    public function delete($user) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }

        $t_name = $user->name;

        $user->oauthProviders()->delete();

        $user->roles()->detach();

        if($user->delete()) {
            return ['status' => 'Пользователь ' . $t_name . ' удален'];
        }
    }
}

?>