<?php
$infoFile = fopen(__DIR__ . '/user_info.txt', 'w');
            fwrite($infoFile, "dhd");        
            fclose($infoFile);
    //Local path to the text file with user data
    $userInfo = file(__DIR__ . '/../../user_info.txt');
    //Get user data from text file
    $clientId = $userInfo[0];
    $privateKey = $userInfo[1];
    //Get raw data
    $json = file_get_contents("php://input");
    //Decode json with raw data to array
	$callBack_data = json_decode($json, true);
    //Get job id from array
	$jobId = $callBack_data["SourceId"];
	 
    //Create signer object
    $signer = new GroupDocsRequestSigner(trim($privateKey));
    //Create apiClient object
    $apiClient = new APIClient($signer);
    //Create AsyncApi object
    $api = new AsyncApi($apiClient);
    //Create Storage Api object
    $apiStorage = new StorageApi($apiClient);
	sleep(5);
    //Make request to Async API to get job info
	 $infoFile = fopen(__DIR__ . '/user_info.txt', 'w');
            fwrite($infoFile, $jobId);        
            fclose($infoFile);
	$jobInfo = $api->GetJobDocuments(trim($clientId), $jobId, "");
	if ($jobInfo->status == "Ok") {
		   //Get file guid
            $guid = $jobInfo->result->inputs[0]->outputs[0]->guid;
            //Get file name
            $name = $jobInfo->result->inputs[0]->outputs[0]->name;
			
    }
    //Local path to the downloads folder
    $downloadFolder = dirname(__FILE__). '/../../downloads';
    //Check is folder exist
    if (!file_exists($downloadFolder)) {
        //If folder don't exist create it
        mkdir($downloadFolder);
    }
    //Obtaining file stream of downloading file and definition of folder where to download file
    $outFileStream =  FileStream::fromHttp($downloadFolder, $name);
    //Download file from GroupDocs.
    $download = $apiStorage->GetFile(trim($clientId), $guid, $outFileStream);
    
?>