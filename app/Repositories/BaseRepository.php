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

	/**
	 * __construct
	 */
	public function __construct()
	{
	}

	/**
	 * __destruct
	 */
	public function __destruct()
	{
		if ($this->_connection) {
			$this->_connection->close();
		}
	}

	/**
	 * connect: kết nối với phpmysql
	 *
	 * @return void
	 */
	public function connect()
	{
		$this->_connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
	}

	/**
	 * insert: thêm dữ liệu vào cơ sở dữ liệu
	 *
	 * @param [type] $table
	 * @param [type] $data
	 * @return void
	 */
	public function insert($table, $data, $insert_id = false)
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
		if ($insert_id) {
			$this->_connection->query($sql);
			return $this->_connection->insert_id;
		} else
			return $this->_connection->query($sql);
	}

	/**
	 * update: cập nhật dữ liệu vào cơ sở dữ liệu
	 *
	 * @param [type] $table
	 * @param [type] $data
	 * @param [type] $where
	 * @return void
	 */
	public function update($table, $data, $where)
	{
		$this->connect();

		$field_list = '';
		foreach ($data as $key => $value) {
			// $field_list .= ', ' . $key;
			// $value_list .= ', "' . $this->_connection->real_escape_string($value) . '"';;
			$field_list .= "$key = '" . $this->_connection->real_escape_string($value) . "', ";
		}
		$field_list = trim($field_list, ', ');
		$sql = "UPDATE $table SET $field_list WHERE $where ;";
		return $this->_connection->query($sql);
	}

	/**
	 * delete: xóa dữ liệu trong cơ sở dữ liệu
	 *
	 * @param [type] $table
	 * @param [type] $where
	 * @return void
	 */
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

	/**
	 * get_data: lấy dữ liệu từ cơ sở dữ liệu
	 *
	 * @param [type] $sql
	 * @return array
	 */
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
