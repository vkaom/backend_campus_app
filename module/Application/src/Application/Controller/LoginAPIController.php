<?php

/* * ***************************************************************************
 * Copyright (C) 2015 {KAOM Vibolrith} <{vibolrith@gmail.com}>
 * 
 * This file is part of CAMEMIS Learning.
 * 
 * {CAMEMIS Learning} can not be copied and/or distributed without the express
 * permission of {KAOM Vibolrith, Vikensoft Germany}
 * ************************************************************************** */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
//use Course\Model\Course;
//use Application\Model\UserJournal;

class LoginAPIController extends AbstractRestfulController {

    public function getList() {
        
        error_log("Ich in hier...");
        
//        $JOURNAL_ACCESS = new UserJournal($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
//        $parentId = isset($_GET["parentId"]) ? $_GET["parentId"] : "";
//        $searchKey = isset($_GET["key"]) ? $_GET["key"] : "";
//        $target = isset($_GET["target"]) ? $_GET["target"] : "";
//        $strSearch = isset($_GET["strSearch"]) ? $_GET["strSearch"] : "";
//
//        $facette = new Course($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
//
//        if ($parentId) {
//            switch ($searchKey) {
//                case "SECTION":
//                    return new JsonModel($facette->getCourseCurriculums($parentId, true));
//                case "LECTURE":
//                    return new JsonModel($facette->getCourseCurriculumLectures($parentId, true));
//                case "JOURNAL":
//                    return new JsonModel($JOURNAL_ACCESS->getListObjectJournal($parentId, 'course'));
//                default:
//                    return new JsonModel($facette->getCourseCurriculums($parentId, false));
//            }
//        } else {
//            return new JsonModel($facette->getListCourses($parentId, $target, $strSearch, $searchKey));
//        }
        return new JsonModel();
    }

    public function get($id) {
//        $facette = new Course($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
//        return new JsonModel($facette->findCourseById($id));
         return new JsonModel($id);
    }

    public function create($data) {
//        $facette = new Course($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
//        return new JsonModel(array('lastID' => $facette->createCourse($data)));
         return new JsonModel($data);
    }

    public function update($id, $data) {
//        $facette = new Course($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
//        $facette->changeCourse($id, $data);
        return new JsonModel(array('status' => true));
    }

    public function delete($id) {
//
//        $facette = new Course($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
//        $facette->deleteCourse($id);

        return new JsonModel(array('status' => true));
    }

}
