<?php

namespace ExmentOauth\MicrosoftGraph;

use Exceedone\Exment\Auth\ProviderAvatar;
use SocialiteProviders\Graph\Provider;

class MicrosoftGraphProvider extends Provider implements ProviderAvatar
{
    /**
     * Get avatar stream
     * @param mixed $token
     * @return string
     */
    public function getAvatar($token = null){
        try
        {
            $client = $this->getHttpClient();
            $response = $client->get('https://graph.microsoft.com/v1.0/me/photo/$value', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json;odata.metadata=minimal;odata.streaming=true'
                ],
                'http_errors' => false,
            ]);

            if($response->getStatusCode() == 404){
                return null;
            }

            return $response->getBody()->getContents();

        }
        catch (\Exception $exception)
        {
            return null;
        }
        return null;
    }

    /**
     * Return the logout endpoint with an optional post_logout_redirect_uri query parameter.
     * ( Copy from socialiteproviders/microsoft/Provider.php )
     *
     * @param  string|null  $redirectUri  The URI to redirect to after logout, if provided.
     *                                    If not provided, no post_logout_redirect_uri parameter will be included.
     * @return string The logout endpoint URL.
     */
    public function getLogoutUrl(?string $redirectUri = null)
    {
        $logoutUrl = sprintf('https://login.microsoftonline.com/%s/oauth2/logout', $this->getConfig('tenant', 'common'));

        return $redirectUri === null ?
            $logoutUrl :
            $logoutUrl.'?'.http_build_query(['post_logout_redirect_uri' => $redirectUri], '', '&', $this->encodingType);
    }
}