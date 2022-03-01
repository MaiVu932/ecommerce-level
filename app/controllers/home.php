<?php
class Home extends Controller {
    public function index() {
        echo 'hihi';
    }
    public function login() {
        $this->view('admin/t');
    }

}