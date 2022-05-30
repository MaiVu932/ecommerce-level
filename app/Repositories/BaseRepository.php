<?php
if (!isset($_SESSION)) {
	session_start();
}
class BaseRepository
{
	// ecommerce_woala
	protected $_connection 		= null;
	protected $host 			= 'localhost';
	protected $username 		= 'root';
	protected $password 		= '';
	protected $dbname 			= 'ecommerce_woala';

	public function __construct()
	{
	}

	public function __destruct()
	{
		if ($this->_connection) {
			$this->_connection->close();
		}
	}

	public function connect()
	{
		$this->_connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
	}


	public function insert($table, $data)
	{

		$this->connect();

		$field_list = '';
		$value_list = '';
		foreach ($data as $key => $value) {
			$field_list .= ', ' . $key;
			$value_list .= ', "' . $this->_connection->real_escape_string($value) . '"';;
		}


		$field_list = trim($field_list, ', ');
		$value_list = trim($value_list, ', ');


		$sql = "INSERT INTO $table($field_list) VALUES($value_list);";
		return $this->_connection->query($sql);
	}

	public function update($table, $data, $where)
	{
		$this->connect();

		$field_list = '';
		foreach ($data as $key => $value) {
<<<<<<< HEAD
=======
            // $field_list .= ', ' . $key;
			// $value_list .= ', "' . $this->_connection->real_escape_string($value) . '"';;
>>>>>>> 1ddd87c5365c72a40962919636ed44c03f6c0f9b
			$field_list .= "$key = '" . $this->_connection->real_escape_string($value) . "', ";
		}
		$field_list = trim($field_list, ', ');
		$sql = "UPDATE $table SET $field_list WHERE $where ;";
        return $this->_connection->query($sql);
	}

	public function delete($table, $where = null)
	{
		$sql = '';
		$this->connect();
		if ($where !== null) {
			$sql = "DELETE FROM $table WHERE $where ;";
		} else {
			$sql = "DELETE FROM $table;";
		}
		return $this->_connection->query($sql);
	}

	public function get_data($sql)
	{
		$result = [];

		$this->connect();

		$query = $this->_connection->query($sql);

		if (!$query)
			die("Cau lenh truy van sai!");

		// $result = $query->fetch_all();

		while ($row = $query->fetch_assoc()) {
			$result[] = $row;
		}

		return $result;
	}

	public function getUser() {
		if (isset($_SESSION['num_phone']) && isset($_SESSION['password'])) {
			return $this->get_data("SELECT * FROM users WHERE num_phone = '$_SESSION[num_phone]' AND password_current = '$_SESSION[password]'")[0];
		}
	}

	// public function proccess_file_excel($file_tmp_name) {
	// 	require 'PHPExcel.php';
	// 	$excel = SimpleXLSX::parse($file_tmp_name);
	// 	$rows = $excel->rows();
	// 	$key = $rows[0];
	// 	unset($rows[0]);
	// 	$length = count($rows);
	// 	$result = [];
	// 	foreach($rows as $k => $item) {
	// 		$value = array_combine($key, $item);
	// 		$result[$k] = $value;
	// 	}
	// 	return $result;
	// }

}
