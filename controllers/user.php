<?php
namespace Controllers;

use Libs;

/**
*
*/
class User extends \Libs\Controller
{


	public function __construct()
	{
		parent::__construct();
		\Util\Auth::handLeLoggin();
		\Util\Permission::check();
	}

	public function index()	{
		$this->view->userList = $this->model->userList();
		$this->view->render('user');
	}

	public function create() {

		$user = carregar_variavel('user');
		$user['password'] = \Libs\Hash::create('sha256', $user['password'], HASH_PASSWORD_KEY);
		$user += [
			'role' => 'default',
		];

		$this->model->create('user', $user);
		header('location: ' . URL . 'user');
	}

	public function edit($id)
	{
		// Fetch user individualmente
		$this->view->user = $this->model->userSingleList($id);

		$this->view->sub_render('user', 'edit');

	}

	public function editSave($id)
	{
		$data = array(
			'userid' => $id,
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'role' => $_POST['role']
		);

		// @TODO: Faça seu error checking!



		$this->model->editSave($data);


		header('location: ' . URL . 'user');
	}

	public function delete($id)
	{
		$this->model->delete($id);
		header('location: ' . URL . 'user');


	}


}