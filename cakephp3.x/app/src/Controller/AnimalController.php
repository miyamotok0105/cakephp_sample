<?php

	namespace App\Controller;

	class AnimalController extends AppController
	{
		public function index(){

    }

		public function reg(){
			$animal_name = $this->request->data['animal_name'];
			$this->set(array(
					'animal_name'=>$animal_name
			));
		}
	}