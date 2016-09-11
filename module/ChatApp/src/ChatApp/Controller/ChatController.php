<?php

/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */

namespace ChatApp\Controller;

use Zend\View\Model\JsonModel;


class ChatController extends AbstractRestfulJsonController
{
    public function getList()
    {
        return new JsonModel(
			array(
			'success' => true,
			'data' => 
				array(
					array('id' => '4TdH2R1CS08BrqbB', 'name' => '9EC9-9D12', 'lastMessage' => 'Hello, how are you?'),
					array('id' => '535NEVW4xAq1i9AP', 'name' => '97A7-7D05', 'lastMessage' => 'Hasha...'),
					array('id' => '6E6B3F2E-DC84-4C', 'name' => 'Demo Admin', 'lastMessage' => 'Hello')
				)
			)
		);
    }


    public function get($id)
    {

        return new JsonModel(array("data" => array('id' => $this->getServiceLocator()->get("getTokenId"))));
    }

    public function create($data)
    {

        return new JsonModel(array('data' => array('id' => 2, 'Lastname' => 'Thou', 'Firstname' => 'Veasna')));
    }

    public function update($id, $data)
    {

        return new JsonModel(array('data' => array('id' => 3, 'Lastname' => 'Sao', 'Firstname' => 'Sothearak')));
    }

    public function delete($id)
    {

        return new JsonModel(array('data' => 'Staff id 3 deleted'));
    }
}