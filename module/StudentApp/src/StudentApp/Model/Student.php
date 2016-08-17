<?php

/* * ***************************************************************************
* Copyright (C) 2015 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS Learning.
*
* {CAMEMIS Learning} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */

namespace StudentApp\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class Student extends AbstractTableGateway {

    public $table = 't_student';

    public function __construct(Adapter $adapter) {

        $this->sql = new Sql($adapter);
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }

    public function getListBookcollections($target = false, $searchKey = false) {
        $SESSION = new Container('User');
        $pos = strrpos(getcwd(), "uploads");
        if ($pos === false) {
            chdir('public/uploads');
        }

        $FILE_ACCESS = new File($this->adapter);
        $TRANSLATION_ACCESS = new Translation($this->adapter);

        try {
            $data = array();
            $sql = $this->sql->select();
            $sql->from(array(
                't1' => $this->table
            ));
            $sql->columns(array('*'));
            $sql->where(array("t1.object_type='0'"));

            if ($target != "publish") {
                if ($SESSION->roleId == 3) {
                    $sql->join(array('t3' => 'book_user'), 't1.book_id = t3.book_id', array(), 'left');
                    $sql->where(array("t3.user_id='" . $SESSION->userId . "'"));
                }
                if ($SESSION->userId <> 1) {
                    switch ($SESSION->roleId) {
                        case 1:
                        case 2:
                            $sql->where(array("t1.user_id='" . $SESSION->userId . "'"));
                            break;
                    }
                }
            }

            $sql->order('t1.sortkey  ASC');
            //echo ($this->sql->getSqlstringForSqlObject($sql));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $entries = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();

            $OBJECT_DATA = array();
            if ($entries) {
                foreach ($entries as $result) {
                    $book_id = isset($result["book_id"]) ? $result["book_id"] : "";
                    $OBJECT_DATA["image"] = $FILE_ACCESS->getCAMEMISUpload($book_id, "BOOKCOLLECTION", 3)->display_file_name;
                    $OBJECT_DATA["id"] = $book_id;

                    $price = $result["price"] ? $result["price"] : 0;
                    $cost = $result["permission_status"] ? $result["permission_status"] : 0;
                    $currency = $result["currency"] ? $result["currency"] : 0;

                    if ($cost) {
                        if (is_numeric($price)) {
                            $OBJECT_DATA["price"] = number_format($price, 2) . " " . $TRANSLATION_ACCESS->getCurrencyName($currency);
                        } else {
                            $OBJECT_DATA["price"] = "---";
                        }
                    } else {
                        $OBJECT_DATA["price"] = $TRANSLATION_ACCESS->getTextByConst("FREE");
                    }

                    $OBJECT_DATA["permission_status"] = $result["permission_status"] ? $result["permission_status"] : 0;
                    $OBJECT_DATA["currency"] = $result["currency"] ? $result["currency"] : 0;
                    $OBJECT_DATA["label"] = isset($result["name"]) ? Utilities::showText($result["name"]) : "";
                    $OBJECT_DATA["parent"] = isset($result["parent"]) ? $result["parent"] : "";
                    $OBJECT_DATA["name"] = isset($result["name"]) ? Utilities::showText($result["name"]) : "";
                    $OBJECT_DATA["book_id"] = isset($result["book_id"]) ? $result["book_id"] : "";
                    $OBJECT_DATA["description"] = isset($result["description"]) ? Utilities::showText($result["description"]) : "";
                    $OBJECT_DATA["created_on"] = isset($result["created_on"]) ? $result["created_on"] : "";
                    $OBJECT_DATA["modified_on"] = isset($result["modified_on"]) ? $result["modified_on"] : "";
                    $OBJECT_DATA["rating"] = isset($result["rating"]) ? $result["rating"] : 1;

                    $data[] = $OBJECT_DATA;
                }
            }
            return $data;
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    public function findBookcollectionById($Id) {

        $pos = strrpos(getcwd(), "uploads");
        if ($pos === false) {
            chdir('public/uploads');
        }

        $SESSION = new Container('User');
        $FILE_ACCESS = new File($this->adapter);
        $BOOK_USER_ACCESS = new BookcollectionUser($this->adapter);
        $TRANSLATION_ACCESS = new Translation($this->adapter);
        $ASSIGNED_CATEGORY_ACCESS = new AssignedCategory($this->adapter);

        try {

            $sql = $this->sql->select();
            $sql->from(array('t1' => 'book'));
            $sql->columns(array('*'));
            $sql->join(array('t2' => 'users'), 't1.user_id = t2.user_id', array('lastname', 'firstname', 'author_text'), 'left');
            $sql->where(array("t1.book_id='" . $Id . "'"));
            if ($SESSION->userId <> 1) {
                switch ($SESSION->roleId) {
                    case 1:
                    case 2:
                        $sql->where(array("t1.user_id='" . $SESSION->userId . "'"));
                        break;
                }
            }
            //echo ($this->sql->getSqlstringForSqlObject($sql));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $result = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            $DATA_RESULT = isset($result[0]) ? $result[0] : array();
            $data = array();

            if ($DATA_RESULT) {
                $data["name"] = $DATA_RESULT["name"];
                $data["display_file_name"] = $FILE_ACCESS->getCAMEMISUpload($Id, "BOOKCOLLECTION", 3)->display_file_name;
                $data["display_file_id"] = $FILE_ACCESS->getCAMEMISUpload($Id, "BOOKCOLLECTION", 3)->display_file_id;
                $data["read_online"] = $DATA_RESULT["read_online"];
                $data["sortkey"] = Utilities::showText($DATA_RESULT["sortkey"]);
                $data["status"] = $DATA_RESULT["status"];
                $data["book_id"] = $DATA_RESULT["book_id"];
                $data["is_copyright"] = Utilities::showText($DATA_RESULT["is_copyright"]);
                $data["copyright_desc"] = Utilities::showText($DATA_RESULT["copyright_desc"]);
                $data["description"] = Utilities::showText($DATA_RESULT["description"]);
                $data["year_pub"] = Utilities::showText($DATA_RESULT["year_pub"]);
                $data["au_lname"] = Utilities::showText($DATA_RESULT["au_lname"]);
                $data["au_fname"] = Utilities::showText($DATA_RESULT["au_fname"]);
                $data["au_email"] = Utilities::showText($DATA_RESULT["au_email"]);
                $data["au_phone"] = Utilities::showText($DATA_RESULT["au_phone"]);
                $data["au_address"] = Utilities::showText($DATA_RESULT["au_address"]);
                $data["publisher_name"] = Utilities::showText($DATA_RESULT["publisher_name"]);
                $data["pub_city"] = Utilities::showText($DATA_RESULT["pub_city"]);
                $data["pub_state"] = Utilities::showText($DATA_RESULT["pub_state"]);
                $data["pub_country_id"] = $DATA_RESULT["pub_country_id"];
                $data["isbn"] = Utilities::showText($DATA_RESULT["isbn"]);
                $data["permission_status"] = isset($DATA_RESULT["permission_status"]) ? $DATA_RESULT["permission_status"] : 0;
                $data["search_tags"] = Utilities::showText($DATA_RESULT["search_tags"]);
                $data["created_on"] = Utilities::showText($DATA_RESULT["created_on"]);
                $data["modified_on"] = Utilities::showText($DATA_RESULT["modified_on"]);
                $data["instructional_level"] = $DATA_RESULT["instructional_level"];
                $data["language"] = isset($DATA_RESULT["language"]) ? $DATA_RESULT["language"] : 0;
                $data["parent"] = $DATA_RESULT["parent"];
                $data["children"] = $this->getBookChapterChildren($Id);
                $data["html_content"] = Utilities::showText($DATA_RESULT["html_content"]);

                $data["language_name"] = $TRANSLATION_ACCESS->getLanguageName($DATA_RESULT["language"]);
                $data["instructional_level_name"] = $TRANSLATION_ACCESS->getLanguageName($DATA_RESULT["instructional_level"]);

                $data["price"] = isset($DATA_RESULT["price"]) ? $DATA_RESULT["price"] : "0";
                $data["currency"] = isset($DATA_RESULT["currency"]) ? $DATA_RESULT["currency"] : "0";

                $data["publish_data"] = $this->getBookDataPublish(
                    $TRANSLATION_ACCESS
                    , $BOOK_USER_ACCESS
                    , $FILE_ACCESS
                    , $ASSIGNED_CATEGORY_ACCESS
                    , $Id
                    , $DATA_RESULT
                );
                $data["book_type"] = isset($DATA_RESULT["book_type"]) ? $DATA_RESULT["book_type"] : 0;
            }

            return $data;
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    public function createBookcollection($data) {
        $SESSION = new Container('User');
        try {
            $sql = $this->sql->insert();
            $sql->into('book');
            $sql->columns(array(
                'name'
            , 'status'
            , 'copyright_desc'
            , 'isbn'
            , 'search_tags'
            , 'is_copyright'
            , 'description'
            , 'read_online'
            , 'created_on'
            , 'modified_on'
            , 'book_type'
            , 'object_type'
            , 'parent'
            , 'html_content'
            , 'user_id'
            ));
            $sql->values(array(
                'name' => isset($data["data"]["name"]) ? Utilities::setText($data["data"]["name"]) : "",
                'status' => isset($data["data"]["status"]) ? $data["data"]["status"] : "",
                'copyright_desc' => isset($data["data"]["copyright_desc"]) ? Utilities::setText($data["data"]["copyright_desc"]) : "",
                'isbn' => isset($data["data"]["isbn"]) ? $data["data"]["isbn"] : "",
                'search_tags' => isset($data["data"]["search_tags"]) ? Utilities::setText($data["data"]["search_tags"]) : "",
                'is_copyright' => isset($data["data"]["is_copyright"]) ? Utilities::setText($data["data"]["is_copyright"]) : "",
                'description' => isset($data["data"]["description"]) ? Utilities::setText($data["data"]["description"]) : "",
                'read_online' => isset($data["data"]["read_online"]) ? $data["data"]["read_online"] : "",
                'created_on' => date('Y-m-d H:i'),
                'book_type' => isset($data["data"]["book_type"]) ? $data["data"]["book_type"] : 0,
                'object_type' => isset($data["data"]["object_type"]) ? $data["data"]["object_type"] : 0,
                'parent' => isset($data["data"]["parent"]) ? $data["data"]["parent"] : 0,
                'user_id' => $SESSION->userId
            ));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $statement->execute();
            if ($this->adapter->getDriver()->getLastGeneratedValue()) {
                return $this->adapter->getDriver()->getLastGeneratedValue();
            }
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    public function changeBookcollection($id, $data) {
        $SESSION = new Container('User');
        try {
            if (isset($data["data"]["name"]))
                $UPDATE_DATA["name"] = Utilities::setText($data["data"]["name"]);
            if (isset($data["data"]["sortkey"]))
                $UPDATE_DATA["sortkey"] = Utilities::setText($data["data"]["sortkey"]);
            if (isset($data["data"]["status"]))
                $UPDATE_DATA["status"] = $data["data"]["status"];
            if (isset($data["data"]["is_copyright"]))
                $UPDATE_DATA["is_copyright"] = Utilities::setText($data["data"]["is_copyright"]);
            if (isset($data["data"]["copyright_desc"]))
                $UPDATE_DATA["copyright_desc"] = Utilities::setText($data["data"]["copyright_desc"]);
            if (isset($data["data"]["description"]))
                $UPDATE_DATA["description"] = Utilities::setText($data["data"]["description"]);
            if (isset($data["data"]["year_pub"]))
                $UPDATE_DATA["year_pub"] = Utilities::setText($data["data"]["year_pub"]);
            if (isset($data["data"]["au_lname"]))
                $UPDATE_DATA["au_lname"] = Utilities::setText($data["data"]["au_lname"]);
            if (isset($data["data"]["au_fname"]))
                $UPDATE_DATA["au_fname"] = Utilities::setText($data["data"]["au_fname"]);
            if (isset($data["data"]["au_email"]))
                $UPDATE_DATA["au_email"] = Utilities::setText($data["data"]["au_email"]);
            if (isset($data["data"]["au_phone"]))
                $UPDATE_DATA["au_phone"] = Utilities::setText($data["data"]["au_phone"]);
            if (isset($data["data"]["au_address"]))
                $UPDATE_DATA["au_address"] = Utilities::setText($data["data"]["au_address"]);
            if (isset($data["data"]["publisher_name"]))
                $UPDATE_DATA["publisher_name"] = Utilities::setText($data["data"]["publisher_name"]);
            if (isset($data["data"]["pub_city"]))
                $UPDATE_DATA["pub_city"] = Utilities::setText($data["data"]["pub_city"]);
            if (isset($data["data"]["pub_state"]))
                $UPDATE_DATA["pub_state"] = Utilities::setText($data["data"]["pub_state"]);
            if (isset($data["data"]["pub_country_id"]))
                $UPDATE_DATA["pub_country_id"] = $data["data"]["pub_country_id"];
            if (isset($data["data"]["isbn"]))
                $UPDATE_DATA["isbn"] = Utilities::setText($data["data"]["isbn"]);
            if (isset($data["data"]["search_tags"]))
                $UPDATE_DATA["search_tags"] = Utilities::setText($data["data"]["search_tags"]);
            if (isset($data["data"]["read_online"]))
                $UPDATE_DATA["read_online"] = Utilities::setText($data["data"]["read_online"]);
            if (isset($data["data"]["permission_status"]))
                $UPDATE_DATA["permission_status"] = $data["data"]["permission_status"];
            if (isset($data["data"]["price"]))
                $UPDATE_DATA["price"] = Utilities::setText($data["data"]["price"]);
            if (isset($data["data"]["html_content"]))
                $UPDATE_DATA["html_content"] = Utilities::setText($data["data"]["html_content"]);
            $UPDATE_DATA["instructional_level"] = isset($data["data"]["instructional_level"]) ? $data["data"]["instructional_level"] : 0;
            $UPDATE_DATA["language"] = isset($data["data"]["language"]) ? $data["data"]["language"] : 0;
            $UPDATE_DATA["currency"] = isset($data["data"]["currency"]) ? $data["data"]["currency"] : 0;

            $sql = $this->sql->update();
            $sql->table('book');
            $sql->set($UPDATE_DATA);
            $sql->where(array('book_id' => $id));
            $sql->where(array('user_id' => $SESSION->userId));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $statement->execute();
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    public function deleteBookcollection($id) {
        $SESSION = new Container('User');
        try {
            $sql = $this->sql->delete();
            $sql->from('book');
            $sql->where(array('book_id' => $id));
            $sql->where(array('user_id' => $SESSION->userId));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $statement->execute();
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    public static function createTree(&$list, $parent) {
        $data = array();
        if ($parent) {
            foreach ($parent as $key => $value) {
                if (isset($list[$value['id']])) {
                    $value['children'] = self::createTree($list, $list[$value['id']]);
                }
                $data[] = $value;
            }
        }

        return $data;
    }

    public function getTreeItems($catID) {
        $entries = $this->getListBookcollections($catID);
        $data = array();
        foreach ($entries as $a) {
            if ($a)
                $data[$a['parent']][] = $a;
        }
        return self::createTree($data, isset($data[0]) ? $data[0] : array());
    }

    public function checkChildren($parentID) {
        $sql = $this->sql->select()->from($this->table);
        $sql->columns(array('COUNT' => new \Zend\Db\Sql\Expression('COUNT(*)')));
        $sql->where(array("parent='" . $parentID . "'"));
        $statement = $this->sql->prepareStatementForSqlObject($sql);
        $result = $this->resultSetPrototype->initialize($statement->execute())->toArray();
        return isset($result[0]["COUNT"]) ? $result[0]["COUNT"] : 0;
    }

    public function getBookHTMLContent($id) {
        try {
            $SESSION = new Container('User');
            $data = array();
            $sql = $this->sql->select();
            $sql->from(array(
                't1' => $this->table
            ));
            $sql->columns(array(
                'book_id'
            , 'parent'
            , 'name'
            , 'created_on'
            , 'modified_on'
            ));
            $sql->where(array("t1.parent='" . $id . "'"));
            $sql->where(array("t1.object_type='1'"));
            if ($SESSION->userId <> 1) {
                switch ($SESSION->roleId) {
                    case 1:
                    case 2:
                        $sql->where(array("t1.user_id='" . $SESSION->userId . "'"));
                        break;
                }
            }
            $sql->order('t1.sortkey  ASC');
            //echo ($this->sql->getSqlstringForSqlObject($sql));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $entries = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();

            $OBJECT_DATA = array();
            if ($entries) {
                foreach ($entries as $result) {
                    $chapterId = isset($result["book_id"]) ? $result["book_id"] : "";
                    $OBJECT_DATA["chapter_id"] = $chapterId;
                    $book_id = isset($result["book_id"]) ? $result["book_id"] : "";
                    $OBJECT_DATA["id"] = $book_id;
                    $OBJECT_DATA["parent"] = isset($result["parent"]) ? $result["parent"] : "";
                    $OBJECT_DATA["name"] = isset($result["name"]) ? Utilities::showText($result["name"]) : "";
                    $OBJECT_DATA["book_id"] = isset($result["book_id"]) ? $result["book_id"] : "";
                    $OBJECT_DATA["created_on"] = isset($result["created_on"]) ? $result["created_on"] : "";
                    $OBJECT_DATA["modified_on"] = isset($result["modified_on"]) ? $result["modified_on"] : "";
                    $OBJECT_DATA["count_children"] = $this->getCountChapterChildren($chapterId);
                    $OBJECT_DATA["children"] = $this->getBookChapterChildren($chapterId);
                    $data[] = $OBJECT_DATA;
                }
            }
            return $data;
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    public function getCountChapterChildren($chapterId) {

        $sql = $this->sql->select()->from($this->table);
        $sql->columns(array('COUNT' => new \Zend\Db\Sql\Expression('COUNT(*)')));
        $sql->where(array("parent='" . $chapterId . "'"));
        $statement = $this->sql->prepareStatementForSqlObject($sql);
        $result = $this->resultSetPrototype->initialize($statement->execute())->toArray();
        return isset($result[0]["COUNT"]) ? $result[0]["COUNT"] : 0;
    }

    public function getBookChapterChildren($chapterId) {
        try {
            $SESSION = new Container('User');
            $data = array();
            $sql = $this->sql->select();
            $sql->from(array(
                't1' => $this->table
            ));
            $sql->columns(array(
                'book_id'
            , 'parent'
            , 'name'
            , 'created_on'
            , 'modified_on'
            ));
            $sql->where(array("t1.parent='" . $chapterId . "'"));
            if ($SESSION->userId <> 1) {
                switch ($SESSION->roleId) {
                    case 1:
                    case 2:
                        $sql->where(array("t1.user_id='" . $SESSION->userId . "'"));
                        break;
                }
            }
            //$sql->where(array("t1.object_type='1'"));
            $sql->order('t1.sortkey  ASC');
            //echo ($this->sql->getSqlstringForSqlObject($sql));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $entries = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();

            $OBJECT_DATA = array();
            if ($entries) {
                foreach ($entries as $result) {

                    $book_id = isset($result["book_id"]) ? $result["book_id"] : "";
                    $OBJECT_DATA["id"] = $book_id;
                    $OBJECT_DATA["parent"] = isset($result["parent"]) ? $result["parent"] : "";
                    $OBJECT_DATA["name"] = isset($result["name"]) ? Utilities::showText($result["name"]) : "";
                    $OBJECT_DATA["book_id"] = isset($result["book_id"]) ? $result["book_id"] : "";
                    $OBJECT_DATA["created_on"] = isset($result["created_on"]) ? $result["created_on"] : "";
                    $OBJECT_DATA["modified_on"] = isset($result["modified_on"]) ? $result["modified_on"] : "";
                    $data[] = $OBJECT_DATA;
                }
            }
            return $data;
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    public function deleteBookParentChildren($id) {
        $SESSION = new Container('User');
        try {

            $sql = $this->sql->delete();
            $sql->from('book');
            $sql->where(array("book_id='" . $id . "'"));
            $statement = $this->sql->prepareStatementForSqlObject($sql);
            $statement->execute();

            //error_log ($this->sql->getSqlstringForSqlObject($sql));
            $sqlChild = $this->sql->select();
            $sqlChild->from(array(
                't1' => $this->table
            ));
            $sqlChild->columns(array(
                'book_id'
            ));
            $sqlChild->where(array("t1.parent='" . $id . "'"));
            if ($SESSION->userId <> 1) {
                switch ($SESSION->roleId) {
                    case 1:
                    case 2:
                        $sql->where(array("t1.user_id='" . $SESSION->userId . "'"));
                        break;
                }
            }
            $statementChild = $this->sql->prepareStatementForSqlObject($sqlChild);

            //error_log ($this->sql->getSqlstringForSqlObject($sqlChild));
            $result = $this->resultSetPrototype->initialize($statementChild->execute())
                ->toArray();

            if ($result) {
                $idchildarr = array();
                foreach ($result as $values) {
                    $idchildarr[] = $values["book_id"];
                }
                $childID = implode(",", $idchildarr);

                return $this->deleteBookParentChildren($childID);
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            throw new \Exception("SQL EXCEPTION...." . $e . "");
        }
    }

    protected function getBookDataPublish($translation, $book_user, $file, $assigned_category, $id, $result) {
        $data["name"] = Utilities::showText($result["name"]);
        $data["language"] = $translation->getLanguageName($result["language"]);
        $user_id = isset($result["user_id"]) ? $result["user_id"] : "";
        $permission_status = isset($result["permission_status"]) ? Utilities::showText($result["permission_status"]) : "";

        switch ($permission_status) {
            case 1:
                $price = isset($result["price"]) ? $result["price"] : 0;
                $currency = isset($result["currency"]) ? $result["currency"] : 0;
                $data["price"] = number_format($price, 2) . " " . $translation->getCurrencyName($currency);
                break;
            case 2:
                $data["price"] = $translation->getTextByConst("PERMISSION");
                break;
            default:
                $data["price"] = $translation->getTextByConst("FREE");
                break;
        }
        $data["permission_status"] = $permission_status;
        $data["rating"] = isset($result["rating"]) ? Utilities::showText($result["rating"]) : 0;
        $data["description"] = isset($result["description"]) ? Utilities::showText($result["description"]) : "";
        $data["is_copyright"] = isset($result["is_copyright"]) ? Utilities::showText($result["is_copyright"]) : "0";
        $data["isbn"] = isset($result["isbn"]) ? Utilities::showText($result["isbn"]) : "";
        $data["copyright_desc"] = isset($result["copyright_desc"]) ? Utilities::showText($result["copyright_desc"]) : "";
        $data["author_firstname"] = isset($result["firstname"]) ? Utilities::showText($result["firstname"]) : "---";
        $data["author_lastname"] = isset($result["lastname"]) ? Utilities::showText($result["lastname"]) : "---";
        $data["author_text"] = isset($result["author_text"]) ? Utilities::showText($result["author_text"]) : "---";
        $data["enrolled_count"] = $book_user->getBookEnrolled($id);
        $data["author_image"] = $file->getCAMEMISUpload($user_id, "USER_IMAGE", 5)->display_file_name;
        $data["display_image"] = $file->getCAMEMISUpload($id, "BOOKCOLLECTION", 3)->display_file_name;
        $data["assigned_category"] = $assigned_category->getAssignedCategoryName($id, "BOOKCOLLECTION");

        return $data;
    }
}
