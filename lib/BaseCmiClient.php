<?php

namespace Soluzi\CMI;

use Soluzi\CMI\Requests\ConfigRequest;

abstract class BaseCmiClient implements CmiClientInterface
{
    /**
     * @var string default base URL for CMI's API
     */
    public const DEFAULT_API_BASE = 'https://testpayment.cmi.co.ma';

    /**
     * @var array Languages supported by CMI
     */
    public const LANGUES = ['ar', 'fr', 'en'];

    /**
     * @var array all requiredOpts
     */
    protected $requireOpts;

    public function __construct(ConfigRequest $request)
    {
        $this->requireOpts = array_merge($this->getDefaultOpts(), $request->validated());
    }

    /**
     * Get default options CMI
     *
     * @return array all default options
     */
    public function getDefaultOpts(): array
    {
        return [
            'storetype' => '3D_PAY_HOSTING',
            'trantype' => 'PreAuth',
            'currency' => '504', // MAD
            'rnd' => microtime(),
            'lang' => 'fr',
            'hashAlgorithm' => 'ver3',
            'encoding' => 'UTF-8', // OPTIONAL
            'refreshtime' => '5' // OPTIONAL
        ];
    }

    /**
     * Get all requires options
     *
     * @return array all require options
     */
    public function getRequireOpts(): array
    {
        return $this->requireOpts;
    }

    /**
     * Generate Hash to make redirection to CMI page
     *
     * @return string hash
     */
    public function generateHash($storeKey = null): string
    {
        // amount|BillToCompany|BillToName|callbackUrl|clientid|currency|email|failUrl|hashAlgorithm|lang|okurl|rnd|storetype|TranType|storeKey
        /**
         * ASSIGNE STORE KEY
         */
        if ($storeKey == null) {
            $storeKey = $this->requireOpts['storekey'];
        }

        unset($this->requireOpts['storekey']); // EXCLUDE STOREKEY FROM REQUIRE OPTIONS
        $cmiParams = $this->requireOpts;
        $postParams = array_keys($cmiParams);
        natcasesort($postParams);
        $hashval = "";
        foreach ($postParams as $param) {
            $paramValue = trim($cmiParams[$param]);
            $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

            $lowerParam = strtolower($param);
            if ($lowerParam != "hash" && $lowerParam != "encoding") {
                $hashval = $hashval . $escapedParamValue . "|";
            }
        }
        $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));
        $hashval = $hashval . $escapedStoreKey;

        $calculatedHashValue = hash('sha512', $hashval);
        $hash = base64_encode(pack('H*', $calculatedHashValue));

        $this->requireOpts['Hash'] = $hash; // ASSIGN HASH

        return $hash;
    }

    public function __get($name)
    {
        return $this->requireOpts[$name];
    }

    public function __set($name, $value)
    {
        $this->requireOpts[$name] = $value;
    }
}
