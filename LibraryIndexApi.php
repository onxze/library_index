<?php

/**
 * Connection class to kirjastot.fi library index api.
 */
class LibraryIndexApi {

  private $urlOpenHours = 'http://api.kirjastot.fi/v2/';
  private $apiUrl;

  /**
   * Inject api url to class.
   * @param type $apiUrl
   */
  public function __construct($apiUrl) {
    if (empty($apiUrl)) {
      $this->apiUrl = $this->urlOpenHours;
    }
    else {
      $this->apiUrl = $apiUrl;
    }
  }

  /**
   * Read Library's Open Hours from kirjastot.fi api.
   * @param type $lid
   * @return type
   */
  public function getOpenHours($lid) {
    $curl = curl_init();
    curl_reset($curl);
  
    $fullURL = $this->apiUrl . 'libraries/schedules/' . $lid . '?as_weeks=1';
    curl_setopt($curl, CURLOPT_URL, $fullURL);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $headers = array(
        "Accept-Language: fi",
        "Content-Type: application/json",
    );

    array_push($headers, "Accept: application/json");

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($curl);

    //Error: something caused by
    if (curl_errno($curl)) {
      dpm('Curl error: ' . curl_error($curl), curl_errno($curl));
    }

    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    $responseAsObject = json_decode($response);

    return $responseAsObject;
  }

}
