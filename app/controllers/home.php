<?php
class Home extends Controller {
    public function index() {
        $this->view('index');
    }
    public function login() {
        $this->view('admin/t');
    }

}