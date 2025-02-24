<?php

namespace AccountingSoftware\QuickBook\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;

class generateInvoice extends Action
{
    protected $scopeConfig;

    public function __construct(Context $context, ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        $clientId = "client_id";
        $clientSecret = "client_secret";

        $realmId = "realmId";
        $accessToken = "access_token";
        $refreshToken = "refresh_token";

        $dataService = DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => $clientId,
            'ClientSecret' => $clientSecret,
            'accessTokenKey' => $accessToken,
            'refreshTokenKey' => $refreshToken,
            'QBORealmID' => $realmId,
            'baseUrl' => 'Development'
        ]);

        $dataService->throwExceptionOnError(true);

        //Add a new Invoice
        $invoiceToCreate = Invoice::create([
            "DocNumber" => "101",
            "Line" => [
                [
                    "Description" => "Sewing Service for Jimmy in Canada",
                    "Amount" => 150.00,
                    "DetailType" => "SalesItemLineDetail",
                    "SalesItemLineDetail" => [
                        "ItemRef" => [
                            "value" => 1,
                            "name" => "Services"
                        ],
                        "TaxCodeRef" => [
                            "value" => "NON"
                        ]
                    ]
                ]
            ],
            "CustomerRef" => [
                "value" => "2",
                "name" => "Jimmy"
            ]
        ]);

        $resultObj = $dataService->Add($invoiceToCreate);
        $error = $dataService->getLastError();
        if ($error) {
            echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
            echo "The Response message is: " . $error->getResponseBody() . "\n";
        } else {
            echo "Created Id={$resultObj->Id}. Reconstructed response body:\n\n";
            $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultObj, $urlResource);
            echo $xmlBody . "\n";
        }
    }
}
