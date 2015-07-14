<?php

class Core_Jasper_Client {

    private $url;
    private $username;
    private $password;

    public function __construct() {
//        $this->url = REPORT_PROTOCOL.'://'.REPORT_URL.':'.REPORT_PORT.REPORT_LOCATION.'/services/repository?wsdl';
//        $this->username = REPORT_USER;
//        $this->password = REPORT_PASSWORD;
        $this->url = "http://192.168.1.35:8080/jasperserver/services/repository";  
        $this->username = "jasperadmin";  
        $this->password = "jasperadmin";  

    }

    public function requestReport($report, $format, $params) {
        $params_xml = "";
        foreach ($params as $name => $value) {
            $params_xml .= "<parameter name=\"$name\"><![CDATA[$value]]></parameter>\n";
        }
        $request = "
                    <request operationName=\"runReport\" locale=\"en\">
                    <argument name=\"RUN_OUTPUT_FORMAT\">$format</argument>
                    <resourceDescriptor name=\"\" wsType=\"\"
                    uriString=\"$report\"
                    isNew=\"false\">
                    <label>null</label>
                    $params_xml
                    </resourceDescriptor>
                    </request>
                    ";
        $client = new SoapClient(null, array(
            'location' => $this->url,
            'uri' => 'urn:',
            'login' => $this->username,
            'password' => $this->password,
            'trace' => 1,
            'exception' => 1,
            'soap_version' => SOAP_1_1,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'style' => SOAP_RPC,
            'use' => SOAP_LITERAL
        ));

        $pdf = null;
        try {
            $result = $client->__soapCall('runReport', array(
                new SoapParam($request, "requestXmlString")
            ));
            $pdf = $this->parseReponseWithReportData(
                    $client->__getLastResponseHeaders(), $client->__getLastResponse());
        } catch (SoapFault $exception) {
            $responseHeaders = $client->__getLastResponseHeaders();
            if ($exception->faultstring == "looks like we got no XML document" &&
                    strpos($responseHeaders, "Content-Type: multipart/related;") !== false) {
                $pdf = $this->parseReponseWithReportData($responseHeaders, $client->__getLastResponse());
            } else {
                throw $exception;
            }
        }
        if ($pdf)
            return $pdf;
        else
            throw new Exception("Jasper did not return PDF data. Instead got: \n$pdf");
    }

    protected function parseReponseWithReportData($responseHeaders, $responseBody) {
        preg_match('/boundary="(.*?)"/', $responseHeaders, $matches);
        $boundary = $matches[1];
        $parts = explode($boundary, $responseBody);
        $pdf = null;
        foreach ($parts as $part) {
            if (strpos($part, "Content-Type: application/pdf") !== false) {
                $pdf = substr($part, strpos($part, '%PDF-'));
                break;
            }
        }
        return $pdf;
    }

}
