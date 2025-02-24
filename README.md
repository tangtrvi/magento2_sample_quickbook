Required: 
- composer require quickbooks/v3-php-sdk

Library Document: https://intuit.github.io/QuickBooks-V3-PHP-SDK/authorization.html#generate-oauth-2-0-tokens

To Get $clientId and $clientSecret: https://developer.intuit.com/app/developer/qbo/docs/get-started/get-client-id-and-client-secret

$redirectUri is the endpoint used for QuickBooks redirect after authorization. The @realmId and $code will be sent in the parameters.

Use $realmId and $code to receive $accessToken and $refreshToken. Then, use this information to sync data to QuickBooks via QuickBooksOnline\API\DataService\DataService or RestAPI.
