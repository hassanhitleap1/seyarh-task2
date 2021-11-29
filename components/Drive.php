<?php
namespace  app\components;
use yii\base\BaseObject;

class Drive extends BaseObject
{

    public function getClient() {
        $client = new \Google_Client();
        $client->setApplicationName('hassan');
        $client->setRedirectUri('http://localhost:8080');
        $client->setScopes(\Google_Service_Drive::DRIVE);
        $client->setAuthConfig('client_secret.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        return $client;
    }

    public  function get_client()
    {
        $client = $this->getClient();

        $tokenPath = 'token.json';

        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    public function listSOFolder($service) {
        $folderID = $this->getSOFolderByName($service);
        if ($folderID)
            $this->printFilesInFolder($service, $folderID);
    }
    public function getSOFolderByName($service) {
        $search = "title='stackoverflow' AND mimeType = 'application/vnd.google-apps.folder' AND trashed != true";
        $parameters = array("q" => $search);
        $files = $service->files->listFiles($parameters);
        if (!empty($files["items"])) {
            $folderID = $files["items"][0]->getId(); // the first element
            return $folderID;
        } else
            return false;
    }

    public function printFilesInFolder($service, $folderId) {
        $pageToken = NULL;

        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $children = $service->children->listChildren($folderId, $parameters);

                foreach ($children->getItems() as $child) {
                    print 'File Id: ' . $child->getId();
                }
                $pageToken = $children->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);
    }

}