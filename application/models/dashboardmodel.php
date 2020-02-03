<?php

class dashboardmodel
{
	private $__config;
    private $__router;
    private $__db;
	private $__params;
	
	private $od;
	private $do;
	
	public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
	}

	private function getBtwData() {

        $dataWarfor = $this->__db->execute("SELECT 
        warfor.btw,
        details.quantity,
        details.price
        FROM bouw_factur_details AS details 
		INNER JOIN bouw_waarvoor AS warfor ON details.waarvoor_id = warfor.id
		INNER JOIN bouw_factur AS factur ON details.factur_nr = factur.factur_numer
		WHERE factur.data BETWEEN '".$this->od."' AND '".$this->do."'
		ORDER BY warfor.btw
		");

        $y = array();
        foreach($dataWarfor as $q){
            array_push($y, $q);

        }

        return $y;

    }
	
    private function getbtw() {

        $warfor = $this->getBtwData();
        $x = Array();
        foreach($warfor as $row){
			
            $z = $row['quantity'] * $row['price'];
            if(!in_array($row['btw'], $x))
            $x += array($row['btw'] => 0) ;
			
            foreach($x as $rows=>$val){
				

                if($rows == $row['btw']){
                    $x[$rows] += $z * ((int)$rows * 0.01);
                }
            }
		}
        return $x;

	}

	private function getBtwDataUitgaven() {

        $dataWarfor = $this->__db->execute("SELECT 
        warfor.btw,
        uitgaven.price
        FROM bouw_uitgaven AS uitgaven 
		INNER JOIN bouw_waarvoor AS warfor ON uitgaven.waarvoor_id = warfor.id
		WHERE uitgaven.data BETWEEN '".$this->od."' AND '".$this->do."'
		ORDER BY warfor.btw
		");

        $y = array();
        foreach($dataWarfor as $q){
            array_push($y, $q);

        }

        return $y;

    }
	
    private function getbtwUitgaven() {

        $warfor = $this->getBtwDataUitgaven();
        $x = Array();
        foreach($warfor as $row){
			
            $z = $row['price'];
            if(!in_array($row['btw'], $x))
            $x += array($row['btw'] => 0) ;
			
            foreach($x as $rows=>$val){
				

                if($rows == $row['btw']){
                    $x[$rows] += $z * ((int)$rows * 0.01);
                }
            }
		}
        return $x;

	}

	private function getAllInkomsten() {
        $dataWarfor = $this->__db->execute("SELECT 
        details.quantity,
        details.price
        FROM bouw_factur_details AS details 
		INNER JOIN bouw_factur AS factur ON details.factur_nr = factur.factur_numer
		WHERE factur.data BETWEEN '".$this->od."' AND '".$this->do."'
		");

		$y = array();
		$total = 0;
        foreach($dataWarfor as $q){
			$z = $q['quantity'] * $q['price'];
			$total += $z;
		}
		
		array_push($y, $total);
        return $y[0];
	}

	private function getAllUitgavenn() {
        $dataWarfor = $this->__db->execute("SELECT 
        uitgaven.price
        FROM bouw_uitgaven AS uitgaven 
		WHERE uitgaven.data BETWEEN '".$this->od."' AND '".$this->do."'
		");

		$y = array();
		$total = 0;
        foreach($dataWarfor as $q){
			$z = $q['price'];
			$total += $z;
		}
		
		array_push($y, $total);
        return $y[0];
	}

	private function clear() {
		if(isset($this->__params['POST']['clear'])){
			print_r($this->__params['POST']['clear']);
			$d = new DateTime(date("Y-m-d"));
			
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('first day of this month');  

			$this->od = $dOd->format('Y-m-d');
			$this->do = $d->format('Y-m-d');

			unset($this->__params['POST']['vanafStatistic']);
			unset($this->__params['POST']['totStatistic']);
			unset($_SESSION['vanafStatistic']);
			unset($_SESSION['totStatistic']);
		}
	}
	
	public function getAllStatistic() {
		if (isset($this->__params['POST']['vanafStatistic'])) {
			$this->od = $this->__params['POST']['vanafStatistic'];
			$this->do = $this->__params['POST']['totStatistic'];

			$_SESSION['vanafStatistic'] = $this->od; 
			$_SESSION['totStatistic'] = $this->do; 
		} else if(isset($_SESSION['vanafStatistic']) && $_SESSION['vanafStatistic'] != null) {
			$this->od = $_SESSION['vanafStatistic'];
            $this->do = $_SESSION['totStatistic'];
		} else {
			$d = new DateTime(date("Y-m-d"));
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('first day of this month');
			// $dOd->modify('-12 month');

			$this->od = $dOd->format('Y-m-d');
			$this->do = $d->format('Y-m-d');


			
		}

		$this->clear();
		$z = array();

		$totalBTW = 0;
		foreach($this->getbtw() as $row){
			$totalBTW += $row;
		}

		$totalBTWUitgaven = 0;
		foreach($this->getbtwUitgaven() as $row){
			$totalBTWUitgaven += $row;
		}

		array_push($z, $this->getbtw());
		array_push($z, $totalBTW);
		array_push($z, $this->getbtwUitgaven());
		array_push($z, $totalBTWUitgaven);
		array_push($z, $this->getAllInkomsten());
		array_push($z, $this->getAllUitgavenn());
		return $z;
	}


}

?>