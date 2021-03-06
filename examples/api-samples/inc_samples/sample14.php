<?php
    //### This sample will show how to check the list of shares for a folder using PHP SDK
     
    //### Set variables and get POST data
    F3::set('userId', '');
    F3::set('privateKey', '');
    F3::set('path', '');

    $clientId = F3::get('POST["client_id"]');
    $privateKey = F3::get('POST["private_key"]');
    $path = F3::get('POST["path"]');

    function ListOfShares($clientId, $privateKey, $path) {

        if (empty($clientId) || empty($privateKey) || empty($path)) {
            throw new Exception('Please enter all required parameters');
        } else {
            //Get base path
            $basePath = f3::get('POST["server_type"]');
            F3::set('userId', $clientId);
            F3::set('privateKey', $privateKey);
            F3::set('path', $path);

            // parse input path
            $newPath = "";
            $array = explode("/", $path);
            if (count($array) > 1) {
                $lastFolder = array_pop($array);
                $newPath = implode("/", $array);
            } else{
                $lastFolder = array_pop($array);
            }

            // initialization some variables
            $folderId = null;
            $users = "";

            //### Create Signer, ApiClient, StorageApi and Document Api objects
            // Create signer object
            $signer = new GroupDocsRequestSigner($privateKey);

            // Create apiClient object
            $apiClient = new ApiClient($signer);

            // Create Storage object
            $storage = new StorageApi($apiClient);

            // Create Document object
            $doc = new DocApi($apiClient);
            if ($basePath == "") {
                //If base base is empty seting base path to prod server
                $basePath = 'https://api.groupdocs.com/v2.0';
            }
            //Set base path
            $storage->setBasePath($basePath);
            $doc->setBasePath($basePath);
            // get folder ID
            $list = $storage->ListEntities($clientId, $newPath);
            if ($list->status == "Ok") {
                
                foreach ($list->result->folders as $folder) {
                   
                    if ($folder->name == $lastFolder) {
                        $folderId = $folder->id;
                        break;
                    }
                }
            }

            //### Get list of shares
            if ( !is_null($folderId)) {
                // Make a request to Document API
                $shares = $doc->GetFolderSharers($clientId, $folderId);
                if ($shares->status == "Ok" and count($shares->result->shared_users)) {
                    foreach ($shares->result->shared_users as $k => $user) {
                        $users .= $user->primary_email;
                        $users .= $user->nickname;
                        $users .= (count($shares->result->shared_users) == $k+1) ? '' : ', ';
                    }
                }
            }

            F3::set('users', $users);
        }
    }

    try {
        ListOfShares($clientId, $privateKey, $path);
    } catch (Exception $e) {
        $error = 'ERROR: ' .  $e->getMessage() . "\n";
        f3::set('error', $error);
    }

    // Process template
    echo Template::serve('sample14.htm');