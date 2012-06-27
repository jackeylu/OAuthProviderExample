<?php

	require_once(dirname(__FILE__)."/../interfaces/IConsumer.php");
	
	/* this class is just for the example purpose
	 * It's badly written but it's just for POC 
	 *
	 * 很多代码安全性、异常处理都没有考虑，这仅仅是
	 * 一个原型
	 *
	 * 从安全性角度考虑，数据库存储方面要注意防止sql injection，
	 * 可以考虑ORM方式提高数据库安全性
	 *
	 * 从性能角度考虑，可以将consumer/token等信息放在缓存中
	 *
	 * 从开发接口的友善角度考虑，应该定义一些有意义的
	 * error code,然后从HTTP可以传输的形式将接口返回值
	 * 告诉第三方开发者，便于调试。
	 *
	 * 再从安全角度和运营考虑，可以借鉴主流的方式，进行
	 * API rate控制
	 */
	class Consumer implements IConsumer{
		
		private $id;
		private $key;
		private $secret;
		private $active;
		private $pdo;
		
		public static function findByKey($key){
			$consumer = null;
			$pdo = Db::singleton();
			$info = $pdo->query("select id from consumer where consumer_key = '".$key."'"); // this is not safe !
			if($info->rowCount()==1){
				$info = $info->fetch();
				$consumer = new Consumer($info['id']);
			}
			return $consumer;
		}
		
		public function __construct($id = 0){
			$this->pdo = Db::singleton();
			if($id != 0){
				$this->id = $id;
				$this->load();
			}
		}
		
		private function load(){
			$info = $this->pdo->query("select * from consumer where id = '".$this->id."'")->fetch();
			$this->id = $this->id;
			$this->key = $info['consumer_key'];
			$this->secret = $info['consumer_secret'];
			$this->active = $info['active'];
		}
		
		public static function create($key,$secret){
			$pdo = Db::singleton();
			$pdo->exec("insert into consumer (consumer_key,consumer_secret,active) values ('".$key."','".$secret."',1)");
			$consumer = new Consumer($pdo->lastInsertId());
			return $consumer;
		}
		
		public function isActive(){
			return $this->active;
		}
		
		public function getKey(){
			return $this->key;
		}
		
		public function getSecretKey(){
			return $this->secret;
		}
		
		public function getId(){
			return $this->id;
		}
		
		/*
		 * 检查当前的consumer是否具有传入的nonce和timestamp
		 *
		 * @param $nonce
		 * @param $timestamp
		 *
		 * @return true 表示具有传入的nonce和timestamp，否则false
		 */
		public function hasNonce($nonce,$timestamp){
			$check = $this->pdo->query("select count(*) as cnt from consumer_nonce where timestamp = '".$timestamp."' and nonce = '".$nonce."' and consumer_id = ".$this->id)->fetch();
			if($check['cnt']==1){
				return true;
			} else {
				return false;
			}
		}
		
		/*
		 * 以传入的nonce值，当前timestamp以及consumer id
		 * 作为值记录到数据库中
		 *
		 * @param $nonce
		 * @return void
		 */
		public function addNonce($nonce){
			$check = $this->pdo->exec("insert into consumer_nonce (consumer_id,timestamp,nonce) values (".$this->id.",".time().",'".$nonce."')");
		}
		
		/* setters */
		
		public function setKey($key){
			$this->key = $key;
		}
		
		public function setSecret($secret){
			$this->secret = $secret;
		}
		
		public function setActive($active){
			$this->active = $active;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
	}
	
?>
