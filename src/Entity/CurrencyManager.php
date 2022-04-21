<?php
namespace App\Entity;
class CurrencyManager
{
    
    function __construct($apiKey)
    {
        $this->apiKey=$apiKey;
		$this->exchangeRates=null;
		$this->success=null;
		$this->timestamp=null;
		$this->base=null;
		$this->dataDate=null;
		$this->rates=null;
		
    }

    public function Convert($value, $code1, $code2):array
    {
		return array(
		'value'=>$value, 
		'code1'=>$code1,
		'code2'=>$code2, 
		'result'=>round($this->rates[$code2]/$this->rates[$code1]*$value,4,PHP_ROUND_HALF_UP),
		'date'=>$this->dataDate
		);
	}
    

    public function UpdateLatest():void
    {
        // Initialize CURL:
		$this->ch = curl_init('http://api.exchangeratesapi.io/v1/'.'latest'.'?access_key='.$this->apiKey);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		// Store the data:
		$this->json = curl_exec($this->ch);
		curl_close($this->ch);
		// Decode JSON response:
		$this->exchangeRates=json_decode($this->json, true);
		$this->success=$this->exchangeRates['success'];
		$this->timestamp=$this->exchangeRates['timestamp'];
		$this->base=$this->exchangeRates['base'];
		$this->dataDate=$this->exchangeRates['date'];
		$this->rates=$this->exchangeRates['rates'];

    }

	public function getSymbols():array
	{
		// Initialize CURL:
		$this->ch = curl_init('http://api.exchangeratesapi.io/v1/'.'symbols'.'?access_key='.$this->apiKey);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		// Store the data:
		$this->json = curl_exec($this->ch);
		curl_close($this->ch);
		// Decode JSON response:
		$this->exchangeRates=json_decode($this->json, true);
		$this->success=$this->exchangeRates['success'];
		$this->symbols=$this->exchangeRates['symbols'];
		return ['success'=>$this->success, 'symbols'=>$this->symbols];
	}

	public function UpdatePast($date):void
	{
		// Initialize CURL:
		$this->ch = curl_init('http://api.exchangeratesapi.io/v1/'.$date.'?access_key='.$this->apiKey);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		// Store the data:
		$this->json = curl_exec($this->ch);
		curl_close($this->ch);
		// Decode JSON response:
		$this->exchangeRates=json_decode($this->json, true);
		$this->success=$this->exchangeRates['success'];
		$this->timestamp=$this->exchangeRates['timestamp'];
		$this->base=$this->exchangeRates['base'];
		$this->dataDate=$this->exchangeRates['date'];
		$this->rates=$this->exchangeRates['rates'];
	}

	public function CompareCurrency($date1, $date2,$code1, $code2):array
	{
        $this->UpdatePast($date1);
		$result1=($this->Convert(1, $code1, $code2))['result'];
		$result1=round($result1, 4 , PHP_ROUND_HALF_UP);
		$this->UpdatePast($date2);
		$result2=($this->Convert(1,$code1,$code2))['result'];
		$result2=round($result2, 4 , PHP_ROUND_HALF_UP);
        $percent=($result2-$result1)/$result2*100;
		$percent=round($percent, 4 , PHP_ROUND_HALF_UP);
		if($percent>0){$isGrowing=1;}
		elseif($percent<0){$isGrowing=2;}
		else{$isGrowing=null;};
		return [
				'date1'=>$date1,
				'date2'=>$date2, 
				'code1'=>$code1,
				'code2'=>$code2,
				'result1'=>$result1,
				'result2'=>$result2,
				'percent'=>$percent,
				'isGrowing'=>$isGrowing
		];
	}

	

}