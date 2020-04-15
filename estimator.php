<?php
$reportedcases=$_POST["reportedcases"];
$timeToElapse=$_POST["timeToElapse"];
$periodType=$_POST["periodType"];
$totalHospitalBeds=$_POST["totalHospitalBeds"];
$Population=$_POST["Population"];

  
  function covid19ImpactEstimator($data)
  { 
     $Impact["currentlyinfected"]=$data['reportedCases'] * 10;
     $severeImpact["currentlyinfected"]=$data["reportedCases"] *50;
     
    $Impact["infectionsbyrequestedtime"] = $Impact['currentlyinfected'] * 1024 . 30 ;
    $severeImpact["infectionsbyrequestedtime"] = $severeImpact['currentlyinfected'] * 1024 * 30;

  $Impact["severeCasesByRequestedTime"]=$Impact["infectionsbyrequestedtime"] * 0.15;
  $severeImpact["severeCasesByRequestedTime"]=$severeImpact["infectionsbyrequestedtime"] * 0.15;
  $Impact["hospitalBedsByRequestedTime"]=intval(($data["totalHospitalBeds"]*0.35) - $Impact["severeCasesByRequestedTime"]);
  $severeImpact["hospitalBedsByRequestedTime"]=intval(($data["totalHospitalBeds"]*0.35)-$severeImpact["severeCasesByRequestedTime"]);
  $Impact["casesForICUByRequestedTime"]=$Impact["infectionsbyrequestedtime"]*0.05;
  $severeImpact["casesForICUByRequestedTime"]=$severeImpact["infectionsbyrequestedtime"]*0.05;
  $Impact["casesForVentilatorsByRequestedTime"]=intval($Impact["infectionsbyrequestedtime"]*0.02);
  $severeImpact["casesForVentilatorsByRequestedTime"]=intval($severeImpact["infectionsbyrequestedtime"]*0.02);
  $Impact["dollarsInFlight"] = ($Impact["infectionsbyrequestedtime"] * 0.65) * 1.5 * 30;
  $severeImpact["dollarsInFlight"] = ($severeImpact["infectionsbyrequestedtime"] * 0.65) * 1.5 * 30 ;

  return [
    "data"=> $data,
    "impact"=>$Impact,
    "severeImpact"=>$severeImpact];
  

}

$c = covid19ImpactEstimator([
  'region' => [
      'name'                       => 'Africa',
      'avgAge'                     => 19.7,
      'avgDailyIncomeInUSD'        => 1,
      'avgDailyIncomePopulation'   => 0.73
  ],
  'periodType'                    => $periodType,
  'timeToElapse'                  => $timeToElapse,
  'reportedCases'                 => $reportedcases,
  'population'                    => $Population,
  'totalHospitalBeds'             => $totalHospitalBeds
]);

print("<pre>".print_r($c,true)."</pre>");

?>