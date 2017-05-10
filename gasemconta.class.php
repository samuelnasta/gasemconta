<?php
class GasEmConta {

	const DB_NAME = 'gasemconta';
	const DB_HOST = 'localhost';
	const DB_USER = 'root';
	const DB_PASSWORD = 'root';
	public $db;

	# Create the PDO database object
    public function __construct() {
		try {
			$this->db = new PDO('mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_HOST, self::DB_USER, self::DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} catch (PDOException $e) {
			file_put_contents('PDOErrors.txt', date('d-m-Y H:i:s') . ' - ' . $e->getMessage() . "\r\n", FILE_APPEND);
		}
    }


	# Authenticate user thru Facebook and keep the records
	public function addUser($name, $email) {
		$data = array(':name' => $name, ':email' => $email);
		$this->db
			->prepare("INSERT INTO users (name, email)
				VALUES (:name, :email)")
			->execute($data);
	}


	# Create a marker for a new Gas Station
	public function createGasStation($user_id){
		$data = array(':created_at' => date('Y-m-d H:i:s'), ':name' => $_POST['name'], ':address' => $_POST['address'], ':city' => $_POST['city'], ':province' => $_POST['province'], ':geolat' => $_POST['geolat'], ':geolng' => $_POST['geolng']);
		$this->db
			->prepare("INSERT INTO stations (created_at, name, address, city, province, geolat, geolng)
				VALUES (:created_at, :name, :address, :city, :province, :geolat, :geolng)")
			->execute($data);

		# Set the fuel prices too
		$data = array(':gas_price' => $_POST['gas-price'], ':etanol_price' => $_POST['etanol-price'], ':station_id' => $this->db->lastInsertId(), ':user_id' => $user_id);
		$this->db
			->prepare("INSERT INTO prices (price, fuel, station_id, user_id)
				VALUES (:gas_price, 'gas', :station_id, :user_id);
				INSERT INTO prices (price, fuel, station_id, user_id)
				VALUES (:etanol_price, 'etanol', :station_id, :user_id)")
			->execute($data);
	}

/*
UPDATE prices SET price = CASE
				WHEN fuel = 'gas' THEN :gas-price
				WHEN fuel = 'etanol' THEN :etanol-price END
				WHERE station_id = :station_id
*/


	# Update Gas Station name and address
	public function updateGasStation(){
		$data = array(':name' => $_POST['name'], ':address' => $_POST['address'], ':city' => $_POST['city'], ':province' => $_POST['province'], ':station_id' => $_POST['station_id']);
		$this->db
			->prepare("UPDATE stations
				SET name = :name, address = :address, city = :city, province = :province
				WHERE id = :station_id")
			->execute($data);
	}


	# Update gas and ethanol prices for specific gas station
	public function updateFuelPrice($user_id){
		if($_POST['gas-price']):
			$data = array(':fuel' => 'gas', ':price' => $_POST['price'], ':station_id' => $_POST['station_id'], ':user_id' => $user_id);
			$this->db
				->prepare("UPDATE prices
					SET price = :price, user_id = :user_id
					WHERE station_id = :station_id AND fuel = :fuel")
				->execute($data);
		elseif($_POST['gas-price']):
			
		endif;
	}


	# Create a marker for a new Gas Station
	public function findBestPrice($station_id, $user_id){
		$data = array(':fuel' => $_POST['fuel'], ':price' => $_POST['price'], ':station_id' => $_POST['station_id'], ':user_id' => $_POST['user_id']);
		$this->db
			->prepare("UPDATE prices
				SET price = :price, user_id = :user_id
				WHERE station_id = :station_id AND fuel = :fuel")
			->execute($data);
	}

}

?>