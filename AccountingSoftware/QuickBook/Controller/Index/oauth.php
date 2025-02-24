<?php

namespace AccountingSoftware\QuickBook\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use QuickBooksOnline\API\DataService\DataService;

class oauth extends Action
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
        $redirectUri = "http://localhost/quickbooks/oauth/callback";

        $dataService = DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => $clientId,
            'ClientSecret' => $clientSecret,
            'RedirectURI' => $redirectUri,
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl' => 'Development'
        ]);

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authorizationUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        $this->_redirect($authorizationUrl);
    }
}
