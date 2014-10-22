<?php

/**
 * Connection class to kirjastot.fi library index api.
 */
class LibraryIndexApi {

  private $apiUrl;
  private $httpStatus;
  private $code;
  private $errorMessage;

  const LIA_NO_ERROR = 0;
  const NO_API_URL = 1;
  const LIA_CURL_FAIL = 2;
  const LIA_NOT_200 = 3;

  /**
   * Inject api url to class.
   * @param type $apiUrl
   */
  public function __construct($apiUrl) {
    $this->apiUrl = $apiUrl;
  }

  /**
   * Read Library's Open Hours from kirjastot.fi api.
   * @param type $lid Library id at kirjastot.fi
   * @param type $firstDate start date of open hours.
   * @return type returned response or NULL
   */
  public function getOpenHours($lid, $firstDate = NULL) {
    $date = '';
    $cacheKey = 'field-li-' . $lid;

    if (!empty($firstDate)) {
      $lastDate = $firstDate + (6 * 24 * 60 * 60);
      $strFirstDate = date('Y-m-d', $firstDate);
      $strLastDate = date('Y-m-d', $lastDate);
      $date = '&date>=' . $strFirstDate .
              '&date<=' . $strLastDate;
      $cacheKey .= '-' . $strFirstDate . '-' . $strLastDate;
    }
    else {
      $cacheKey .= '-' . date('W', time());
    }

    $cacheData = cache_get($cacheKey, 'cache_field');
    $cacheTimeout = variable_get('library_index_cache_timeout', 0) * 3600;
    if ($cacheTimeout > 0) {
      if (isset($cacheData->created) && time() > $cacheData->created + $cacheTimeout) {
        $cacheData = NULL;
      }
    }
    if (isset($cacheData->data)) {
      $responseAsObject = $cacheData->data;
    }
    else {
      $query = 'libraries/schedules/' . $lid . '?as_weeks=1' . $date;
      $responseAsObject = $this->queryData($query);
      cache_set($cacheKey, $responseAsObject, 'cache_field', CACHE_TEMPORARY);
    }
    return $responseAsObject;
  }

  /**
   * Get list libraries in consortium.
   * @param type $consortiun consortium which data is asked
   * @return type returned response or NULL
   */
  public function getLibraryList($consortium) {
    $cacheKey = 'field-li-' . $consortium;
    $cacheData = cache_get($cacheKey, 'cache_field');
    if (isset($cacheData->data)) {
      $responseAsObject = $cacheData->data;
    }
    else {
      $query = 'search/libraries?consortium=' . $consortium;
      $responseAsObject = $this->queryData($query);
      cache_set($cacheKey, $responseAsObject, 'cache_field', CACHE_TEMPORARY);
    }
    return $responseAsObject;
  }

  /**
   * Return last query http result code
   * @return int HTTP status
   */
  public function getHttpStatus() {
    return $this->httpStatus;
  }

  /**
   * Return last query error code
   * @return int error code
   */
  public function getErrorCode() {
    return $this->code;
  }

  /**
   * Returnn last query error message
   * @return string error message
   */
  public function getErrorMessage() {
    return $this->errorMessage;
  }

  /**
   * Set error code and message.
   * @param int $code error code
   * @param string $errorMessage error message
   */
  private function setError($code, $errorMessage) {
    $this->code = $code;
    $this->errorMessage = $errorMessage;
  }

  /**
   * Clear last query errors.
   */
  private function clearError() {
    $this->code = 'LIA_NO_ERROR';
    $this->errorMessage = NULL;
  }

  /**
   * Ask data from kirjastot.fi Library directory
   * @param type $query query to kirjastot.fi Library directory api
   * @return type returned response or NULL
   */
  private function queryData($query) {
    $this->clearError();
    if (empty($this->apiUrl)) {
      $this->setError('LIA_NO_API_URL', t('No Api URL'));
      return NULL;
    }
    $fullURL = $this->apiUrl . $query;
    $this->httpStatus = 0;

    $curl = curl_init();
    curl_reset($curl);

    curl_setopt($curl, CURLOPT_URL, $fullURL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $headers = array(
        "Accept-Language: fi",
        "Content-Type: application/json",
    );

    array_push($headers, "Accept: application/json");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
      $this->setError('LIA_CURL_FAIL', t('Curl error') . ': ' . curl_error($curl), curl_errno($curl));
      return NULL;
    }

    $this->httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($this->httpStatus != 200) {
      $this->setError('LIA_NOT_200', t('HTTP status not 200'));
      return NULL;
    }

    $responseAsObject = json_decode($response);

    return $responseAsObject;
  }

}
