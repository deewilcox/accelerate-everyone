<?php 

namespace AccelerateEveryone;

class Member {

    protected $skd;
    protected $dynamoDB;
    protected $marshaller;
    protected $s3;

    public function __construct() {
        $sdk = $this->sdk;
        $dynamoDB = $sdk->createDynamoDb();
        $s3 = $sdk->createS3Client();
        $marshaller = new Marshaler();
    }

    public function validateForm ($requiredParams = array(), $paramArray = array()) {
        $errors = array();

        foreach ($paramArray as $param) { 
            if (!in_array($param, $requiredParams)) {
                $errors[] = $param . ' is a required field.';
            }
        }

        return $errors;
    }

    public function getMarshallJson ($data = array()) {
        $json = json_encode($data);
        $marshalledJson = $marshaller->marshalJson($json);
        
        return $marshalledJson;
    }
}